<?php

namespace MiklSeo;

class Module
{
    protected $_navigation = 'Zend\Navigation\Service\DefaultNavigationFactory';

    public function init()
    {
        $config = $this->getConfig();

        if (isset($config['miklSeo']['navigation'])) {
            $this->setNavigation($config['miklSeo']['navigation']);
        }

    }

    public function onBootstrap($e)
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
            'factories' => array(
                'MiklSeo'       => 'MiklSeo\Service\SeoFactory',
                'MiklSeoNavigation' => $this->_navigation,
            ),
        );

    }

    public function setNavigation($navigation)
    {
        $this->_navigation = (string) $navigation;
    }

}
