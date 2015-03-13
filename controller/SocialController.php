<?php
namespace controller;
require_once 'twitter-api/TwitterAPIExchange.php';


use model\service\NewsService;
use model\service\UserService;
use model\service\GlobalService;
use util\Request;
use model\entity\global_news;
use model\entity\stopword;
use model\entity\SocialInfo;

function multiexplode ($delimiters,$string) {
    
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}
    
class SocialController extends \controller\BaseController{
    
    private $startService;
    private $newsService;
    private $userService;
    private $globalService;
    
    
    public function GetVkNewsAction() {
        
       $user_serv = $this->GetUserService();
       $glob_service = $this->GetGlobalService();
       $stop_word_for_search = $glob_service->GetStopWords();
       
       
           $user = $this->getRequest()->getSessionValue('user_info_plus');
           if(empty($user)){
               $user = $this->getRequest()->getCookieValue('user_info_plus');
           }//if
           $this->view->current_user = $this->GetUserService()->getUser($user);
           
           ini_set("max_execution_time", "2500");
           
           $districts = $glob_service->GetDistricts();
           $first_time = time() - 14400;
           
           $i=0;
           
           foreach ($districts as $district){//Проходим по всем районам

                //&start_time=".(time()-299)."
                $d_title = $district->getTitle();
                $to_search = urlencode($d_title);
                
                $result = file_get_contents("https://api.vk.com/method/newsfeed.search?q=$to_search&extended=0&start_time=$first_time&count=200&v=5.28");
//                $result = file_get_contents("https://api.vk.com/method/newsfeed.search?q=$to_search&extended=0&count=200&v=5.28");
                
                $result_from_json = json_decode($result);
                
                foreach ($result_from_json->response->items as $my_item){



                //if($my_item->owner_id < 0){//Отсеивание групп
                    $pos = false;
                    //Описание новости
                    $text = $my_item->text;
                    $found = false;

                    foreach($stop_word_for_search as $sw){
                        //поиск в тексте стоп-слова, если тру останавлеваем поиск, сохранаяем запись в базе
                        
                        $pos = stripos($text,$sw->getWord());
                        
                        if($pos  != false){
                            
                            $words = multiexplode('/., !@#$%^&*+_', $text);
                            
                            foreach ($words as $value) {
                                //Сове3
                                //Совет
                                if(strlen($value) == strlen($sw->getWord())){
                                    
                                    if(stristr($value,$sw->getWord()) != false){
                                        $found = true;
                                        break;
                                    }//if
                                    
                                }//if

                                
                            }//foreach

                        }//if            
                        
                        if($found){
                            break;
                        }//if
                        
                    }//foreach
                    
                    if ($pos != false){
                        
                        $date = date("D M Y H:i:s",$my_item->date);
                        //Заголовок
                        $title = explode('.', $text)[0];
                        $contains = false;
                        //////////////$contains = $glob_service->IsContainsNews($title);

                        ///if($contains < 10){

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

                        $glob_service->AddGlobalNews($new_global_news);
                        $i++;

                        //}//if


                    }//if стоп-слова
                //}//if группы   


                }//foreach
                

            }//foreach
           
           echo "final";
        
    }//GetVkNewsAction
    
    public function GetGoogleWebNewsAction() {
        
       $user_serv = $this->GetUserService();
       
       $glob_service = $this->GetGlobalService();
       $stop_word_for_search = $glob_service->GetStopWords();
           ini_set("max_execution_time", "2500");
           $user = $this->getRequest()->getSessionValue('user_info_plus');
           if(empty($user)){
               $user = $this->getRequest()->getCookieValue('user_info_plus');
           }//if
           $this->view->current_user = $this->GetUserService()->getUser($user);
           $stop_word_for_search = $glob_service->GetStopWords();

            //Получаем все районы из БД
            $districts = $glob_service->GetDistricts();

            for($offset = 0;$offset <= 40; $offset+=8){

                foreach ($districts as $district){//Проходим по всем районам

                $d_title = $district->getTitle();
                $to_search = urlencode($d_title);

                $global = new GlobalService();

                //$cron = $global->IsCronEnable();

                $result = file_get_contents("https://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=$to_search&start=$offset&rsz=large");    

                $result_from_json = json_decode($result);
                if(property_exists($result_from_json, "responseData")){
                foreach ($result_from_json->responseData->results as $my_item){

                        $pos = false;
                        //Описание новости
                        $text = $my_item->content;
                        foreach($stop_word_for_search as $sw){
                            //поиск в тексте стоп-слова, если тру останавлеваем поиск, сохранаяем запись в базе
                            $pos = stripos($text, $sw->getWord());
                            if($pos  != false){
                                break;
                            }//if                
                        }//foreach

                        if ($pos != false){

                            $date = date("D M Y H:i:s");
                            //Заголовок
                            $title = $my_item->titleNoFormatting;
                            ////////////$contains = $glob_service->IsContainsNews($title);


                            $img = NULL;

                            $new_global_news = new global_news();
                            $new_global_news->setTitle($title);
                            $new_global_news->setDescription($text);
                            $new_global_news->setImage($img);
                            $new_global_news->setSource($my_item->url);
                            $new_global_news->setDistrict($district->getId());
                            $new_global_news->setDate($date);
                            $new_global_news->setDistrict_str($district->getTitle());
                            $new_global_news->setStop_words($sw->getWord());   

                            $glob_service->AddGlobalNews($new_global_news);

                        }//if стоп-слова

                }//foreach


                }//foreach
                }//if

                }

            echo "final";
            
    }
    
    public function GetGoogleNewsNewsAction() {
        
        $user_serv = $this->GetUserService();
        $glob_service = $this->GetGlobalService();
        $stop_word_for_search = $glob_service->GetStopWords();
       
            ini_set("max_execution_time", "2500");
            $user = $this->getRequest()->getSessionValue('user_info_plus');
            if(empty($user)){
               $user = $this->getRequest()->getCookieValue('user_info_plus');
            }//if
            $this->view->current_user = $this->GetUserService()->getUser($user);

            $stop_word_for_search = $glob_service->GetStopWords();
            $districts = $glob_service->GetDistricts();
  
            $count = 0;

            for($offset = 0;$offset <= 40; $offset+=8){

                foreach ($districts as $district){//Проходим по всем районам

                $d_title = $district->getTitle();
                $to_search = urlencode($d_title);

                $global = new GlobalService();

                //$cron = $global->IsCronEnable();

                $result = file_get_contents("https://ajax.googleapis.com/ajax/services/search/news?v=1.0&q=$to_search&start=$offset&rsz=large");    

                $result_from_json = json_decode($result);

                if(property_exists($result_from_json, 'responseData')){

                    if(property_exists($result_from_json->responseData, 'results')){

                        foreach ($result_from_json->responseData->results as $my_item){

                        $pos = false;
                        //Описание новости
                        $text = $my_item->content;
                        foreach($stop_word_for_search as $sw){
                            //поиск в тексте стоп-слова, если тру останавлеваем поиск, сохранаяем запись в базе
                            $pos = stripos($text, $sw->getWord());
                            if($pos  != false){
                                break;
                            }//if                
                        }//foreach

                        if ($pos != false){

                            $date = date("D M Y H:i:s");
                            //Заголовок
                            $title = $my_item->titleNoFormatting;
                            //$contains = $glob_service->IsContainsNews($title);


                            $img = NULL;

                            $new_global_news = new global_news();
                            $new_global_news->setTitle($title);
                            $text = html_entity_decode($text);
                            $new_global_news->setDescription($text);
                            $new_global_news->setImage($img);
                            $new_global_news->setSource(urldecode($my_item->url));
                            $new_global_news->setDistrict($district->getId());
                            $new_global_news->setDate($date);
                            $new_global_news->setDistrict_str($district->getTitle());
                            $new_global_news->setStop_words($sw->getWord());   

                            $glob_service->AddGlobalNews($new_global_news);
                            $count++;
                            echo "Count appebded record's - $count<br>";

                        }//if стоп-слова

                }//foreach

            }//if results


                }//if responseData



                }//foreach

            }//for
           echo "final";
           

    }
    
    public function GetTwitterNewsAction() {
        

        $user_serv = $this->GetUserService();
        $glob_service = $this->GetGlobalService();
        $stop_word_for_search = $glob_service->GetStopWords();
        
            $user = $this->getRequest()->getSessionValue('user_info_plus');
            if(empty($user)){
               $user = $this->getRequest()->getCookieValue('user_info_plus');
            }//if
            $this->view->current_user = $this->GetUserService()->getUser($user);

            $stop_word_for_search = $glob_service->GetStopWords();

            //Получаем все районы из БД
            $districts = $glob_service->GetDistricts();

            //инициализация первого приложения


            $url = 'https://api.twitter.com/1.1/search/tweets.json';
            $request = new Request();
            $i=1;
            //$last_id = $glob_service->GetLastIdTwitter();

            foreach ($districts as $district){

               if ($i<141){
                    $settings = array(
                       'oauth_access_token' => "3062725937-L6VtUnZ6xx644GWDU2Y3NHhz14yx1KADWeAnoxm",
                       'oauth_access_token_secret' => "Q54JmVltQyKZjE5ymPAuCcWsipCOLo5GOfFWeUuLpdhqo",
                       'consumer_key' => "lW5B5TUxOdwjKxVN9ufGEmYLy",
                       'consumer_secret' => "BiJCp5uwPJ8bjufMzDbgRl4P7IzdhH0uawjr31hHHkhkdavYe4"
                    );   
                    //$last_news = $glob_service->GetLastIdTwitter();
                    $dist = $district->getTitle();
                    $q_param = urlencode($dist);
                    $count = count($districts);

            //        if($last_id != NULL){
            //            $getfield = "?q=$q_param&since_id=$last_id&count=80";
            //        }
            //        else{ 
                        $getfield = "?q=$q_param&count=80";

                    //}

                    $requestMethod = 'GET';
                    
                    $twitter = new TwitterAPIExchange($settings);

                    $fields = $twitter->setGetfield($getfield);
                    $oAuth = $fields->buildOauth($url, $requestMethod);
                    $response = $oAuth->performRequest();
                    $js_obj = json_decode($response);

                   if(property_exists($js_obj, 'statuses')){

                       foreach($js_obj->statuses as $status){

                        $last_id = $status->id_str;
                        $glob_service->SetLastIdTwitter($last_id);
                        $text = $status->text;

                        foreach($stop_word_for_search as $sw){
                            $pos = false;
                            //поиск в тексте стоп-слова, если тру останавлеваем поиск, сохранаяем запись в базе
                            $pos = stripos($text, $sw->getWord());
                            if($pos  != false){
                                break;
                            }//if

                        }//foreach
                        if ($pos != false){

                            ////////////$contains = $glob_service->IsContainsNews($text);


                            $user_id = $status->user->id;
                            $screen_name = $status->user->screen_name;
                            $user_image = $status->user->profile_image_url_https;
                            $created_at = $status->created_at;
                            $created_at = strtotime($created_at);
                            $created_at = date("D M Y H:i:s",$created_at);

                            $source = "https://twitter.com/" . $status->user->id_str . "/status/" . $status->id_str;

                            $date = $status->created_at;

                            $new_global_news = new global_news();
                            $new_global_news->setTitle($screen_name);
                            $new_global_news->setDescription($text);
                            $new_global_news->setSource($source);
                            $new_global_news->setDistrict($district->getId());
                            $new_global_news->setDate($created_at);
                            $new_global_news->setDistrict_str($district->getTitle());
                            $new_global_news->setStop_words($sw->getWord());

                            if(property_exists($status->entities, 'media')){
                                $media = $status->entities->media;
                                    if(property_exists($media, 'media_url')){
                                        $media_url = $media->media_url;

                                        if($media_url != NULL){
                                        $new_global_news->setImage($status->entities->media->media_url);

                                        }//if
                                        else{

                                           $new_global_news->setImage($user_image);  

                                        }//else
                                }//media_url
                                else{

                                    $new_global_news->setImage($user_image);  

                                }//else

                            }//if media

                            else{

                                $new_global_news->setImage($user_image);  

                            }//else

                            $glob_service->AddGlobalNews($new_global_news);


                        }//if



                    }//foreach
                   }
                   else{
                       echo "<div>Error in twitter api response:<br>";
                       echo "<pre>";
                       echo var_dump($js_obj);
                       echo "</pre></div>";

                   }//else
                   echo "$i<br/>";
                   $i++;
               }//if перое приложение

               if($i>140){
                    //инициализайия второго приложения
                    $settings = array(
                        'oauth_access_token' => "3062725937-Kw9iEiRVS8BdCoJs73qbrDoBtsdy8HWLe61P8b9",
                        'oauth_access_token_secret' => "r3maoXVB4IW9KLymu0hgGPrNneoicA2AdThIUqH3Eyu4l",
                        'consumer_key' => "tNw1sIS6Xa0F2InUcSVsUfsbl",
                        'consumer_secret' => "DEceuesToCQGp64CHKJI4XHbWSzBjecjIQLdMAGukMJ6luhbnY"
                    );

                    $url = 'https://api.twitter.com/1.1/search/tweets.json';
                    $request = new Request();

                    //$last_news = $glob_service->GetLastIdTwitter();
                    $dist = $district->getTitle();
                    $q_param = urlencode($dist);
                    $count = count($districts);

            //        if($last_id != NULL){
            //            $getfield = "?q=$q_param&since_id=$last_id&count=80";
            //        }//if
            //        else{ 
                        $getfield = "?q=$q_param&count=80";

                    //}//else

                    $requestMethod = 'GET';

                    $twitter = new TwitterAPIExchange($settings);

                    $fields = $twitter->setGetfield($getfield);
                    $oAuth = $fields->buildOauth($url, $requestMethod);
                    $response = $oAuth->performRequest();
                    $js_obj = json_decode($response);

                   if(property_exists($js_obj, 'statuses')){
                       foreach($js_obj->statuses as $status){

                        $last_id = $status->id_str;
                        $text = $status->text;
                        $glob_service->SetLastIdTwitter($last_news);

                        foreach($stop_word_for_search as $sw){
                            $pos = false;
                            //поиск в тексте стоп-слова, если тру останавлеваем поиск, сохранаяем запись в базе
                            $pos = stripos($text, $sw->getWord());
                            if($pos  != false){
                                break;
                            }//if

                        }//foreach
                        if ($pos != false){

                            ////////////$contains = $glob_service->IsContainsNews($text);

                            if($contains){
                                continue;
                            }//if

                            $user_id = $status->user->id;
                            $screen_name = $status->user->screen_name;
                            $user_image = $status->user->profile_image_url_https;
                            $created_at = $status->created_at;
                            $created_at = strtotime($created_at);
                            $created_at = date("D M Y H:i:s",$created_at);

                            $source = "https://twitter.com/" . $status->user->id_str . "/status/" . $status->id_str;

                            $date = $status->created_at;

                            $new_global_news = new global_news();
                            $new_global_news->setTitle($screen_name);
                            $new_global_news->setDescription($text);
                            $new_global_news->setSource($source);
                            $new_global_news->setDistrict($district->getId());
                            $new_global_news->setDate($created_at);
                            $new_global_news->setDistrict_str($district->getTitle());
                            $new_global_news->setStop_words($sw->getWord());


                            if($status->entities->media->media_url != NULL){
                                $new_global_news->setImage($status->entities->media->media_url);
                            }//if
                            else{

                               $new_global_news->setImage($user_image);  

                            }//else

                            $glob_service->AddGlobalNews($new_global_news);


                        }//if


                    }//foreach

                   }//if statuses is property


               }//if второе приложение
            }//for
            
            echo "final";
    }
    
    public function GetFacebookNewsAction() {
        
       $user_serv = $this->GetUserService();
       $glob_service = $this->GetGlobalService();
       $stop_word_for_search = $glob_service->GetStopWords();
       
       
            ini_set("max_execution_time", "2500");
            $user = $this->getRequest()->getSessionValue('user_info_plus');
            if(empty($user)){
               $user = $this->getRequest()->getCookieValue('user_info_plus');
            }//if
            $this->view->current_user = $this->GetUserService()->getUser($user);
            
            $stop_word_for_search = $glob_service->GetStopWords();
            $districts = $glob_service->GetDistricts();

            for($offset = 0;$offset <= 40; $offset+=8){
                $i = 1;
                foreach ($districts as $district){//Проходим по всем районам

                $d_title = $district->getTitle();
                $to_search = urlencode($d_title);

                $global = new GlobalService();

                $result = file_get_contents("https://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=$to_search%20site:http://www.facebook.com/&start=$offset");    

                $result_from_json = json_decode($result);

                foreach ($result_from_json->responseData->results as $my_item){

                        $pos = false;
                        //Описание новости
                        $text = $my_item->content;
                        foreach($stop_word_for_search as $sw){
                            //поиск в тексте стоп-слова, если тру останавлеваем поиск, сохранаяем запись в базе
                            $pos = stripos($text, $sw->getWord());
                            if($pos  != false){
                                break;
                            }//if                
                        }//foreach

                        if ($pos != false){

                            $date = date("D M Y H:i:s");
                            //Заголовок
                            $title = $my_item->titleNoFormatting;
                            //$contains = $glob_service->IsContainsNews($title);



                            $img = NULL;

                            $new_global_news = new global_news();
                            $new_global_news->setTitle($title);
                            $new_global_news->setDescription($text);
                            $new_global_news->setImage($img);
                            $new_global_news->setSource($my_item->url);
                            $new_global_news->setDistrict($district->getId());
                            $new_global_news->setDate($date);
                            $new_global_news->setDistrict_str($district->getTitle());
                            $new_global_news->setStop_words($sw->getWord());   

                            $glob_service->AddGlobalNews($new_global_news);
                            echo "In base!!!! <br />";
                        }//if стоп-слова

                }//foreach
              //  }
                echo "$i <br />";
                $i++;

                }//foreach

            }//for
            
            echo "final";
    }
       
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