<?php

namespace model\service;

use model\entity\user;

class UserService{
    
    function add(user $user) {
        
        
        
        $stmt = \util\MySQL::$db->prepare(
                "INSERT INTO users (id,Login,Password,Email,FirstName,LastName)".
                "VALUES(NULL,:login,:pass,:email,:fn,:ln)");
        
        $stmt->bindParam(":login",$user->getLogin());
        $stmt->bindParam(":pass",$user->getPassword());
        $stmt->bindParam(":email",$user->getEmail());
        $stmt->bindParam(":fn",$user->getFirstName());
        $stmt->bindParam(":ln",$user->getLastName());
        
        $stmt->execute();
        
        return $stmt->lastInsertId();     
        
    }//add
    
    function searchLoginAction(){
        
        $login = (new \util\Request())->getPostValue('userLogin');
        $stmt = \util\MySQL::$db->prepare("SELECT id FROM users WHERE Login = :login");
        $stmt->bindParam(":login",$login);
        $stmt->execute();
        $user = $stmt->fetchObject(user::class);
        
        if(is_a($user, 'user'))
        {echo "yes";}
        else
        {echo "no";}
        
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