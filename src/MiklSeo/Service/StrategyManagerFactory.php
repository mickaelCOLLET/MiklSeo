<?php

namespace MiklSeo\Service;

use Zend\ServiceManager\Config;
use Zend\Mvc\Service\AbstractPluginManagerFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

class StrategyManagerFactory extends AbstractPluginManagerFactory
{
    const PLUGIN_MANAGER_CLASS = 'MiklSeo\Strategy\StrategyPluginManager';

    /**
     * Create and return the strategy plugins manager
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return StrategyPluginManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $plugins = parent::createService($serviceLocator);
        $config = $serviceLocator->get('Config');
        if(isset($config['miklSeo']['strategy_plugins'])) {
            $smConfig = new Config($config['miklSeo']['strategy_plugins']);
            $smConfig->configureServiceManager($plugins);
        }
        return $plugins;
    }
}
