<?php

namespace controller;
use model\service\NewsService;

class NewsController extends \controller\BaseController{
    
    public function newsAction(){
        
        return 'news';
        
    }
    
    public function specificPostAction(){
        
        return 'SpecificPost';
        
    }
    
    public function MakePostAction(){
        
        return 'MakePost';
        
    }

    public function MyPostsAction(){
        
        return 'SpecificPost';
        
    }
    
    public function ConfirmPostAction(){
        
        $newsService = new NewsService();
        
        $newsService->PublicPost();
        
        return 'news';
    }
    
}