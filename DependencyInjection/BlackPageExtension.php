<?php

namespace Black\Bundle\PageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BlackPageExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor      = new Processor();
        $configuration  = new Configuration();
        $config         = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if (!isset($config['db_driver'])) {
            throw new \InvalidArgumentException('You must provide the black_page.db_driver configuration');
        }

        try {
            $loader->load(sprintf('%s.xml', $config['db_driver']));
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException(sprintf('The db_driver "%s" is not supported by engine', $config['db_driver']));
        }

        $this->remapParametersNamespaces($config, $container, array(
                ''      => array(
                    'page_class'          => 'black_page.page.model.class',
                )
            ));

        if (!empty($config['page'])) {
            $this->loadPage($config['page'], $container, $loader);
        }

        if (!empty($config['proxy'])) {
            $this->loadProxy($config['proxy'], $container, $loader);
        }

        if (!empty($config['config'])) {
            $this->loadConfig($config['config'], $container, $loader);
        }
    }

    private function loadPage(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        foreach (array('page') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }

        $this->remapParametersNamespaces($config, $container, array(
                'form'  => 'black_page.page.form.%s',
            ));
    }

    private function loadProxy(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        foreach (array('proxy') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }

        $this->remapParametersNamespaces($config, $container, array(
                'proxy'  => 'black_page.proxy.%s',
            ));
    }

    private function loadConfig(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $loader->load('config.xml');

        $this->remapParametersNamespaces($config, $container, array(
                'form' => 'black_page.config.form.%s',
            )
        );
    }

    protected function remapParameters(array $config, ContainerBuilder $container, array $map)
    {
        foreach ($map as $name => $paramName) {
            if (array_key_exists($name, $config)) {
                $container->setParameter($paramName, $config[$name]);
            }
        }
    }

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

    public function getAlias()
    {
        return 'black_page';
    }
}
