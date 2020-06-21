<?php

namespace App\Services;

use App\Http\Clients\NewsClient;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class NewsService
{
    /**
     * @var \App\Http\Clients\NewsClient
     */
    protected $client;

    public function __construct(NewsClient $client)
    {
        $this->client = $client;
    }

    public function headlines(): Collection
    {
        //retrieve data from api
        $response = $this->client->get('everything?q=bitcoin&from=2020-05-18&sortBy=publishedAt');

        $body = json_decode((string)$response->getBody(), true);
        //convert the data to a collection
        $collection = collect($body['articles'])->map(function ($article) {
            return [
                'author'      => $article['author'],
                'title'       => $article['title'],
                'url'         => $article['url'],
                'imageUrl'    => $article['urlToImage'],
                'publishedAt' => $article['publishedAt'] !== null ? Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $article['publishedAt']) : 'unknown',
            ];
        });
        //return the collection
        return $collection;
    }
}
