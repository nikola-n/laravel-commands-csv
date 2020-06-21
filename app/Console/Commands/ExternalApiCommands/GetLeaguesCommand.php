<?php

namespace App\Console\Commands\ExternalApiCommands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetLeaguesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:leagues';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all leagues';

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
        $response = Http::get($this->endpoint());
        $data     = json_decode($response->body());
        $this->info('Listing all the leagues...');
        foreach ($data->data as $name) {
            $this->comment($name->name);
        }
    }

    public function endpoint()
    {
        $key = config('services.clients.key');

        return "http://api.isportsapi.com/sport/football/league/basic?api_key={$key}";
    }
}
