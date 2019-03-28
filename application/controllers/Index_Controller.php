<?php

declare(strict_types=1);

namespace Application\Controllers;

use System\Core\Controller;

class Index_Controller extends Controller{

    public function index(){
        $this->load->view('index');
    }

}