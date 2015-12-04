<?php
namespace Reportman\Helpers;

use Zend\View\Helper\AbstractHelper;

class DateHelper extends AbstractHelper
{

    /**
     * Formats the specified date from timestamp.
     *
     * @param int $date
     * @return string
     */
    public function __invoke($date)
    {
        return !empty($date) ? date('d.m.Y', $date) : '';
    }

}
