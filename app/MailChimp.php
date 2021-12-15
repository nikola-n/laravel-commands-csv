<?php

namespace App;

use Illuminate\Support\Facades\Http;

class MailChimp
{

    /**
     * @var \Illuminate\Support\Facades\Http
     */
    protected $http;

    public function __construct(Http $http)
    {
        $this->http = $http;
    }
}
