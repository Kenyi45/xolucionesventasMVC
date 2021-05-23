<?php

namespace App\Controllers;

use Libs\Controller;

class ProductsController extends Controller
{
    public function __construct() 
    {
        $this->loadDirectoryTemplate('products');
    }

    public function index()
    {
        echo $this->template->render('index');
    }
}