<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PostsYesterdayEmail;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        \App\Console\Commands\SendCustomEmail::class,
    ];
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('emails:send')
                ->timezone("Asia/Rangoon") 
                ->fridays()
                ->at('08:00')
                //->dailyAt('09:27')
                ->withoutOverlapping();
        
        //send email to admin with yesterday last created post
        $schedule->call(function () {
            $yesterday = Carbon::yesterday();
            $posts = Post::whereDate('created_at', $yesterday)
                          ->where('status', 1)
                          ->orderBy('created_at', 'desc')
                          ->take(10)
                          ->get();
            $admins= User::where('type',0)->get();
            foreach($admins as $admin){
                Mail::to($admin->email)->send(new PostsYesterdayEmail($posts) );
            }
            
        }) ->timezone("Asia/Rangoon") 
            ->dailyAt('10:18');;
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
