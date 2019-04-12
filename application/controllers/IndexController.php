<?php

declare(strict_types=1);

namespace Application\Controllers;

use System\Core\Controller;

class IndexController extends Controller{

    public function index(){
        $this->load->view('index');
    }
    
}