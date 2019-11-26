<?php
declare(strict_types=1);

namespace EonX\ScheduleBundle\DataCollector;

use EonX\ScheduleBundle\Interfaces\ScheduleInterface;
use EonX\ScheduleBundle\Interfaces\TraceableScheduleInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

final class ScheduleDataCollector extends DataCollector
{
    /** @var string */
    public const NAME = 'schedule.schedule_collector';

    /** @var \EonX\ScheduleBundle\Interfaces\ScheduleInterface */
    private $schedule;

    /**
     * ScheduleDataCollector constructor.
     *
     * @param \EonX\ScheduleBundle\Interfaces\ScheduleInterface $schedule
     */
    public function __construct(ScheduleInterface $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * {@inheritDoc}
     *
     * @throws \ReflectionException
     */
    public function collect(Request $request, Response $response, \Exception $exception = null): void
    {
        if (($this->schedule instanceof TraceableScheduleInterface) === false) {
            return;
        }

        /** @var \EonX\ScheduleBundle\Interfaces\TraceableScheduleInterface $schedule */
        $schedule = $this->schedule;

        $this->data['providers'] = [];
        $this->data['events'] = [];

        foreach ($schedule->getProviders() as $provider) {
            $class = \get_class($provider);

            $this->data['providers'][$class] = [
                'class' => $class,
                'events_count' => 0,
                'file' => (new \ReflectionClass($class))->getFileName()
            ];
        }

        foreach ($schedule->getEvents() as $provider => $events) {
            $this->data['providers'][$provider]['events_count'] = \count($events);

            foreach ($events as $event) {
                /** @var \EonX\ScheduleBundle\Interfaces\EventInterface $event */
                $this->data['events'][] = [
                    'allowsOverlapping' => $event->allowsOverlapping(),
                    'description' => $event->getDescription(),
                    'cronExpression' => $event->getCronExpression(),
                    'maxLockTime' => $event->getMaxLockTime(),
                    'lockResource' => $event->getLockResource(),
                    'provider' => $this->data['providers'][$provider],
                    'timezone' => $event->getTimezone()
                ];
            }
        }
    }

    /**
     * Get events.
     *
     * @return mixed[]
     */
    public function getEvents(): array
    {
        return $this->data['events'];
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * Get providers.
     *
     * @return string[]
     */
    public function getProviders(): array
    {
        return $this->data['providers'];
    }

    /**
     * {@inheritDoc}
     */
    public function reset(): void
    {
        $this->data = [];
    }
}
