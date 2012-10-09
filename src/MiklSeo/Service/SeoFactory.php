<?php

namespace MiklSeo\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use MiklSeo\Seo;
//use MiklSeo\Strategy;
use MiklSeo\Strategy\StrategyInterface;
use MiklSeo\Iterator\StrategyIterator;
use MiklSeo\Exception\StrategyException;

class SeoFactory implements FactoryInterface{
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 */
	
    public function createService(ServiceLocatorInterface $services){
    	
    	$config   = $services->get('Configuration');
    	$nav      = $services->get('MiklSeoNavigation');
    	$renderer = $services->get('ViewManager')->getRenderer();
    	
    	$strategies = new StrategyIterator(); 
    	$strategies->setRenderer($renderer);
    	$strategies->setNavigation($nav);
    	
    	$config = $config['miklSeo'];

    	foreach($config['strategies'] as $strategyClass => $params){
    		if(class_exists($strategyClass) && ($strategy = new $strategyClass($params)) instanceof StrategyInterface){	
    			$strategies->attach($strategy);
    		} else{
    			throw new StrategyException($strategyClass.' is not exist or does not a instance of StrategyInterface');
    		}
    	} 
    	
    	$seo = new Seo();
    	$seo->setStrategies($strategies);
    	
    	return $seo;
    	 
    }
}