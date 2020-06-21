<?php

namespace Tests\Support;

use App\Http\Clients\NewsClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

trait WorksWithNewsClient
{
    public function swapNewsClient(): MockHandler
    {
        $mockHandler = new MockHandler();
        $client      = new NewsClient([
            'handler' => HandlerStack::create($mockHandler),
        ]);
        $this->app->instance(NewsClient::class, $client);

        return $mockHandler;
    }

    public function mockSingleArticleResponse()
    {
        return new Response(200, [], json_encode([
            'status'       => 'ok',
            'totalResults' => 38,
            'articles'     => [
                [
                    'source'      => [
                        'id'   => null,
                        'name' => 'CNBC',
                    ],
                    'author'      => 'Thomas Franck',
                    'title'       => 'Another 1 million jobless claims show Congress may need to extend extra benefits set to expire - CNBC',
                    'description' => 'Economists say the latest jobless claims report shows adds weight to calls for the extension of expanded unemployment benefits.',
                    'url'         => 'https://www.cnbc.com/2020/06/18/another-1-million-jobless-claims-show-congress-may-need-to-extend-extra-benefits-set-to-expire.html',
                    'urlToImage'  => 'https://image.cnbcfm.com/api/v1/image/106464162-1585333686829gettyimages-1208426197.jpeg?v=1592487425',
                    'publishedAt' => '2020-06-18T18:25:03Z',
                    'content'     => 'The Labor Departments latest jobless claims report showed that employers across the U.S. are still laying off workers and added urgency to calls for an extension to bolstered unemployment ben',
                ],
            ],
        ]));
    }
}
