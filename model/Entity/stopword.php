<?php

namespace model\entity;

class stopword{
    
    private $id;
    private $word;
    
    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getWord() {
        return $this->word;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setWord($word) {
        $this->word = $word;
    }


}

