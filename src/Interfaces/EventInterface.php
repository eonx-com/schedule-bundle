<?php
declare(strict_types=1);

namespace LoyaltyCorp\ScheduleBundle\Interfaces;

use Symfony\Component\Console\Application;

interface EventInterface
{
    /**
     * Check if event allows multiple instances to overlap.
     *
     * @return bool
     */
    public function allowsOverlapping(): bool;

    /**
     * Schedule the command at a given time.
     *
     * @param string $time
     *
     * @return self
     */
    public function at(string $time): self;

    /**
     * Register function to call before running the event.
     *
     * @param callable $func
     *
     * @return \LoyaltyCorp\ScheduleBundle\Interfaces\EventInterface
     */
    public function before(callable $func): self;

    /**
     * Schedule the event to run between start and end time.
     *
     * @param string $startTime
     * @param string $endTime
     *
     * @return $this
     */
    public function between(string $startTime, string $endTime): self;

    /**
     * The Cron expression representing the event's frequency.
     *
     * @param string $expression
     *
     * @return self
     */
    public function cron(string $expression): self;

    /**
     * Schedule the event to run daily.
     *
     * @return self
     */
    public function daily(): self;

    /**
     * Schedule the event to run daily at a given time (10:00, 19:30, etc).
     *
     * @param string $time
     *
     * @return self
     */
    public function dailyAt(string $time): self;

    /**
     * Set the days of the week the command should run on.
     *
     * @param mixed[]|mixed $days
     *
     * @return self
     */
    public function days($days): self;

    /**
     * Schedule the event to run every fifteen minutes.
     *
     * @return self
     */
    public function everyFifteenMinutes(): self;

    /**
     * Schedule the event to run every five minutes.
     *
     * @return self
     */
    public function everyFiveMinutes(): self;

    /**
     * Schedule the event to run every minute.
     *
     * @return self
     */
    public function everyMinute(): self;

    /**
     * Schedule the event to run every ten minutes.
     *
     * @return self
     */
    public function everyTenMinutes(): self;

    /**
     * Schedule the event to run every thirty minutes.
     *
     * @return self
     */
    public function everyThirtyMinutes(): self;

    /**
     * Check if the filters pass for the event.
     *
     * @return bool
     */
    public function filtersPass(): bool;

    /**
     * Schedule the event to run only on Fridays.
     *
     * @return self
     */
    public function fridays(): self;

    /**
     * Get cron expression.
     *
     * @return string
     */
    public function getCronExpression(): string;

    /**
     * Get description for display.
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Get lock resource.
     *
     * @return string
     */
    public function getLockResource(): string;

    /**
     * Get max lock time.
     *
     * @return float
     */
    public function getMaxLockTime(): float;

    /**
     * Get timezone.
     *
     * @return string
     */
    public function getTimezone(): string;

    /**
     * Schedule the event to run hourly.
     *
     * @return self
     */
    public function hourly(): self;

    /**
     * Schedule the event to run hourly at a given offset in the hour.
     *
     * @param int $offset
     *
     * @return self
     */
    public function hourlyAt(int $offset): self;

    /**
     * Check if event is due or not.
     *
     * @return bool
     */
    public function isDue(): bool;

    /**
     * Schedule the event to run only on Mondays.
     *
     * @return self
     */
    public function mondays(): self;

    /**
     * Schedule the event to run monthly.
     *
     * @return self
     */
    public function monthly(): self;

    /**
     * Schedule the event to run monthly on a given day and time.
     *
     * @param null|int $day
     * @param null|string $time
     *
     * @return self
     */
    public function monthlyOn(?int $day = null, ?string $time = null): self;

    /**
     * Schedule the event to run quarterly.
     *
     * @return self
     */
    public function quarterly(): self;

    /**
     * Run event on given app.
     *
     * @param \Symfony\Component\Console\Application $app
     *
     * @return void
     */
    public function run(Application $app): void;

    /**
     * Schedule the event to run only on Saturdays.
     *
     * @return self
     */
    public function saturdays(): self;

    /**
     * Allow or not multiple instances of the same event to overlap.
     *
     * @param null|bool $allowOverlapping
     *
     * @return \LoyaltyCorp\ScheduleBundle\Interfaces\EventInterface
     */
    public function setAllowOverlapping(?bool $allowOverlapping = null): self;

    /**
     * Set max lock time in seconds.
     *
     * @param float $seconds
     *
     * @return \LoyaltyCorp\ScheduleBundle\Interfaces\EventInterface
     */
    public function setMaxLockTime(float $seconds): self;

    /**
     * Set the timezone the date should be evaluated on.
     *
     * @param \DateTimeZone|string $timezone
     *
     * @return self
     */
    public function setTimezone($timezone): self;

    /**
     * Register a callback to further filter the schedule.
     *
     * @param callable|bool $callback
     *
     * @return self
     */
    public function skip($callback): self;

    /**
     * Splice the given value into the given position of the expression.
     *
     * @param int $position
     * @param int|string $value
     *
     * @return self
     */
    public function spliceIntoPosition(int $position, $value): self;

    /**
     * Schedule the event to run only on Sundays.
     *
     * @return self
     */
    public function sundays(): self;

    /**
     * Register function to call after the event has ran.
     *
     * @param callable $func
     *
     * @return \LoyaltyCorp\ScheduleBundle\Interfaces\EventInterface
     */
    public function then(callable $func): self;

    /**
     * Schedule the event to run only on Thursdays.
     *
     * @return self
     */
    public function thursdays(): self;

    /**
     * Schedule the event to run only on Tuesdays.
     *
     * @return self
     */
    public function tuesdays(): self;

    /**
     * Schedule the event to run twice daily.
     *
     * @param null|int $first
     * @param null|int $second
     *
     * @return self
     */
    public function twiceDaily(?int $first = null, ?int $second = null): self;

    /**
     * Schedule the event to run twice monthly.
     *
     * @param null|int $first
     * @param null|int $second
     *
     * @return self
     */
    public function twiceMonthly(?int $first = null, ?int $second = null): self;

    /**
     * Schedule the event to not run between start and end time.
     *
     * @param string $startTime
     * @param string $endTime
     *
     * @return self
     */
    public function unlessBetween(string $startTime, string $endTime): self;

    /**
     * Schedule the event to run only on Wednesdays.
     *
     * @return self
     */
    public function wednesdays(): self;

    /**
     * Schedule the event to run only on weekdays.
     *
     * @return self
     */
    public function weekdays(): self;

    /**
     * Schedule the event to run only on weekends.
     *
     * @return self
     */
    public function weekends(): self;

    /**
     * Schedule the event to run weekly.
     *
     * @return self
     */
    public function weekly(): self;

    /**
     * Schedule the event to run weekly on a given day and time.
     *
     * @param int $day
     * @param null|string $time
     *
     * @return self
     */
    public function weeklyOn(int $day, ?string $time = null): self;

    /**
     * Register a callback to further filter the schedule.
     *
     * @param callable|bool $callback
     *
     * @return self
     */
    public function when($callback): self;

    /**
     * Schedule the event to run yearly.
     *
     * @return self
     */
    public function yearly(): self;
}
