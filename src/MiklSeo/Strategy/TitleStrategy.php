<?php

namespace MiklSeo\Strategy;

use MiklSeo\Exception\StrategyException;
use Zend\View\Helper\Placeholder;

class TitleStrategy extends AbstractStrategy
{
    /**
     * Title Tag
     *
     * @var string
     */

    protected $tag = 'title';

    /**
     * Placement position
     *
     * @var string
     */

    protected $placement;

    /**
     * Ignore Tag
     *
     * @var string
     */

    protected $ignoreTag = 'noTitleSeo';

    /**
     * Run the strategy
     * @return TitleStrategy
     */
    public function run()
    {
        $container = parent::currentActive();
        if ($container) {
            $title = $container->{$this->getTag()};
            if (null !== ($placement = $this->getPlacement())) {
                $this->getRenderer()->headTitle()->{$placement}($title);
                return;
            }
            $this->getRenderer()->headTitle($title);
        }
        return $this;
    }

    public function getPlacement()
    {
        if(null === $this->placement) {
            $this->setPlacement(Navigation::PREPEND);
        }
        return $this->placement;
    }

    public function setPlacement($placement)
    {
        if (!in_array(strtoupper($placement),
                array(
                    Placeholder\Container\AbstractContainer::APPEND,
                    Placeholder\Container\AbstractContainer::PREPEND)
                )
            ) {
            throw new StrategyException('Invalid placement');
        }
        $this->placement = $placement;
        return $this;
    }

}
