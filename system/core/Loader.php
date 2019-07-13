<?php

declare(strict_types = 1);

namespace System\Core;

use Exception;

class Loader{

    private $view_path = APPLICATION . DS . 'views';

    public function view(String $view, $args = ''){

        if(empty($view)){
            throw new Exception('Undefined view file.');
        }

        $file = $this->view_path . DS . $view . '.php'; 

        if(!file_exists($file)){
            http_response(404);
        }

        /**Enable gzip */
        if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
        {
            ob_start('ob_gzhandler');
            include($file);
            ob_end_flush();   
        }
        else
        {
            include($file);
        }

    }

}
