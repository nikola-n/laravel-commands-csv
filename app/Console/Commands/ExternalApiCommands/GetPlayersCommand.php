<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetPlayersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:players';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Players Command';

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
        foreach ($results['data'] as $players) {
            $this->info('This is Real Madrid squad member:');
            $this->comment("Player Name: {$players['name']}");
            $this->comment("Country: {$players['country']}");
            $this->comment("Position:{$players['position']}");
            $this->comment("Market Value:{$players['value']}");
            $this->comment("Number:{$players['number']}");
        }
    }

    public function endpoint()
    {
        $key = config('services.clients.key');

        return "http://api.isportsapi.com/sport/football/player?api_key={$key}&teamId=82";
    }
}

