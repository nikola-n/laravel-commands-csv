<?php

namespace Tests\Feature;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsTest extends ApiTester
{
    use RefreshDatabase;

    /** @test */
    public function it_fetches_products()
    {
        $this->times(5)->makeProduct();

        $this->json('api/v1/products');

        $this->assertStatus(200);
    }

    protected function makeProduct($productFields = [])
    {
        $product = array_merge([
            'title'        => $this->fake->sentence,
            'body'         => $this->fake->text,
            'some-boolean' => $this->fake->boolean,
        ], $productFields);

        while ($this->times--) {
            Product::create($product);
        }
    }
}
