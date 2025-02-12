<?php

namespace App\controllers;

use App\core\View;
use App\models\Tag;

class TagController
{
    private Tag $tag;

    public function __construct(){
        $this->tag = new Tag();
    }
    public function index(){
        View::render("back/tag",[
            "Tags"=>$this->tag->showTag()
        ]);
    }
    public function deleteTag($id){
        if($this->tag->deleteTag($id)){
            $result = [
                "status"=>true,
                "message"=>"Tag number $id Has been deleted successfully !"
            ];
        }else{
            $result = [
                "status"=>false,
                "message"=>"Failed To delete Tag number $id "
            ];
        }
        echo json_encode($result);
    }

    public function addTag(){
        header('Content-Type: application/json');

        extract($_POST);
        $tagName = $tagname;
        if($this->tag->addTag([$tagName])){
            $result = [
                "status"=>true,
                "message"=>"$tagName Has been Added successfully !"
            ];
        }else{
            $result = [
                "status"=>false,
                "message"=>"Failed To add Tag $tagName "
            ];
        }
        echo json_encode($result);
    }
    public function GetTags(){
        $Tags = $this->tag->showTag();
        if ($Tags){
            $result = [
                "status"=>true,
                "data"=>$Tags
            ];
        }else{
            $result = [
                "status"=>false,
                "data"=>"Failed !"
            ];
        }
        echo json_encode($result);
    }
    public static function GetAllTags(){
        $Tag = new Tag();
        return $Tag->showTag();
    }
}