<?php

declare(strict_types = 1);

use System\Core\Router;

/*
 *---------------------------------------------------------------
 * LOAD CONTROLLERS AND ROUTES FILE
 *---------------------------------------------------------------
 */
Router::SetDefaultController('Index_Controller');
Router::SetDefaultMethod('index');
Router::SetNamespace('Application\\Controllers\\');

Router::Load('Index_Routes');