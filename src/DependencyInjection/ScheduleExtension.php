<?php
declare(strict_types=1);

namespace LoyaltyCorp\ScheduleBundle\DependencyInjection;

use LoyaltyCorp\ScheduleBundle\Interfaces\ScheduleProviderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class ScheduleExtension extends Extension
{
    /**
     * {@inheritDoc}
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $container
            ->registerForAutoconfiguration(ScheduleProviderInterface::class)
            ->addTag(ScheduleProviderInterface::TAG_SCHEDULE_PROVIDER);
    }
}
