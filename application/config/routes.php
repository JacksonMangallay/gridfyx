<?php declare(strict_types = 1);

defined('BASEPATH') OR exit('Direct access is forbidden');

use System\Core\Router;

/*
 *---------------------------------------------------------------
 * LOAD CONTROLLERS AND ROUTES FILE
 *---------------------------------------------------------------
 */
Router::setDefaultController('IndexController');
Router::setDefaultMethod('index');
Router::setNamespace('Application\\Controllers\\');

Router::load('IndexRoutes');