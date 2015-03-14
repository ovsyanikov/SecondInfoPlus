<?php

require_once './util/Request.php';
require_once './util/MySQL.php';
require_once './model/entity/user.php';
require_once './model/entity/news.php';
require_once './model/entity/global_news.php';
require_once './model/service/GlobalService.php';
require_once './model/entity/district.php';
require_once './model/entity/stopword.php';

\util\MySQL::$db = new PDO('mysql:host=localhost;dbname=u304199710_info', 'u304199710_alex', '1qaz2wsx');

use model\entity\user;
use model\entity\news;
use model\entity\global_news;
use model\entity\district;
use model\service\GlobalService;
use model\entity\stopword;

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

else if(!empty($_POST['EmailSuccess'])){
    
    $r = new Request();
    
    $db_user = $r->getPostValue('Owner');
    
    $NewMail = $r->getPostValue('NewPersonalMail');
    
    \util\MySQL::$db = new PDO('mysql:host=localhost;dbname=u304199710_info', 'u304199710_alex', '1qaz2wsx');
    
    $stmt = \util\MySQL::$db->prepare("UPDATE users SET Email = :email WHERE Login = :owner");
    $stmt->bindParam(":email",$NewMail);
    $stmt->bindParam(":owner",$db_user);
    
    $result = $stmt->execute();
    
    if($result == 1){
        echo "ok";
    }
    else{
        echo "$result";
    }
   
}

else if(!empty($_POST['CheckPassword'])){
    
    \util\MySQL::$db = new PDO('mysql:host=localhost;dbname=u304199710_info', 'u304199710_alex', '1qaz2wsx');
    $r = new Request();
    $owner = $r->getPostValue('Owner');
    $input_password = $r->getPostValue('UserPassword');
    
    $stmt = \util\MySQL::$db->prepare("SELECT * FROM users WHERE Login = :owner");
    $stmt->bindParam(":owner",$owner);
    
    $stmt->execute();
    
    $user = $stmt->fetchObject(user::class);
    
    if(is_a($user,'model\entity\user')){
        
        $pass = $user->getPassword();
        if($pass == $input_password){
            echo "password_correct";
        }//if
        else{
            echo "password_incorrect";
        }//else
    }//if
    else{echo "owner_problem($owner)";}//else
    
}

else if(!empty($_POST['ChangePassword'])){
    
    $r = new Request();
    $NewPass = $r->getPostValue('NewPassword');
    $Owner = $r->getPostValue('Owner');
    
    \util\MySQL::$db = new PDO('mysql:host=localhost;dbname=u304199710_info', 'u304199710_alex', '1qaz2wsx');
    
    $stmt = \util\MySQL::$db->prepare("UPDATE users SET Password = :pass WHERE Login = :owner");
    $stmt->bindParam(":pass",$NewPass);
    $stmt->bindParam(":owner",$Owner);
    
    $res = $stmt->execute();
    
    if($res == 1){
            
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM users WHERE Login = :owner");
        $stmt->bindParam(":owner",$Owner);
        $stmt->execute();
        $user = $stmt->fetchObject(user::class);
        
        if(is_a($user,'model\entity\user')){
            
            $id = $user->getId();
            $stmt = \util\MySQL::$db->prepare("UPDATE passwordinfo SET LastChangePassword = NOW() WHERE user = :owner");
            $stmt->bindParam(":owner",$id);
            $stmt->execute();
            
            echo "ok";
            
        }//if
        
    }//if
    else{
        echo "$res";
    }//else
    
}//else if

else if(!empty($_POST['ChangeFirstName'])){
    
    $r = new Request();
    $NewFirstName = $r->getPostValue('NewFirstName');
    $Owner = $r->getPostValue('Owner');
    
    \util\MySQL::$db = new PDO('mysql:host=localhost;dbname=u304199710_info', 'u304199710_alex', '1qaz2wsx');
    
    $stmt = \util\MySQL::$db->prepare("UPDATE users SET FirstName = :firstName WHERE Login = :owner");
    $stmt->bindParam(":firstName",$NewFirstName);
    $stmt->bindParam(":owner",$Owner);
    
    $res = $stmt->execute();
    
    if($res == 1){
        echo "ok";
    }//if
    else{
        echo "res = $res, Owner = $Owner, new name = $NewFirstName";
        
    }//else
}

else if(!empty($_POST['ChangeLastName'])){
    
    $r = new Request();
    $NewLastName = $r->getPostValue('NewLastName');
    $Owner = $r->getPostValue('Owner');
    
    \util\MySQL::$db = new PDO('mysql:host=localhost;dbname=u304199710_info', 'u304199710_alex', '1qaz2wsx');
    
    $stmt = \util\MySQL::$db->prepare("UPDATE users SET LastName = :lastName WHERE Login = :owner");
    $stmt->bindParam(":lastName",$NewLastName);
    $stmt->bindParam(":owner",$Owner);
    
    $res = $stmt->execute();
    
    if($res == 1){
        echo "ok";
    }//if
    else{
        echo "res = $res, Owner = $Owner, new last name = $NewLastName";
        
    }//else
}

else if(!empty ($_POST['GetCountOfNews'])){
    
    $stmt = \util\MySQL::$db->prepare("SELECT COUNT(id) FROM global_news");
    $stmt->execute();
    $count = $stmt->fetch(PDO::FETCH_BOTH);
    
    if($count >= 0){
        echo "$count[0]";
    }//if
    else{
        echo "$count";
    }//else
}//else if

else if(!empty ($_POST['ADD_DISTRICT'])){
    
    $glob_serv = new GlobalService();
    $r = new Request();
    $new_district = $r->getPostValue('District');
    
    $distr =  $glob_serv->GetDistrictByName($new_district);
    
    if(!is_a($distr,'model\entity\district')){
        
        $result_insert = $glob_serv->AddDistrict($new_district);
        
        if($result_insert){
            $distr = $glob_serv->GetDistrictByName($new_district);
            echo "{$distr->getId()}";
        }//if
        else{
            echo "not inserted";
        }//else
    }//if
    else{
        echo "exist";
    }//else
}//else

else if(!empty ($_POST['ADD_STOP_WORD'])){
    
    $glob_serv = new GlobalService();
    $r = new Request();
    $new_stop_word = $r->getPostValue('stop_word');
    
    $ex_stop_word =  $glob_serv->GetStopWordByTitle($new_stop_word);
    
    if(!is_a($ex_stop_word,'model\entity\district')){
        
        $result_insert = $glob_serv->AddStopWord($new_stop_word);
        
        if($result_insert){
            $result_insert = $glob_serv->GetStopWordByTitle($new_stop_word);
            
            echo "{$result_insert->getId()}";
        }//if
        else{
            echo "exist";
        }//else
    }//if
    else{
        echo "exist";
    }//else
    
}

else if(!empty ($_POST['SET_COOKIE_OFFSET'])){
    
    $request = new Request();
    $request->setCookiesWithKey('offset', 0);
    
}

else if(!empty ($_POST['UPDATE_STOP_WORD'])){
    
    $request = new Request();
    $id_to_update = $request->getPostValue('stop_id');
    $update_stop_word = $request->getPostValue('new_word');
    $glob_news_service = new GlobalService();
    
    $result = $glob_news_service->UpdateStopWord($id_to_update, $update_stop_word);
    
    if($result){
        echo "ok";
    }//if
    else{
        echo "error";
    }//else
}

else if(!empty ($_POST['CHECK_STOP_WORD'])){
    
    $request = new Request();
    $word_to_update = $request->getPostValue('stop_word');
    
    $glob_news_service = new GlobalService();
    
    $word = $glob_news_service->GetStopWordByTitle($word_to_update);
    
    if(is_a($word,'model\entity\stopword')){
        echo "exist";
    }
    else{
        echo "ok";
    }
}

else if(!empty ($_POST['UPDATE_DISTRICT'])){
    
    $request = new Request();
    $id_to_update = $request->getPostValue('district_id');
    $new_title = $request->getPostValue('new_district_title');
    $glob_news_service = new GlobalService();
    
    $result = $glob_news_service->UpdateDistrict($id_to_update, $new_title);
    
    if($result){
        echo "ok";
    }//if
    else{
        echo "error";
    }//else
}

else if(!empty ($_POST['CHECK_DISTRICT'])){
    
    $request = new Request();
    $distr = $request->getPostValue('district');
    
    $glob_news_service = new GlobalService();
    
    $word = $glob_news_service->GetDistrictByName($distr);
    
    if(is_a($word,'model\entity\district')){
        echo "exist";
    }
    else{
        echo "ok";
    }
}
else if(!empty ($_POST['GET_VK_POST_ACTION'])){
        $gl_service = new GlobalService();
        
        $count = $gl_service->GetVkPostsCount();
        
        echo "$count";
}//else if
else if(!empty ($_POST['GET_TW_POST_ACTION'])){
    
        $gl_service = new GlobalService();
        
        $count = $gl_service->GetTwitterPostsCount();
        
        echo "$count";
}//else if