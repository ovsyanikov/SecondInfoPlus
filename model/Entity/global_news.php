<?php

namespace model\entity;

class global_news{

       
    public $id;
    public $title;
    public $description;
    public $public_date;
    public $district;
    public $Source;
    public $Images;
    
    function getImage() {
        return $this->Images;
    }

    function setImage($Images) {
        $this->Images = $Images;
    }

    
    function __construct() {
        
    }
    
    function getId() {
        return $this->id;
    }

    function getTitle() {
        return $this->title;
    }

    function getDescription() {
        return $this->description;
    }

    function getPublic_date() {
        return $this->public_date;
    }

    function getDistrict() {
        return $this->district;
    }

    function getSource() {
        return $this->Source;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setPublic_date($public_date) {
        $this->public_date = $public_date;
    }

    function setDistrict($district) {
        $this->district = $district;
    }

    function setSource($Source) {
        $this->Source = $Source;
    }
    
}