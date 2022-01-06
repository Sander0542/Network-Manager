<?php

namespace App\Console\Commands;

use Exception;
use DB;
use Illuminate\Console\Command;

class CheckConfigurationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the configuration of the environment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $appKey = config('app.key');
        if (strlen($appKey) != 32 || preg_match('/^[a-zA-Z0-9]{32}$/', $appKey, $matches, PREG_OFFSET_CAPTURE) == false) {
            $this->error('Invalid app key. Must be 32 characters of [a-zA-Z0-9]');
        }

        try {
            $results = DB::select(DB::raw('SELECT version() as `version`'));
            $this->info('Database: '.$results[0]->version);
        } catch (Exception) {
            $this->error('Could not connect to the database server');
        }
    }
}
