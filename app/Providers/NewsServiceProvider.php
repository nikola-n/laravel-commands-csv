<?php

namespace App\Providers;

use App\Http\Clients\NewsClient;
use Illuminate\Support\ServiceProvider;

class NewsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(NewsClient::class, function () {
           $config = $this->app->get('config')['news'];
            return new NewsClient([
                'base_uri' => $config['base_uri'],
                'headers' => [
                    'Authorization' => $config['api_token']
                ]
            ]);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
