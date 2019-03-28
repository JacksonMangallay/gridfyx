<?php

declare(strict_types = 1);

namespace System\Core;

use PDO;

class DB_Connect{

    private $host;
    private $username;
    private $password;
    private $db_name;

    public function use(String $db_group_name){

        $db_data = DB::fetch_group($db_group_name);

        $this->host = $db_data['host'];
        $this->username = $db_data['username'];
        $this->password = $db_data['password'];
        $this->db_name = $db_data['db_name'];

        return $this;

    }

    public function connect(){
        return new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
    }

}