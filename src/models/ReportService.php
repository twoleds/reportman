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
     * Finds report by the specified identifier.
     *
     * @param int $reportId
     * @return Report|null
     */
    public function findById($reportId)
    {

        $statement = $this->adapter->createStatement(
            'SELECT * FROM `reports` WHERE id = :report_id LIMIT 1'
        );

        $params = new ParameterContainer();
        $params['report_id'] = $reportId;

        $statement->setParameterContainer($params);
        $result = $statement->execute();

        $report = null;
        if ($result->count()) {
            $result->rewind();
            $report = new Report($result->current());
        }

        return $report;

    }

    /**
     * Finds report by the specified user and filtering parameters.
     *
     * @param int $userId
     * @param string $dateFrom
     * @param string $dateTo
     * @param null|int $issueId
     * @param string $order
     * @return \Generator
     */
    public function findByUser($userId, $dateFrom, $dateTo, $issueId = null, $order = 'asc')
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

        $orderBy = ' ORDER BY `date` ASC';
        if ($order == 'desc') {
            $orderBy = ' ORDER BY `date` DESC';
        }

        $statement = $this->adapter->createStatement(
            'SELECT * FROM `reports` WHERE ' . implode(' AND ', $conds) . $orderBy
        );

        $statement->setParameterContainer($params);
        $result = $statement->execute();

        foreach ($result as $row) {
            yield new Report($row);
        }

    }

    /**
     * Store the specified report to database.
     *
     * @param Report $report
     */
    public function save(Report $report)
    {

        $params = new ParameterContainer();
        $params['date'] = $report->getDate();
        $params['issue_id'] = $report->getIssueId();
        $params['issue_text'] = $report->getIssueText();
        $params['spent_time'] = $report->getSpentTime();
        $params['estimated_time'] = $report->getEstimatedTime();
        $params['complete'] = $report->getComplete();
        $params['user_id'] = $report->getUserId();

        if (empty($report->getId())) {
            $statement = $this->adapter->createStatement(
                'INSERT INTO `reports` SET ' .
                '`date` = :date, ' .
                '`issue_id` = :issue_id, ' .
                '`issue_text` = :issue_text, ' .
                '`spent_time` = :spent_time, ' .
                '`estimated_time` = :estimated_time, ' .
                '`complete` = :complete, ' .
                '`user_id` = :user_id'
            );
        } else {
            $statement = $this->adapter->createStatement(
                'UPDATE `reports` SET ' .
                '`date` = :date, ' .
                '`issue_id` = :issue_id, ' .
                '`issue_text` = :issue_text, ' .
                '`spent_time` = :spent_time, ' .
                '`estimated_time` = :estimated_time, ' .
                '`complete` = :complete, ' .
                '`user_id` = :user_id ' .
                'WHERE `id` = :id'
            );
            $params['id'] = $report->getId();
        }

        $statement->setParameterContainer($params);
        $result = $statement->execute();

        if (empty($report->getId())) {
            $report->setId($result->getGeneratedValue());
        }

    }

    /**
     * Removes a report by the specified identifier.
     *
     * @param int $reportId
     * @return bool
     */
    public function delete($reportId)
    {

        $statement = $this->adapter->createStatement(
            'DELETE FROM `reports` WHERE id = :report_id LIMIT 1'
        );

        $params = new ParameterContainer();
        $params['report_id'] = $reportId;

        $statement->setParameterContainer($params);
        $result = $statement->execute();

        return $result->getAffectedRows() > 0;

    }

}
