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
            $categoriesNames = $Stats->getCategories();
            $names = [];
            foreach ($categoriesNames as $name){
                $names[] = $name["categorie_name"];
            }
            $colors = [
                'rgb(78, 115, 223)',    // primary
                'rgb(28, 200, 138)',    // success
                'rgb(54, 185, 204)',    // info
                'rgb(246, 194, 62)',    // warning
                'rgb(231, 74, 59)',     // danger
                'rgb(133, 135, 150)',   // secondary
                'rgb(90, 92, 105)',     // dark
                'rgb(244, 246, 249)',   // light

                'rgb(52, 144, 220)',    // deep blue
                'rgb(19, 130, 100)',    // deep green
                'rgb(46, 165, 180)',    // teal
                'rgb(255, 160, 0)',     // orange
                'rgb(214, 48, 49)',     // bright red
                'rgb(108, 117, 125)',   // neutral grey
                'rgb(40, 42, 54)',      // dark navy
                'rgb(235, 236, 239)',   // soft white

                'rgb(111, 66, 193)',    // purple
                'rgb(255, 99, 132)',    // pinkish red
                'rgb(255, 159, 64)',    // coral
                'rgb(255, 205, 86)',    // gold
                'rgb(75, 192, 192)',    // turquoise
                'rgb(153, 102, 255)',   // lavender
                'rgb(255, 159, 176)',   // pastel pink
                'rgb(201, 203, 207)',   // soft grey

                'rgb(204, 85, 0)',      // dark orange
                'rgb(128, 0, 128)',     // dark purple
                'rgb(255, 0, 255)',     // magenta
                'rgb(50, 205, 50)',     // lime green
                'rgb(0, 191, 255)',     // sky blue
                'rgb(139, 69, 19)',     // brown
                'rgb(220, 20, 60)',     // crimson
                'rgb(184, 134, 11)',    // dark goldenrod

                'rgb(255, 105, 180)',   // hot pink
                'rgb(72, 209, 204)',    // medium turquoise
                'rgb(47, 79, 79)',      // dark slate grey
                'rgb(176, 224, 230)',   // powder blue
                'rgb(128, 128, 0)',     // olive
                'rgb(0, 250, 154)',     // medium spring green
                'rgb(100, 149, 237)',   // cornflower blue
                'rgb(25, 25, 112)',     // midnight blue
            ];
            $background = json_encode(array_slice($colors, 0, count($names)));

            View::render("back/dashboard",[
                "TotalUsers"=>$Stats->getTotalUtilisateurs(),
                "TotalEvents"=>$Stats->getTotalEvenements(),
                "TotalSoldTicket"=>$Stats->getTotalBilletsVendus(),
                "TotalRevenue"=>$Stats->getRevenuTotal(),
                "categoriesNames"=>json_encode($names),
                "background"=>$background
            ]);
        }elseif ($role === 1){
            View::render("front/home",["isAuth"=>true]);
        }else{
            header("Location:/Auth/Login");
        }
    }
}