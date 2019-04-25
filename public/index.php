<?php declare(strict_types=1);

define('BASEPATH', str_replace('\\', '/',dirname(dirname(__FILE__))));
define('DS', str_replace('\\', '/', DIRECTORY_SEPARATOR ));


/*
 *---------------------------------------------------------------
 * PATH CONSTANTS
 *---------------------------------------------------------------
 */
define('APPLICATION', BASEPATH . DS . 'application');
define('DATA', BASEPATH . DS . 'data');
define('LIBRARY', BASEPATH . DS . 'library');
define('PUB', BASEPATH . DS . 'public');
define('SYSTEM', BASEPATH . DS . 'system');

/*
 *---------------------------------------------------------------
 * START THE APPLICATION
 *---------------------------------------------------------------
 */
require_once(SYSTEM . DS . 'core' . DS . 'Bootstrap.php');