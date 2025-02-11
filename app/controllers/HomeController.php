<?php

namespace App\controllers;
use App\core\Database;
use App\core\Session;
use App\core\View;

class HomeController
{
    public function index(){
        $db = new Database();
        $isAuth = Session::get("isAuth");
        $role = Session::get("roleID");
        $fname = Session::get("fname");
        if ($role === 1){
            View::render("front/home",[
                "title"=>"Home",
                "isAuth"=>$isAuth
            ]);
        }elseif($role === 3){
            View::render("back/Dashboard",[
                "title"=>"Home",
                "isAuth"=>$isAuth
            ]);
        }elseif($role === 2){
            View::render("front/home",[
                "title"=>"Home",
                "isAuth"=>$isAuth
            ]);
        }else{
            View::render("front/home",[
                "title"=>"Home",
                "isAuth"=>$isAuth
            ]);
        }

    }
}