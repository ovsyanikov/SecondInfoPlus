<?php

namespace model\service;

class StartService{
    
    public function __construct() {
        
        $stmt = \util\MySQL::$db->prepare("SET NAMES utf8");
        $stmt->execute();
        
    }
    
    //Последние новости форума
    public function GetLastResourceNews(){
        
        $news = [];
        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM resourcenews ORDER BY DateOfPublic DESC LIMIT 3");
        $stmt->execute();
        
//        while($lastNews = $stmt->fetchObject(resourcenews::class)){
//            
//            $news[] = $lastNews;
//            
//        }//while
        
        return $news;
        
    }
    
    //Новости форума
    public function GetLastForumThemes(){
        
        $lastThemes = [];
        
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM themes ORDER BY DTOfWriting desc LIMIT 3;");
        $stmt->execute();
        
//        while($topThemes = $stmt->fetchObject(theme::class)){
//            
//            $lastThemes[] = $topThemes;
//            
//        }//while
        
        return $lastThemes;
        
    }
    
    //Последние зарегистрированные поставщики
    public function GetLastCompanies(){
        
        $companies = [];
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM companies ORDER BY id desc LIMIT 3");
        $stmt->execute();
        
//        while($topCompanies = $stmt->fetchAll(company::class)){
//            
//            $companies[] = $topCompanies;
//            
//        }
        
        return $companies;
        
    }
    
    //Последние новости поставщиков/Компаний
    public function GetLastCompanyNews(){
        
        $topCompanyNews = [];
        $stmt = \util\MySQL::$db->prepare("SELECT * FROM companies ORDER BY id desc LIMIT 3");
        $stmt->execute();
        
//        while($company = $stmt->fetchObject('model\entity\company')){
//            
//            $topCompanyNews[] = $company;
//            
//        }
        
        return $topCompanyNews;
        
    }
    
    
}