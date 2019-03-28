<?php

declare(strict_types=1);

namespace Setono\SyliusPaginationPlugin;

use Setono\SyliusPaginationPlugin\DependencyInjection\Compiler\AddServiceTagsPass;
use Setono\SyliusPaginationPlugin\DependencyInjection\Compiler\RegisterEventHandlersPass;
use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SetonoSyliusPaginationPlugin extends Bundle
{
    use SyliusPluginTrait;

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new AddServiceTagsPass());
        $container->addCompilerPass(new RegisterEventHandlersPass());
    }
}
