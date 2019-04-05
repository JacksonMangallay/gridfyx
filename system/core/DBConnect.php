<?php

declare(strict_types = 1);

namespace System\Core;

use PDO;

class DBConnect{

    private $host;
    private $username;
    private $password;
    private $db_name;

    public function Use(String $db_group_name){

        $db_data = DB::FetchGroup($db_group_name);

        $this->host = $db_data['host'];
        $this->username = $db_data['username'];
        $this->password = $db_data['password'];
        $this->db_name = $db_data['db_name'];

        return $this;

    }

    public function Connect(){
        return new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
    }

}