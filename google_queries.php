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
require_once './model/entity/CronProperties.php';

use model\service\GlobalService;
use model\entity\global_news;
use util\Request;
use model\entity\stopword;
use model\entity\SocialInfo;
use model\entity\CronProperties;

\util\MySQL::$db = new \PDO('mysql:host=localhost;dbname=u304199710_info', 'u304199710_alex', '1qaz2wsx');

$glob_service = new GlobalService();
$stop_word_for_search = $glob_service->GetStopWords();

//Получаем все районы из БД
$districts = $glob_service->GetDistricts();

for($offset = 0;$offset <= 40; $offset+=8){
    $i=0;
    foreach ($districts as $district){//Проходим по всем районам
    
    $d_title = $district->getTitle();
    $to_search = urlencode($d_title);
    
    $global = new GlobalService();


    $result = file_get_contents("https://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=$to_search&start=$offset&rsz=large");    
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
                echo "in base<br />";
            }//if стоп-слова

    }//foreach
    $i++;
    echo "$i<br />";     

    }//foreach
    
}//for

