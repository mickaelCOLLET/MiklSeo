<?php

namespace MiklSeo\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use MiklSeo\Seo;
use MiklSeo\Strategy\StrategyInterface;
use MiklSeo\Iterator\StrategyIterator;
use MiklSeo\Exception\StrategyException;

class SeoFactory implements FactoryInterface
{
    /**
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config   = $serviceLocator->get('Config');
        $nav      = $serviceLocator->get('MiklSeoNavigation');
        $renderer = $serviceLocator->get('ViewManager')->getRenderer();

        $strategies = new StrategyIterator();
        $strategies->setRenderer($renderer);
        $strategies->setNavigation($nav);

        $config = $config['miklSeo'];
        foreach ($config['strategies'] as $strategyClass => $params) {
            $strategyManager = $serviceLocator->get('MiklSeoStrategyManager');
            if(!$strategyManager->has($strategyClass)) {
                throw new StrategyException('"' . $strategyClass . '" strategy plugin do no exists.');
            }
            $strategy = $strategyManager->get($strategyClass, $params);
            $strategies->attach($strategy);
        }

        $seo = new Seo();
        $seo->setStrategies($strategies);

        return $seo;
    }
}
