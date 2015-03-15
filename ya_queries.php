<meta charset="UTF-8">
<?php

ini_set("max_execution_time", "2500");
 
require_once './util/MySQL.php';
require_once './model/entity/global_news.php';
require_once './model/entity/stopword.php';
require_once './model/service/GlobalService.php';
require_once './model/entity/district.php';
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
           
foreach ($districts as $district){//Проходим по всем районам
    
    $d_title = $district->getTitle();
    echo "<h2>РАЙОН - $d_title<br></h2>" ;
    $d_title = trim($d_title);
    
    $d_title = str_replace(' ', '+', $d_title);
    $d_title = urlencode($d_title);
    
    $result = file_get_contents("https://blogs.yandex.ru/search.rss?text=$d_title");
    //$result = file_get_contents("https://xmlsearch.yandex.ru/xmlsearch?user=armen-g2008&key=03.308859073:c792a52e76f0489008aa66814558db5a");
    
    $items = new SimpleXMLElement($result);
    $result_items = [];
    
    foreach ($items->channel->item as $yandex_item){
        $result_items[] = $yandex_item;
    }
    
    var_dump($result_items);
    
//    $xml = xml_parser_create();
//    xml_parser_get_option($xml, XML_OPTION_SKIP_WHITE,1);
//    xml_parse_into_struct($xml, $result, $element, $index);
//    xml_parser_free($xml);
//    
//    $items = $element[$index[]]
    
//    foreach ($result_from_json->response->items as $my_item){
//
//        $pos = false;
//        //Описание новости
//        $text = $my_item->text;
//        
//        $text = str_replace('(^A-Za-zА-Яа-я0-9/!@#$%^&*()_+"|\}{[]:;.,)','',$text);
//        $found = false;
//
//        foreach($stop_word_for_search as $sw){
//            //поиск в тексте стоп-слова, если тру останавлеваем поиск, сохранаяем запись в базе
//            $stop_word = trim( $sw->getWord() );
//            $pos = stripos($text,$stop_word);
//
//            if($pos  != false){
//                
//                $words = strtok($text,' ,.!;-)({}@\'\":^$');
//                       
//                while($words !== false){
//                    
//                    if(strlen($words) == strlen($stop_word)){
//                        
//                        if(stristr($words, $stop_word) != false){
//                            $found = true;
//                            break;
//                        }//if
//                        
//                    }//if
//                    $words = strtok(' ,.!;-)({}@\'\":^$');
//                    
//                }//while
//                
//            }//if            
//
//            if($found){
//                $found = false;
//                break;
//            }//if
//
//        }//foreach
//
//        if ($pos != false){
//
//            $date = date("D M Y H:i:s",$my_item->date);
//            //Заголовок
//            $title = substr($text, 0, 50) . "...";
//            $contains = false;
//            //////////////$contains = $glob_service->IsContainsNews($title);
//
//            ///if($contains < 10){
//
//            $img = NULL;
//
//            if(property_exists($my_item, 'attachments')){
//                $att = $my_item->attachments[0];
//
//                if(property_exists($att,'photo')){
//                    $photo = $my_item->attachments[0]->photo;
//                    if(property_exists($photo,'photo_1280')){
//                        $img = $my_item->attachments[0]->photo->photo_1280;
//                    }//if
//                    else if(property_exists($photo,'photo_604')){
//                        $img = $my_item->attachments[0]->photo->photo_604;
//                    }
//                }//if
//            }//if
//
//            $new_global_news = new global_news();
//            $new_global_news->setTitle($title);
//            $new_global_news->setDescription($text);
//            $new_global_news->setImage($img);
//            $new_global_news->setSource("http://vk.com/feed?w=wall{$my_item->owner_id}_{$my_item->id}");
//            $new_global_news->setDistrict($district->getId());
//            $new_global_news->setDate($date);
//            $new_global_news->setDistrict_str($district->getTitle());
//            $new_global_news->setStop_words($sw->getWord());   
//
//            $glob_service->AddGlobalNews($new_global_news);
//            //}//if
//
//
//        }//if стоп-слова
//    //}//if группы   
//
//
//    }//foreach
    
}//foreach

echo "final";