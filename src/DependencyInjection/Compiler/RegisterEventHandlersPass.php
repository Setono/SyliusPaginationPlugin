<?php

declare(strict_types=1);

namespace Setono\SyliusPaginationPlugin\DependencyInjection\Compiler;

use Setono\SyliusPaginationPlugin\EventHandler\CompositeEventHandler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterEventHandlersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $compositeEventHandler = new Definition(CompositeEventHandler::class);

        foreach ($container->findTaggedServiceIds('setono_sylius_pagination.event_handler') as $id => $attributes) {
            $compositeEventHandler->addArgument(new Reference($id));
        }

        $container->setDefinition('setono_sylius_pagination.event_handler.composite', $compositeEventHandler);
    }
}
