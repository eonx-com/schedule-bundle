<?php
declare(strict_types=1);

namespace LoyaltyCorp\ScheduleBundle\Interfaces;

interface TraceableScheduleInterface extends ScheduleInterface
{
    /**
     * Get events indexed by their profiler class.
     *
     * @return \LoyaltyCorp\ScheduleBundle\Interfaces\EventInterface[]
     */
    public function getEvents(): array;

    /**
     * Get providers.
     *
     * @return \LoyaltyCorp\ScheduleBundle\Interfaces\ScheduleProviderInterface[]
     */
    public function getProviders(): array;
}
