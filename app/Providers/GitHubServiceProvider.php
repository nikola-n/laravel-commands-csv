<?php

namespace App\Providers;

use App\Http\Clients\GitHubClient;
use App\Services\GitHubService;
use Illuminate\Support\ServiceProvider;

class GitHubServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GitHubClient::class, function () {
            return new GitHubClient([
                'base_uri' => 'https://api.github.com/',
                'headers'  => [
                    'auth' => ['nikolan995', 'ogledaloggmu7'],
                ],
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
