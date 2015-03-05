<?php

ini_set("max_execution_time", "500");
 
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
$i=1;
foreach ($districts as $district){//Проходим по всем районам
    
    $d_title = $district->getTitle();
    $to_search = urlencode($d_title);
    $result = file_get_contents("https://api.vk.com/method/newsfeed.search?q=$to_search&start_time=".(time()-299)."&extended=0&count=50&v=5.28");    
    $result_from_json = json_decode($result);
    
    foreach ($result_from_json->response->items as $my_item){
        
        if($my_item->owner_id < 0){//Отсеивание групп
            $pos = false;
            //Описание новости
            $text = addslashes($my_item->text);
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
                $contains = $glob_service->IsContainsNews($title);

                if($contains){
                    continue;
                }//if

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

            }//if стоп-слова
        }//if группы   
        
    }//foreach
    echo "$i <br />";
    $i++;
}//foreach