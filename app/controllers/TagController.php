<?php

namespace App\controllers;

use App\core\View;

class TagController
{

    public function index(){
        View::render("back/tag");
    }
}