<?php
declare(strict_types=1);

namespace EonX\ScheduleBundle\Interfaces;

interface ScheduleProviderInterface
{
    /** @var string */
    public const TAG_SCHEDULE_PROVIDER = 'schedule.provider';

    /**
     * Schedule command on given schedule.
     *
     * @param \EonX\ScheduleBundle\Interfaces\ScheduleInterface $schedule
     *
     * @return void
     */
    public function schedule(ScheduleInterface $schedule): void;
}
