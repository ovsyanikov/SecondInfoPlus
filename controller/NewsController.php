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
       $glob_sevice = $this->GetGlobalService();
       
       if($access){//Если доступ запрещен
           $this->redirect("index");
       }//if
       else{//Если доступ разрешен
           
           $user = $this->getRequest()->getSessionValue('user_info_plus');
           if(empty($user)){
               $user = $this->getRequest()->getCookieValue('user_info_plus');
           }//
           $this->view->current_user = $this->GetUserService()->getUser($user);
           $this->view->all_news = $glob_sevice->GetGlobalNews();
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
           
           $stop_words = $this->GetGlobalService()->GetStopWords();
           $distr =  $global_service->GetDistrictByName($r->getPostValue('District'));
           
           $news = [];
           
           foreach($stop_words as $word){
               
               $word = trim($word->getWord());
               
               $news[] = $global_service->GetGlobalNewsByStopWord($word, $distr->getId());
               
           }//for
           $this->view->finded_news = $news;
           $this->view->stop_words = $this->GetGlobalService()->GetStopWords();
           $r->setSessionValue('currecnt_district', $distr->getTitle());
           
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
           
           $r = new Request();
           
           $post_id = $r->getGetValue('id');
           
           $specific_news =  $global_service->GetGlobalNewsById($post_id);
           
           if(is_a($specific_news,'model\entity\global_news')){
               
               $this->view->global_news = $specific_news;
               return 'SpecificPostHome';
           }//if
           else{
               return 'NewsNotFound';
           }//else
           
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
    
    public function MyTasksAction() {
        
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
           $this->view->my_tasks = $this->GetNewsService()->GetMyTasks();
           
           return 'MyTasks';
           
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
           
           $owner = $this->view->current_user->getLogin();
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
            $spec_news = $this->GetNewsService()->GetSpecificNews();
            if($spec_news != null){
                $this->view->specific_news = $spec_news;
                return 'SpecificNews';
            }//if
            else{
                return 'NewsNotFound';
            }//else
            
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
           $this->view->stop_words = $this->GetGlobalService()->GetStopWords();
           
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