<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AdminCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:crud {name}
        {--m|migration : Also create a basic database migration file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        if($this->option('migration')){
        $this->createMigration();
        }
    }

    public function createMigration()
    {
        $name = strtolower(\Str::plural($this->argument('name')));
        $this->call('make:migration', [
            'name' => "create_{$name}_table",
            '--create' => $name,
        ]);
        $this->info('Created migration successfully');
    }
}
