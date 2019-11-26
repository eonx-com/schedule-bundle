<div align="center">
    <h1>EonX - ScheduleBundle</h1>
    <p>Provides the Command Scheduling logic of Laravel in a Symfony application.</p>
</div>

---

## Installation

```bash
$ composer require eonx-com/schedule-bundle
```

Until a recipe is created for this bundle you will need to register it manually:

```php
// config/bundles.php

return [
    // Other bundles...
    
    EonX\ScheduleBundle\ScheduleBundle::class => ['all' => true],
];
```

## Usage

### Register Your Scheduled Commands

To register the scheduled commands this bundle implements a concept of "schedule providers", thanks to Symfony's
autoconfigure feature, the only thing required is to create services that implement `EonX\ScheduleBundle\Interfaces\ScheduleProviderInterface`.
The `ScheduleInterface` passed to the `schedule` method offers all the features of the [Laravel Console Scheduling][1].

```php
// src/Schedule/MyScheduleProvider.php

use EonX\ScheduleBundle\Interfaces\ScheduleProviderInterface;

final class MyScheduleProvider implements ScheduleProviderInterface
{
    /**
     * Schedule command on given schedule.
     *
     * @param \EonX\ScheduleBundle\Interfaces\ScheduleInterface $schedule
     *
     * @return void
     */
    public function schedule(ScheduleInterface $schedule): void
    {
        $schedule
            ->command('poc:hello-world', ['-v'])
            ->everyMinute()
            ->setMaxLockTime(120);
    
        $schedule
            ->command('poc:hello-world-2')
            ->everyFiveMinutes();
        }
    }
}
```

### Run The Schedule

This bundle providers a console command to run the schedule:

```bash
$ php bin/console schedule:run
```

[1]: https://laravel.com/docs/5.8/scheduling
