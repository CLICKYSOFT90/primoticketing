<?php

namespace App\Console;

use App\Helpers\Cron;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\CronJob;
use Illuminate\Support\Facades\Log;
use App\Helpers\Common;

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
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /*if (strpos(php_sapi_name(), 'cli') !== false) {
            try {
                $hosts = Common::getEnvHost();
                foreach ($hosts as $key => $host) {
                    Common::setEnvForCLI($host);
                    $jobs = CronJob::where('active', 1)->withoutGlobalScope('facilityFilter')->get();
                    if (!$jobs->isEmpty()) {
                        foreach ($jobs as $job) {
                            $frequencyFunc = $job->frequency_func;
                            $method = $job->function;
                            $timeZone = $job->timezone;
                            if (method_exists(Cron::class, $method)) {
                                try {
                                    $schedule->call(function () use ($job, $host) {
                                        Log::channel('cron')->info('================ START ==================');
                                        Common::setEnvForCLI($host);
                                        $function = $job->function;
                                        Cron::$function($job->function_arg_1, $job->function_arg_2, $job->model_type, $job->model_id);
                                        $job->total_execution = $job->total_execution + 1;
                                        $job->save();
                                        Log::channel('cron')->info($host.' CRON # '.$job->id.': ' . $job->function . ', Dated: ' . \Carbon\Carbon::now());
                                        Log::channel('cron')->info('================ STOP ==================');
                                    })->name($host . '_cron_job_' . $job->id)->withoutOverlapping()->runInBackground()->$frequencyFunc($job->frequency_func_arg_1, $job->frequency_func_arg_2);
                                } catch (\Exception $ex) {
                                    Log::channel('cron')->info('================ ERROR ==================');
                                    Log::channel('cron')->info('================ START ==================');
                                    Log::channel('cron')->info("ERROR: " . $ex->getMessage() . ' ' . \Carbon\Carbon::now());
                                    Log::channel('cron')->info('================ STOP ==================');
                                }
                            }
                        }
                    }
                }
            } catch (\Exception $ex) {
                Log::channel('cron')->info('================ ERROR ==================');
                Log::channel('cron')->info('================ START ==================');
                Log::channel('cron')->info("ERROR: " . $ex->getMessage() . ' ' . \Carbon\Carbon::now());
                Log::channel('cron')->info('================ STOP ==================');
            }
        }*/
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}