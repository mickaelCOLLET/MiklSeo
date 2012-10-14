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

    protected $tag;

    /**
     * Ignore Tag
     *
     * @var string
     */

    protected $ignoreTag;

    /**
     * Navigation
     *
     * @var Zend\Navigation\Navigation
     */

    protected $navigation;

    /**
     * Renderer
     *
     * @var Zend\View\Renderer\RendererInterface
     */

    protected $renderer;

    /**
     * Set tag key
     *
     * @param  string                          $tagKey
     * @return \MiklSeo\Strategy\TitleStrategy
     */

    public function setTag($tag)
    {
        $this->tag = (string) $tag;
        return $this;
    }

    /**
     * Get tag key
     *
     * @return string
     */

    public function getTag()
    {
        return $this->tag;
    }

    /**
     *
     * @param  string                          $ignoreTag
     * @return \MiklSeo\Strategy\TitleStrategy
     */

    public function setIgnoreTag($ignoreTag)
    {
        $this->ignoreTag = (string) $ignoreTag;
        return $this;
    }

    /**
     * Get ignore tag
     *
     * @return string
     */

    public function getIgnoreTag()
    {
        return $this->ignoreTag;
    }

    /**
     * Check if active navigation is ok and can be execute
     *
     * (non-PHPdoc)
     * @see \MiklSeo\Strategy\StrategyInterface::run()
     */

    public function currentActive()
    {
        $container = $this->getActive();
        $ignoreTag = $container->{$this->getIgnoreTag()};

        if (null === $container || ( isset($ignoreTag) && true === (bool) $container->{$ignoreTag})) {
            return false;
        }

        return $container;
    }

    /**
     *
     * @param  Navigation                         $nav
     * @return \MiklSeo\Strategy\AbstractStrategy
     */

    public function setNavigation(Navigation $nav)
    {
        $this->navigation = $nav;
        return $this;
    }

    /**
     * Return current navigation
     *
     * @return Navigation
     */

    public function getNavigation()
    {
        return $this->navigation;
    }

    /**
     *
     * @param  Renderer                           $renderer
     * @return \MiklSeo\Strategy\AbstractStrategy
     */

    public function setRenderer(Renderer $renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }

    /**
     * Return current renderer
     *
     * @return Renderer
     */

    public function getRenderer()
    {
        return $this->renderer;
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
