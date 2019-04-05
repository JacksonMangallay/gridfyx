<?php

declare(strict_types = 1);

use System\Core\Router;

/*
 *---------------------------------------------------------------
 * LOAD CONTROLLERS AND ROUTES FILE
 *---------------------------------------------------------------
 */
Router::SetDefaultController('IndexController');
Router::SetDefaultMethod('index');
Router::SetNamespace('Application\\Controllers\\');

Router::Load('IndexRoutes');