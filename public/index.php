<?php declare(strict_types=1);

//Directory paths
define('BASEPATH', str_replace('\\', '/',dirname(dirname(__FILE__))));
define('DIR_APPLICATION', BASEPATH . '/application');
define('DIR_CONFIG', BASEPATH . '/application/config');
define('DIR_CONTROLLERS', BASEPATH . '/application/controllers');
define('DIR_DATA', BASEPATH . '/application/data');
define('DIR_CACHE', BASEPATH . '/application/data/cache');
define('DIR_LOGS', BASEPATH . '/application/data/logs');
define('DIR_MODELS', BASEPATH . '/application/models');
define('DIR_PLUGINS', BASEPATH . '/application/plugins');
define('DIR_ROUTES', BASEPATH . '/application/routes');
define('DIR_VIEWS', BASEPATH . '/application/views');
define('DIR_SYSTEM', BASEPATH . '/system');
define('DIR_CORE', BASEPATH . '/system/core');
define('DIR_HELPERS', BASEPATH . '/system/helpers');
define('DIR_LIBRARY', BASEPATH . '/system/library');
define('DIR_THIRD_PARTY', BASEPATH . '/system/third_party');
define('DIR_PUBLIC', BASEPATH . '/public');

require_once(DIR_SYSTEM . '/start_up.php');