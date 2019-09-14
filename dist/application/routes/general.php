<?php declare(strict_types = 1);

defined('BASEPATH') OR exit('Direct access is forbidden');

Router::get('/',array(
    'method' => 'index'
));

Router::get('/login',array(
    'method' => 'login'
));