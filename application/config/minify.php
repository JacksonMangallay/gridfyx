<?php declare(strict_types = 1);

defined('BASEPATH') OR exit('Direct access is forbidden');

use System\Core\Minify;

/*
 *---------------------------------------------------------------
 * MINIFY CSS
 *---------------------------------------------------------------
 */
Minify::css(array(), '', FALSE);

/*
 *---------------------------------------------------------------
 * MINIFY JS
 *---------------------------------------------------------------
 */
Minify::js(array(), '', FALSE);