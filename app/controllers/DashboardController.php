<?php

namespace App\controllers;

use App\core\View;

class DashboardController
{
    public function index(){
        View::render("back/dashboard",[]);
    }
}