<?php

require_once './model/entity/global_news.php';
require_once './model/entity/stopword.php';
require_once './model/service/GlobalService.php';
require_once './model/entity/district.php';
require_once './util/MySQL.php';
require_once './util/Request.php';

use model\entity\global_news;
use model\entity\district;
use model\service\GlobalService;
use util\Request;

$db_name = \util\MySQL::GetDbName();
$db_user = \util\MySQL::GetUserName();
$db_user_password = \util\MySQL::GetUserPassword();

 \util\MySQL::$db = new \PDO("mysql:host=localhost;dbname=$db_name", $db_user, $db_user_password);

$request = new Request();
$glob_service = new GlobalService();

$offset =  $request->getPostValue('OFFSET');

$district = $request->getPostValue('District');

$main_district = $glob_service->GetDistrictByName($district);
$stop_words = $glob_service->GetStopWords();
$news = [];

foreach($stop_words as $word){
               
    $word = trim($word->getWord());
    $new_news = $glob_service->GetGlobalNewsByStopWord($word, $main_district->getId(),0,10000);
    
    if(count($new_news)!=0){
        
        $news[] = $new_news;
        
    }//if
    
}//foreach

if(count($news) == 0){
    echo "end";
}//if
else{
    $to_return = json_encode($news);
    echo $to_return;
}//else


