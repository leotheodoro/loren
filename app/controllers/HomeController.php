<?php

namespace App\Controllers;

use Core\BaseController;

class HomeController extends BaseController
{
    public function index() 
    {
        $this->setPageTitle('Home');
        $this->view->nome = 'Leonardo Theodoro';
        $this->view('home/index', 'layout');
    }
}