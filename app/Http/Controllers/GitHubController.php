<?php

namespace App\Http\Controllers;

use App\Services\GitHubService;
use Illuminate\Http\Request;

class GitHubController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request    $request
     * @param \App\Services\GitHubService $github
     *
     * @return void
     */
    public function __invoke(Request $request, GitHubService $github)
    {
        $commits = $github->githubActivity();
        dd($commits);
    }
}
