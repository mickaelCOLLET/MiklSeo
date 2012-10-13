<?php

namespace Mock;

use Zend\Mvc\Application as BaseApplication;

class Application extends BaseApplication
{
    public function setMvcEvent($event)
    {
        $this->event = $event;
    }
}