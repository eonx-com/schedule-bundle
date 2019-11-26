<?php
declare(strict_types=1);

namespace EonX\ScheduleBundle;

use EonX\CoreBundle\Services\Lock\Interfaces\LockServiceInterface;
use EonX\ScheduleBundle\Interfaces\ScheduleInterface;
use EonX\ScheduleBundle\Interfaces\ScheduleRunnerInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ScheduleRunner implements ScheduleRunnerInterface
{
    /** @var \EonX\CoreBundle\Services\Lock\Interfaces\LockServiceInterface */
    private $lockService;

    /** @var bool */
    private $ran = false;

    /**
     * ScheduleRunner constructor.
     *
     * @param \EonX\CoreBundle\Services\Lock\Interfaces\LockServiceInterface $lockService
     */
    public function __construct(LockServiceInterface $lockService)
    {
        $this->lockService = $lockService;
    }

    /**
     * Run given schedule and display to given output.
     *
     * @param \EonX\ScheduleBundle\Interfaces\ScheduleInterface $schedule
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    public function run(ScheduleInterface $schedule, OutputInterface $output): void
    {
        foreach ($schedule->getDueEvents() as $event) {
            if ($event->filtersPass() === false) {
                continue;
            }

            $this->ran = true;

            $description = $event->getDescription();
            $lock = $this->lockService->createLock($event->getLockResource(), $event->getMaxLockTime());

            $output->writeln(\sprintf('<info>Running scheduled command:</info> %s', $description));

            if ($event->allowsOverlapping() === false && $lock->acquire() === false) {
                $output->writeln(\sprintf('Abort execution of "%s" to prevent overlapping', $description));

                continue;
            }

            try {
                $event->run($schedule->getApplication());

                $lock->release();
            } finally {
                $lock->release();
            }
        }

        if ($this->ran === false) {
            $output->writeln('<info>No scheduled commands are ready to run.</info>');
        }
    }

    /**
     * Set lock service.
     *
     * @param \EonX\CoreBundle\Services\Lock\Interfaces\LockServiceInterface $lockService
     *
     * @return \EonX\ScheduleBundle\Interfaces\ScheduleRunnerInterface
     */
    public function setLockService(LockServiceInterface $lockService): ScheduleRunnerInterface
    {
        $this->lockService = $lockService;

        return $this;
    }
}
