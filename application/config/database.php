<?php declare(strict_types = 1);

defined('BASEPATH') OR exit('Direct access is forbidden');

use System\Core\DB;

/*
 *---------------------------------------------------------------
 * SETUP APPLICATION DATABASE
 *---------------------------------------------------------------
 */
DB::createGroup('default',[
    'host' => '',
    'username' => '',
    'password' => '',
    'db_name' => ''
]);