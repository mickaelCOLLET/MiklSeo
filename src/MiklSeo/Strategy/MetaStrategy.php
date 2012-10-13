<?php

namespace MiklSeo\Strategy;

class MetaStrategy extends AbstractStrategy
{
    /**
     * Meta Tag
     *
     * @var string
     */

    protected $tag = 'meta';

    /**
     * Ignore Tag
     *
     * @var string
     */

    protected $ignoreTag = 'noMetaSeo';

    /**
     * (non-PHPdoc)
     * @see \MiklSeo\Strategy\StrategyInterface::run()
     */

    public function run()
    {
        $container = parent::currentActive();
        if ($container) {
            $metas = $container->{$this->getTag()};
            if (is_array($metas)) {
                foreach ($metas as $metaKey => $metaData) {
                    $this->getRenderer()->headMeta()->appendName($metaKey, $metaData);
                }
            }
        }

    }

}
