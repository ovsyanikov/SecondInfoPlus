<?php

namespace model\entity;

class user {
    
    private $id;
    private $Login;
    private $Password;
    private $Email;
    private $FirstName;
    private $LastName;
    
    public function __construct() {
        
    }
    
    function getId() {
        return $this->id;
    }

    function getLogin() {
        return $this->Login;
    }

    function getPassword() {
        return $this->Password;
    }

    function getEmail() {
        return $this->Email;
    }

    function getFirstName() {
        return $this->FirstName;
    }

    function getLastName() {
        return $this->LastName;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLogin($Login) {
        $this->Login = $Login;
    }

    function setPassword($Password) {
        $this->Password = $Password;
    }

    function setEmail($Email) {
        $this->Email = $Email;
    }

    function setFirstName($FirstName) {
        $this->FirstName = $FirstName;
    }

    function setLastName($LastName) {
        $this->LastName = $LastName;
    }

    
    
}
