<?php

require_once './util/Request.php';
require_once './util/MySQL.php';
require_once './model/Entity/user.php';
\util\MySQL::$db = new PDO('mysql:host=localhost;dbname=infoplus', 'StepUser', '1qaz2wsx');

use model\entity\user;

 $login = (new \util\Request())->getPostValue('userLogin');
 
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM users WHERE Login = :login");
        $stmt->bindParam(":login",$login);
        $stmt->execute();
        $user = $stmt->fetchObject(user::class);
        
        if(is_a($user, 'model\entity\user')){
            echo "yes";
            
        }//if
        else{
            echo $login;
        }//else