<?php

namespace App\Console\Commands;

use App\Movie;
use Illuminate\Console\Command;

class CreateMovieCommad extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:movie {title} {genre} {cost?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates new movies';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $movie        = new Movie();
        $movie->title = $this->argument('title');
        $movie->genre = $this->argument('genre');
        $movie->cost  = $this->argument('cost');
        if ($this->argument('cost') == null) {
            $cost        = $this->ask('How much does this movie cost');
            $movie->cost = $cost;
        }
        $headers = ['Title', 'Genre', 'Cost'];
        $movies = Movie::all(['title','genre','cost'])->toArray();
        $this->table($headers, $movies);
        $this->alreadyExist();
        $movie->save();

        $this->comment('Movie Created!');
    }

    public function alreadyExist()
    {
        $arguments = $this->argument();
        //$movies = Movie::where('title', $arguments['title'])->first();
        //if($movies) {
        //    $this->error('Exists..');
        //    exit;
        $movies    = Movie::all()->toArray();
        foreach ($movies as $movie) {
            if ($movie['title'] == ($arguments['title'])) {
                $this->error('Already Exists');
                exit;
            }
        }

    }

}
