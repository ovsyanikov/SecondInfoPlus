<?php

namespace model\service;

use model\entity\user;

class UserService{
    
    function add(user $user) {
     
        
        
    }
    
    function searchLoginAction(){
        
        $login = (new \util\Request())->getPostValue('RLogin');
        $stmt = \util\MySQL::$db->prepare("SELECT id FROM users WHERE Login = :login");
        $stmt->bindParam(":login",$login);
        $stmt->execute();
        $user = $stmt->fetchObject(user::class);
        
        if(is_a($user, 'model\entity\user'))
        {echo 1;}
        else
        {echo 0;}
        
    }//searchLoginAction
            
    function authorize($login, $password) {

        $stmt = \util\MySQL::$db->prepare("SELECT * FROM users WHERE ( (Login = :login or Email =:login) and Password = :pass)");
        $stmt->bindParam(":login",$login);
        $stmt->bindParam(":pass",$password);
        
        $stmt->execute();
        $user = $stmt->fetchObject(user::class);
        
        if(is_a($user, 'model\entity\user')){
            
            return $user;
            
        }
        else{
            
            return NULL;
            
        }
        
    }
    
    function leaveResource(){
        
        $r = new \util\Request();
        $r->unsetCookie('user_info_plus');
        $r->unsetSeesionValue('user_info_plus');
        
    }
    
}