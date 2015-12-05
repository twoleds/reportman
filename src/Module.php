<?php
namespace Reportman;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

class Module implements ConfigProviderInterface, ServiceProviderInterface, ViewHelperProviderInterface
{

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return [
            'db' => [
                'driver' => 'Pdo_Mysql',
                'database' => 'reportman',
                'username' => 'root',
                'password' => 'root',
                'hostname' => 'localhost',
                'port' => '3306',
                'charset' => 'utf8',
            ],
            'controllers' => array(
                'invokables' => array(
                    'Home' => 'Reportman\Controllers\HomeController',
                    'User' => 'Reportman\Controllers\UserController',
                    'Report' => 'Reportman\Controllers\ReportController',
                    'ReportAjax' => 'Reportman\Controllers\ReportAjaxController',
                ),
            ),
            'router' => [
                'routes' => [
                    'home' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/',
                            'defaults' => [
                                'controller' => 'Home',
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'login' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/login/',
                            'defaults' => [
                                'controller' => 'User',
                                'action' => 'login',
                            ],
                        ],
                    ],
                    'logout' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/logout/',
                            'defaults' => [
                                'controller' => 'User',
                                'action' => 'logout',
                            ],
                        ],
                    ],
                    'keep-alive' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/keep-alive/',
                            'defaults' => [
                                'controller' => 'User',
                                'action' => 'keepAlive',
                            ],
                        ],
                    ],
                    'register' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/register/',
                            'defaults' => [
                                'controller' => 'User',
                                'action' => 'register',
                            ],
                        ],
                    ],
                    'report-index' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/report/index/',
                            'defaults' => [
                                'controller' => 'Report',
                                'action' => 'index',
                            ],
                        ],
                    ],
                    'report-export' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/report/export/',
                            'defaults' => [
                                'controller' => 'Report',
                                'action' => 'export',
                            ],
                        ],
                    ],
                    'report-ajax' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/report-ajax[/:id]',
                            'constraints' => array(
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'ReportAjax',
                            ),
                        ),
                    ),
                ],
            ],
            'view_manager' => [
                'base_path' => '/assets',
                'display_not_found_reason' => true,
                'display_exceptions' => true,
                'doctype' => 'HTML5',
                'not_found_template' => 'error/404',
                'exception_template' => 'error/500',
                'template_map' => [
                    'layout/layout' => __DIR__ . '/views/layout.phtml',
                    'error/404' => __DIR__ . '/views/error/404.phtml',
                    'error/500' => __DIR__ . '/views/error/500.phtml',
                ],
                'template_path_stack' => [
                    __DIR__ . '/views',
                ],
                'strategies' => array(
                    'ViewJsonStrategy',
                ),
            ],
        ];
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'Database' => 'Zend\Db\Adapter\AdapterServiceFactory',
                'ReportService' => 'Reportman\Models\ReportServiceFactory',
                'UserService' => 'Reportman\Models\UserServiceFactory',
                'Session' => 'Zend\Session\Service\SessionManagerFactory',
                'AuthService' => 'Reportman\Helpers\AuthServiceFactory',
            ]
        ];
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getViewHelperConfig()
    {
        return [
            'invokables' => [
                'formatTime' => 'Reportman\Helpers\TimeHelper',
                'formatDate' => 'Reportman\Helpers\DateHelper',
            ],
        ];
    }
}
