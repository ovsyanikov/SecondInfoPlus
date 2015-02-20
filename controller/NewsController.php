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
   
    public function SpecificNewsAction(){
        
        $newsService = new NewsService();
        
        $spec_news =  $newsService->GetSpecificNews();
        
        if($spec_news != NULL){
            
            $this->view->specific_news = $spec_news;
            
            return 'SpecificNews';
            
        }//if
        else{
            return 'NewsNotFound';
        }
        
        
    }
    
    public function MyPostsAction(){
        
        $newsService = new NewsService();
        $this->view->current_user_news = $newsService->GetMyPosts();
        
        return 'MyPosts';
        
    }
    
    
    
    public function ConfirmPostAction(){
        
        $newsService = new NewsService();
        
        $newsService->PublicPost();
        
        header("Location: index.php?ctrl=news&act=MyPosts");
        
    }
    
}