<?php

namespace Black\Bundle\PageBundle\Application\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
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

        $supportedDrivers = ['mongodb', 'orm'];

        $rootNode
            ->children()

                ->scalarNode('db_driver')
                    ->isRequired()
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The database driver must be either \'mongodb\', \'orm\'.')
                    ->end()
                ->end()

                ->scalarNode('page_dto')->defaultValue('Black\\Bundle\\PageBundle\\Application\\DTO\\WebPageDTO')->end()
                ->scalarNode('page_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('page_manager')->defaultValue('Black\\Bundle\\PageBundle\\Infrastructure\\Doctrine\\WebPageManager')->end()
            ->end();

        $this->addControllerSection($rootNode);

        $node = $rootNode
            ->children()
                ->arrayNode('infrastructure')
                ->addDefaultsIfNotSet();

                $this->addCQRSSection($node);
                $this->addEventSection($node);

        $rootNode
            ->end();

        return $treeBuilder;
    }

    private function addControllerSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('application')
                ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('controller')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->arrayNode('class')
                            ->addDefaultsIfNotSet()
                            ->canBeUnset()
                            ->children()
                                ->scalarNode('create_page')
                                    ->defaultValue('Black\\Bundle\\PageBundle\\Application\\Controller\\CreatePageController')
                                ->end()
                                ->scalarNode('write_page')
                                    ->defaultValue('Black\\Bundle\\PageBundle\\Application\\Controller\\WritePageController')
                                ->end()
                                ->scalarNode('read_page')
                                    ->defaultValue('Black\\Bundle\\PageBundle\\Application\\Controller\\ReadPageController')
                                ->end()
                                ->scalarNode('publish_page')
                                    ->defaultValue('Black\\Bundle\\PageBundle\\Application\\Controller\\PublishPageController')
                                ->end()
                                ->scalarNode('remove_page')
                                    ->defaultValue('Black\\Bundle\\PageBundle\\Application\\Controller\\RemovePageController')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    private function addCQRSSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('cqrs')
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('class')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('create_web_page')
                            ->defaultValue('Black\\Bundle\\PageBundle\\Infrastructure\\CQRS\\Handler\\CreateWebPageHandler')
                        ->end()
                        ->scalarNode('write_web_page')
                            ->defaultValue('Black\\Bundle\\PageBundle\\Infrastructure\\CQRS\\Handler\\WriteWebPageHandler')
                        ->end()
                            ->scalarNode('publish_web_page')
                        ->defaultValue('Black\\Bundle\\PageBundle\\Infrastructure\\CQRS\\Handler\\PublishWebPageHandler')
                        ->end()
                            ->scalarNode('remove_web_page')
                        ->defaultValue('Black\\Bundle\\PageBundle\\Infrastructure\\CQRS\\Handler\\RemoveWebPageHandler')
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    private function addEventSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('domain_event_subscriber')
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('class')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('created')
                            ->defaultValue('Black\\Bundle\\PageBundle\\Infrastructure\\DomainEvent\\WebPageCreatedSubscriber')
                        ->end()
                        ->scalarNode('writed')
                            ->defaultValue('Black\\Bundle\\PageBundle\\Infrastructure\\DomainEvent\\WebPageWritedSubscriber')
                        ->end()
                        ->scalarNode('published')
                            ->defaultValue('Black\\Bundle\\PageBundle\\Infrastructure\\DomainEvent\\WebPagePublishedSubscriber')
                        ->end()
                        ->scalarNode('depublished')
                            ->defaultValue('Black\\Bundle\\PageBundle\\Infrastructure\\DomainEvent\\WebPageDepublishedSubscriber')
                        ->end()
                        ->scalarNode('removed')
                            ->defaultValue('Black\\Bundle\\PageBundle\\Infrastructure\\DomainEvent\\WebPageRemovedSubscriber')
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
