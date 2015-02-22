<?php

namespace model\service;

use model\entity\district;
use model\entity\global_news;
use model\entity\stopword;
use model\entity\statistic_stop_word;

class GlobalService{
    
    public function GetDistricts(){
        
        $districts = [];
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM Districts");
        $stmt->execute();
        
        while($district = $stmt->fetchObject(district::class)){
            $districts[] = $district;
        }//while
        
        
        return $districts;
        
    }
    
    public function GetDistrictById($id){
        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM Districts WHERE id = :id");
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        
        $district = $stmt->fetchObject(district::class);
        
        if(is_a($district, 'model\entity\district')){
               return $district;
        }//if
        else{
            return NULL;
        }
    }//GetDistrict
    
    public function GetDistrictByTitle($title){
        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM Districts WHERE title = :title");
        $stmt->bindParam(":title",$title);
        $stmt->execute();
        
        $district = $stmt->fetchObject(district::class);
        
        if(is_a($district, 'model\entity\district')){
               return $district;
        }//if
        else{
            return NULL;
        }
    }//GetDistrict
    
    public function GetGlobalNewsById($id) {
        
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
    
    public function AddGlobalNews(global_news $news){
        
        $stmt = \util\MySQL::$db->prepare("INSERT INTO global_news(id,title,description,public_date,district,Source)".
                " VALUES(NULL,:title,:description,:pd,:distr,:src) ");
        
        $title = $news->getTitle();
        $stmt->bindParam(":title",$title);
        
        $description = $news->getDescription();
        $stmt->bindParam(":description",$description);
        
        $pd = $news->getPublic_date();
        $stmt->bindParam(":pd",$pd);
        
        $destr = $news->getDistrict();
        $stmt->bindParam(":distr",$destr);
        
        $source = $news->getSource();
        $stmt->bindParam(":src",$source);
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
        
        $stopword = $stmt->fetchObject(district::class);
        
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
    
    
}

