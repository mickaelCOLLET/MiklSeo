<?php 

namespace MiklSeo\Strategy;

use MiklSeo\Exception\StrategyException;

class TitleStrategy extends AbstractStrategy  {
	
	/**
	 * Title Tag
	 * 
	 * @var string
	 */
	
	protected $_tag = 'title';
	
	/**
	 * Placement position
	 *
	 * @var string
	 */
	
	protected $_placement;
	
	/**
	 * Not execute Tag
	 * 
	 * @var string
	 */
	
	protected $_doNotExecuteTag = 'noTitleSeo';
	
	/**
	 * (non-PHPdoc)
	 * @see \MiklSeo\Strategy\StrategyInterface::run()
	 */
	
	public function run(){		
		
		if($nav = parent::currentActive()){
			
			$title = $nav->{$this->getTag()};
			
			if(null !== ($placement = $this->getPlacement())){
				$this->getRenderer()->headTitle()->{$placement}($title);	
			} else {	
				$this->getRenderer()->headTitle($title);	
			}

		}
	} 
	
	public function getPlacement(){
		
		return $this->_placement;
	}
	
	public function setPlacement($placement){	
			
		if(!in_array($placement, array('prepend', 'append'))){
			throw new StrategyException('Invalid placement');
		}	
		$this->_placement = (string) $placement;
		return $this;		
	}
	
}