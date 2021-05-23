<?php

namespace App\Controllers;

use Libs\Controller;

class RegisterController extends Controller
{
    public function __construct() 
    {
        $this->loadDirectoryTemplate('register');
    }

    public function index()
    {
        echo $this->template->render('index');
    }
}