<?php

declare(strict_types=1);

namespace System\Library;

class XSS{

    private $bad_chars = [
        '&', '&amp;', 'amp', '<', '&lt;',
        'lt;', '>', '&gt;', 'gt;', '"',
        '&quot;', 'quot;', "'", '&#x27;',
        '#x27;', '/', '&#x2F;', '#x2F;'
    ];

    private $bad_names = [
        'script', 'javascript', 'expression',
        'vbscript', 'jscript', 'wscript',
        'vbs', 'base64', 'applet', 'alert', 'document',
        'write', 'cookie', 'window', 'confirm',
        'prompt', 'eval', 'exec'
    ];

    public function clean($str = ''){

        if(empty($str)){
            return false;
        }

        if(is_array($str)){

            foreach(array_keys($str) as $key){
                $str[$key] = $this->removeBadStrings($str[$key]);
                $str[$key] = $this->removeInvisibleChars($str[$key]);
                $str[$key] = htmlspecialchars($str[$key], ENT_QUOTES, 'UTF-8', true);
            }

            return $str;

        }else{

            $str = $this->removeBadStrings($str);
            $str = $this->removeInvisibleChars($str);
            $str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8', true);
            return $str;
            
        }

    }

    private function removeBadStrings(String $str):string{

        foreach($this->bad_chars as $bad){
            $str = str_replace($bad,'',$str);
        }

        foreach($this->bad_names as $bad){
            $str = str_replace($bad,'',$str);
        }

        return $str;

    }

    private function removeInvisibleChars(String $str):string{

        $invisibles = [
            '/%0[0-8bcef]/i',
            '/%1[0-9a-f]/i',
            '/%7f/i',
            '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S'
        ];

        do{
            $str = preg_replace($invisibles, '', $str, -1, $ctr);
        }while($ctr);

        return $str;
        
    }

}