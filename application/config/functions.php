<?php declare(strict_types = 1);

defined('BASEPATH') OR exit('Direct access is forbidden');

function get_header($params = ''){
    
    $file = DIR_VIEWS . '/header.php';
    
    if(file_exists($file)){
        include_once($file);
    }
    
}

function get_footer($params = ''){

    $file = DIR_VIEWS . '/footer.php';
    
    if(file_exists($file)){
        include_once($file);
    }

}

function component($file = '', $params = ''){

    $file = DIR_VIEWS . '/components/' . $file . '.PHP';
    
    if(file_exists($file)){
        include_once($file);
    }

}