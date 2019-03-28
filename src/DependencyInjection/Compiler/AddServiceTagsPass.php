<?php

declare(strict_types=1);

namespace Setono\SyliusPaginationPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

final class AddServiceTagsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if ($container->has('setono_sylius_pagination.event_listener.add_pagination_links') === false) {
            return;
        }

        $eventListener = $container->getDefinition('setono_sylius_pagination.event_listener.add_pagination_links');

        if ($container->hasParameter('setono_sylius_pagination.events')) {
            $this->addEvents($eventListener, $container->getParameter('setono_sylius_pagination.events'));
        }

        $listenToResources = $container->hasParameter('setono_sylius_pagination.listen_to_resources') && ($container->getParameter('setono_sylius_pagination.listen_to_resources') === true);

        if ($listenToResources && $container->hasParameter('sylius.resources')) {
            $this->addResources($eventListener, $container->getParameter('sylius.resources'));
        }
    }

    private function addEvents(Definition $eventListener, array $events): void
    {
        foreach ($events as $event) {
            $eventListener->addTag('kernel.event_listener', ['event' => $event, 'method' => 'handle']);
        }
    }

    private function addResources(Definition $eventListener, array $resources): void
    {
        foreach ($resources as $resource => $attributes) {
            $eventListener->addTag('kernel.event_listener', ['event' => $resource . '.index', 'method' => 'handle']);
        }
    }
}
