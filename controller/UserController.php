<?php

namespace controller;

use model\entity\user;
use model\service\UserService;
use model\service\StartService;

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
          
         if(empty($this->startService)){
            
            $this->startService = new StartService();
        }
        $r = new \util\Request();
        
        $is_user_cookies = $r->getCookieValue('user_info_plus');
        $is_user_session = $r->getSessionValue('user_info_plus');
        
        if($is_user_cookies == NULL && $is_user_session == NULL){
            
            header('Location: index.php?ctrl=start&act=welcome');
            
        }//if
        else{
            
            if(!empty($is_user_cookies)){
                
                if(empty($this->userService)){
                    $this->userService = new UserService();
                }//if
                
                $decode_string = htmlspecialchars_decode($is_user_cookies);
                //login[0]
                //pass[1]
                
                $login = explode('|',$decode_string)[0];
                $pass = explode('|',$decode_string)[1];
                
                $user = $this->userService->getUser($login);
                
                if(is_a($user,'model\entity\user')){
                    
                    $md5_pass = md5($user->getPassword());
                    
                    if($pass == $md5_pass){
                        $this->view->current_user = $user;
                        return 'MyProfile';
                        
                    }//if
                    
                    else if(!empty($is_user_session)){
                
                        if(empty($this->userService)){
                            $this->userService = new model\Service\UserService();
                        }//if

                        $session_login = explode('|',$is_user_session)[0];  
                        $session_user = $this->userService->getUser($session_login);

                        $pass_session_user = explode('|',$is_user_session)[1];  

                        if($session_user->getPassword() == $pass_session_user){
                             $this->view->current_user = $session_user;
                             return 'MyProfile';
                        }//if
                        else{
                            header('Location: index.php?ctrl=start&act=welcome');
                        }//else
                
                    }//else if
                    else{
                            header('Location: index.php?ctrl=start&act=welcome');
                    }//else
                }//if
                
                
            }//if
            
            else if(!empty($is_user_session)){
                
                if(empty($this->userService)){
                    $this->userService = new UserService();
                }//if
                
                $session_login = explode('|',$is_user_session)[0];  
                $session_user = $this->userService->getUser($session_login);
                
                $pass_session_user = explode('|',$is_user_session)[1];  
                
                if($session_user->getPassword() == $pass_session_user){
                    $this->view->current_user = $session_user;
                     return 'MyProfile';
                }//if
                else{
                    header('Location: index.php?ctrl=start&act=welcome');
                }//else
                
            }//else
            else{
                
                 header('Location: index.php?ctrl=start&act=welcome');
                
            }//else
            
        }//else
         
          
      }
      
}//UserController