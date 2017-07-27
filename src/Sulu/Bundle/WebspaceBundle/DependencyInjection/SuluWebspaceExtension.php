<?php

namespace Sulu\Bundle\WebspaceBundle\DependencyInjection;

use Sulu\Bundle\WebspaceBundle\Model\Portal;
use Sulu\Bundle\WebspaceBundle\Model\Url;
use Sulu\Bundle\WebspaceBundle\Model\Webspace;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class SuluWebspaceExtension extends ConfigurableExtension
{
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $container->getDefinition('sulu_webspace.webspace_collection')->replaceArgument(
            0,
            $this->loadWebspaces($mergedConfig['webspaces'])
        );
    }

    private function loadWebspaces(array $webspaceConfigs)
    {
        $webspaces = [];
        foreach ($webspaceConfigs as $webspaceKey => $webspaceConfig) {
            $webspace = new Definition(
                Webspace::class,
                [$webspaceConfig['name'], $this->loadPortals($webspaceConfig['portals'])]
            );
            $webspaces[$webspaceKey] = $webspace;
        }

        return $webspaces;
    }

    private function loadPortals(array $portalConfigs)
    {
        $portals = [];
        foreach ($portalConfigs as $portalKey => $portalConfig) {
            $portal = new Definition(
                Portal::class,
                [$this->loadUrls($portalConfig['urls'])]
            );

            $portals[$portalKey] = $portal;
        }

        return $portals;
    }

    private function loadUrls($urlConfigs)
    {
        $urls = [];
        foreach ($urlConfigs as $urlConfig) {
            $urls[] = new Definition(
                Url::class,
                [$urlConfig['pattern'], $urlConfig['host']]
            );
        }

        return $urls;
    }
}
