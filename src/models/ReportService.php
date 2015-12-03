<?php
namespace Reportman\Models;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\ParameterContainer;

class ReportService
{

    /** @var Adapter */
    private $adapter;

    /**
     * ReportService constructor.
     *
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param $userId
     * @param $dateFrom
     * @param $dateTo
     * @return \Generator
     */
    public function findByUser($userId, $dateFrom, $dateTo)
    {

        $statement = $this->adapter->createStatement(
            'SELECT * FROM `reports` WHERE `user_id` = :user_id AND `date` >= :date_from AND `date` <= :date_to ORDER BY `date` ASC'
        );

        $params = new ParameterContainer();
        $params['user_id'] = $userId;
        $params['date_from'] = $dateFrom;
        $params['date_to'] = $dateTo;

        $statement->setParameterContainer($params);
        $result = $statement->execute();

        foreach ($result as $row) {
            yield new Report($row);
        }

    }

}
