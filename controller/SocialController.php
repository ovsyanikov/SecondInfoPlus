<?php

namespace controller;

use model\service\NewsService;
use model\service\UserService;
use model\service\GlobalService;
use util\Request;
use model\entity\global_news;
use model\entity\stopword;
use model\entity\SocialInfo;
    
class SocialController extends \controller\BaseController{
    
    private $startService;
    private $newsService;
    private $userService;
    private $globalService;
    
    
    public function GetVkNewsAction() {
        
       $user_serv = $this->GetUserService();
       $access = $user_serv->isAccessDenied();
       $glob_sevice = $this->GetGlobalService();
       $stop_word_for_search = $glob_sevice->GetStopWords();
       
       if($access){//Если доступ запрещен
           $this->redirect("index");
       }//if
       
       else{//Если доступ разрешен
           
           $user = $this->getRequest()->getSessionValue('user_info_plus');
           if(empty($user)){
               $user = $this->getRequest()->getCookieValue('user_info_plus');
           }//if
           $this->view->current_user = $this->GetUserService()->getUser($user);
           
           
           ini_set("max_execution_time", "2500");
           
           $districts = $glob_sevice->GetDistricts();
           $first_time = time() - 299;
           $last_time = time();
           
           $i=0;
           
           foreach ($districts as $district){//Проходим по всем районам

                //&start_time=".(time()-299)."
                $d_title = $district->getTitle();
                $to_search = urlencode($d_title);
                
                $result = file_get_contents("https://api.vk.com/method/newsfeed.search?q=$to_search&extended=0&start_time=$first_time&last_time=$last_time&count=200&v=5.28");
                $result_from_json = json_decode($result);
                
                $total_count = $result_from_json->response->total_count;
                $count = count($result_from_json->response->items);
                
                do{
                    
                  foreach ($result_from_json->response->items as $my_item){
                    
                    $start_time = $my_item->date;
                    
                    //if($my_item->owner_id < 0){//Отсеивание групп
                        $pos = false;
                        //Описание новости
                        $text = $my_item->text;

                        foreach($stop_word_for_search as $sw){
                            //поиск в тексте стоп-слова, если тру останавлеваем поиск, сохранаяем запись в базе
                            $pos = stripos($text, $sw->getWord());
                            if($pos  != false){
                                break;
                            }//if            
                            
                        }//foreach
                        if ($pos != false){

                            $date = date("D M Y H:i:s",$my_item->date);
                            //Заголовок
                            $title = explode('.', $text)[0];
                            $contains = false;
                            $contains = $glob_sevice->IsContainsNews($title);

                            if($contains < 10){

                            if(strlen($title) > 100){

                                $title = substr($title, 0, 97);
                                $title .= "...";

                            }//if

                            $img = NULL;

                            if(property_exists($my_item, 'attachments')){
                                $att = $my_item->attachments[0];

                                if(property_exists($att,'photo')){
                                    $photo = $my_item->attachments[0]->photo;
                                    if(property_exists($photo,'photo_1280')){
                                        $img = $my_item->attachments[0]->photo->photo_1280;
                                    }//if
                                    else if(property_exists($photo,'photo_604')){
                                        $img = $my_item->attachments[0]->photo->photo_604;
                                    }
                                }//if
                            }//if

                            $new_global_news = new global_news();
                            $new_global_news->setTitle($title);
                            $new_global_news->setDescription($text);
                            $new_global_news->setImage($img);
                            $new_global_news->setSource("http://vk.com/feed?w=wall{$my_item->owner_id}_{$my_item->id}");
                            $new_global_news->setDistrict($district->getId());
                            $new_global_news->setDate($date);
                            $new_global_news->setDistrict_str($district->getTitle());
                            $new_global_news->setStop_words($sw->getWord());   

                            $glob_sevice->AddGlobalNews($new_global_news);
                            $i++;

                            }//if


                        }//if стоп-слова
                    //}//if группы   
                    $last_post_time = $my_item->date;
                    
                }//foreach
                
                  $result = file_get_contents("https://api.vk.com/method/newsfeed.search?q=$to_search&extended=0&start_time=$last_post_time&last_time=$last_time&count=200&v=5.28");
                  $result_from_json = json_decode($result);
                  
                  $total_count = $result_from_json->total_count;
                  $count = count($result_from_json->response->items);
                  
                }while($total_count > $count);

            }//foreach
            
           $this->view->all_news = $glob_sevice->GetGlobalNews(0,10);
           $this->view->vk_posts = $glob_sevice->GetVkPostsCount();
           $this->view->tw_posts = $glob_sevice->GetTwitterPostsCount();
           $this->view->google_posts = $glob_sevice->GetGooglePostsCount();
           $this->view->fb_posts = $glob_sevice->GetFaceBookPostsCount();
           
           $this->getRequest()->setCookiesWithKey('offset',0);
           $this->getRequest()->setCookiesWithKey('vk_records',$i);
           
           return 'news';
           
       }//else
        
    }//GetVkNewsAction   
    
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