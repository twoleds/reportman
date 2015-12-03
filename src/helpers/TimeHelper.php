<?php
namespace Reportman\Helpers;

use Zend\View\Helper\AbstractHelper;

class TimeHelper extends AbstractHelper
{

    public function __construct()
    {
    }

    /**
     * Formats the specified time in minutes.
     *
     * @param int $time
     * @return string
     */
    public function __invoke($time)
    {
        $hours = floor($time / 60);
        $minutes = $time % 60;
        return $hours . 'h' . ($minutes > 0 ? sprintf(' %02dm', $minutes) : '');
    }

}
