<?php declare(strict_types = 1);

namespace System\Core;

defined('BASEPATH') OR exit('Direct access is forbidden');

use System\Core\Config;
use PDO;

class Database extends Config{

    protected $db = null;
    protected $credentials = null;

    public function __construct(){

        parent::__construct();
        self::config()->load('db');
        $this->db = $this;

    }

	/**
	 * 
     * @param string $db
     * 
     * @return object
     */
    protected function connect($db = 'primary'){

        $this->credentials = self::config()->get('db');

        if(!array_key_exists($db, $this->credentials)){
            display_log('Undefined database selected!');
            write_log('[' . date('Y-m-d') . '] [Database] Undefined database selected!');
        }

        return new PDO('mysql:host=' . $this->credentials[$db]['host'] . ';dbname=' . $this->credentials[$db]['db_name'], $this->credentials[$db]['username'], $this->credentials[$db]['password']);

    }

}