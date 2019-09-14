<?php declare(strict_types=1);

namespace Application\Controllers;

defined('BASEPATH') OR exit('Direct access is forbidden');

use System\Helpers\Controller;
use System\Library\File;

class IndexController extends Controller{

    public function index(){
        $this->view->render('pages/index');
    }
    
}