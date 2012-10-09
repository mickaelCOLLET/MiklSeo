<?php 

namespace MiklSeo\Iterator;

use MiklSeo\Exception\InvalidArgumentException;
use MiklSeo\Strategy\StrategyInterface;

use Zend\View\Renderer\RendererInterface as Renderer;
use Zend\Navigation\Navigation as Navigation;

class StrategyIterator extends \SplObjectStorage {
	
	/**
	 * Renderer
	 * 
	 * @var Zend\View\Renderer\RendererInterface
	 */
	
	protected $_renderer;
	
	/**
	 * Navigation
	 * 
	 * @var Zend\Navigation\Navigation
	 */
	
	protected $_navigation;
	
	/**
	 * Set renderer
	 * 
	 * @param Renderer $renderer
	 * @return \MiklSeo\Iterator\StrategyIterator
	 */
	
	public function setRenderer(Renderer $renderer){
		
		$this->_renderer = $renderer;
		return $this;
		
	}
	
	/**
	 * Set navigation
	 * 
	 * @param Navigation $nav
	 * @return \MiklSeo\Iterator\StrategyIterator
	 */
	
	public function setNavigation(Navigation $nav){
	
		$this->_navigation = $nav;
		return $this;
	
	}
	
	/**
	 * (non-PHPdoc)
	 * @see SplObjectStorage::attach()
	 */
	
	public function attach($strategy, $inf = null)
    {
        if (!$strategy instanceof StrategyInterface) { 
            throw new InvalidArgumentException('Instance of StrategyInterface nedeed');
        }
     
        $strategy->setRenderer($this->_renderer);
        $strategy->setNavigation($this->_navigation);
          
        return parent::attach($strategy, $inf);
    }
    
    /**
     * (non-PHPdoc)
     * @see SplObjectStorage::detach()
     */
    
    public function detach($strategy, $inf = null)
    {
        if (!$strategy instanceof StrategyInterface) {
             throw new InvalidArgumentException('Instance of StrategyInterface nedeed');
        }
        
        return parent::detach($strategy, $inf);
    }
	
}