<?php
namespace Reportman\Models;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserServiceFactory implements FactoryInterface
{

    /**
     * Create user service.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return UserService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \Zend\Db\Adapter\Adapter $db */
        $db = $serviceLocator->get('Database');
        return new UserService($db);
    }

}
