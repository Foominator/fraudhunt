<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {name : The user`s name} {email : The user`s email} {password : The user`s password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin command';

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
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');

        if (User::where('name', $name)->orWhere('email', $email)->exists()) {
            dd('User already exists');
        }

        $admin = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
        dd("New admin`s ID = $admin->id");
        return 0;
    }
}
