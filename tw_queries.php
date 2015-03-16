<meta charset="UTF-8" >
<?php
 
ini_set("max_execution_time", "2500");
 
require_once './util/MySQL.php';
require_once './model/entity/global_news.php';
require_once './model/entity/stopword.php';
require_once './model/service/GlobalService.php';
require_once './model/entity/district.php';
require_once './twitter-api/TwitterAPIExchange.php';
require_once './util/Request.php';
require_once './model/entity/social_info.php';

use model\service\GlobalService;
use model\entity\global_news;
use util\Request;
use model\entity\stopword;
use model\entity\SocialInfo;

\util\MySQL::$db = new \PDO('mysql:host=localhost;dbname=u304199710_info', 'u304199710_alex', '1qaz2wsx');

$glob_service = new GlobalService();
$stop_word_for_search = $glob_service->GetStopWords();

//Получаем все районы из БД
$districts = $glob_service->GetDistricts();

//инициализация первого приложения


$url = 'https://api.twitter.com/1.1/search/tweets.json';
$request = new Request();
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
        
        $dist = $district->getTitle();
        $q_param = urlencode($dist);
        $count = count($districts);

        $getfield = "?q=$q_param&count=80";


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
            $found = false;
            
            foreach($stop_word_for_search as $sw){
            //поиск в тексте стоп-слова, если тру останавлеваем поиск, сохранаяем запись в базе
            $stop_word = trim( $sw->getWord() );
            $pos = stripos($text,$stop_word);

            if($pos  != false){
                
                $words = strtok($text,' ,.!;-)({}@\'\":^$');
                       
                while($words !== false){
                    
                    if(strlen($words) == strlen($stop_word)){
                        
                        if(stristr($words, $stop_word) != false){
                            $found = true;
                            break;
                        }//if
                        
                    }//if
                    $words = strtok(' ,.!;-)({}@\'\":^$');
                    
                }//while
                
            }//if            

            if($found){
                $found = false;
                break;
            }//if

        }//foreach
        
            if ($pos != false){
                
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
                    $new_global_news->setSearchType('t');
                    $glob_service->AddGlobalNews($new_global_news);
                
            }//if



        }//foreach
       }
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

        $dist = $district->getTitle();
        $q_param = urlencode($dist);
        $count = count($districts);


        $getfield = "?q=$q_param&count=80";
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
            //$glob_service->SetLastIdTwitter($last_news);
            $found = false;
            foreach($stop_word_for_search as $sw){
            //поиск в тексте стоп-слова, если тру останавлеваем поиск, сохранаяем запись в базе
            $stop_word = trim( $sw->getWord() );
            $pos = stripos($text,$stop_word);

            if($pos  != false){
                
                $words = strtok($text,' ,.!;-)({}@\'\":^$');
                       
                while($words !== false){
                    
                    if(strlen($words) == strlen($stop_word)){
                        
                        if(stristr($words, $stop_word) != false){
                            $found = true;
                            break;
                        }//if
                        
                    }//if
                    $words = strtok(' ,.!;-)({}@\'\":^$');
                    
                }//while
                
            }//if            

            if($found){
                $found = false;
                break;
            }//if

        }//foreach
        
            if ($pos != false){
                
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
                    $new_global_news->setSearchType('t');
                    $glob_service->AddGlobalNews($new_global_news);
                
            }//if


        }//foreach

       }//if statuses is property

   $i++;
   
   }//if второе приложение
   
}//for

echo "final";