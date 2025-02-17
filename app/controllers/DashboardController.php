<?php

namespace App\controllers;

use App\core\Database;
use App\core\Session;
use App\core\View;
use App\models\Statistique;

class DashboardController
{
    public function index(){
        $role = Session::get("roleID");
        if ($role === 3){
            $db = new Database();
            $Stats = new Statistique($db->getConnection());
            View::render("back/dashboard",[
                "TotalUsers"=>$Stats->getTotalUtilisateurs(),
                "TotalEvents"=>$Stats->getTotalEvenements(),
                "TotalSoldTicket"=>$Stats->getTotalBilletsVendus(),
                "TotalRevenue"=>$Stats->getRevenuTotal(),
                "role"=>3
            ]);
        }elseif ($role === 1){
            View::render("front/home",["isAuth"=>true]);
        }else{
            header("Location:/Auth/Login");
        }
    }
}