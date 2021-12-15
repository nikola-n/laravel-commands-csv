<?php

namespace Tests\Feature;

use App\Acme\Transformers\TagTransformer;
use App\Container;
use App\Newsletter;
use Tests\TestCase;

class ContainerTest extends TestCase
{
    /** @test */
    public function LEVEL_ONE_it_can_bind_keys_to_values()
    {
        $container = new Container();
        $container->bind('foo', 'bar');
        $this->assertEquals('bar', $container->get('foo'));
    }

    /** @test */
    public function LEVEL_TWO_it_can_lazily_resolve_functions()
    {
        $container = new Container();

        $container->singleton('tag-transformer', function () {
            return new TagTransformer();
        });
        //$container->bind('tag-transformer', function (){
        //    return new TagTransformer();
        //});
        $this->assertInstanceOf(TagTransformer::class, $container->get('tag-transformer'));
    }

    /** @test */
    public function LEVEL_THREE_it_can_do_magic()
    {
        $container = new Container();

        $this->assertInstanceOf(Newsletter::class, $container->get(Newsletter::class));
    }
}
