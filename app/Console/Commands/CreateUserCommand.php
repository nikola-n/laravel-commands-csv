<?php

namespace App\Console\Commands;

use App\Role;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user';

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
        $name     = $this->ask('What\'s your name?');
        $email    = $this->ask('Enter your Email');
        $password = $this->secret('Password?');

        $roles = new Role();
        if(! $roles->exists) {
            $this->warn('Create Roles first with create:role command');
        }
        $roles = Role::all()->pluck('name')->toArray();
        $role = $this->choice('Your Role?', $roles);
        if ($role == 'admin') {
            $role_id = 1;
        } else if ($role == 'dev') {
            $role_id = 2;
        } else {
            $role_id = 3;
        }

        $checkEmail = User::where('email', $email)->first();
        if ($checkEmail) {
            $this->error('Email Exists');
            exit;
        }
        User::firstOrCreate([
            'name'     => $name,
            'email'    => $email,
            'password' => bcrypt($password),
            'role_id'  => $role_id,
        ]);

        $tableStringRole = Role::where('id', $role_id)->pluck('name');
        $displayUser     = [
            [
                'name'     => $name,
                'email'    => $email,
                'password' => $password,
                'role_id'  => $tableStringRole[0],
            ],
        ];
        $headers = ['First Name', 'Email', 'Password', 'Role'];
        $this->table($headers, $displayUser);
    }
}
