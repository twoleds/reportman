<?php
namespace Reportman\Helpers;

use Reportman\Models\UserService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\SessionManager;

class AuthServiceFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var SessionManager $sessionManager */
        $sessionManager = $serviceLocator->get('Session');
        /** @var UserService $userService */
        $userService = $serviceLocator->get('UserService');
        return new AuthService($sessionManager, $userService);
    }

}