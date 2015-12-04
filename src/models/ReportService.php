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
     * @param int $userId
     * @param string $dateFrom
     * @param string $dateTo
     * @param null|int $issueId
     * @return \Generator
     */
    public function findByUser($userId, $dateFrom, $dateTo, $issueId = null)
    {

        $conds = [];
        $params = new ParameterContainer();

        $conds[] = '`user_id` = :user_id';
        $params['user_id'] = $userId;

        $conds[] = '`date` >= :date_from';
        $params['date_from'] = $dateFrom;

        $conds[] = '`date` <= :date_to';
        $params['date_to'] = $dateTo;

        if (!empty($issueId)) {
            $conds[] = '`issue_id` = :issue_id';
            $params['issue_id'] = $issueId;
        }

        $statement = $this->adapter->createStatement(
            'SELECT * FROM `reports` WHERE ' . implode(' AND ', $conds) . ' ORDER BY `date` ASC'
        );

        $statement->setParameterContainer($params);
        $result = $statement->execute();

        foreach ($result as $row) {
            yield new Report($row);
        }

    }

}
