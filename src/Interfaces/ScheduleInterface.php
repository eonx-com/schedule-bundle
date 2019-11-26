<?php
declare(strict_types=1);

namespace EonX\ScheduleBundle\Interfaces;

use Symfony\Component\Console\Application;

interface ScheduleInterface
{
    /**
     * Add schedule providers.
     *
     * @param \EonX\ScheduleBundle\Interfaces\ScheduleProviderInterface[] $providers
     *
     * @return self
     */
    public function addProviders(array $providers): self;

    /**
     * Create event for given command and parameters.
     *
     * @param string $command
     * @param null|mixed[] $parameters
     *
     * @return \EonX\ScheduleBundle\Interfaces\EventInterface
     */
    public function command(string $command, ?array $parameters = null): EventInterface;

    /**
     * Get application the schedule belongs to.
     *
     * @return \Symfony\Component\Console\Application
     */
    public function getApplication(): Application;

    /**
     * Get due events.
     *
     * @return \EonX\ScheduleBundle\Interfaces\EventInterface[]
     */
    public function getDueEvents(): array;

    /**
     * Set application.
     *
     * @param \Symfony\Component\Console\Application $app
     *
     * @return self
     */
    public function setApplication(Application $app): self;
}
