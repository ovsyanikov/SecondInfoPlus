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
$result_items = [];    
$i = 0;

foreach ($districts as $district){//Проходим по всем районам
    
    $d_title = $district->getTitle();
    echo "<h2>({$district->getId()})РАЙОН - $d_title<br></h2>" ;
    $d_title = trim($d_title);
    
    $d_title = str_replace(' ', '+', $d_title);
    $d_title = urlencode($d_title);
    
    
    $result = file_get_contents("https://blogs.yandex.ru/search.rss?text=$d_title&ft=all");
    $i++;
    //$result = file_get_contents("https://xmlsearch.yandex.ru/xmlsearch?user=ovsyanikov-alesha&key=03.309510372:32a5df722ab8ef27c85f504b572d5fe4&query=$d_title");
    
    $items = new SimpleXMLElement($result);
    
    
    foreach ($items->channel->item as $yandex_item){
        $result_items[] = $yandex_item;
    }//foreach
    
    foreach ($result_items as $my_item){

        $pos = false;
        //Описание новости
        $text = $my_item->description;
        
        $text = str_replace('(^A-Za-zА-Яа-я0-9/!@#$%^&*()_+"|\}{[]:;.,)','',$text);
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

            $date = $my_item->pubDate;
            //Заголовок
            $title = $my_item->title;

            $new_global_news = new global_news();
            $new_global_news->setTitle($title);
            $new_global_news->setDescription($text);
            $new_global_news->setImage(NULL);
            $new_global_news->setSource($my_item->link);
            $new_global_news->setDistrict($district->getId());
            $new_global_news->setDate($date);
            $new_global_news->setDistrict_str($district->getTitle());
            $new_global_news->setStop_words($sw->getWord());   
            $new_global_news->setSearchType('y');
            
            $glob_service->AddGlobalNews($new_global_news);
            //}//if


        }//if стоп-слова
    //}//if группы   


    }//foreach
    
    if($i == 10){
        
        die;
        
    }//if
    
    $i++;
    
}//foreach

echo "final";