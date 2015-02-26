<?php

require_once './util/MySQL.php';
require_once './model/entity/global_news.php';
require_once './model/service/GlobalService.php';
require_once './model/entity/district.php';

use model\service\GlobalService;
use model\entity\global_news;

\util\MySQL::$db = new \PDO('mysql:host=localhost;dbname=u304199710_info', 'u304199710_alex', '1qaz2wsx');

$glob_service = new GlobalService();

//Получаем все районы из БД
$districts = $glob_service->GetDistricts();

foreach ($districts as $district){//Проходим по всем районам
    //3600

    $result = file_get_contents("https://api.vk.com/method/newsfeed.search?q={$district->getTitle()}&start_time=".(time()-299)."&extended=0&count=10&v=5.28");    
    $result_from_json = json_decode($result);
    
    foreach ($result_from_json->response->items as $my_item){
        
        if($my_item->owner_id < 0){//Отсеивание групп
            
            //Описание новости
            $text = $my_item->text;            
            //Заголовок
            $title = explode('.', $text)[0];
            
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
            $glob_service->AddGlobalNews($new_global_news);
            
        }//if
        
        
    }//foreach
    
}//foreach