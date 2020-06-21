<?php

namespace App\Console\Commands;

use App\Services\GitHubService;
use Illuminate\Console\Command;
use phpDocumentor\Reflection\Types\Parent_;

class ShowCommitsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'show:commits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shows all commits on Flexdelt Project';

    /**
     * @var \App\Services\GitHubService
     */
    protected $results;

    /**
     * @param \App\Services\GitHubService $results
     */
    public function __construct(GitHubService $results)
    {
        parent::__construct();

        $this->results = $results;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $commits = $this->results->githubActivity();

        $this->info('Here are all commits made on flexdelft project');
        for($i=0; $i < count($commits); $i++)
        {
            $this->info('Commit number: '.$i );
            $this->comment('Author: ' .$commits[$i]['author']);
            $this->comment('Author email: '.$commits[$i]['email']);
            $this->comment('Message: '.$commits[$i]['message']);
            $this->comment('Time: '.$commits[$i]['date']);
            $this->line('----------------------');
        }
    }
}
