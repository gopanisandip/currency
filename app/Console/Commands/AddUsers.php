<?php

namespace App\Console\Commands;

use App\Models\Curruncy;
use App\Models\User;
use Illuminate\Console\Command;
use GuzzleHttp;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AddUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AddUsers {username} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'AddUsers';

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

        $user = new User;
        $user->username = $this->argument('username');
        $user->password =  Hash::make($this->argument('password'));
        $user->save();


dd($this->argument('username'), $this->argument('password'));

    }
}
