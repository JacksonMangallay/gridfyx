<?php

declare(strict_types = 1);

namespace System\Core;

use System\Core\Loader;

class Controller{

    protected $load;

    public function __construct(){
        $this->load = new Loader();
    }

}