<?php

namespace Black\Bundle\PageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;


/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('black_page');

        $supportedDrivers = array('mongodb');

        $rootNode
            ->children()

                ->scalarNode('db_driver')
                    ->isRequired()
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The database driver must be either \'mongodb\'.')
                    ->end()
                ->end()

                ->scalarNode('page_class')->isRequired()->cannotBeEmpty()->end()

            ->end()
        ;

        $this->addPageSection($rootNode);
        $this->addConfigSection($rootNode);

        return $treeBuilder;
    }

    private function addPageSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('page')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                        ->children()
                        ->arrayNode('form')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('name')->defaultValue('black_page_page_form')->end()
                                ->scalarNode('type')->defaultValue('Black\\Bundle\\PageBundle\\Form\\Type\\PageType')->end()
                                ->scalarNode('handler')->defaultValue('Black\\Bundle\\PageBundle\\Form\\Handler\\PageFormHandler')->end()
                                ->scalarNode('enabled_list')->defaultValue('Black\\Bundle\\PageBundle\\Form\\ChoiceList\\EnabledList')->end()
                                ->scalarNode('status_list')->defaultValue('Black\\Bundle\\PageBundle\\Form\\ChoiceList\\StatusList')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addConfigSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('config')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                        ->children()
                        ->arrayNode('form')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('page_config_name')->defaultValue('black_page_config')->end()
                                ->scalarNode('page_config_type')->defaultValue('Black\\Bundle\\PageBundle\\Form\\Type\\PageConfigType')->end()
                                ->scalarNode('page_config_handler')->defaultValue('Black\\Bundle\\EngineBundle\\Form\\Handler\\ConfigFormHandler')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
