<?php
declare(strict_types=1);

namespace EonX\ScheduleBundle;

use EonX\ScheduleBundle\DependencyInjection\Compiler\SchedulePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class ScheduleBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new SchedulePass());
    }
}
