<?php

declare(strict_types = 1);

namespace System\Core;

use Exception;

class Loader{

    private $view_path = APPLICATION . DS . 'views';

    public function View(String $view, $params = ''){

        if(empty($view)){
            throw new Exception('Undefined view file.');
        }

        $file = $this->view_path . DS . $view . '.php'; 

        if(!file_exists($file)){
            http_response(404);
        }

        ob_start();
        include($file);
        $content = ob_get_contents();
        ob_end_clean();
        print_r($content);        

    }

}