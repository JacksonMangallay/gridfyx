<?php

declare(strict_types = 1);

use System\Core\DB;


/*
 *---------------------------------------------------------------
 * SETUP APPLICATION DATABASE
 *---------------------------------------------------------------
 */
DB::CreateGroup('default',[
    'host' => '',
    'username' => '',
    'password' => '',
    'db_name' => ''
]);