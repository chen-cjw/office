<?php

namespace App\Console;

use App\Models\Team;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            // 订阅消息推送
            DB::table('teams')->where('close_time',date('Y-m-d'))->chunk(100, function ($users) {
                // Process the records...

                return false;
            });
            $teams = Team::get();
            foreach ($teams as $k) {
                $user = User::find($k->user_id);
                service_due($user->ml_openid,$k->name,$k->close_time,'请尽快续费，以免影响您的使用！');
            }

        })->everyMinute();
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
