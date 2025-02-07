<?php

namespace App\controllers;
use App\core\Database;
use App\core\View;

class HomeController
{
    public function index(){
        $db = new Database();
        View::render("front/home",[
            "title"=>"Home",
        ]);
    }
}