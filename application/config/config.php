<?php

declare(strict_types = 1);

use System\Core\Config;

/*
 *---------------------------------------------------------------
 * APPLICATION DEFAULTS
 *---------------------------------------------------------------
 */
define('BASE_URL', 'localhost');
define('ENCODING', 'UTF-8');
define('AUTH_SECRET_KEY', 'N+@17-Q#bDtCAeV+HQ)8~f-qk`}z^_RCzK6dHI]|elI~fv7Ai$/KFw{(b|CYS=|}');

/*
 *---------------------------------------------------------------
 * DEVELOPMENT ENVIRONMENT
 *---------------------------------------------------------------
 */
Config::set_display_error(true);
Config::set_log_error(true);
Config::set_timezone('Asia/Manila');
Config::set_date_format('Y-m-d');

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
Config::set_error_pages_path('errors');