<?php declare(strict_types = 1);

namespace System\Helpers;

defined('BASEPATH') || exit('Direct access is forbidden');

use System\Library\Encryption;
use System\Library\File;
use System\Library\JWT;
use System\Library\Session;
use System\Library\XSS;

final class Library{

    public $encryption = null;
    public $file = null;
    public $jwt = null;
    public $session = null;
    public $xss = null;

    public function __construct(){

        $this->encryption = new Encryption();
        $this->file = new File();
        $this->jwt = new JWT();
        $this->session = new Session();
        $this->xss = new XSS();

    }

}