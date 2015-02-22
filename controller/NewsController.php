<?php

namespace controller;

use model\service\NewsService;
use model\service\UserService;
use model\service\StartService;

class NewsController extends \controller\BaseController{
    
    private $startService;
    private $newsService;
    private $userService;
    
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
    
    
}