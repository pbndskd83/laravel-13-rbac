<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SettingsService;

class ResetSettings extends Command
{
    protected $signature = 'settings:reset';
    protected $description = 'Reset all dynamic website settings to factory defaults';

    public function handle(SettingsService $service)
    {
        if ($this->confirm('Are you sure you want to reset all site settings? This will delete logos and custom branding.')) {
            $service->reset();
            $this->info('Settings have been reset successfully.');
        }
    }
}