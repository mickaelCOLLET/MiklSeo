<?php 

namespace MiklSeo\Strategy;

class MetaStrategy extends AbstractStrategy  {
	
	/**
	 * Meta Tag
	 *
	 * @var string
	 */
	
	protected $_tag = 'meta';
	
	/**
	 * Not execute Tag
	 *
	 * @var string
	 */
	
	protected $_doNotExecuteTag = 'noMetaSeo';
	
	/**
	 * (non-PHPdoc)
	 * @see \MiklSeo\Strategy\StrategyInterface::run()
	 */
	
	public function run(){
		
		if($nav = parent::currentActive()){
			
			if(is_array($nav->{$this->getTag()}))
			{
				foreach($nav->{$this->getTag()} as $metaKey => $metaData)
				{
					$this->getRenderer()->headMeta()->appendName($metaKey, $metaData);
				}
			
			}
		
		}
		
	}
	
}