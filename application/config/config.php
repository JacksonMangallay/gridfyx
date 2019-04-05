<?php

declare(strict_types = 1);

use System\Core\Config;

/*
 *---------------------------------------------------------------
 * APPLICATION DEFAULTS
 *---------------------------------------------------------------
 */
define('BASE_URL', '127.0.0.1/gridfyx');
define('ENCODING', 'UTF-8');
define('AUTH_SECRET_KEY', 'N+@17-Q#bDtCAeV+HQ)8~f-qk`}z^_RCzK6dHI]|elI~fv7Ai$/KFw{(b|CYS=|}');

/*
 *---------------------------------------------------------------
 * DEVELOPMENT ENVIRONMENT
 *---------------------------------------------------------------
 */
Config::SetDisplayError(true);
Config::SetLogError(true);
Config::SetTimezone('Asia/Manila');
Config::SetDateFormat('Y-m-d');

/*
 *---------------------------------------------------------------
 * ERROR PAGES
 *---------------------------------------------------------------
 *
 * To make everything in its place, errors path are restricted
 * inside /application/views folder all the time. It's up to you
 * if you'll create another folder inside this path containing
 * the error pages.
 * 
 */
Config::SetErrorPagesPath('errors');