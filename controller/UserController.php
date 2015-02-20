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
          
          header('Location: ?ctrl=start&act=welcome');
          
      }//leaveAction
      
      function authorizeAction() {
        
        if(empty($this->userService)){
              
              $this->userService = new UserService();
              
          }//if
          $r = new \util\Request();
              
          $login = $r->getPostValue("userLE");
          $password = $r->getPostValue("userPS");
          $remember = $r->getPostValue("remember_me");
          
          $cuser = $this->userService->authorize($login, $password);
              
          if($cuser != NULL){
                  
                  $this->view->current_user = $cuser;
                  
                  if($remember == 'on'){
                      
                      $r->setCookies($cuser->getLogin(). "|" . md5($cuser->getPassword()));
                      $r->setSessionValue('user_info_plus', $cuser->getLogin() . "|" . $cuser->getPassword());
                      
                  }//if
                  else{
                      
                      $r->setSessionValue('user_info_plus', $cuser->getLogin() . "|" . $cuser->getPassword());
                      
                  }//else
                  
                  header("Location: ?ctrl=news&act=news");
                  
          }//if
          else{
              
              return 'user_not_found';
              
          }
    }
    
      function mainRegisterAction(){
          
          $newUser = new user();
          $r = new \util\Request();
          
          $newUser->setEmail($r->getPostValue('REmail'));
          $newUser->setLogin($r->getPostValue('RLogin'));
          $newUser->setPassword('Rpassword');
          
          $this->view->NewUser = $newUser;
          
          return 'register';
          
      }
      
      function registerAction(){
          
           if(empty($this->userService)){
              
              $this->userService = new UserService();
              
          }//if

          $this->userService->add($user);
          
          header("Location: ?ctrl=news&act=news");
          
      }//registerAction
      
      function newuserAction(){
          
          if(empty($this->userService)){
              
              $this->userService = new UserService();
              
          }//if
          
          $r = new \util\Request();
          $newUser = new user();
          
          $login = $r->getPostValue("userLE");
          $newUser->setLogin($login);
          
          $password = $r->getPostValue("userPS");
          $newUser->setPassword($password);
          
          $email = $r->getPostValue("REmail");
          $newUser->setEmail($email);
          
          $firstName = $r->getPostValue("NewFirstName");
          $newUser->setFirstName($firstName);
          
          $lastName = $r->getPostValue("NewLastName");
          $newUser->setLastName($lastName);
          
          $this->userService->add($newUser);
          
          header("Location: ?ctrl=news&act=news");
          
      }//newuserAction
      
      function MyProfileAction(){ 
          
          if(empty($this->userService)){
              
              $this->userService = new UserService();
              
          }//if
          
          $r = new \util\Request();
          
          $this->view->UserToUpdate = $this->userService->getUser($r->getSessionValue('user_info_plus'));
          
          return 'MyProfile';
          
      }
      
}//UserController