<?php

namespace App\Controllers;
error_reporting(E_ALL);
ini_set('display_errors', 1);


class Home extends BaseController
{
    public function index(): string
    {
        return view('test');
    }
}