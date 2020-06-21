<?php

namespace App\Services;

use App\Http\Clients\GitHubClient;
use Carbon\Carbon;
use GuzzleHttp\Client;

class GitHubService
{
    /**
     * @var \App\Http\Clients\GitHubClient
     */
    protected $client;

    /**
     * @param \App\Http\Clients\GitHubClient $client
     */
    public function __construct(GitHubClient $client)
    {
        $this->client = $client;
    }

    public function githubActivity()
    {
        $response   = $this->client->get('https://api.github.com/repos/thecodeconnectors/flexdelft/commits', [
            'auth' => [
                'nikolan995',
                'ogledaloggmu7',
            ],
        ]);
        $body       = json_decode((string)$response->getBody(), true);
        $collection = collect($body)->map(function ($commits) {
            return [
                'author'  => $commits['commit']['author']['name'],
                'email'   => $commits['commit']['author']['email'],
                'message' => $commits['commit']['message'],
                'date'    => $commits['commit']['committer']['date'] !== null ? Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $commits['commit']['committer']['date']) : 'unknown',
            ];
        });

        return $collection;
    }
}
