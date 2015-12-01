<?php
require __DIR__ . '/vendor/autoload.php';

use Zend\Mvc\Application;

$application = Application::init([
    'modules' => [
        'Reportman'
    ],
    'module_listener_options' => []
])->run();
