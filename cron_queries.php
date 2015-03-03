<meta charset="UTF-8" >
<?php

require_once './util/MySQL.php';
require_once './model/entity/global_news.php';
require_once './model/entity/stopword.php';
require_once './model/service/GlobalService.php';
require_once './model/entity/district.php';
require_once './twitter-api/TwitterAPIExchange.php';
require_once './util/Request.php';

use model\service\GlobalService;
use model\entity\global_news;
use util\Request;
use model\entity\stopword;

\util\MySQL::$db = new \PDO('mysql:host=localhost;dbname=u304199710_info', 'u304199710_alex', '1qaz2wsx');

$glob_service = new GlobalService();
$stop_word_for_search = $glob_service->GetStopWords();

//Получаем все районы из БД
$districts = $glob_service->GetDistricts();

foreach ($districts as $district){//Проходим по всем районам
    //3600

    $result = file_get_contents("https://api.vk.com/method/newsfeed.search?q={$district->getTitle()}&start_time=".(time()-299)."&extended=0&count=10&v=5.28");    
    $result_from_json = json_decode($result);
    
    foreach ($result_from_json->response->items as $my_item){
        
        if($my_item->owner_id < 0){//Отсеивание групп
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

                $date = date("D H:i:s",$my_item->date);


                //Заголовок
                $title = explode('.', $text)[0];
                $contains = $glob_service->IsContainsNews($title);

                if($contains){
                    continue;
                }//if

                if(strlen($title) > 100){

                    $title = substr($title, 0, 97);
                    $title .= "...";

                }//if

                $img = NULL;

                try{

                    if($my_item->attachments[0]->photo){

                    if($my_item->attachments[0]->photo->photo_1280){

                        $img = $my_item->attachments[0]->photo->photo_1280;

                    }//if
                    else if($my_item->attachments[0]->photo->photo_604){
                        $img = $my_item->attachments[0]->photo->photo_604;
                    }//if


                }//if

                }catch(\Exception $ex){

                }

                $new_global_news = new global_news();
                $new_global_news->setTitle($title);
                $new_global_news->setDescription($text);
                $new_global_news->setImage($img);
                $new_global_news->setSource("http://vk.com/feed?w=wall{$my_item->owner_id}_{$my_item->id}");
                $new_global_news->setDistrict($district->getId());
                $new_global_news->setDate($date);
                $glob_service->AddGlobalNews($new_global_news);

            }//if стоп-слова
        }//if группы   
        
    }//foreach
    
}//foreach

$settings = array(
    'oauth_access_token' => "3062725937-L6VtUnZ6xx644GWDU2Y3NHhz14yx1KADWeAnoxm",
    'oauth_access_token_secret' => "Q54JmVltQyKZjE5ymPAuCcWsipCOLo5GOfFWeUuLpdhqo",
    'consumer_key' => "lW5B5TUxOdwjKxVN9ufGEmYLy",
    'consumer_secret' => "BiJCp5uwPJ8bjufMzDbgRl4P7IzdhH0uawjr31hHHkhkdavYe4"
);

$url = 'https://api.twitter.com/1.1/search/tweets.json';
$request = new Request();

$cookie_last_news = $request->getCookieValue('last_record_id');

foreach ($districts as $district){
    
    $dist = $district->getTitle();
    $q_param = urlencode($dist);
    
    
    
    if($cookie_last_news != null){
        $getfield = "?since_id=$cookie_last_news&q=$q_param&count=10&lang=ru";
    }//if
    else{
        $getfield = "?lang=ru&q=$q_param&count=10";
    }//else
    $requestMethod = 'GET';

    $twitter = new TwitterAPIExchange($settings);

    $fields = $twitter->setGetfield($getfield);
    $oAuth = $fields->buildOauth($url, $requestMethod);
    $response = $oAuth->performRequest();
    $js_obj = json_decode($response);
    $last_news = NULL;
    
   foreach($js_obj->statuses as $status){
       
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
            $contains = $glob_service->IsContainsNews($text);

            if($contains){
                continue;
            }//if

            $user_id = $status->user->id;
            $screen_name = $status->user->screen_name;
            $user_image = $status->user->profile_image_url_https;
            $created_at = $status->created_at;
            $created_at = strtotime($created_at);
            $created_at = date("D H:i:s",$created_at);

            $source = "https://twitter.com/" . $status->user->id_str . "/status/" . $status->id_str;

            $date = $status->created_at;

            if($status->entities->media->media_url != NULL){
                $new_global_news->setImage($status->entities->media->media_url);
            }//if
            else{

               $new_global_news->setImage($user_image);  

            }//else

            $new_global_news = new global_news();
            $new_global_news->setTitle($screen_name);
            $new_global_news->setDescription($text);
            $new_global_news->setSource($source);
            $new_global_news->setDistrict($district->getId());
            $new_global_news->setDate($created_at);

            $glob_service->AddGlobalNews($new_global_news);
            $last_news = $status->id_str;
            $request->setCookiesWithKey('last_record_id', $last_news);
        }//if
   }//foreach
   
}//foreach

