<?php
declare(strict_types=1);

namespace EonX\ScheduleBundle\Interfaces;

use EonX\CoreBundle\Services\Lock\Interfaces\LockServiceInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface ScheduleRunnerInterface
{
    /**
     * Run given schedule and display to given output.
     *
     * @param \EonX\ScheduleBundle\Interfaces\ScheduleInterface $schedule
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    public function run(ScheduleInterface $schedule, OutputInterface $output): void;

    /**
     * Set lock service.
     *
     * @param \EonX\CoreBundle\Services\Lock\Interfaces\LockServiceInterface $lockService
     *
     * @return \EonX\ScheduleBundle\Interfaces\ScheduleRunnerInterface
     */
    public function setLockService(LockServiceInterface $lockService): self;
}
