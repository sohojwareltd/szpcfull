<?php

namespace App\Services;

use App\Enums\ContestType;
use App\Models\Registration;
use App\Models\RegistrationMember;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Support\Facades\DB;

class TeamProvisioner
{
    public function syncFromRegistration(Registration $registration): Team
    {
        return DB::transaction(function () use ($registration): Team {
            $registration->loadMissing('members');

            $team = Team::query()->firstOrNew(['registration_id' => $registration->id]);
            $team->contest_type = $registration->contest_type;
            $team->name = $this->teamName($registration);
            $team->leader_id = null;
            $team->save();

            $existingMemberIds = [];
            $leaderMember = null;

            if ($registration->contest_type === ContestType::Ithq) {
                $leaderMember = $this->upsertMember($team, [
                    'full_name' => $registration->full_name ?? 'Participant',
                    'phone' => $registration->phone,
                    'email' => $registration->email,
                    'tshirt_size' => null,
                    'is_leader' => true,
                    'sort_order' => 1,
                    'registration_member_id' => null,
                ], null);
                $existingMemberIds[] = $leaderMember->id;
            } else {
                foreach ($registration->members as $regMember) {
                    $isLeader = $regMember->sort_order === 1;
                    $teamMember = $this->upsertMember($team, [
                        'full_name' => $regMember->full_name,
                        'phone' => $regMember->phone ?? ($isLeader ? $registration->phone : null),
                        'email' => $isLeader ? $registration->email : null,
                        'tshirt_size' => $regMember->tshirt_size,
                        'is_leader' => $isLeader,
                        'sort_order' => $regMember->sort_order,
                        'registration_member_id' => $regMember->id,
                    ], $regMember);
                    $existingMemberIds[] = $teamMember->id;
                    if ($isLeader) {
                        $leaderMember = $teamMember;
                    }
                }

                if (! $leaderMember && $team->members()->exists()) {
                    $leaderMember = $team->members()->orderBy('sort_order')->first();
                    $leaderMember?->update(['is_leader' => true]);
                }
            }

            $team->members()->whereNotIn('id', $existingMemberIds)->delete();

            if ($leaderMember) {
                $team->update(['leader_id' => $leaderMember->id]);
            }

            return $team->fresh(['members', 'leader', 'registration']);
        });
    }

    private function teamName(Registration $registration): string
    {
        return $registration->team_name
            ?? $registration->full_name
            ?? $registration->reference_code;
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function upsertMember(Team $team, array $attributes, ?RegistrationMember $regMember): TeamMember
    {
        $query = $team->members();
        if ($regMember) {
            $member = $query->firstOrNew(['registration_member_id' => $regMember->id]);
        } else {
            $member = $query->firstOrNew(['sort_order' => $attributes['sort_order']]);
        }

        $member->fill($attributes);
        $member->team_id = $team->id;
        $member->save();

        return $member;
    }
}
