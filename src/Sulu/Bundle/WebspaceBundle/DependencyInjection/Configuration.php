<?php

namespace Sulu\Bundle\WebspaceBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sulu_webspace');

        $rootNode
            ->fixXmlConfig('webspace')
            ->children()
                ->arrayNode('webspaces')
                    ->useAttributeAsKey('key')
                    ->prototype('array')
                        ->fixXmlConfig('localization')
                        ->fixXmlConfig('portal')
                        ->validate()
                            ->ifTrue(function($webspace) {
                                $localizationKeys = array_keys($webspace['localizations']);
                                foreach ($webspace['portals'] as $portal) {
                                    foreach ($portal['urls'] as $url) {
                                        if (isset($url['localization'])
                                            && !in_array($url['localization'], $localizationKeys)
                                        ) {
                                            return true;
                                        }
                                    }
                                }

                                return false;
                            })
                            ->thenInvalid('A URL uses a not specified localization: %s')
                        ->end()
                        ->children()
                            ->scalarNode('name')->cannotBeEmpty()->end()
                            // TODO should localizations be part of this bundle?
                            ->arrayNode('localizations')
                                ->useAttributeAsKey('key')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('language')->cannotBeEmpty()->end()
                                        ->scalarNode('country')->end()
                                        ->booleanNode('default')->end()
                                        ->booleanNode('x_default')->end()
                                        // TODO how to support nesting of localizations?
                                    ->end()
                                ->end()
                            ->end()
                            // TODO how to handle themes? Maybe configure in theme bundle instead?
                            // TODO default-templates
                            // TODO templates
                            // TODO navigation
                            ->arrayNode('portals')
                                ->useAttributeAsKey('key')
                                ->isRequired()
                                ->requiresAtLeastOneElement()
                                ->prototype('array')
                                    ->fixXmlConfig('url')
                                    ->children()
                                        ->arrayNode('urls')
                                            ->isRequired()
                                            ->requiresAtLeastOneElement()
                                            ->prototype('array')
                                                ->children()
                                                    ->scalarNode('localization')->end()
                                                    ->scalarNode('host')->defaultValue(null)->end()
                                                    ->scalarNode('pattern')->defaultValue(null)->end()
                                                ->end()
                                            ->end()
                                        ->end()
                                        // TODO custom-urls
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
