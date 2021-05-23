<?php

namespace App\Controllers;

use Libs\Controller;

class LoginController extends Controller
{
    public function __construct() 
    {
        $this->loadDirectoryTemplate('login');
    }

    public function index()
    {
        echo $this->template->render('login');
    }
}