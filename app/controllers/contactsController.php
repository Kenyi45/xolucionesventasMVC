<?php

namespace App\Controllers;

use Libs\Controller;

class ContactsController extends Controller
{
    public function __construct() 
    {
        $this->loadDirectoryTemplate('contacts');
    }

    public function index()
    {
        echo $this->template->render('index');
    }
}