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

        ob_start();
        include($file);
        $content = ob_get_contents();
        $content = $this->minifyOutput($content);
        ob_end_clean();
        print_r($content);

    }

    private function minifyOutput($content)
    {
        $search = array(
            '/(\n|^)(\x20+|\t)/',
            '/(\n|^)\/\/(.*?)(\n|$)/',
            '/\n/',
            '/\<\!--.*?-->/',
            '/(\x20+|\t)/',
            '/\>\s+\</',
            '/(\"|\')\s+\>/',
            '/=\s+(\"|\')/'
        );
        $replace = array(
            "\n","\n"," ",
            ""," ","><","$1>",
            "=$1"
        );
        return preg_replace($search,$replace,$content);
    }
    
}
