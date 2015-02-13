<?php

require_once './util/Request.php';
require_once './util/MySQL.php';
require_once './model/Entity/user.php';
\util\MySQL::$db = new PDO('mysql:host=localhost;dbname=infoplus', 'StepUser', '1qaz2wsx');

use model\entity\user;

if(!empty($_POST['mainregister'])){
    
    //Главная регистрация
 
 $newLogin = (new \util\Request())->getPostValue('newUserLogin');
 $newMail = (new \util\Request())->getPostValue('newMail');
 
 //Если не пуст новый логин
 if(!empty($newLogin)){
     
     $stmt = \util\MySQL::$db->prepare("SELECT * FROM users WHERE Login = :login");
     $stmt->bindParam(":login",$newLogin);
     $stmt->execute();
     $user = $stmt->fetchObject(user::class);
     
     if(is_a($user,'model\entity\user')){
         
         echo "used_login";
         
     }//if
     //Если логин не используется и пароль на форме не пуст
     else if(!empty($newMail)){
         
            $stmt = \util\MySQL::$db->prepare("SELECT * FROM users WHERE Email = :mail");
            $stmt->bindParam(":mail",$newMail);
            $stmt->execute();
            $user = $stmt->fetchObject(user::class);

            if(is_a($user,'model\entity\user')){

                echo "used_email";

            }//if
            else{
                
                echo $newMail;
                
            }//else
            
     }//if !empty($newMail)
     else {echo "no";}
     
 }//login
 
}

else{
    
    //Регистрация
 $login = (new \util\Request())->getPostValue('userLogin');
 $email = (new \util\Request())->getPostValue('userEmail');
 
 if(!empty($login) && !empty($email)){
     
    $stmt = \util\MySQL::$db->prepare("SELECT * FROM users WHERE Login = :login");
    $stmt->bindParam(":login",$login);
    $stmt->execute();
    $user = $stmt->fetchObject(user::class);
    
    if(is_a($user, 'model\entity\user')){
        
        echo "used_login";
        
    }//if
    else{
        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM users WHERE Email = :email");
        $stmt->bindParam(":email",$email);
        $stmt->execute();
        $user = $stmt->fetchObject(user::class);
        
        if(is_a($user, 'model\entity\user')){
        
            echo "used_email";
        
        }//if
        else{
            echo "acc_free";
        }
    }
    
    
 }
 
 //Авторизация
 $userLE = (new \util\Request())->getPostValue('userLE');
 
 if(!empty($userLE)){
     
    $userPS = (new \util\Request())->getPostValue('userPS');
     
    $stmt = \util\MySQL::$db->prepare("SELECT * FROM users WHERE ( (Login = :login or Email =:login) and Password = :pass)");
    $stmt->bindParam(":login",$userLE);
    $stmt->bindParam(":pass",$userPS);
    $stmt->execute();
    
    $user = $stmt->fetchObject(user::class);
    
       if(is_a($user, 'model\entity\user')){
               echo "yes";
       }//if
       else{
            echo "no_authorize";
       }//else
     
 }//if
 

    
}
