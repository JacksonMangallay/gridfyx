<?php

declare(strict_types = 1);

use System\Core\Router;

/*
 *---------------------------------------------------------------
 * LOAD CONTROLLERS AND ROUTES FILE
 *---------------------------------------------------------------
 */
Router::set_default_controller('Index_Controller');
Router::set_default_method('index');
Router::set_namespace('Application\\Controllers\\');

Router::load('Index_Routes');