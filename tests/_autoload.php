<?php

require_once DIR_ZF2 . 'Zend/Loader/AutoloaderFactory.php';
Zend\Loader\AutoloaderFactory::factory(array(
    'Zend\Loader\StandardAutoloader' => array(
        'autoregister_zf' => true,
        'namespaces' => array(
            'MiklSeo' => __DIR__ . '/../src/MiklSeo',
            'MiklSeoTest' => __DIR__ . '/MiklSeo',
            'Mock' => __DIR__ . '/mocks',
        ),
    ),
));