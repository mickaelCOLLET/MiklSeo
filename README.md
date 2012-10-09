MiklSeo
==============

This is a simple ZF2 module that optimize your "On-page" *SEO* based on a *Zend\Navigation\Navigation* instance.

Configuration
------------

The module use by default the *DefaultNavigationFactory of Zend\Navigation* but you can use your own Navigation.

To do this, add the *navigation* key in the configuration, and specify your classname. 

Also, MiklSeo use strategies to optimize your html for search engine.

MiklSeo\config\module.config.php :

    return array(
        'miklSeo' => array(	 		
			//'navigation' => 'my\Custom\Navigation',
        	'strategies' => array(
        		'MiklSeo\Strategy\TitleStrategy' => array(),
    	    	'MiklSeo\Strategy\MetaStrategy' => array(), 	
        	),
        ),
    );

Define strategies in module.config.php under *strategies* key :

- key : string, Strategy classname
- value : array, Parameters 

By default, 2 strategies are available:


MiklSeo\Strategy\TitleStrategy :
----------

TitleStrategy add title tag of your current html page if active page is found.
prepend or append to the root title by specify placement key parameter.

    return array(
    	'miklSeo' => array(	 		
    		'strategies' => array(	
    			'MiklSeo\Strategy\TitleStrategy' => array(
    				//'tag'             => 'myCustomTag',
					//'placement'       => 'appendOrPrepend',
					//'doNotExecuteTag' => 'notExecuteSeoTag'
    			),
    		),
    	),
	);

Default parameters:

- tag : title
- placement : null
- doNotExcecuteTag : noTitleSeo

doNotExcecuteTag bypass strategy on the current node

MiklSeo\Strategy\MetaStrategy :
----------

MetaStrategy add meta tag of your current html page if active page is found.

	return array(
	    'miklSeo' => array(	 		
	    	'strategies' => array(
		    	'MiklSeo\Strategy\MetaStrategy' => array(
		    		//'tag'             => 'myCustomTag',
					//'doNotExecuteTag' => 'notExecuteSeoTag'			
		    	),
		    	
	    	),
	    ),
	);
	
Default parameters:

- tag : meta
- doNotExcecuteTag : noMetaSeo	

doNotExcecuteTag bypass strategy on the current node.

## Exemple : ##

From xml navigation file :

	<?xml version="1.0" encoding="UTF-8"?>
	<configdata>
	    <navigation>
	        <default>
	        	<home>
	            	<label>Home</label>
	            	<title>Home</title>
	            	<uri>/</uri>
	            	<controller>index</controller>
	            	<action>index</action>  
	            	<route>home</route>
	           	 	<noTitleSeo>true</noTitleSeo>
	           	 	<meta>
	            		<description>i am the description</description>
	            		<keywords>my, keywords, list</keywords>
						<google-site-verification>xxxx---x---x---x--xxxxxx-xx</google-site-verification>
					</meta>
					<pages>
						<create>                
	                      	<label>create a disk list</label>
	                      	<title>create a disk list/title>
	                      	<route>create-disk</route>
	                      	<meta>
	                      		<description>another description.</description>
	                      		<keywords>another,keywords, here</keywords>                
	                	  	</meta>
	     				</create>
					</pages>
				</home>
	        </default>           
	    </navigation>   
	</configdata>

Form this *module.config.php* file:

	return array(
	    'miklSeo' => array(	 		
	    	'strategies' => array(
	    		'MiklSeo\Strategy\TitleStrategy' => array(
					'placement' => 'prepend'
				),
		    	'MiklSeo\Strategy\MetaStrategy' => array(),
		    	
	    	),
	    ),
	);

Result :

( Title have already defined before and value is : My Beauty Website )

In **home** page :

	<title>My Beauty Website</title>
	<meta>
		<description>i am the description</description>
	    <keywords>my, keywords, list</keywords>
		<google-site-verification>xxxx---x---x---x--xxxxxx-xx</google-site-verification>
	</meta>

In **create** page:

	<title>create a disk list - My Beauty Website</title>
	<meta>
		<description>another description.</description>
	    <keywords>another,keywords, here</keywords>
	</meta>


## Add your custom strategies : ##

You can create your custom seo strategy and add it in module.config.php
To add a custom strategy your class must implement MiklSeo\Strategy\StrategyInterface

	interface StrategyInterface{

		public function run();
		
	}

You can also herit MiklSeo\Strategy\AbstractStrategy to use default comportement: 

	public function setTag($tag);
	public function getTag();	
	public function setDoNotExecuteTag($doNotExecuteTag);
	public function getDoNotExecuteTag();
	