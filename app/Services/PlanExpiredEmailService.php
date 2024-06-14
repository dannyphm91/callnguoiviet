<?php

namespace App\Services;

use App\Jobs\PlanExpiredNotificationJob;

class PlanExpiredEmailService
{
    public function privacy()
    {
        dispatch(new PlanExpiredNotificationJob());

    }
}
