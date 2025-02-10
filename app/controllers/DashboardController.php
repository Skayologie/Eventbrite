<?php

namespace App\controllers;

use App\core\Session;
use App\core\View;

class DashboardController
{
    public function index(){
        $role = Session::get("roleID");
        if ($role === 3){
            View::render("back/dashboard",[]);
        }elseif ($role === 1){
            View::render("front/home",["isAuth"=>true]);
        }else{
            header("Location:/Auth/Login");
        }
    }
}