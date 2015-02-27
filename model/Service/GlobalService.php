<?php

namespace model\service;

use model\entity\district;
use model\entity\global_news;
use model\entity\stopword;
use model\entity\statistic_stop_word;

class GlobalService{
    
    public function GetDistricts(){
        
        $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
        $stmt->execute();
        
        $districts = [];
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM Districts");
        $stmt->execute();
        
        while($district = $stmt->fetchObject(district::class)){
            $districts[] = $district;
        }//while
        
        
        return $districts;
        
    }
    
    public function IsContainsNews($text){
        
        $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
        $stmt->execute();
        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM global_news WHERE description Like ?");
        $params = array("%$text%");
        $stmt->execute($params);
        
        $news = $stmt->fetchObject(global_news::class);
        
        if(is_a($news,'model\entity\global_news')){
            return true;
        }//if
        else{
            return false;
        }
    }//IsContainsNews
    
    public function GetDistrictById($id){
        
        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM Districts WHERE id = :id");
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        
        $district = $stmt->fetchObject('model\entity\district');
        
        if(is_a($district, 'model\entity\district')){
               return $district;
        }//if
        else{
            return NULL;
        }
    }//GetDistrict
    
    public function GetDistrictByName($name){
        
        $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
        $stmt->execute();
        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM Districts WHERE Title = :name");
        $stmt->bindParam(":name",$name);
        $stmt->execute();
        
        $final_district = $stmt->fetchObject('model\entity\district');
        
        if(is_a($final_district, 'model\entity\district')){
               return $final_district;
        }//if
        else{
            return NULL;
        }
    }//GetDistrict
    
    public function GetLastNews(){
        
        $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
        $stmt->execute();
        
        $districts = [];
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM global_news PRDER BY id desc");
        $stmt->execute();
        
        $last_news = $stmt->fetchObject(global_news::class);
        
        if(is_a($last_news,'model\entity\global_news')){
             return $last_news;
        }//if
        else{
            return NULL;
        }
       
        
    }
    
    public function GetGlobalNewsById($id) {
        $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");       
        $stmt->execute();
        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM global_news WHERE id = :id");
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        
        $globalNews = $stmt->fetchObject(global_news::class);
        
        if(is_a($globalNews, 'model\entity\global_news')){
               return $globalNews;
        }//if
        else{
            return NULL;
        }//else
        
    }//GetGlobalNewsById
    
    public function GetGlobalNews($offset=0,$limit=0){
        
        $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
        $stmt->execute();
        
        $global_news_array = [];
        
        if($offset == 0){//DefaultParam

            $stmt = \util\MySQL::$db->prepare("SELECT * FROM global_news");
            $stmt->execute();
            
            while($glob_news = $stmt->fetchObject(global_news::class)){
                $global_news_array[] = $glob_news;
            }//while
            
        }//if
        else{
            
            $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
            $stmt->execute();
            
            $stmt = \util\MySQL::$db->prepare("SELECT * FROM global_news LIMIT $offset,$limit");
            $stmt->execute();
            
            while($glob_news = $stmt->fetchObject(global_news::class)){
                $global_news_array[] = $glob_news;
            }//while
            
        }//else
        
        return $global_news_array;
        
    }
    
    public function AddGlobalNews(global_news $news){
        
        $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
        $stmt->execute();
        
        $stmt = \util\MySQL::$db->prepare("INSERT INTO global_news(id,title,description,public_date,district,Source,Images,Date)".
                " VALUES(NULL,:title,:description,now(),:distr,:src,:img,:date) ");
        
        $title = $news->getTitle();
        $stmt->bindParam(":title",$title);
        
        $description = $news->getDescription();
        $stmt->bindParam(":description",$description);
        
        $destr = $news->getDistrict();
        $stmt->bindParam(":distr",$destr);
        
        $source = $news->getSource();
        $stmt->bindParam(":src",$source);
        
        $img = $news->getImage();
        $stmt->bindParam(":img",$img);
        
        $public_date = $news->getDate();
        $stmt->bindParam(":date",$public_date);
        
        
        $res = $stmt->execute();
        
        if($res == 1){
            return true;
        }//if
        else{
            return false;
        }//else
        
    }
    
    public function GetGlobalNewsSinceDate($date){
        $globalNews=[];
        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM global_news WHERE public_date > :date; ");
        $stmt->bindParam(":date",$date);
        $stmt->execute();
        
        while($news = $stmt->fetchObject(global_news::class)){
            
            $globalNews[] = $news;
            
        }//while
        
        
        return $globalNews;
    }
    
    public function GetGlobalNewsByStopWord($word,$district){
    
        $globalNews=[];
        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM global_news WHERE description Like ? and district = ?; ");
        $params = array("%$word%","$district");
        $stmt->execute($params);
        
        while($news = $stmt->fetchObject(global_news::class)){
            
            $globalNews[] = $news;
            
        }//while
        
        
        return $globalNews;
    
}
    
    public function GetGlobalNewsBetweenDate($date_left, $date_right){

    $globalNews=[];

    $stmt = \util\MySQL::$db->prepare("SELECT * FROM global_news WHERE public_date BETWEEN :ldate AND :rdate; ");
    $stmt->bindParam(":ldate",$date_left);
    $stmt->bindParam(":rdate",$date_right);
    $stmt->execute();

    while($news = $stmt->fetchObject(global_news::class)){

        $globalNews[] = $news;

    }//while


    return $globalNews;
}

    public function GetStopWordById($id){

    $stmt = \util\MySQL::$db->prepare("SELECT * FROM stop_words WHERE id = :id");
    $stmt->bindParam(":id",$id);
    $stmt->execute();

    $stopword = $stmt->fetchObject(stopword::class);

    if(is_a($stopword, 'model\entity\stopword')){
           return $stopword;
    }//if
    else{
        return NULL;
    }

}

    public function GetStopWordByTitle($word){

    $stmt = \util\MySQL::$db->prepare("SELECT * FROM stop_words WHERE word = :word");
    $stmt->bindParam(":word",$word);
    $stmt->execute();

    $stopword = $stmt->fetchObject(stopword::class);

    if(is_a($stopword, 'model\entity\stopword')){
           return $stopword;
    }//if
    else{
        return NULL;
    }

}

    public function AddStopWord($word){

    $stmt = \util\MySQL::$db->prepare("SELECT * FROM stop_words WHERE word = :word");
    $stmt->bindParam(":word",$word);
    $stmt->execute();

    $exist_word = $stmt->fetchObject(stopword::class);

    if(is_a($exist_word,'model\entity\stopword')){

        return false;

    }//if

    else{

        $stmt = \util\MySQL::$db->prepare("INSERT INTO stop_words(id,word)  VALUES(NULL,:word)");
        $stmt->bindParam(":word",$word);
        $st = $stmt->execute();

        if($st == 1){
            return true;
        }//if
        else{
            return false;
        }//else
    }//else

}//AddStopWord

    public function AddStatisticWord($user_id,$word_id) {

    $stmt = \util\MySQL::$db->prepare("INSERT INTO statistic_stop_words(user_id,word_id) VALUES(:ui,:wi)");
    $stmt->bindParam(":ui",$user_id);
    $stmt->bindParam(":wi",$word_id);
    $res = $stmt->execute();

    return ($res == 1) ? true : false;

}//

    public function GetStatisticWordsByUserId($id) {

    $stat_wrd = [];

    $stmt = \util\MySQL::$db->prepare("SELECT * FROM statistic_stop_words WHERE user_id = :uid");
    $stmt->bindParam(":uid",$id);
    $stmt->execute();

    while( $sw = $stmt->fetchObject(statistic_stop_word::class)){

        $stat_wrd[] = $sw;

    }//while

    return $stat_wrd;

}

    public function GetStatisticByStopWordId($id) {

    $stmt = \util\MySQL::$db->prepare("SELECT COUNT(id) FROM statistic_stop_words WHERE word_id = :wId");
    $stmt->bindParam(":wId",$id);
    $stmt->execute();

    $array = $stmt->fetchAll( \PDO::FETCH_COLUMN, 0 );

    return $array;

}//public

    public function GetStopWords(){

    $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
    $stmt->execute();

    $stmt = \util\MySQL::$db->prepare("SELECT * FROM stop_words");
    $stmt->execute();

    $stop_words = [];

    while($stop_word = $stmt->fetchObject(stopword::class)){

        $stop_words[] = $stop_word;

    }//while

    return $stop_words;

}

}