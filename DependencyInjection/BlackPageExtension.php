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
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws \RuntimeException
     * @throws \Symfony\Component\DependencyInjection\Exception\BadMethodCallException
     * @throws \Symfony\Component\Config\Exception\FileLoaderLoadException
     * @throws \InvalidArgumentException
     * @throws \Exception
     * @throws \Symfony\Component\Config\Exception\FileLoaderImportCircularReferenceException
     * @throws \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor     = new Processor();
        $configuration = new Configuration($this->getAlias());
        $config        = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

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

        foreach (array('configuration') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }

        $this->remapParametersNamespaces(
            $config,
            $container,
            array(
                '' => array(
                    'page_class'          => 'black_page.page.model.class',
                    'page_manager'        => 'black_page.page.manager',
                )
            )
        );
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
