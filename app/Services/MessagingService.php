<?php

namespace App\Services;

use App\Enums\CampaignAudience;
use App\Enums\CampaignStatus;
use App\Enums\MessageLogStatus;
use App\Enums\MessageType;
use App\Models\MessageCampaign;
use App\Models\MessageLog;
use App\Models\Registration;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Support\Collection;

class MessagingService
{
    public function __construct(
        private SmsService $sms,
        private MessageTemplateRenderer $templates,
    ) {}

    public function sendCampaign(MessageCampaign $campaign, ?User $sender = null): MessageCampaign
    {
        $campaign->update([
            'status' => CampaignStatus::Sending,
            'sent_count' => 0,
            'failed_count' => 0,
            'recipients_count' => 0,
        ]);

        $teams = $this->teamsForCampaign($campaign);
        $recipients = $this->collectRecipients($teams, $campaign->audience);

        $campaign->update(['recipients_count' => $recipients->count()]);

        $sent = 0;
        $failed = 0;

        foreach ($recipients as $recipient) {
            /** @var array{registration: Registration, member: ?TeamMember, phone: string, name: string, type: string} $recipient */
            $log = $this->dispatchMessage(
                template: $campaign->body,
                registration: $recipient['registration'],
                member: $recipient['member'],
                phone: $recipient['phone'],
                name: $recipient['name'],
                recipientType: $recipient['type'],
                messageType: MessageType::Campaign,
                campaign: $campaign,
                sender: $sender,
            );

            if ($log->status === MessageLogStatus::Sent) {
                $sent++;
            } elseif ($log->status === MessageLogStatus::Failed) {
                $failed++;
            }
        }

        $campaign->update([
            'status' => CampaignStatus::Completed,
            'sent_count' => $sent,
            'failed_count' => $failed,
            'sent_at' => now(),
        ]);

        return $campaign->fresh();
    }

    public function sendIndividual(
        Registration $registration,
        string $template,
        ?TeamMember $member = null,
        ?User $sender = null,
    ): MessageLog {
        $registration->loadMissing(['team.members', 'team.leader']);
        $phone = $member?->displayPhone() ?? $registration->phone;
        $name = $member?->full_name ?? $registration->displayName();

        return $this->dispatchMessage(
            template: $template,
            registration: $registration,
            member: $member,
            phone: $phone,
            name: $name,
            recipientType: $member ? 'team_member' : 'registration',
            messageType: MessageType::Individual,
            campaign: null,
            sender: $sender,
        );
    }

    /**
     * @return Collection<int, Team>
     */
    private function teamsForCampaign(MessageCampaign $campaign): Collection
    {
        $query = Team::query()->with(['registration', 'members', 'leader']);

        if ($campaign->contest_filter) {
            $query->where('contest_type', $campaign->contest_filter);
        }

        return $query->get();
    }

    /**
     * @param  Collection<int, Team>  $teams
     * @return Collection<int, array{registration: Registration, member: ?TeamMember, phone: string, name: string, type: string}>
     */
    private function collectRecipients(Collection $teams, CampaignAudience $audience): Collection
    {
        $items = collect();

        foreach ($teams as $team) {
            $registration = $team->registration;
            if (! $registration) {
                continue;
            }

            $add = function (?TeamMember $member, string $type) use (&$items, $registration): void {
                $phone = $member?->displayPhone() ?? $registration->phone;
                if (! filled($phone)) {
                    return;
                }
                $key = $registration->id.':'.preg_replace('/\D+/', '', $phone);
                if ($items->has($key)) {
                    return;
                }
                $items->put($key, [
                    'registration' => $registration,
                    'member' => $member,
                    'phone' => $phone,
                    'name' => $member?->full_name ?? $registration->displayName(),
                    'type' => $type,
                ]);
            };

            match ($audience) {
                CampaignAudience::TeamLeaders => $add($team->leader, 'team_leader'),
                CampaignAudience::AllMembers => (function () use ($team, $add): void {
                    foreach ($team->members as $member) {
                        $add($member, 'team_member');
                    }
                })(),
                CampaignAudience::Both => (function () use ($team, $add): void {
                    $add($team->leader, 'team_leader');
                    foreach ($team->members as $member) {
                        $add($member, 'team_member');
                    }
                })(),
            };
        }

        return $items->values();
    }

    private function dispatchMessage(
        string $template,
        Registration $registration,
        ?TeamMember $member,
        string $phone,
        string $name,
        string $recipientType,
        MessageType $messageType,
        ?MessageCampaign $campaign,
        ?User $sender,
    ): MessageLog {
        if (! filled($phone)) {
            return $this->writeLog(
                campaign: $campaign,
                registration: $registration,
                member: $member,
                messageType: $messageType,
                recipientType: $recipientType,
                phone: '',
                name: $name,
                template: $template,
                body: '',
                status: MessageLogStatus::Skipped,
                error: 'No phone number',
                sender: $sender,
            );
        }

        $body = $this->templates->render($template, $registration, $member);
        $result = $this->sms->sendToPhone($phone, $body, $registration);

        return $this->writeLog(
            campaign: $campaign,
            registration: $registration,
            member: $member,
            messageType: $messageType,
            recipientType: $recipientType,
            phone: $phone,
            name: $name,
            template: $template,
            body: $body,
            status: $result['success'] ? MessageLogStatus::Sent : MessageLogStatus::Failed,
            error: $result['error'],
            providerResponse: $result['response'],
            sender: $sender,
        );
    }

    private function writeLog(
        ?MessageCampaign $campaign,
        Registration $registration,
        ?TeamMember $member,
        MessageType $messageType,
        string $recipientType,
        string $phone,
        string $name,
        string $template,
        string $body,
        MessageLogStatus $status,
        ?string $error = null,
        ?string $providerResponse = null,
        ?User $sender = null,
    ): MessageLog {
        $log = MessageLog::create([
            'message_campaign_id' => $campaign?->id,
            'registration_id' => $registration->id,
            'team_id' => $registration->team?->id,
            'team_member_id' => $member?->id,
            'message_type' => $messageType,
            'recipient_type' => $recipientType,
            'recipient_phone' => $phone,
            'recipient_name' => $name,
            'message_body' => $body,
            'template_body' => $template,
            'status' => $status,
            'error_message' => $error,
            'provider_response' => $providerResponse,
            'sent_by' => $sender?->id,
            'sent_at' => now(),
        ]);

        if ($status === MessageLogStatus::Sent) {
            $registration->update(['last_sms_at' => now()]);
        }

        return $log;
    }
}
