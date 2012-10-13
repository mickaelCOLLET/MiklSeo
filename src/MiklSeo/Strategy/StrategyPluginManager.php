<?php

namespace MiklSeo\Strategy;

use MiklSeo\Exception\InvalidArgumentException;
use Zend\ServiceManager\AbstractPluginManager;

class StrategyPluginManager extends AbstractPluginManager
{
    /**
     * Default set of strategy
     *
     * @var array
     */
    protected $invokableClasses = array(
        'title' => 'MiklSeo\Strategy\TitleStrategy',
        'meta'  => 'MiklSeo\Strategy\MetaStrategy',
    );

    /**
     * Validate the plugin
     *
     * Checks that the adapter loaded is an instance
     * of StrategyInterface
     *
     * @param  mixed $plugin
     * @return void
     * @throws InvalidArgumentException if invalid
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof StrategyInterface) {
            // we're okay
            return;
        }

        throw new InvalidArgumentException(sprintf(
            'Plugin of type %s is invalid; must implement %s\StrategyInterface',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
            __NAMESPACE__
        ));
    }
}
