<?php

namespace controller;

use model\entity\user;
use model\service\UserService;

class UserController extends BaseController{
    
      private $userService;
      
      function leaveAction(){
          
          if(empty($this->userService)){
              
              $this->userService = new UserService();
              $this->userService->leaveResource();
              
          }//if
          
          return 'leave';
          
      }//leaveAction
      
    function authorizeAction() {
        
        if(empty($this->userService)){
              
              $this->userService = new UserService();
              
          }//if
          $r = new \util\Request();
              
          $login = $r->getPostValue("e-mail");
          $password = $r->getPostValue("password");
          $remember = $r->getPostValue("remember_me");
          
          $cuser = $this->userService->authorize($login, $password);
              
          if($cuser != NULL){
                  
                  $this->view->currentUser = $cuser;
                  
                  if($remember == 'on'){
                      
                      $r->setCookies($cuser->getLogin());
                      
                  }//if
                  else{
                      
                      $r->setSessionValue('user_info_plus', $cuser->getLogin());
                      
                  }//else
                  return 'authorize';
                  
          }//if
          else{
              
              return 'user_not_found';
              
          }
    }
    
    function registerAction(){
        
        return 'register';
        
    }
    
}//UserController