<?php

require_once './util/Request.php';
require_once './util/MySQL.php';
require_once './model/entity/user.php';
require_once './model/entity/news.php';

\util\MySQL::$db = new PDO('mysql:host=localhost;dbname=u304199710_info', 'u304199710_alex', '1qaz2wsx');

use model\entity\user;
use model\entity\news;
use util\Request;

 
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

else if(!empty($_POST['fastregister'])){
    
    $login = (new \util\Request())->getPostValue('userLogin');
    $email = (new \util\Request())->getPostValue('userEmail');
        
 //Регистрация

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
 
}

else if(!empty($_POST['authorize'])){
     
    $userPS = (new \util\Request())->getPostValue('userPS');
    $userLE = (new \util\Request())->getPostValue('userLE');
    
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
//ajax remove user post
else if(!empty($_POST['DeleteMyNews'])){
    
    $current_user = (new Request())->getSessionValue('user_info_plus');
    
    $post_id = (new Request())->getPostValue('post_id');
    
    \util\MySQL::$db = new PDO('mysql:host=localhost;dbname=u304199710_info', 'u304199710_alex', '1qaz2wsx');
    
    $stmt = \util\MySQL::$db->prepare("SELECT * FROM news WHERE id = :id");
    $stmt->bindParam(":id",$post_id);
    $stmt->execute();
    
    $news_record = $stmt->fetchObject(news::class);
    
    if(is_a($news_record, 'model\entity\news')){
        
        $files = $news_record->getFiles();
        $files_to_remove = explode(',',$files);
        
        $files_count = count($files_to_remove);

        if($files_count != 0){
            $i = 0;
            
            foreach ($files_to_remove as $img_file){
                
                    if($i != $files_count-1){
                        unlink("files/$img_file");
                    }//if
                    $i++;
            }//foreach
        
        }//if
    }//if

    
    $stmt = \util\MySQL::$db->prepare("DELETE FROM news WHERE id = :id");
    $stmt->bindParam(":id",$post_id);
    $res = $stmt->execute();
    
    if($res != 0){
       echo "1";
    }//if
    else{
        echo "0";
    }//else
    
    
}//else if