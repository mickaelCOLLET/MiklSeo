<?php

namespace MiklSeo\Strategy;

use Zend\Stdlib\AbstractOptions;
use Zend\Navigation\Navigation as Navigation;
use Zend\View\Renderer\RendererInterface as Renderer;

use MiklSeo\Strategy\StrategyInterface;

abstract class AbstractStrategy extends AbstractOptions implements StrategyInterface
{
    /**
     * Tag Key
     *
     * @var string
     */

    protected $_tag;

    /**
     * Ignore Tag
     *
     * @var string
     */

    protected $_ignoreTag;

    /**
     * Navigation
     *
     * @var Zend\Navigation\Navigation
     */

    protected $_navigation;

    /**
     * Renderer
     *
     * @var Zend\View\Renderer\RendererInterface
     */

    protected $_renderer;

    /**
     * Set tag key
     *
     * @param  string                          $tagKey
     * @return \MiklSeo\Strategy\TitleStrategy
     */

    public function setTag($tag)
    {
        $this->_tag = (string) $tag;

        return $this;
    }

    /**
     * Get tag key
     *
     * @return string
     */

    public function getTag()
    {
        return $this->_tag;
    }

    /**
     *
     * @param  string                          $ignoreTag
     * @return \MiklSeo\Strategy\TitleStrategy
     */

    public function setIgnoreTag($ignoreTag)
    {
        $this->_ignoreTag = (string) $ignoreTag;

        return $this;
    }

    /**
     * Get ignore tag
     *
     * @return string
     */

    public function getIgnoreTag()
    {
        return $this->_ignoreTag;
    }

    /**
     * Check if active navigation is ok and can be execute
     *
     * (non-PHPdoc)
     * @see \MiklSeo\Strategy\StrategyInterface::run()
     */

    public function currentActive()
    {
        $nav = $this->getActive();

        if (null === $nav || ( isset($nav->{$this->getIgnoreTag()}) && true === (bool) $nav->{$this->getIgnoreTag()})) {
            return false;
        }

        return $nav;

    }

    /**
     *
     * @param  Navigation                         $nav
     * @return \MiklSeo\Strategy\AbstractStrategy
     */

    public function setNavigation(Navigation $nav)
    {
        $this->_navigation = $nav;

        return $this;
    }

    /**
     * Return current navigation
     *
     * @return Navigation
     */

    public function getNavigation()
    {
        return $this->_navigation;
    }

    /**
     *
     * @param  Renderer                           $renderer
     * @return \MiklSeo\Strategy\AbstractStrategy
     */

    public function setRenderer(Renderer $renderer)
    {
        $this->_renderer = $renderer;

        return $this;
    }

    /**
     * Return current renderer
     *
     * @return Renderer
     */

    public function getRenderer()
    {
        return $this->_renderer;
    }

    /**
     * Return active navigation page
     *
     * @return Zend\Navigation\Navigation
     */

    public function getActive()
    {
        return $this->getNavigation()->findOneByActive(true);
    }

}
