<?php

namespace model\entity;

class News{
    
    private $id;
    private $Title;
    private $Resourse;
    
    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getTitle() {
        return $this->Title;
    }

    function getResourse() {
        return $this->Resourse;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTitle($Title) {
        $this->Title = $Title;
    }

    function setResourse($Resourse) {
        $this->Resourse = $Resourse;
    }


    
}