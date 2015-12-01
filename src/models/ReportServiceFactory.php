<?php
namespace Reportman\Models;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ReportServiceFactory implements FactoryInterface
{

    /**
     * Create report service.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return ReportService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \Zend\Db\Adapter\Adapter $db */
        $db = $serviceLocator->get('Database');
        return new ReportService($db);
    }

}
