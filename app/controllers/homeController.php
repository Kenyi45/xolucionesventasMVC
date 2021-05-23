<?php

namespace App\Controllers;

use Libs\Controller;

class HomeController extends Controller
{
    public function __construct() 
    {
        $this->loadDirectoryTemplate('home');
    }

    public function index()
    {
        // $this->renderView('home/index');

        // $this->loadDirectoryTemplate('home');
        echo $this->template->render('index');
    }
}