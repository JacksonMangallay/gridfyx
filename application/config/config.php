<?php declare(strict_types = 1);

defined('BASEPATH') OR exit('Direct access is forbidden');

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
Config::setDisplayError(TRUE);
Config::setLogError(TRUE);
Config::setTimezone('Asia/Manila');
Config::setDateFormat('Y-m-d');

/*
 *---------------------------------------------------------------
 * ERROR PAGES
 *---------------------------------------------------------------
 */
Config::setErrorPagesPath();