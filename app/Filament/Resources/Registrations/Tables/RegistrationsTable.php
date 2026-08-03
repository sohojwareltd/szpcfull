<?php

namespace App\Filament\Resources\Registrations\Tables;

use App\Filament\Resources\Registrations\Actions\AddRegistrationNoteAction;
use App\Filament\Resources\Registrations\Actions\ManageRegistrationTagsAction;
use App\Filament\Resources\Registrations\Actions\UpdateRegistrationProgressAction;
use App\Filament\Resources\Registrations\RegistrationResource;
use App\Enums\MessageLogStatus;
use App\Models\Registration;
use App\Models\TeamMember;
use App\Services\MessageTemplateRenderer;
use App\Services\MessagingService;
use App\Services\TeamProvisioner;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class RegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('reference_code')
                    ->label('Ref')
                    ->searchable()
                    ->sortable()
                    ->url(fn (Registration $record): string => RegistrationResource::getUrl('view', ['record' => $record])),
                TextColumn::make('contest_type')
                    ->label('Competition')
                    ->badge()
                    ->sortable(),
                TextColumn::make('tags.name')
                    ->label('Tags')
                    ->badge()
                    ->separator(',')
                    ->toggleable(),
                TextColumn::make('display_name')
                    ->label('Team / Name')
                    ->getStateUsing(fn (Registration $record): string => $record->displayName())
                    ->searchable(['team_name', 'full_name', 'university', 'institution_name']),
                TextColumn::make('team.leader.full_name')
                    ->label('Leader')
                    ->toggleable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('email')
                    ->toggleable(),
                IconColumn::make('is_contacted')
                    ->label('Contacted')
                    ->boolean(),
                IconColumn::make('is_paid')
                    ->label('Paid')
                    ->boolean(),
                IconColumn::make('is_confirmed')
                    ->label('Confirmed')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('contest_type')
                    ->label('Competition')
                    ->options([
                        'SZPC-2026' => 'SZPC-2026',
                        'JPC-2026' => 'JPC-2026',
                        'ITHQ-2026' => 'ITHQ-2026',
                    ]),
                SelectFilter::make('tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->preload()
                    ->label('Tags'),
                TernaryFilter::make('is_contacted')->label('Contacted'),
                TernaryFilter::make('is_paid')->label('Paid'),
                TernaryFilter::make('is_confirmed')->label('Confirmed'),
            ])
            ->recordActions([
                Action::make('sendSms')
                    ->label('SMS')
                    ->icon(Heroicon::OutlinedChatBubbleLeftRight)
                    ->form(fn (Registration $record): array => [
                        Select::make('team_member_id')
                            ->label('Recipient')
                            ->options(function () use ($record): array {
                                $record->loadMissing('team.members');
                                $options = ['' => 'Primary contact ('.$record->phone.')'];
                                foreach ($record->team?->members ?? [] as $member) {
                                    $phone = $member->displayPhone() ?? 'no phone';
                                    $options[(string) $member->id] = $member->full_name.($member->is_leader ? ' (leader)' : '').' — '.$phone;
                                }

                                return $options;
                            })
                            ->default(''),
                        Textarea::make('message')
                            ->label('Message template')
                            ->required()
                            ->rows(4)
                            ->helperText('Placeholders: '.MessageTemplateRenderer::placeholderHelp())
                            ->default("SZPC '26: Hello {{member_name}}, your registration {{reference_code}} is received. — UGV Programming Club"),
                    ])
                    ->action(function (Registration $record, array $data, MessagingService $messaging): void {
                        $record->loadMissing(['team.members', 'team.leader']);
                        $member = filled($data['team_member_id'] ?? null)
                            ? TeamMember::find($data['team_member_id'])
                            : null;

                        $log = $messaging->sendIndividual($record, $data['message'], $member, Auth::user());

                        if ($log->status === MessageLogStatus::Sent) {
                            Notification::make()->title('SMS sent')->success()->send();

                            return;
                        }

                        Notification::make()
                            ->title('SMS not sent')
                            ->body($log->error_message ?? 'Check message log for details.')
                            ->warning()
                            ->send();
                    }),
                ActionGroup::make([
                    UpdateRegistrationProgressAction::make(),
                    ManageRegistrationTagsAction::make(),
                    AddRegistrationNoteAction::make(),
                ])
                    ->label('Update')
                    ->icon(Heroicon::OutlinedPencilSquare)
                    ->color('gray')
                    ->button(),
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('markContacted')
                        ->label('Mark contacted')
                        ->icon(Heroicon::OutlinedPhone)
                        ->action(fn (Collection $records) => $records->each(fn (Registration $r) => $r->update([
                            'is_contacted' => true,
                            'contacted_at' => now(),
                        ]))),
                    BulkAction::make('markPaid')
                        ->label('Mark paid')
                        ->icon(Heroicon::OutlinedBanknotes)
                        ->action(fn (Collection $records) => $records->each(fn (Registration $r) => $r->update([
                            'is_paid' => true,
                            'paid_at' => now(),
                        ]))),
                    BulkAction::make('markConfirmed')
                        ->label('Mark confirmed')
                        ->icon(Heroicon::OutlinedCheckCircle)
                        ->action(fn (Collection $records) => $records->each(fn (Registration $r) => $r->update([
                            'is_confirmed' => true,
                            'confirmed_at' => now(),
                        ]))),
                    BulkAction::make('syncTeams')
                        ->label('Sync teams')
                        ->icon(Heroicon::OutlinedUserGroup)
                        ->action(function (Collection $records, TeamProvisioner $provisioner): void {
                            $records->load('members');
                            foreach ($records as $record) {
                                $provisioner->syncFromRegistration($record);
                            }
                            Notification::make()
                                ->title('Teams synced')
                                ->success()
                                ->send();
                        }),
                    BulkAction::make('bulkSms')
                        ->label('Send SMS (same text)')
                        ->icon(Heroicon::OutlinedChatBubbleLeftRight)
                        ->form([
                            Textarea::make('message')
                                ->required()
                                ->rows(4)
                                ->helperText('Placeholders: '.MessageTemplateRenderer::placeholderHelp()),
                        ])
                        ->action(function (Collection $records, array $data, MessagingService $messaging): void {
                            $sent = 0;
                            foreach ($records as $record) {
                                $log = $messaging->sendIndividual($record, $data['message'], null, Auth::user());
                                if ($log->status === MessageLogStatus::Sent) {
                                    $sent++;
                                }
                            }
                            Notification::make()
                                ->title("SMS sent to {$sent} of {$records->count()} registrations")
                                ->success()
                                ->send();
                        }),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
