<?php

namespace model\service;
use util\Request;
use model\entity\news;
use model\entity\resource_news;

class NewsService{
    
      function PublicPost($owner){
          
          $r = new Request();
          
          $post_title = $r->getPostValue('postTitle');
          
          $post_description = $r->getPostValue('makePostArea');
          
          $user_files;
          $name = NULL;
          
          try {
              
            foreach($_FILES['user_files']['name'] as $k=>$f) {

            if (!$_FILES['user_files']['error'][$k]) {

                   if (is_uploaded_file($_FILES['user_files']['tmp_name'][$k])) {

                        if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['user_files']['name'][$k])){

                            $file_array = explode('.',$_FILES['user_files']['name'][$k]);
                            $ext = end($file_array);

                            $name = "$owner.". md5($name . rand (-100000,100000)).".$ext" ;
                            $user_files  .= ($name.",");

                            if (move_uploaded_file($_FILES['user_files']['tmp_name'][$k], "files/".$name)) {
                                }//if
                            }//if
                        }//if
            }//if
        }//foreach
        
          } 
          catch (Exception $ex) {} 
          
        
        $stmt = \util\MySQL::$db->prepare("INSERT INTO news (id,Title,Files,Owner,Description,PublicDateTime) VALUES(NULL,:title,:files,:owner,:description,now())");
        
        $stmt->bindParam(":title",$post_title); 
        $stmt->bindParam(":files",$user_files); 
        $stmt->bindParam(":owner",$owner);
        $stmt->bindParam(":description",$post_description);

        $stmt->execute();
        
      }
      
      function GetMyPosts(){
          
          $news = [];
          
          $r = new Request();
          $owner = $r->getSessionValue('user_info_plus');
          if(empty($owner)){
              $owner = $r->getCookieValue('user_info_plus');
          }
          $stmt = \util\MySQL::$db->prepare("SELECT * FROM news WHERE Owner = :owner");
          $stmt->bindParam(":owner",$owner);
          $stmt->execute();
          
          while ($current_news = $stmt->fetchObject('model\entity\news')){
              
                 $news[] = $current_news;
                 
          }//while

          return $news;
          
      }//GetMyPosts
      
      function GetSpecificNews(){
          
          $r = new Request();
          
          $news_id = $r->getGetValue('news_id');
          
          $stmt = \util\MySQL::$db->prepare("SELECT * FROM news WHERE id = :id");
          $stmt->bindParam(":id",$news_id);
          $stmt->execute();
          $spec_news = $stmt->fetchObject('model\entity\news');
          
          return $spec_news;
          
      }
      
      function GetLastResourceNews(){
          
          $last_news = [];
          
          $stmt = \util\MySQL::$db->prepare("SET NAMES UTF-8");
          $stmt->execute();
          
          $stmt = \util\MySQL::$db->prepare("SELECT * FROM ResourceNews LIMIT 5");
          $stmt->execute();
          
          while($news = $stmt->fetchObject(resource_news::class) ){
              
              $last_news[] = $news;
              
          }//while
          
          return $last_news;
          
      }//GetLastResourceNews
      
}