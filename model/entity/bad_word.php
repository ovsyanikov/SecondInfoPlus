<?php

namespace model\entity;

class bad_word{
    
    public $id;
    public $word;
    
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