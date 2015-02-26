<?php

namespace controller;

use model\service\NewsService;
use model\service\UserService;
use model\service\GlobalService;
use util\Request;

class NewsController extends \controller\BaseController{
    
    private $startService;
    private $newsService;
    private $userService;
    private $globalService;
    
    public function newsAction(){
        
       $user_serv = $this->GetUserService();
       $access = $user_serv->isAccessDenied();
       
       if($access){//Если доступ запрещен
           $this->redirect("index");
       }//if
       else{//Если доступ разрешен
           
           $user = $this->getRequest()->getSessionValue('user_info_plus');
           if(empty($user)){
               $user = $this->getRequest()->getCookieValue('user_info_plus');
           }//
           $this->view->current_user = $this->GetUserService()->getUser($user);
           return 'news';
       }//else
    }
    
    public function getNewsByStopWordsAction(){
        
       $user_serv = $this->GetUserService();
       $access = $user_serv->isAccessDenied();
       $global_service = new GlobalService();
       
       if($access){//Если доступ запрещен
           $this->redirect("index");
       }//if
       else{//Если доступ разрешен
           
           $user = $this->getRequest()->getSessionValue('user_info_plus');
           
           if(empty($user)){
               $user = $this->getRequest()->getCookieValue('user_info_plus');
           }//if
           
           $this->view->current_user = $this->GetUserService()->getUser($user);
           $this->view->districts = $global_service->GetDistricts();
           
           $r = new Request();
           
           $stop_words = $r->getPostValue('stop_words');
           $distr =  $global_service->GetDistrictByName($r->getPostValue('District'));
           
           $arr_sw = explode(',', $stop_words);
           $news = [];
           
           foreach($arr_sw as $word){
               
               $word = trim($word);
               
               $news[] = $global_service->GetGlobalNewsByStopWord($word, $distr->getId());
               
           }//for
           $this->view->finded_news = $news;
           return 'Districts';
           
       }//else'
       
        
    }
    public function SpecificPostHomeAction(){
        
       $user_serv = $this->GetUserService();
       $access = $user_serv->isAccessDenied();
       $global_service = new GlobalService();
       
       if($access){//Если доступ запрещен
           $this->redirect("index");
       }//if
       else{//Если доступ разрешен
           $user = $this->getRequest()->getSessionValue('user_info_plus');
           if(empty($user)){
               $user = $this->getRequest()->getCookieValue('user_info_plus');
           }//if
           $this->view->current_user = $this->GetUserService()->getUser($user);
           
           
           $post_id = $_GET['id'];
           
           $distr =  $global_service->GetGlobalNewsById($post_id);
           
 //          $this->view->specific_news = $distr;
           $this->view->global_news = $distr;
              
           return 'SpecificPostHome';
       }//else
        
    }
    
    public function specificPostAction(){
        
       $user_serv = $this->GetUserService();
       $access = $user_serv->isAccessDenied();
       
       if($access){//Если доступ запрещен
           $this->redirect("index");
       }//if
       else{//Если доступ разрешен
           $user = $this->getRequest()->getSessionValue('user_info_plus');
           if(empty($user)){
               $user = $this->getRequest()->getCookieValue('user_info_plus');
           }//if
           $this->view->current_user = $this->GetUserService()->getUser($user);
           return 'SpecificPost';
       }//else
        
    }
    
    public function MakePostAction(){
        
       $user_serv = $this->GetUserService();
       $access = $user_serv->isAccessDenied();
       
       if($access){//Если доступ запрещен
           $this->redirect("index");
       }//if
       else{//Если доступ разрешен
           
           $user = $this->getRequest()->getSessionValue('user_info_plus');
           if(empty($user)){
               $user = $this->getRequest()->getCookieValue('user_info_plus');
           }//if
           
           $this->view->current_user = $this->GetUserService()->getUser($user);
           return 'MakePost';
       }//else
        
        
    }

    public function MyPostsAction(){
        
       $user_serv = $this->GetUserService();
       $access = $user_serv->isAccessDenied();
       
       if($access){//Если доступ запрещен
           $this->redirect("index");
       }//if
       else{//Если доступ разрешен
           $user = $this->getRequest()->getSessionValue('user_info_plus');
           if(empty($user)){
               $user = $this->getRequest()->getCookieValue('user_info_plus');
           }//if
           $this->view->current_user = $this->GetUserService()->getUser($user);
           $this->view->current_user_news =  $this->GetNewsService()->GetMyPosts();
           return 'MyPosts';
       }//else
    }
    
    public function ConfirmPostAction(){
        
       $user_serv = $this->GetUserService();
       $access = $user_serv->isAccessDenied();
       
       if($access){//Если доступ запрещен
           $this->redirect("index");
       }//if
       else{//Если доступ разрешен
           
           $user = $this->getRequest()->getSessionValue('user_info_plus');
           if(empty($user)){
               $user = $this->getRequest()->getCookieValue('user_info_plus');
           }//if
           
           $this->view->current_user = $this->GetUserService()->getUser($user);
           
           $owner = $this->getRequest()->getSessionValue('user_info_plus');
           $this->GetNewsService()->PublicPost($owner);
           
           $this->view->current_user_news =  $this->GetNewsService()->GetMyPosts();
           
           return 'MyPosts';
       }//else
        
    }
    
    public function SpecificNewsAction(){
        
       $user_serv = $this->GetUserService();
       $access = $user_serv->isAccessDenied();
       
       if($access){//Если доступ запрещен
           $this->redirect("index");
       }//if
       else{//Если доступ разрешен
            $user = $this->getRequest()->getSessionValue('user_info_plus');
            if(empty($user)){
                $user = $this->getRequest()->getCookieValue('user_info_plus');
            }//if
            $this->view->current_user = $this->GetUserService()->getUser($user);
            $this->view->specific_news = $this->GetNewsService()->GetSpecificNews();
            
           return 'SpecificNews';
       }//else
    }
    
    public function DistrictsAction(){
        
       $user_serv = $this->GetUserService();
       $access = $user_serv->isAccessDenied();
       
       if($access){//Если доступ запрещен
           $this->redirect("index");
       }//if
       else{//Если доступ разрешен
           
           $user = $this->getRequest()->getSessionValue('user_info_plus');
           
           if(empty($user)){
               $user = $this->getRequest()->getCookieValue('user_info_plus');
           }//if
           
           $this->view->current_user = $this->GetUserService()->getUser($user);
           
           $this->view->districts = $this->GetGlobalService()->GetDistricts();
           
           return 'Districts';
       }//else
        
    }
    
    public function GetUserService(){
        
        if(empty($this->userService)){
            $this->userService = new UserService();
        }//if
        
        return $this->userService;
        
    }
    
    public function GetNewsService(){
        
        if(empty($this->newsService)){
            $this->newsService = new NewsService();
        }//if
        
        return $this->newsService;
    }
    
    public function GetGlobalService() {
        
        if(empty($this->globalService)){
            
            $this->globalService = new GlobalService();
            
        }//if
        return $this->globalService;
    }
}