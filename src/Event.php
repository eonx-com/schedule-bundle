<?php
declare(strict_types=1);

namespace EonX\ScheduleBundle;

use Exception;
use EonX\ScheduleBundle\Interfaces\EventInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;

final class Event extends AbstractEvent
{
    /** @var bool */
    private $allowOverlapping = false;

    /** @var callable[] */
    private $before = [];

    /** @var string */
    private $command;

    /** @var \Symfony\Component\Console\Input\InputInterface */
    private $input;

    /** @var float */
    private $maxLockTime = 60.0;

    /** @var null|mixed[] */
    private $params;

    /** @var callable[] */
    private $then = [];

    /**
     * Event constructor.
     *
     * @param string $command
     * @param null|mixed[] $params
     */
    public function __construct(string $command, ?array $params = null)
    {
        $this->command = $command;
        $this->params = $params ?? [];
        $this->input = $this->buildInput();
    }

    /**
     * Check if event allows multiple instances to overlap.
     *
     * @return bool
     */
    public function allowsOverlapping(): bool
    {
        return $this->allowOverlapping;
    }

    /**
     * Register function to call before running the event.
     *
     * @param callable $func
     *
     * @return \EonX\ScheduleBundle\Interfaces\EventInterface
     */
    public function before(callable $func): EventInterface
    {
        $this->before[] = $func;

        return $this;
    }

    /**
     * Get description for display.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return (string)$this->input;
    }

    /**
     * Get lock resource.
     *
     * @return string
     */
    public function getLockResource(): string
    {
        return \sprintf('sf-schedule-%s', \sha1($this->getExpression() . $this->command));
    }

    /**
     * Get max lock time.
     *
     * @return float
     */
    public function getMaxLockTime(): float
    {
        return $this->maxLockTime;
    }

    /**
     * Check if event is due or not.
     *
     * @return bool
     */
    public function isDue(): bool
    {
        return $this->expressionPasses();
    }

    /**
     * Run event on given app.
     *
     * @param \Symfony\Component\Console\Application $app
     *
     * @return void
     *
     * @throws \Exception
     */
    public function run(Application $app): void
    {
        $this->runCallbacks($app, $this->before);

        $app->run($this->input);

        $this->runCallbacks($app, $this->then);
    }

    /**
     * Allow or not multiple instances of the same event to overlap.
     *
     * @param null|bool $allowOverlapping
     *
     * @return \EonX\ScheduleBundle\Interfaces\EventInterface
     */
    public function setAllowOverlapping(?bool $allowOverlapping = null): EventInterface
    {
        $this->allowOverlapping = $allowOverlapping ?? true;

        return $this;
    }

    /**
     * Set max lock time in seconds.
     *
     * @param float $seconds
     *
     * @return \EonX\ScheduleBundle\Interfaces\EventInterface
     */
    public function setMaxLockTime(float $seconds): EventInterface
    {
        $this->maxLockTime = $seconds;

        return $this;
    }

    /**
     * Register function to call after the event has ran.
     *
     * @param callable $func
     *
     * @return \EonX\ScheduleBundle\Interfaces\EventInterface
     */
    public function then(callable $func): EventInterface
    {
        $this->then[] = $func;

        return $this;
    }

    /**
     * Build input to run event.
     *
     * @return \Symfony\Component\Console\Input\InputInterface
     */
    private function buildInput(): InputInterface
    {
        $inputParams = ['command' => $this->command];

        foreach ($this->params as $key => $value) {
            $inputParams[$key] = $value;
        }

        return new ArrayInput($inputParams);
    }

    /**
     * Render exception in application.
     *
     * @param \Symfony\Component\Console\Application $app
     * @param \Exception $exception
     *
     * @return void
     */
    private function renderException(Application $app, Exception $exception): void
    {
        $app->renderException($exception, new ConsoleOutput());
    }

    /**
     * Run given callbacks and render exceptions in given app.
     *
     * @param \Symfony\Component\Console\Application $app
     * @param callable[] $callbacks
     *
     * @return void
     */
    private function runCallbacks(Application $app, array $callbacks): void
    {
        try {
            foreach ($callbacks as $callback) {
                \call_user_func($callback);
            }
        } catch (Exception $exception) {
            $this->renderException($app, $exception);
        }
    }
}
