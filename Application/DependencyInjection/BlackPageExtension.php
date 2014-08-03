<?php

namespace Black\Bundle\PageBundle\Application\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Class BlackPageExtension
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class BlackPageExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor     = new Processor();
        $configuration = new Configuration($this->getAlias());
        $config        = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../../Resources/config'));

        if (!isset($config['db_driver'])) {
            throw new \InvalidArgumentException('You must provide the black_page.db_driver configuration');
        }

        try {
            $loader->load(sprintf('%s.xml', $config['db_driver']));
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException(
                sprintf('The db_driver "%s" is not supported by engine', $config['db_driver'])
            );
        }

        foreach (['dto', 'service', 'specification'] as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
            $container->setParameter($this->getAlias() . '.backend_type_' . $config['db_driver'], true);
        }

        $this->remapParametersNamespaces($config, $container, [
                '' => [
                    'page_dto' => 'black_page.webpage.dto.class',
                    'page_class' => 'black_page.webpage.model.class',
                    'page_manager' => 'black_page.webpage.manager.class',
                ]
            ]);

        if (!empty($config['application']['controller'])) {
            $this->loadController($config['application']['controller'], $container, $loader);
        }

        if (!empty($config['application']['form'])) {
            $this->loadForm($config['application']['form'], $container, $loader);
        }

        if (!empty($config['infrastructure']['cqrs'])) {
            $this->loadCQRS($config['infrastructure']['cqrs'], $container, $loader);
        }

        if (!empty($config['infrastructure']['domain_event_subscriber'])) {
            $this->loadEvent($config['infrastructure']['domain_event_subscriber'], $container, $loader);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getAlias()
    {
        return 'black_page';
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     * @param XmlFileLoader    $loader
     */
    private function loadController(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        foreach (array('controller') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }

        $this->remapParametersNamespaces(
            $config,
            $container,
            [
                'class' => 'black_page.application.controller.class.%s',
            ]
        );
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     * @param XmlFileLoader    $loader
     */
    private function loadForm(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        foreach (array('form') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }

        $this->remapParametersNamespaces(
            $config,
            $container,
            [
                'create_web_page' => 'black_page.application.form.create_web_page.%s',
                'web_page' => 'black_page.application.form.web_page.%s',
            ]
        );
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     * @param XmlFileLoader    $loader
     */
    private function loadCQRS(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        foreach (array('cqrs') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }

        $this->remapParametersNamespaces(
            $config,
            $container,
            [
                'class' => 'black_page.infrastructure.cqrs.handler.class.%s',
            ]
        );
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     * @param XmlFileLoader    $loader
     */
    private function loadEvent(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        foreach (array('event') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }

        $this->remapParametersNamespaces(
            $config,
            $container,
            [
                'class' => 'black_page.infrastructure.domain_event_subscriber.class.%s',
            ]
        );
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     * @param array            $map
     */
    protected function remapParameters(array $config, ContainerBuilder $container, array $map)
    {
        foreach ($map as $name => $paramName) {
            if (array_key_exists($name, $config)) {
                $container->setParameter($paramName, $config[$name]);
            }
        }
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     * @param array            $namespaces
     */
    protected function remapParametersNamespaces(array $config, ContainerBuilder $container, array $namespaces)
    {
        foreach ($namespaces as $ns => $map) {
            if ($ns) {
                if (!array_key_exists($ns, $config)) {
                    continue;
                }
                $namespaceConfig = $config[$ns];
            } else {
                $namespaceConfig = $config;
            }

            if (is_array($map)) {
                $this->remapParameters($namespaceConfig, $container, $map);
            } else {
                foreach ($namespaceConfig as $name => $value) {
                    $container->setParameter(sprintf($map, $name), $value);
                }
            }
        }
    }
}
