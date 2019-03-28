<?php

declare(strict_types = 1);

use System\Core\DB;


/*
 *---------------------------------------------------------------
 * SETUP APPLICATION DATABASE
 *---------------------------------------------------------------
 */
DB::create_group('default',[
    'host' => '',
    'username' => '',
    'password' => '',
    'db_name' => ''
]);