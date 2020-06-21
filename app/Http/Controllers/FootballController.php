<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FootballController extends Controller
{
    public function index()
    {

        $response = Http::get($this->endpoint());
        $data = json_decode($response->body());

        return view('welcome', compact('data'));
    }

    public function endpoint()
    {
        $key = config('services.clients.key');

        return "http://api.isportsapi.com/sport/football/league/basic?api_key={$key}";
    }
}
