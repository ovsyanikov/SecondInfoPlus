<?php

namespace controller;

use util\Request;
use util\View;

class FrontController{
    
    private $view;
    private $controller;
    
    function start(){
        
        \util\MySQL::$db = new \PDO('mysql:host=localhost;dbname=user1187254_u304199710_info', 'u304199710_alex', '1qaz2wsx');
        $this->view = new View();
        
        session_start();
        $r = new Request();
        
        $control = $r->getGetValue('ctrl');
        $action = $r->getGetValue('act');
        
        if(empty($control)){
            $control = 'start';
        }//if
        
        if(empty($action)){
            $action = 'welcome';
        }//if

        switch ($control) {
            
            case 'start':
                $ctrl = new StartController($this->view);
                break;
            case 'news':
                $ctrl = new NewsController($this->view);
                break;
            case 'user':
                 $ctrl = new UserController($this->view);
                 break;
            case 'social':
                 $ctrl = new SocialController($this->view);
                 break;
            default:
                header("Location: index.php?ctrl=start&act=welcome");
                
        }//switch
        
        if( !method_exists($ctrl, "{$action}Action") ) {
           
            header("Location: index.php?ctrl=start&act=welcome");
           
        }//if
        else{
            
            $view = $ctrl->{"{$action}Action"}();
            
        }//else
        
        include "view/$control/$view.php";
        
    }//start
    
}