<?php

namespace Mukadi\SettingsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class MukadiSettingsExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('types.yml');
        $this->setManager($config,$container);
        $this->loadSettings($config,$container);
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     */
    private function setManager(array $config, ContainerBuilder $container) {
        $container->setAlias("mukadi_settings.data_manager", $config['manager']);
        $container->setParameter("mukadi_settings_param_class", $config['param_class']);
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     */
    private function loadSettings(array $config, ContainerBuilder $container){
        if(isset($config['settings']))
            $p = $config['settings'];
        else
            $p = array();
        $container->setParameter("mukadi_settings_settings",$p);
    }
}
