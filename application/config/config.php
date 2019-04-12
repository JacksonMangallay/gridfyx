<?php

declare(strict_types = 1);

use System\Core\Config;

/*
 *---------------------------------------------------------------
 * APPLICATION DEFAULTS
 *---------------------------------------------------------------
 */
define('BASE_URL', System\Core\base_url());
define('ENCODING', 'UTF-8');
define('AUTH_SECRET_KEY', 'N+@17-Q#bDtCAeV+HQ)8~f-qk`}z^_RCzK6dHI]|elI~fv7Ai$/KFw{(b|CYS=|}');

/*
 *---------------------------------------------------------------
 * DEVELOPMENT ENVIRONMENT
 *---------------------------------------------------------------
 */
Config::setDisplayError(true);
Config::setLogError(true);
Config::setTimezone('Asia/Manila');
Config::setDateFormat('Y-m-d');

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
Config::setErrorPagesPath('errors');