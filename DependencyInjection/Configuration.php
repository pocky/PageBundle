<?php

namespace Black\Bundle\PageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see 
 * {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    private $alias;

    /**
     * @param string $alias
     */
    public function __construct($alias)
    {
        $this->alias = $alias;
    }

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root($this->alias);

        $supportedDrivers = array('mongodb', 'orm');

        $rootNode
            ->children()

                ->scalarNode('db_driver')
                    ->isRequired()
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The database driver must be either \'mongodb\', \'orm\'.')
                    ->end()
                ->end()

                ->scalarNode('page_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('page_manager')->defaultValue('Black\\Bundle\\PageBundle\\Doctrine\\PageManager')->end()
            ->end();

        $this->addPageSection($rootNode);
        $this->addProxySection($rootNode);
        $this->addControllerSection($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
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
                                ->scalarNode('page_list')->defaultValue('Black\\Bundle\\PageBundle\\Form\\ChoiceList\\PageList')->end()
                                ->scalarNode('page_id_list')->defaultValue('Black\\Bundle\\PageBundle\\Form\\ChoiceList\\PageIdList')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addProxySection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('proxy')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                        ->children()
                            ->scalarNode('class')->defaultValue('Black\\Bundle\\PageBundle\\Proxy\\PageProxy')->end()
                            ->scalarNode('enabled')->defaultValue('false')
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addControllerSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('controller')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('class')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('page')
                                    ->defaultValue('Black\\Bundle\\PageBundle\\Controller\\PageController')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
