<?php
declare(strict_types=1);

namespace EonX\ScheduleBundle;

use EonX\ScheduleBundle\Interfaces\EventInterface;
use EonX\ScheduleBundle\Interfaces\ScheduleInterface;
use Symfony\Component\Console\Application;

final class Schedule implements ScheduleInterface
{
    /** @var \Symfony\Component\Console\Application */
    private $app;

    /** @var \EonX\ScheduleBundle\Interfaces\EventInterface[] */
    private $events = [];

    /**
     * Add schedule providers.
     *
     * @param \EonX\ScheduleBundle\Interfaces\ScheduleProviderInterface[] $providers
     *
     * @return self
     */
    public function addProviders(array $providers): ScheduleInterface
    {
        foreach ($providers as $provider) {
            $provider->schedule($this);
        }

        return $this;
    }

    /**
     * Create event for given command and parameters.
     *
     * @param string $command
     * @param null|mixed[] $parameters
     *
     * @return \EonX\ScheduleBundle\Interfaces\EventInterface
     */
    public function command(string $command, ?array $parameters = null): EventInterface
    {
        $this->events[] = $event = new Event($command, $parameters);

        return $event;
    }

    /**
     * Get application the schedule belongs to.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Console\Application
     */
    public function getApplication(): Application
    {
        return $this->app;
    }

    /**
     * Get due events.
     *
     * @return \EonX\ScheduleBundle\Interfaces\EventInterface[]
     */
    public function getDueEvents(): array
    {
        return \array_filter($this->events, static function (EventInterface $event): bool {
            return $event->isDue();
        });
    }

    /**
     * Set application.
     *
     * @param \Symfony\Component\Console\Application $app
     *
     * @return self
     */
    public function setApplication(Application $app): ScheduleInterface
    {
        $this->app = $app;
        $this->app->setAutoExit(false);

        return $this;
    }
}
