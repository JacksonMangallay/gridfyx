<?php declare(strict_types = 1);

defined('BASEPATH') OR exit('Direct access is forbidden');

//Turn minification on/off
Minify::enable(false);

//Stylesheets to minify
Minify::css(array(), '');

//Scripts to minify
Minify::JS(array(), '');