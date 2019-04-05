<?php

declare(strict_types = 1);

namespace System\Core;

use System\Core\DBConnect;

class Model{

    public $db;

    public function __construct(){
        $this->db = new DBConnect();
    }

}