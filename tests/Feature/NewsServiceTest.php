<?php

namespace Tests\Feature;

use App\Http\Clients\NewsClient;
use App\Services\NewsService;
use Carbon\Carbon;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\WorksWithNewsClient;
use Tests\TestCase;

class NewsServiceTest extends TestCase
{
    use WorksWithNewsClient;

    /**
     * @var NewsService
     */
    private $newsService;

    /**
     * @var \GuzzleHttp\Handler\MockHandler
     */
    private $mockHandler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockHandler = $this->swapNewsClient();
        $this->newsService = app(NewsService::class);
    }

    /** @test */
    public function testFetchingHeadlines(): void
    {
        $this->mockHandler->append($this->mockSingleArticleResponse());
        $results = $this->newsService->headlines();
        $this->assertCount(1, $results);
        $this->assertInstanceOf(Carbon::class, $results[0]['publishedAt']);
        $this->assertEquals('Thomas Franck', $results[0]['author']);
    }

}
