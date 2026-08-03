<?php

namespace App\Console\Commands;

use App\Models\Registration;
use App\Services\TeamProvisioner;
use Illuminate\Console\Command;

class SyncTeamsFromRegistrations extends Command
{
    protected $signature = 'teams:sync-from-registrations';

    protected $description = 'Create or update teams and members from all registrations';

    public function handle(TeamProvisioner $provisioner): int
    {
        $count = 0;

        Registration::query()->with('members')->orderBy('id')->chunk(100, function ($registrations) use ($provisioner, &$count): void {
            foreach ($registrations as $registration) {
                $provisioner->syncFromRegistration($registration);
                $count++;
            }
        });

        $this->info("Synced {$count} team(s).");

        return self::SUCCESS;
    }
}
