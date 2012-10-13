<?php

return array(
    'miklSeo' => array(
        'strategies' => array(
            'title' => array(
                'placement' => 'prepend'
            ),
            'meta' => array(),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'MiklSeoNavigation' => 'Zend\Navigation\Service\DefaultNavigationFactory', // feel free to change the factory
        ),
    ),
);
