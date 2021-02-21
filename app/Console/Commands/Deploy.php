<?php

declare(strict_types=1);

namespace CzechitasApp\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class Deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy
                            {version? : Current release version in format v1.2.3}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run after deployment';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('down');

        if (\preg_match('/^v[0-9]+\.[0-9]+(?:\.[0-9]+)?/', (string)$this->argument('version'), $matches)) {
            $this->writeVersionToEnv($matches[0]);
        }

        $this->call('clear-compiled');
        $this->call('view:cache');
        $this->call('config:cache');
        $this->call('event:cache');
        if (!App::isLocal()) {
            $this->call('route:cache');
        }
        $this->call('migrate', ['--force' => true]);

        $this->call('up');

        return 0;
    }

    /**
     * Write current version into .env file
     */
    private function writeVersionToEnv(string $version): void
    {
        if (empty($version)) {
            return;
        }

        $envPath = \base_path('.env');
        $currentEnv = (string)\file_get_contents($envPath);

        $regex = '/^(SENTRY_RELEASE_VERSION).*$/m';
        if (\preg_match($regex, $currentEnv)) {
            $currentEnv = \preg_replace($regex, "\$1={$version}", $currentEnv);
        } else {
            $currentEnv .= "\nSENTRY_RELEASE_VERSION={$version}\n";
        }
        \file_put_contents($envPath, $currentEnv);
    }
}
