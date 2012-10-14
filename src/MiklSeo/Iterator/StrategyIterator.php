<?php

namespace MiklSeo\Iterator;

use MiklSeo\Exception\InvalidArgumentException;
use MiklSeo\Strategy\StrategyInterface;

use Zend\View\Renderer\RendererInterface as Renderer;
use Zend\Navigation\Navigation;

class StrategyIterator extends \SplObjectStorage
{
    /**
     * Renderer
     *
     * @var Zend\View\Renderer\RendererInterface
     */

    protected $renderer;

    /**
     * Navigation
     *
     * @var Zend\Navigation\Navigation
     */

    protected $navigation;

    /**
     * Set renderer
     *
     * @param  Renderer $renderer
     * @return \MiklSeo\Iterator\StrategyIterator
     */
    public function setRenderer(Renderer $renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }

    public function getRenderer()
    {
        return $this->renderer;
    }

    /**
     * Set navigation
     *
     * @param  Navigation $navigation
     * @return \MiklSeo\Iterator\StrategyIterator
     */
    public function setNavigation(Navigation $navigation)
    {
        $this->navigation = $navigation;
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

        $strategy->setRenderer($this->renderer);
        $strategy->setNavigation($this->navigation);

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
