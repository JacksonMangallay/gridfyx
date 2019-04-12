<?php

declare(strict_types = 1);

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