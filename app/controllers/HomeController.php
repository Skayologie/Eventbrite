<?php

namespace App\controllers;
use App\core\Database;
use App\core\Session;
use App\core\View;

class HomeController
{
    public function index(){
        $db = new Database();
        $fname = Session::get("fname");
        View::render("front/home",[
            "title"=>"Home",

        ]);
    }
}