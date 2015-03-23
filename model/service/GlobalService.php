<?php

namespace model\service;

use model\entity\district;
use model\entity\global_news;
use model\entity\stopword;
use model\entity\statistic_stop_word;
use model\entity\SocialInfo;
use model\entity\CronProperties;
use model\entity\bad_word;

class GlobalService{
    
    public function GetUniquePercent(global_news $news){
          
           $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
           $stmt->execute();
           
           $descr = $news->getDescription();
           $SearchType = $news->getSearchType();
           
           $stmt = \util\MySQL::$db->prepare("SELECT MAX(levenshtein_ratio(`description`,:search_text)) FROM `global_news` WHERE SearchType = :st");
           $stmt->bindParam(':search_text',$descr);
           $stmt->bindParam(':st',$SearchType);
           $stmt->execute();
           
           return $stmt->fetch(\PDO::FETCH_BOTH)[0];
           
      }
    
    public function GetDistricts(){
        
        $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
        $stmt->execute();
        
        $districts = [];
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM districts");
        $stmt->execute();
        
        while($district = $stmt->fetchObject('model\entity\district')){
            $districts[] = $district;
        }//while
        
        
        return $districts;
        
    }
    
    public function GetGoogleNewsPostsCount(){
        
        $stmt = \util\MySQL::$db->prepare("SELECT Count(*) FROM global_news WHERE SearchType = 'n'");
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_BOTH)[0];
        
    }
    
    public function GetBadWords(){
        
        $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
        $stmt->execute();
        
        $bad_words = [];
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM badwords");
        $stmt->execute();
        
        while($word = $stmt->fetchObject('model\entity\bad_word')){
            $bad_words[] = $word;
        }//while
        
        
        return $bad_words;
        
    }
    
    public function GetVkPostsCount(){
        
        $stmt = \util\MySQL::$db->prepare("SELECT Count(*) FROM global_news WHERE SearchType = 'v'");
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_BOTH)[0];
        
    }
    
    public function GetYandexPostsCount(){
        
        $stmt = \util\MySQL::$db->prepare("SELECT Count(*) FROM global_news WHERE SearchType = 'y'");
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_BOTH)[0];
        
    }
    
    public function GetTwitterPostsCount(){
        
        $stmt = \util\MySQL::$db->prepare("SELECT Count(*) FROM global_news WHERE SearchType = 't'");
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_BOTH)[0];
        
    }
    
    public function GetGooglePostsCount(){
        
        $stmt = \util\MySQL::$db->prepare("SELECT Count(*) FROM global_news WHERE SearchType = 'g'");
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_BOTH)[0];
        
    }
    
     public function GetFaceBookPostsCount(){
        
        $stmt = \util\MySQL::$db->prepare("SELECT Count(*) FROM global_news WHERE SearchType = 'f'");
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_BOTH)[0];
        
    }
    
    public function GetCronProperties(){
        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM cronproperties");
        $stmt->execute();
        
        $cron = $stmt->fetchObject('model\entity\CronProperties');
        
        if(is_a($cron, 'model\entity\CronProperties')){
            
            if($cron->getTimeStart() == NULL){
                return NULL;
            }//if
            else{
                return $cron;
            }//else
        }
        
    }
    
    public function IsCronEnable(){
        
        $stmt = \util\MySQL::$db->prepare("SELECT NOW()");
        $stmt->execute();
        $date = $stmt->fetch(\PDO::FETCH_COLUMN);
        
        $stmt = \util\MySQL::$db->prepare("SELECT TimeEnd FROM cronproperties");
        $stmt->execute();
        $date_end = $stmt->fetch(\PDO::FETCH_COLUMN);
        
        return $date != $date_end;
        
    }
    
    public function GetLastIdTwitter(){
        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM social_info");
        $stmt->execute();
        
        $sf = $stmt->fetchObject('model\entity\SocialInfo');
        
        if(is_a($sf,'model\entity\SocialInfo')){
            $lastId = $sf->getLastRecordId();   
            if(!empty($lastId)){
                return $lastId;
            }//if
            else{
                return NULL;
            }//else
            
        }//if
        else{
                return NULL;
        }//else
        
        
    }
    
    public function SetLastIdTwitter($lastId){
        
        $stmt = \util\MySQL::$db->prepare("UPDATE social_info SET LastRecordId = :li");
        $stmt->bindParam(":li",$lastId);
        $res = $stmt->execute();
        
        if($res == 1){
            return true;
        }//if
        else{
            return false;
        }//else
        
    }//SetLastIdTwitter
    
    public function AddDistrict($title){
        
        $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
        $stmt->execute();
        
        $stmt = \util\MySQL::$db->prepare("INSERT INTO districts(id,Title) VALUES(NULL,:TITLE)");
        $stmt->bindParam(":TITLE",$title);
        $district = $stmt->execute();
        
        if($district == 1){
            return true;
        }//if
        else{
            return false;
        }//else
        
    }
    
    public function IsContainsNews($text){
        
        $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
        $stmt->execute();
        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM global_news WHERE description Like ?");
        $params = array("%$text%");
        $stmt->execute($params);
        
        $news = $stmt->fetchObject('model\entity\global_news');
        
        if(!is_a($news,'model\entity\global_news')){
            return 0;
        }//if
        
        $stmt = \util\MySQL::$db->prepare("SELECT levenshtein_ratio(:first,:sec)");
        $first = $news->getTitle();
        
        $stmt->bindParam(":first",$first);
        $stmt->bindParam(":sec",$text);
        
        $stmt->execute();
        
        $precent = $stmt->fetch(\PDO::FETCH_BOTH)[0];
        
        return $precent;
        
        
    }//IsContainsNews
    
    public function IsContainsStopWord($stopWord){
        
        $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
        $stmt->execute();

        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM stop_words where word = :word");
        $stmt->bindParam(':word',$stopWord);
        $stmt->execute();
        
        $stopWordContains = $stmt->fetchObject('model\entity\stopword');
        
        if(is_a($stopWordContains,'model\entity\stopword')){
            
            return true;
            
        }//if
        else{
            
            return false;
            
        }//else
        
    }
    
    public function UpdateStopWord($word_id,$word) {
        
        $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
        $stmt->execute();
        
        $stmt = \util\MySQL::$db->prepare("UPDATE stop_words SET word = :word WHERE id = :id");
        $stmt->bindParam(":word",$word);
        $stmt->bindParam(":id",$word_id);
        $res = $stmt->execute();
        
        if($res == 1){
            return true;
        }//if
        else{
            return false;
        }//else
        
    }
    
    public function UpdateDistrict($id_district,$new_title){
        
        $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
        $stmt->execute();
        
        $stmt = \util\MySQL::$db->prepare("UPDATE districts SET Title = :word WHERE id = :id");
        $stmt->bindParam(":word",$new_title);
        $stmt->bindParam(":id",$id_district);
        $res = $stmt->execute();
        
        if($res == 1){
            return true;
        }//if
        else{
            return false;
        }//else
        
    }
    
    public function GetDistrictById($id){
        
        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM districts WHERE id = :id");
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
        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM districts WHERE Title = :name");
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
    
    public function GetLastVkNews(){
        
        $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
        $stmt->execute();
        
        $districts = [];
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM global_news WHERE INSTR(Source,'vk.com') ORDER BY id desc");
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
       
        $global_news_array = [];
        
        $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
        $stmt->execute();

        $stmt = \util\MySQL::$db->prepare("SELECT * FROM `global_news` ORDER BY id desc LIMIT $offset,$limit");
        $stmt->execute();

        while($glob_news = $stmt->fetchObject(global_news::class)){
            $global_news_array[] = $glob_news;
        }//while
            
        return $global_news_array;
        
    }
    
    public function AddGlobalNews(global_news $news){
        
 //       $percent = $this->GetUniquePercent($news->getDescription());
        
 //       if(intval($percent) < 96){
            
            $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
            $stmt->execute();
            $search_type = $news->getSearchType();

            $stmt = \util\MySQL::$db->prepare("INSERT INTO global_news(id,title,description,public_date,district,Source,Images,Date,Stop_words,District_str,SearchType)".
                    " VALUES(NULL,:title,:description,now(),:distr,:src,:img,:date,:s_w,:dis_str,'$search_type') ");
            $title = preg_replace("/[^а-яa-z\\\\.,;\\/!@#$%^&*()_+-=\\\'\\\"«»\n\t\r ]/ius",'',$news->getTitle());

            $stmt->bindParam(":title",$title);

            $description = preg_replace("/[^а-яa-z\\\\.,;\\/!@#$%^&*()_+-=\\\'\\\"«»\n\t\r ]/ius",'',$news->getDescription());

            $description = \util\MySQL::$db->quote($description,\PDO::PARAM_STR);

            $stmt->bindParam(":description",$description );

            $destr = $news->getDistrict();
            $stmt->bindParam(":distr",$destr);

            $source = $news->getSource();
            $stmt->bindParam(":src",$source);

            $img = $news->getImage();
            $stmt->bindParam(":img",$img);

            $public_date = $news->getDate();
            $stmt->bindParam(":date",$public_date);

            $sw = $news->getStop_words();
            $stmt->bindParam(":s_w",$sw);

            $dis_str = $news->getDistrict_str();
            $stmt->bindParam(":dis_str",$dis_str);

            $res = $stmt->execute();
            $stmt = \util\MySQL::$db->prepare("DELETE FROM global_news WHERE description like '% порно %'");
            $stmt->execute();
        
            if($res == 1){
                return true;
            }//if
            else{
                return false;
            }//else
 //       }//if
        
 //       return false;
        
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
    
    public function GetGlobalNewsByStopWord($word,$district,$offset,$limit=10){
    
        $globalNews=[];
        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM global_news WHERE description Like ? and district = ? LIMIT $offset,$limit; ");
        $params = array("%$word%","$district");
        $stmt->execute($params);
        
        while($news = $stmt->fetchObject(global_news::class)){
            
            $text = $news->getDescription();
            $news->setDescription(stripslashes($text));
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

    while($news = $stmt->fetchObject('model\entity\global_news')){

        $globalNews[] = $news;

    }//while


    return $globalNews;
}
    
    public function GetCountOfNewsByStopWord($district){
        
        $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
        $stmt->execute();
        $stop_words = $this->GetStopWords();
        $count = 0;
        
        foreach($stop_words as $sw){
            
            $stmt = \util\MySQL::$db->prepare("SELECT COUNT(*) FROM global_news WHERE district = ? and description Like ?");
            $params = array("$district","%{$sw->getWord()}%");
            $stmt->execute($params);
            
            $count += intval($stmt->fetch(\PDO::FETCH_BOTH));
            
        }//foreach
        
        return $count;
        
    }

    public function GetStopWordById($id){

    $stmt = \util\MySQL::$db->prepare("SELECT * FROM stop_words WHERE id = :id");
    $stmt->bindParam(":id",$id);
    $stmt->execute();

    $stopword = $stmt->fetchObject('model\entity\stopword');

    if(is_a($stopword, 'model\entity\stopword')){
           return $stopword;
    }//if
    else{
        return NULL;
    }

}

    public function GetStopWordByTitle($word){
        
    $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
    $stmt->execute();
    
    $stmt = \util\MySQL::$db->prepare("SELECT * FROM stop_words WHERE word = :word");
    $stmt->bindParam(":word",$word);
    $stmt->execute();

    $stopword = $stmt->fetchObject('model\entity\stopword');

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

    $exist_word = $stmt->fetchObject('model\entity\stopword');

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

    while( $sw = $stmt->fetchObject('model\entity\statistic_stop_word')){

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

    while($stop_word = $stmt->fetchObject('model\entity\stopword')){

        $stop_words[] = $stop_word;

    }//while

    return $stop_words;

}

}
