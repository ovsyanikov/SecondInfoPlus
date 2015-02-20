<?php

namespace controller;

use model\Service\StartService;
use model\service\UserService;

class StartController extends \controller\BaseController{
    
    private $startService;
    private $userService;
    
    public function welcomeAction(){
        
        if(empty($this->startService)){
            
            $this->startService = new StartService();
        }
        $r = new \util\Request();
        
        $is_user_cookies = $r->getCookieValue('user_info_plus');
        $is_user_session = $r->getSessionValue('user_info_plus');
        
        if($is_user_cookies == NULL && $is_user_session == NULL){
            
            return 'welcome';
            
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
                        header('Location: index.php?ctrl=news&act=news');
                    }//if
                    
                    else if(!empty($is_user_session)){
                
                        if(empty($this->userService)){
                            $this->userService = new model\Service\UserService();
                        }//if

                        $session_login = explode('|',$is_user_session)[0];  
                        $session_user = $this->userService->getUser($session_login);

                        $pass_session_user = explode('|',$is_user_session)[1];  

                        if($session_user->getPassword() == $pass_session_user){
                            header('Location: index.php?ctrl=news&act=news');
                        }//if
                        else{
                            return 'welcome';
                        }//else
                
                    }//else if
                    else{
                            return 'welcome';
                    }//else
                }//if
                
                
            }//if
            
            else if(!empty($is_user_session)){
                
                if(empty($this->userService)){
                    $this->userService = new model\service\UserService();
                }//if
                
                $session_login = explode('|',$is_user_session)[0];  
                $session_user = $this->userService->getUser($session_login);
                
                $pass_session_user = explode('|',$is_user_session)[1];  
                
                if($session_user->getPassword() == $pass_session_user){
                    header('Location: index.php?ctrl=news&act=news');
                }//if
                else{
                    return 'welcome';
                }//else
                
            }//else
            else{
                
                 return 'welcome';
                
            }//else
            
        }//else
        
    }
    
    public function GetStartService(){
        
        //Инициализация представления
        
        if(empty($this->startService)){
            
            $this->startService = new StartService();
            
        }
     
        return $this->startService;
        
    }
    
}