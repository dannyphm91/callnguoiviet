<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\PlanExpiredNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Plan\Entities\Plan;

class PlanExpiredEmailSendCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plan:expired-notice';

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
     * @return int
     */
    public function handle()
    {
        $users = User::with('userPlan')->get();
        foreach ($users as $user) {
            $plan_expired_date = $user->userPlan->expired_date;
            if ($plan_expired_date) {
                $today_date = Carbon::now()->format('Y-m-d');
                if ($today_date == $plan_expired_date) {
                    if (checkMailConfig()) {
                        $plan = Plan::where('id', $user->userPlan->current_plan_id)->first();
                        $expired_date = Plan::where('id', $user->userPlan->expired_date)->first();

                        $user->notify(new PlanExpiredNotification($user, $plan, $expired_date));
                    }
                }
            }
        }
    }
}
