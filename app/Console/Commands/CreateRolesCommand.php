<?php

namespace App\Console\Commands;

use App\Role;
use Illuminate\Console\Command;

class CreateRolesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates role';

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
        $name = $this->ask('Enter Role:');
        $roles = new Role();
        $roles->name = $name;
        $roles->save();
        $this->info('Role was successfully created!');
    }
}
