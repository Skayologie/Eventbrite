<?php

namespace App\controllers;

use App\core\View;
use App\models\Category;
use App\models\Tag;

class CategorieController
{
    private Category $category;

    public function __construct(){
        $this->category = new Category();
    }
    public function index(){
        View::render("back/categorie",[
            "Categories"=>$this->category->showAllCategories()
        ]);
    }

    public function addCategorie(){
        header('Content-Type: application/json');

        extract($_POST);
        if($this->category->addCategorie([$CategorieName])){
            $result = [
                "status"=>true,
                "message"=>"$CategorieName Has been Added successfully !"
            ];
        }else{
            $result = [
                "status"=>false,
                "message"=>"Failed To add Tag $CategorieName "
            ];
        }
        echo json_encode($result);
    }
    public function deleteCategorie($id){
        if($this->category->deleteCategory($id)){
            $result = [
                "status"=>true,
                "message"=>"Categorie number $id Has been deleted successfully !"
            ];
        }else{
            $result = [
                "status"=>false,
                "message"=>"Failed To delete Categorie number $id "
            ];
        }
        echo json_encode($result);
    }

    public static function getAllCategories(){
        $category = new Category();
        return $category->showCategorie();
    }
}