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
//$cron_obj = $global->GetCronProperties();
//$offset = $cron_obj->getOffset();    

for($offset = 0;$offset <= 40; $offset+=8){
    $i = 1;
    foreach ($districts as $district){//Проходим по всем районам
    
    $d_title = $district->getTitle();
    $to_search = urlencode($d_title);
    
    $global = new GlobalService();

    //$cron = $global->IsCronEnable();

//    
//    $url = "http://0s.mfvgc6a.m5xw6z3mmvqxa2ltfzrw63i.cmle.ru/ajax/services/search/web?v=1.0&"
//    . "q=Paris%20Hilton&userip=USERS-IP-ADDRESS";
    //$data    = MyDB::get() -> selectOne('*',self::TABLE,'`id_mod` = '.$this->id_mod);
//    $siteUrl = 'http://www.livejournal.com/';
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=$to_search&rsz=large&userip=USERS-IP-ADDRESS");
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//    curl_setopt($ch, CURLOPT_REFERER, $siteUrl);
//    $result = curl_exec($ch);
//    curl_close($ch);

    $result = file_get_contents("https://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=$to_search%20site:http://www.livejournal.com/&start=$offset");    

    $result_from_json = json_decode($result);
//    if(property_exists($js_obj, 'responseData')){
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
                $contains = $glob_service->IsContainsNews($title);

                if($contains){
                    continue;
                }//if

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
