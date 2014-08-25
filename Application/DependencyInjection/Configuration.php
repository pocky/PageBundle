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
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The database driver %s is not supported. Please choose one of ' . json_encode($supportedDrivers))
                    ->end()
                    ->isRequired()
                    ->cannotBeOverwritten()
                    ->cannotBeEmpty()
                ->end()

                ->scalarNode('page_dto')->defaultValue('Black\\Bundle\\PageBundle\\Application\\DTO\\WebPageDTO')->end()
                ->scalarNode('create_page_dto')->defaultValue('Black\\Bundle\\PageBundle\\Application\\DTO\\CreateWebPageDTO')->end()
                ->scalarNode('write_page_dto')->defaultValue('Black\\Bundle\\PageBundle\\Application\\DTO\\WriteWebPageDTO')->end()
                ->scalarNode('page_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('page_manager')->defaultValue('Black\\Bundle\\PageBundle\\Infrastructure\\Doctrine\\WebPageManager')->end()
            ->end();

        $applicationNode = $rootNode
            ->children()
                ->arrayNode('application')
                ->addDefaultsIfNotSet();

                $this->addControllerSection($applicationNode);
                $this->addFormSection($applicationNode);
                $this->addApplicationServiceSection($applicationNode);
                $this->addSpecificationSection($applicationNode);


        $rootNode
            ->end();

        $infrastructureNode = $rootNode
            ->children()
                ->arrayNode('infrastructure')
                ->addDefaultsIfNotSet();

                $this->addCQRSSection($infrastructureNode);
                $this->addEventSection($infrastructureNode);
                $this->addInfrastructureServiceSection($infrastructureNode);


        $rootNode
            ->end();

        return $treeBuilder;
    }

    private function addControllerSection(ArrayNodeDefinition $node)
    {
        $node
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

    private function addFormSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('form')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('create_web_page')
                            ->addDefaultsIfNotSet()
                            ->canBeUnset()
                            ->children()
                                ->scalarNode('type')
                                    ->defaultValue('Black\\Bundle\\PageBundle\\Application\\Form\\Type\\CreateWebPageType')
                                ->end()
                                ->scalarNode('handler')
                                    ->defaultValue('Black\\Bundle\\PageBundle\\Application\\Form\\Handler\\CreateWebPageFormHandler')
                                ->end()
                                ->scalarNode('name')
                                    ->defaultValue('black_page_create_web_page')
                                ->end()
                            ->end()
                        ->end()

                        ->arrayNode('web_page')
                            ->addDefaultsIfNotSet()
                            ->canBeUnset()
                                ->children()
                                    ->scalarNode('type')
                                        ->defaultValue('Black\\Bundle\\PageBundle\\Application\\Form\\Type\\WriteWebPageType')
                                    ->end()
                                    ->scalarNode('handler')
                                        ->defaultValue('Black\\Bundle\\PageBundle\\Application\\Form\\Handler\\WriteWebPageFormHandler')
                                    ->end()
                                    ->scalarNode('name')
                                        ->defaultValue('black_page_web_page')
                                    ->end()
                                ->end()
                            ->end()
                        ->end()

                    ->end()
                ->end()
            ->end();
    }

    private function addSpecificationSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('specification')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('class')
                            ->addDefaultsIfNotSet()
                            ->canBeUnset()
                            ->children()
                                ->scalarNode('page_published')
                                    ->defaultValue('Black\\Bundle\\PageBundle\\Application\\Specification\\PageIsPublishedSpecification')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    private function addApplicationServiceSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('service')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('class')
                            ->addDefaultsIfNotSet()
                            ->canBeUnset()
                            ->children()
                                ->scalarNode('read')
                                    ->defaultValue('Black\\Bundle\\PageBundle\\Application\\Service\\WebPageReadService')
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
                        ->scalarNode('depublish_web_page')
                            ->defaultValue('Black\\Bundle\\PageBundle\\Infrastructure\\CQRS\\Handler\\DepublishWebPageHandler')
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

    private function addInfrastructureServiceSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('service')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('class')
                            ->addDefaultsIfNotSet()
                            ->canBeUnset()
                            ->children()
                                ->scalarNode('read')
                                    ->defaultValue('Black\\Bundle\\PageBundle\\Infrastructure\\Service\\WebPageReadService')
                                ->end()
                                ->scalarNode('write')
                                    ->defaultValue('Black\\Bundle\\PageBundle\\Infrastructure\\Service\\WebPageWriteService')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
