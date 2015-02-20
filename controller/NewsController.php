<?php

namespace controller;

use model\service\NewsService;
use model\service\UserService;
use model\service\StartService;

class NewsController extends \controller\BaseController{
    
    private $startService;
    private $newsService;
    
    public function newsAction(){
        
        
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
                        return 'news';
                        
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
                            return 'news';
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
                    return 'news';
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
    
    public function specificPostAction(){
        
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
                        return 'SpecificPost';
                        
                    }//if
                    
                    else if(!empty($is_user_session)){
                
                        if(empty($this->userService)){
                            $this->userService = new model\Service\UserService();
                        }//if

                        $session_login = explode('|',$is_user_session)[0];  
                        $session_user = $this->userService->getUser($session_login);

                        $pass_session_user = explode('|',$is_user_session)[1];  

                        if($session_user->getPassword() == $pass_session_user){
                            $this->view->current_user = $pass_session_user;
                            return 'SpecificPost';
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
                    $this->userService = new model\service\UserService();
                }//if
                
                $session_login = explode('|',$is_user_session)[0];  
                $session_user = $this->userService->getUser($session_login);
                
                $pass_session_user = explode('|',$is_user_session)[1];  
                
                if($session_user->getPassword() == $pass_session_user){
                    $this->view->current_user = $pass_session_user;
                    return 'SpecificPost';
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
    
    public function MakePostAction(){
        
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
                        return 'MakePost';
                        
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
                           return 'MakePost';
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
                    return 'MakePost';
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

    public function MyPostsAction(){
        
         if(empty($this->startService)){
            
            $this->startService = new StartService();
        }
        
        if(empty($this->newsService)){
            $this->newsService = new NewsService();
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
                         if(empty($this->newsService)){
                             $this->newsService = new NewsService();
                             
                         }
                         $this->view->current_user_news = $this->newsService->GetMyPosts();
                         return 'MyPosts';
                        
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
                             $this->view->current_user_news = $this->newsService->GetMyPosts();
                            return 'MyPosts';
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
                    $this->view->current_user_news = $this->newsService->GetMyPosts();
                    return 'MyPosts';
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
    
    public function ConfirmPostAction(){
        
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
                        
                         $newsService = new NewsService();
                         $this->view->current_user = $user;
                         $newsService->PublicPost($user->getLogin());
                         $this->view->current_user_news = $newsService->GetMyPosts();
                         
                         return 'MyPosts';
                        
                    }//if
                    
                    else if(!empty($is_user_session)){
                
                        if(empty($this->userService)){
                            $this->userService = new model\Service\UserService();
                        }//if

                        $session_login = explode('|',$is_user_session)[0];  
                        $session_user = $this->userService->getUser($session_login);

                        $pass_session_user = explode('|',$is_user_session)[1];  

                        if($session_user->getPassword() == $pass_session_user){
                            
                            $newsService = new NewsService();
        
                            $this->view->current_user = $session_user;
                            $newsService->PublicPost($session_user->getLogin());
                            $this->view->current_user_news = $newsService->GetMyPosts();
                            return 'MyPosts';
                            
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
                    
                            $newsService = new NewsService();
                            $this->view->current_user = $session_user;
                            $newsService->PublicPost($session_user->getLogin());
                            $this->view->current_user_news = $newsService->GetMyPosts();
                            return 'MyPosts';
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
    
    public function SpecificNewsAction(){
        
        if(empty($this->startService)){
            
            $this->startService = new StartService();
        }
        
        if(empty($this->newsService)){
            
            $this->newsService = new NewsService();
            
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
                        $this->view->specific_news = $this->newsService->GetSpecificNews();
                        return 'SpecificNews';
                        
                    }//if
                    
                    else if(!empty($is_user_session)){
                
                        if(empty($this->userService)){
                            $this->userService = new serService();
                        }//if

                        $session_login = explode('|',$is_user_session)[0];  
                        $session_user = $this->userService->getUser($session_login);

                        $pass_session_user = explode('|',$is_user_session)[1];  

                        if($session_user->getPassword() == $pass_session_user){
                            $this->view->current_user = $pass_session_user;
                            $this->view->specific_news = $this->newsService->GetSpecificNews();
                        return 'SpecificNews';
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
                    $this->view->current_user = $pass_session_user;
                    $this->view->specific_news = $this->newsService->GetSpecificNews();
                    return 'SpecificNews';
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
}