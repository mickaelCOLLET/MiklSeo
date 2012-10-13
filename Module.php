<?php

namespace MiklSeo;

use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\EventManager\EventInterface;

class Module implements BootstrapListenerInterface, ConfigProviderInterface,
        ServiceProviderInterface
{
    public function onBootstrap(EventInterface $e)
    {
        $app = $e->getApplication();
        $app->getEventManager()->attach('dispatch', function($e){
            $seo = $e->getApplication()->getServiceManager()->get('MiklSeo');
            $seo->optimize();
        });
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';

    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'MiklSeoStrategyManager' => 'MiklSeo\Strategy\StrategyPluginManager',
            ),
            'factories' => array(
                'MiklSeo' => 'MiklSeo\Service\SeoFactory',
            ),
        );

    }
}
