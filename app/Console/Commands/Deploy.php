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
    protected $signature = 'deploy';

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
        $this->call('clear-compiled');
        if (!App::isLocal()) {
            $this->call('view:cache');
            // $this->call('config:cache');
            $this->call('event:cache');
            $this->call('route:cache');
        }
        $this->call('migrate', ['--force' => true]);

        return 0;
    }
}
