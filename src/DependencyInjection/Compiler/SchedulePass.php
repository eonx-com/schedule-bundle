<?php
declare(strict_types=1);

namespace EonX\ScheduleBundle\DependencyInjection\Compiler;

use EonX\ScheduleBundle\Interfaces\ScheduleInterface;
use EonX\ScheduleBundle\Interfaces\ScheduleProviderInterface;
use EonX\ScheduleBundle\Interfaces\TraceableScheduleInterface;
use EonX\ScheduleBundle\TraceableSchedule;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class SchedulePass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container): void
    {
        $this->registerSchedule($container);
    }

    /**
     * Get references for scheduled command providers.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return \Symfony\Component\DependencyInjection\Reference[]
     */
    private function getProviderReferences(ContainerBuilder $container): array
    {
        $tagged = $container->findTaggedServiceIds(ScheduleProviderInterface::TAG_SCHEDULE_PROVIDER);
        $references = [];

        foreach (\array_keys($tagged) as $id) {
            $references[] = new Reference($id);
        }

        return $references;
    }

    /**
     * Register schedule and traceable schedule if debug.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    private function registerSchedule(ContainerBuilder $container): void
    {
        if ($container->getParameter('kernel.debug')) {
            $container
                ->register(TraceableScheduleInterface::class, TraceableSchedule::class)
                ->setDecoratedService(ScheduleInterface::class)
                ->addArgument(new Reference(\sprintf('%s.inner', TraceableScheduleInterface::class)))
                ->addMethodCall('addProviders', [$this->getProviderReferences($container)]);

            return;
        }

        $schedule = $container->findDefinition(ScheduleInterface::class);
        $schedule->addMethodCall('addProviders', [$this->getProviderReferences($container)]);
    }
}
