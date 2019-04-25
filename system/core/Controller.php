<?php declare(strict_types = 1);

namespace System\Core;

defined('BASEPATH') OR exit('Direct access is forbidden');

use System\Core\Loader;

class Controller
{

    protected $load;

    public function __construct()
    {
        $this->load = new Loader();
    }

}