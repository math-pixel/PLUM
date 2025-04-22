<?php

namespace App\Scheduler;

use App\Message\UpdateAssetPricesMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use Symfony\Component\Scheduler\RecurringMessage;

class UpdateAssetPricesTask implements ScheduleProviderInterface
{
    public function getSchedule(): Schedule
    {
        return (new Schedule())->add(
            RecurringMessage::cron('@daily', new UpdateAssetPricesMessage())
        );

        // Pour tester rapidement tu peux remplacer par : RecurringMessage::every('1 minute', new UpdateAssetPricesMessage())
    }
}