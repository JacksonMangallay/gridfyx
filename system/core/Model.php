<?php declare(strict_types = 1);

namespace System\Core;

defined('BASEPATH') OR exit('Direct access is forbidden');

use System\Core\DBConnect;

class Model
{

    public $db;

    public function __construct()
    {
        $this->db = new DBConnect();
    }

}