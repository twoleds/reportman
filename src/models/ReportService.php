<?php
namespace Reportman\Models;

use Zend\Db\Adapter\Adapter;

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



}
