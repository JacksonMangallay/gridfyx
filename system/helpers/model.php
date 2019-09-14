<?php declare(strict_types = 1);
/**
 *---------------------------------------------------------------------------------
 * GRIDFYX PHP FRAMEWORK
 *---------------------------------------------------------------------------------
 *
 * A progressive PHP framework for small to medium scale web applications
 *
 * MIT License
 *
 * Copyright (c) 2019 Jackson
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 *
 * @package	Gridfyx PHP Framework
 * @author	Jackson Mangallay
 * @license	MIT License
 * @link	https://github.com/JacksonMangallay/gridfyx
 * @since	Version 2.0.0
 *
 */

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