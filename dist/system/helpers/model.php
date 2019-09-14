<?php declare(strict_types = 1);

namespace System\Helpers;

defined('BASEPATH') OR exit('Direct access is forbidden');

use System\Core\Database;
use Exception;

class Model extends Database{

    private $query = null;
    private $table = null;
    private $where = null;

	/**
	 * 
     * @param string $query
     * 
     * @return void
     */
    public function select($query = ''){
        
        if(is_empty($query)){
            throw new Exception('Undefined select query!');
        }

        $this->query = 'SELECT ' . $query . ' FROM ';
    }

	/**
	 * 
     * @param string $table
     * 
     * @return void
     */
    public function from($table = ''){

        if(is_empty($table)){
            throw new Exception('Undefined database table!');
        }

        $this->table = $table;

    }

	/**
	 * 
     * @param string $column
     * @param string $value
     * 
     * @return void
     */
    public function where($column = '', $value = ''){
        
        if(is_empty($column)){
            throw new Exception('Undefined table column!');
        }

        if(is_empty($value)){
            throw new Exception('Undefined parameter value!');
        }

        $this->where[$column] = $value;

    }

	/**
     * 
     * @param string $db
     *
     * @return mixed
     */
    public function process($db = 'primary'){

        $con = $this->db->connect($db);

        $where = $this->manage_where();
        $params = $this->get_params();

        $query = $this->query . $this->table . $where;
        $dbh = $con->prepare($query);
        $dbh->execute($params);

        $this->query = null;
        $this->table = null;
        $this->where = null;
        $query = null;
        $where = null;
        $params = null;
        $con = null;

        unset($this->query);
        unset($this->table);
        unset($this->where);
        unset($query);
        unset($where);
        unset($params);
        unset($con);

        return $dbh;

    }

	/**
     * 
     * @return array
     */
    private function get_params(){

        $params = array();

        if(!is_empty($this->where)){
            foreach($this->where as $key => $value){
                $params[':' . $key] = $value;
            }
        }

        return $params;

    }

	/**
     * 
     * @return string
     */
    private function manage_where(){

        $where = '';

        if(!is_empty($this->where)){

            $where .= ' WHERE ';

            $i = (int)count($this->where);
            $y = 0;

            foreach($this->where as $key => $value){
                
                $where .= '(' . $key . ' = :' . $key . ') ';

                if($i !== 1){
                    $where .= 'AND ';
                    $i--;
                }

            }

        }

        return $where;

    }

}