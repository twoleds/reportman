<?php
namespace Reportman\Models;

class Report
{

    /** @var int */
    private $id;

    /** @var int */
    private $issueId;

    /** @var string */
    private $issueText;

    /** @var int */
    private $spentTime;

    /** @var int */
    private $estimatedTime;

    /** @var int */
    private $complete;

    /** @var int */
    private $userId;

    /** @var string */
    private $date;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Report
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Returns the issue identifier for external issue system. It can be null.
     *
     * @return int|null
     */
    public function getIssueId()
    {
        return $this->issueId;
    }

    /**
     * Sets the issue identifier for external issue system.
     *
     * @param int|null $issueId
     * @return Report
     */
    public function setIssueId($issueId)
    {
        $this->issueId = $issueId;
        return $this;
    }

    /**
     * Returns the additional text about the issue. Can be empty.
     *
     * @return string
     */
    public function getIssueText()
    {
        return $this->issueText;
    }

    /**
     * Sets the additional text about the issue. Can be empty.
     *
     * @param string $issueText
     * @return Report
     */
    public function setIssueText($issueText)
    {
        $this->issueText = $issueText;
        return $this;
    }

    /**
     * Returns the spent time in minutes.
     *
     * @return int
     */
    public function getSpentTime()
    {
        return $this->spentTime;
    }

    /**
     * Sets the spent time in minutes.
     *
     * @param int $spentTime
     * @return Report
     */
    public function setSpentTime($spentTime)
    {
        $this->spentTime = $spentTime;
        return $this;
    }

    /**
     * Returns the estimated time in minutes.
     *
     * @return int
     */
    public function getEstimatedTime()
    {
        return $this->estimatedTime;
    }

    /**
     * Sets the estimated time in minutes.
     *
     * @param int $estimatedTime
     * @return Report
     */
    public function setEstimatedTime($estimatedTime)
    {
        $this->estimatedTime = $estimatedTime;
        return $this;
    }

    /**
     * Returns the percents of completion in range 0 to 100.
     *
     * @return int
     */
    public function getComplete()
    {
        return $this->complete;
    }

    /**
     * Sets the percents of completion in range 0 to 100.
     *
     * @param int $complete
     * @return Report
     */
    public function setComplete($complete)
    {
        $this->complete = $complete;
        return $this;
    }

    /**
     * Returns the identifier of an user.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Sets the identifier of an user.
     *
     * @param int $userId
     * @return Report
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Returns date of this report.
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets date of this report.
     *
     * @param string $date
     * @return Report
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

}
