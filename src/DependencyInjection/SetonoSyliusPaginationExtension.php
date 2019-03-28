<?php

declare(strict_types=1);

namespace Setono\SyliusPaginationPlugin\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class SetonoSyliusPaginationExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $container->setParameter('setono_sylius_pagination.page_parameter', $config['page_parameter']);
        $container->setParameter('setono_sylius_pagination.events', $config['events']);
        $container->setParameter('setono_sylius_pagination.listen_to_resources', $config['listen_to_resources']);

        $loader->load('services.xml');
    }
}
