<?php

namespace MiklSeo;

use Zend\Stdlib\Exception;
use MiklSeo\Exception\StrategyException;
use MiklSeo\Iterator\StrategyIterator;

class Seo
{
    /**
     * Strategies
     *
     * @var MiklSeo\Iterator\StrategyIterator
     */

    protected $strategies;

    /**
     * Set strategies
     *
     * @param  StrategyIterator $strategies
     * @return \MiklSeo\Seo
     */

    public function setStrategies(StrategyIterator $strategies)
    {
        $this->strategies = $strategies;
        return $this;
    }

    /**
     * Return Strategies list
     *
     * @return \MiklSeo\Iterator\StrategyIterator
     */

    public function getStrategies()
    {
        return $this->strategies;
    }

    /**
     * Run optimization
     */

    public function optimize()
    {
        return $this->_executeStrategies();
    }

    /**
     * Execute All Strategies
     *
     * @throws \MiklSeo\Exception\StrategyException
     */

    protected function _executeStrategies()
    {
        $strategies = $this->getStrategies();
        foreach ($strategies as $strategy) {
            $strategy->run();
        }
    }
}
