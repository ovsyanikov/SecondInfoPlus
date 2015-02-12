<?php

namespace controller;

use model\service\StartService;

class StartController extends \controller\BaseController{
    
    private $startService;
    
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
            
            header('Location: index.php?ctrl=news&act=news');
            
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