<?php

namespace App\Console\Commands\ExternalApiCommands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetMatchesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:matches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Today fixtures';

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
     * @return mixed
     */
    public function handle()
    {
        $results = Http::get($this->endpoint())->json();
        foreach ($results['data'] as $fixture) {
            $this->info('Today are playing:');
            $this->comment("{$fixture['homeName']} vs {$fixture['awayName']}");
            $this->comment("League:{$fixture['leagueName']}");
            $this->comment("At: {$fixture['location']}");
        }
    }

    public function endpoint()
    {
        $key = config('services.clients.key');

        return "http://api.isportsapi.com/sport/football/livescores?api_key={$key}";
    }

}
