<?php declare(strict_types=1);

namespace Application\Controllers;

defined('BASEPATH') OR exit('Direct access is forbidden');

use System\Core\Controller;

class IndexController extends Controller
{

    public function index()
    {
        $this->load->view('index');
    }
    
}