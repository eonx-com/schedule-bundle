<?php
declare(strict_types=1);

namespace LoyaltyCorp\ScheduleBundle\Interfaces;

use LoyaltyCorp\CoreBundle\Services\Lock\Interfaces\LockServiceInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface ScheduleRunnerInterface
{
    /**
     * Run given schedule and display to given output.
     *
     * @param \LoyaltyCorp\ScheduleBundle\Interfaces\ScheduleInterface $schedule
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    public function run(ScheduleInterface $schedule, OutputInterface $output): void;

    /**
     * Set lock service.
     *
     * @param \LoyaltyCorp\CoreBundle\Services\Lock\Interfaces\LockServiceInterface $lockService
     *
     * @return \LoyaltyCorp\ScheduleBundle\Interfaces\ScheduleRunnerInterface
     */
    public function setLockService(LockServiceInterface $lockService): self;
}
