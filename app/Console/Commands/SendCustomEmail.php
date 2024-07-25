<?php

namespace App\Console\Commands;

use App\Mail\MyCustomMail;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
class SendCustomEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send';
    protected $description = 'Send custom emails';

    /**
     * The console command description.
     *
     * @var string
     */


    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $users = User::all();
        foreach($users as $user){
            Mail::to($user->email)->send(new MyCustomMail($user));
        }
        $this->info('Email Send Successfully.');
    }
}
