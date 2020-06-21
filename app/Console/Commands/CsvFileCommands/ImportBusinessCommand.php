<?php

namespace App\Console\Commands\CsvFileCommands;

use App\Business;
use App\Jobs\ProcessCsvUpload;
use Illuminate\Console\Command;

class ImportBusinessCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:business';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports business data';

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
        //does not work if you use redis.
        $files = new Business();
        $files->importToDb();
        ProcessCsvUpload::dispatch($files);
    }
}
