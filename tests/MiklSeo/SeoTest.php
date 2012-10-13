<?php

namespace MiklSeoTest;

use PHPUnit_Framework_TestCase as TestCase;
use Zend\ServiceManager;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\SimpleRouteStack;
use Zend\View\Model\ViewModel;

class SeoTest extends TestCase
{
    protected $sm;
    
    public function setUp()
    {   
        // load ParallelJobs config
        require_once __DIR__ . '/../../Module.php';
        $module = new \MiklSeo\Module();
        $serviceConfig = $module->getServiceConfig();
        $config = include __DIR__ . '/../../config/module.config.php';
        $config = array_replace_recursive($config, array(
            'navigation' => array(
                'default' => array(
                    'home' => array(
                        'type' => 'mvc',
                        'route' => 'home',
                        'active' => true,
                        'title' => 'Home',
                        'meta' => array('description' => 'test de description')),
                ),
            ),
            'view_manager' => array(
                'template_map' => array(
                    'unit-tests-title' => __DIR__ . '/../mocks/unit-tests-title.phtml',
                    'unit-tests-meta' => __DIR__ . '/../mocks/unit-tests-meta.phtml',
                ),
            ),
        ));
        $serviceConfig = array_replace_recursive($serviceConfig, $config['service_manager']);
        $serviceConfig = array_replace_recursive($serviceConfig, array(
            'factories' => array(
                'Application'   => function($sm) { return new \Mock\Application($sm->get('Config'), $sm); },
                'Request'       => 'Zend\Mvc\Service\RequestFactory',
                'Response'      => 'Zend\Mvc\Service\ResponseFactory',
                'EventManager'  => 'Zend\Mvc\Service\EventManagerFactory',
                'ViewHelperManager' => 'Zend\Mvc\Service\ViewHelperManagerFactory',
                'ViewResolver'            => 'Zend\Mvc\Service\ViewResolverFactory',
                'ViewTemplateMapResolver' => 'Zend\Mvc\Service\ViewTemplateMapResolverFactory',
                'ViewTemplatePathStack'   => 'Zend\Mvc\Service\ViewTemplatePathStackFactory',
            ),
            'invokables' => array(
                'ViewManager'           => 'Zend\Mvc\View\Http\ViewManager',
                'SharedEventManager'    => 'Zend\EventManager\SharedEventManager',
            ),
        ));
        
        $this->sm = new ServiceManager\ServiceManager(new ServiceManager\Config($serviceConfig));
        $this->sm->setService('Config', $config);
        $this->sm->setAllowOverride(true);
        
        $application = $this->sm->get('Application');
        $mvcEvent = new MvcEvent();
        $mvcEvent->setApplication($application);
        $matches = new RouteMatch(array());
        $matches->setMatchedRouteName('home');
        $mvcEvent->setRouteMatch($matches);
        $router = new SimpleRouteStack();
        $mvcEvent->setRouter($router);
        $application->setMvcEvent($mvcEvent);
        $this->sm->setService('application', $application);
        
        $viewManager = $this->sm->get('ViewManager');
        $viewManager->onBootstrap($mvcEvent);
        
        parent::setUp();
    }
    
    public function testCanGetFactory()
    {
        $seo = $this->sm->get('MiklSeo');
        $this->assertEquals(get_class($seo), 'MiklSeo\Seo');
    }
    
    public function testCanAddTitle()
    {
        $seo = $this->sm->get('MiklSeo');
        $seo->optimize();
        $viewModel = new ViewModel();
        $viewModel->setTemplate('unit-tests-title');
        $view = $seo->getStrategies()->getRenderer()->render($viewModel);
        $this->assertEquals('<title>Home - test</title>', $view);
    }
    
    public function testCanAddMeta()
    {
        $seo = $this->sm->get('MiklSeo');
        $seo->optimize();
        $viewModel = new ViewModel();
        $viewModel->setTemplate('unit-tests-meta');
        $view = $seo->getStrategies()->getRenderer()->render($viewModel);
        $this->assertEquals('<meta name="description" content="test de description">', $view);
    }
}