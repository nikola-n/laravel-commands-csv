<?php

namespace Tests\Feature;

use Tests\TestCase;
use Faker\Factory as Faker;

class ApiTester extends TestCase
{
    protected $fake;

    protected $times = 1;

    function __construct()
    {
        $this->fake = Faker::create();
    }

    protected function times(int $count)
    {
        $this->times = $count;
        return $this;
    }
}
