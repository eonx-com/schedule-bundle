<?php
declare(strict_types=1);

namespace EonX\ScheduleBundle\Interfaces;

interface TraceableScheduleInterface extends ScheduleInterface
{
    /**
     * Get events indexed by their profiler class.
     *
     * @return \EonX\ScheduleBundle\Interfaces\EventInterface[]
     */
    public function getEvents(): array;

    /**
     * Get providers.
     *
     * @return \EonX\ScheduleBundle\Interfaces\ScheduleProviderInterface[]
     */
    public function getProviders(): array;
}
