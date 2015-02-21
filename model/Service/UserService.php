<?php

namespace model\service;

use model\entity\user;
use model\entity\passwordinfo;

class UserService{
    
    function add(user $user) {
       
        $stmt = \util\MySQL::$db->prepare("INSERT INTO users (id,Login,Password,Email,FirstName,LastName) VALUES(NULL,:login,:pass,:email,:fn,:ln)");
        
        $login = $user->getLogin();
        $pass = $user->getPassword();
        $email = $user->getEmail();
        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        
        $stmt->bindParam(":login",$login);
        $stmt->bindParam(":pass",$pass);
        $stmt->bindParam(":email",$email);
        $stmt->bindParam(":fn",$firstName);
        $stmt->bindParam(":ln",$lastName);
        
        $stmt->execute();
        
        $r = new \util\Request();
        $r->setSessionValue('user_info_plus', $user->getLogin());
        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM users WHERE Login = :login");
        $stmt->bindParam(":login",$login);
        $stmt->execute();
        $user = $stmt->fetchObject(user::class);
        
        if(is_a($user,'model\entity\user')){
            
            $id_user = $user->getId();
            
        }//if
        
        $stmt = \util\MySQL::$db->prepare("INSERT INTO passwordinfo (id,user,LastChangePassword) VALUES(NULL,:user,NOW())");
        $stmt->bindParam(":user",$id_user);
        $stmt->execute();
        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM passwordinfo WHERE user = :id_user");
        $stmt->bindParam(":id_user",$id_user);
        $stmt->execute();
        
        $ps_info = $stmt->fetchObject(passwordinfo::class);
        
        if(is_a($ps_info,'model\entity\passwordinfo')){
            $last_time = $ps_info->getLastChangePassword();
        }//if
        
        $r->setSessionValue('lpc', $last_time);
        
    }//add
            
    function authorize($login, $password) {

        $stmt = \util\MySQL::$db->prepare("SELECT * FROM users WHERE ( (Login = :login or Email =:login) and Password = :pass)");
        $stmt->bindParam(":login",$login);
        $stmt->bindParam(":pass",$password);
        
        $stmt->execute();
        $user = $stmt->fetchObject(user::class);
        
        if(is_a($user, 'model\entity\user')){
            
            return $user;
            
        }
        else{
            
            return NULL;
            
        }
        
    }
    
    function leaveResource(){
        
        $r = new \util\Request();
        $r->unsetCookie('user_info_plus');
        $r->unsetCookie('lpc');
        $r->unsetSeesionValue('user_info_plus');
        $r->unsetSeesionValue('lpc');
        
    }
    
    function getUser($login){
        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM users WHERE Login = :login");
        $stmt->bindParam(":login",$login);
        
        $stmt->execute();
        $user = $stmt->fetchObject(user::class);
        
        if(is_a($user, 'model\entity\user')){
           return $user;
        }//if
        else {
            
            return NULL;
            
        }
    }
    
    function getLastTimeChangePassword($user_id){
        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM passwordinfo WHERE user = :id_user");
        $stmt->bindParam(":id_user",$user_id);
        $stmt->execute();
        
        $ps_info = $stmt->fetchObject(passwordinfo::class);
        
        if(is_a($ps_info,'model\entity\passwordinfo')){
            return $ps_info;
        }//if
        else{
            return NULL;
        }//else
        
    }
    
    function isAccessDenied(){
        
        $r = new \util\Request();
        
        $is_user_cookies = $r->getCookieValue('user_info_plus');
        $lpcc = $r->getCookieValue('lpc');
        $lpcs = $r->getSessionValue('lpc');
        $is_user_session = $r->getSessionValue('user_info_plus');
        
        if($is_user_cookies == NULL && $is_user_session == NULL && $lpcc == NULL && $lpcs==NULL){
            
            return 'welcome';
            
        }//if
        
        if(!empty($lpcc)){//LastPassword Change not empty in cookies
            
            if(!empty($is_user_cookies)){//Not Empty user login

                $cookies_user = $this->getUser($is_user_cookies);
                
                if(is_a($cookies_user,'model\entity\user')){
                    
                    $last_time_ps_change = $this->getLastTimeChangePassword($cookies_user->getId());
                    
                    if(is_a($last_time_ps_change,'model\entity\passwordinfo')){
                        
                        if($lpcc == $last_time_ps_change->getLastChangePassword()){
                            
                            return false;
                            
                        }//if
                        else{
                            $r->unsetCookie('user_info_lus');
                            $r->unsetCookie('lpc');
                            $r->unsetSeesionValue('user_info_lus');
                            $r->unsetSeesionValue('lpc');
                            return true;
                        }//else
                    }//if
                    else{
                         $r->unsetCookie('user_info_lus');
                            $r->unsetCookie('lpc');
                            $r->unsetSeesionValue('user_info_lus');
                            $r->unsetSeesionValue('lpc');
                        return true;
                    }//else
                    
                }//if
                else{
                     $r->unsetCookie('user_info_lus');
                            $r->unsetCookie('lpc');
                            $r->unsetSeesionValue('user_info_lus');
                            $r->unsetSeesionValue('lpc');
                    return true;
                }//else
            }//if
            else{
                 $r->unsetCookie('user_info_lus');
                            $r->unsetCookie('lpc');
                            $r->unsetSeesionValue('user_info_lus');
                            $r->unsetSeesionValue('lpc');
                return true;
            }//else
            
        }//if
        else if(!empty($lpcs)){//LastPassword Change not empty in session
            
            if(!empty($is_user_session)){//Not Empty user login
                
                $session_user = $this->getUser($is_user_session);
                
                if(is_a($session_user,'model\entity\user')){
                    
                    $last_time_ps_change = $this->getLastTimeChangePassword($session_user->getId());
                    
                    if(is_a($last_time_ps_change,'model\entity\passwordinfo')){
                        
                        if($lpcs == $last_time_ps_change->getLastChangePassword()){
                            
                            return false;
                            
                        }//if
                        else{
                             $r->unsetCookie('user_info_lus');
                            $r->unsetCookie('lpc');
                            $r->unsetSeesionValue('user_info_lus');
                            $r->unsetSeesionValue('lpc');
                            return true;
                        }//else
                    }//if
                    else{
                         $r->unsetCookie('user_info_lus');
                            $r->unsetCookie('lpc');
                            $r->unsetSeesionValue('user_info_lus');
                            $r->unsetSeesionValue('lpc');
                        return true;
                    }//else
                    
                }//if
                else{
                     $r->unsetCookie('user_info_lus');
                            $r->unsetCookie('lpc');
                            $r->unsetSeesionValue('user_info_lus');
                            $r->unsetSeesionValue('lpc');
                    return true;
                }//else
            }//if
            else{
                 $r->unsetCookie('user_info_lus');
                            $r->unsetCookie('lpc');
                            $r->unsetSeesionValue('user_info_lus');
                            $r->unsetSeesionValue('lpc');
                return true;
            }//else
            
        }//else if
        else{
             $r->unsetCookie('user_info_lus');
                            $r->unsetCookie('lpc');
                            $r->unsetSeesionValue('user_info_lus');
                            $r->unsetSeesionValue('lpc');
            return true;
        }//else
        
    }//isAccessDenied
}