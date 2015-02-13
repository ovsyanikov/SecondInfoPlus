<?php

require_once './util/Request.php';
require_once './util/MySQL.php';
require_once './model/Entity/user.php';
\util\MySQL::$db = new PDO('mysql:host=localhost;dbname=infoplus', 'StepUser', '1qaz2wsx');

use model\entity\user;

//Проверка на регистрационной форме
 $login = (new \util\Request())->getPostValue('userLogin');
 
 if(!empty($login)){
     
    $stmt = \util\MySQL::$db->prepare("SELECT * FROM users WHERE Login = :login");
    $stmt->bindParam(":login",$login);
    $stmt->execute();
    $user = $stmt->fetchObject(user::class);
       if(is_a($user, 'model\entity\user')){
               echo "yes";

       }//if
   else{
       echo "no_reg_form";
   }//else
     
 }
 
 //Проверка на форме авторизации
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
 
