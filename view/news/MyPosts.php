<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/style.css">
        <link rel="shortcut icon" href="img/info-puls1.png">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.0.min.js"></script> 
        <script type="text/javascript" src="js/script.js"></script> 
        <title>Info-Pulse</title>
    </head>
    <body i="body" class="news-bg"> 
        
    <heder>
        <div class="top-head">
            <div class="content">
                <a href="?ctrl=news&act=news"><div class="logo">
                    <img src="img/info-puls1.png" alt="">
                    <h1 class="logo-h1">INFO PULSE</h1>
                </div></a>
                
                <div class="search">
                    <input id="search" type="search" class="isearch" placeholder="Поиск">
                    <span class="search-icon">A</span>
                </div>
                <img src="img/loader.gif" alt="" id="loader" class="hide loader">
            </div>
        </div>
        <div class="bottom-head">
            <div class="content">
                <ul class="menu">
                    <a href="?ctrl=news&act=news"><li class="menu-li">ГЛАВНАЯ</li></a>
                    <a href=""><li class="menu-li">РАЙОНЫ</li></a>
                    <a href=""><li class="menu-li">ЗАДАЧИ</li></a>
                    <a href=""><li class="menu-li">УЧАСНИКИ</li></a>
                    <a href="?ctrl=news&act=MyPosts"><li class="active menu-li">МОИ ЗАПИСИ</li></a>
                </ul>

                <div class="personal">
                    <a href="?ctrl=user&act=MyProfile">Личный кабинет(<?php
                         echo "{$this->view->current_user->getLogin()}"?>)</a> / 
                    <a href="?ctrl=user&act=leave">Выйти</a>
                </div>
            </div>
        </div>
    </heder>



    <div class="content">

        <section class="post-section news-section">

            <a href="?ctrl=news&act=MakePost"><input class="My-posts-button submit" id="addPost" value="Добавить запись" type="button"></a>

            <div id="newsContent">
                  <?php 
                  
                       $count_current_posts = count($this->view->current_user_news);
                       if($count_current_posts == 0){
                           echo "<h2 class=\"post-h2 h2\" style=\"margin: 15px 0px\">У вас пока нет записей!</h2>";
                       }//if
                       else{
                           foreach($this->view->current_user_news as $specific_news){
                           
                           if($specific_news->getFiles() != NULL){
                               
                                $img_files = explode(',',$specific_news->getFiles());
                                $img_count = count($img_files);
                                echo "<div class=\"post\"><div data-post-id=\"{$specific_news->getId()}\"  class=\"delete-post\">J</div><img class=\"post-img\" alt=\"\" src=\"files/{$img_files[0]}\"/><a href=\"?ctrl=news&act=SpecificNews&news_id={$specific_news->getId()}\"><h2 class=\"post-h2 h2\">{$specific_news->getTitle()}</h2></a><p class=\"post-text\">{$specific_news->getDescription()}</p></div>";
                           }//if
                          
                           else{
                                 echo "<div class=\"post\"><div  data-post-id=\"{$specific_news->getId()}\"  class=\"delete-post\">J</div><a href=\"?ctrl=news&act=SpecificNews&news_id={$specific_news->getId()}\"><h2 class=\"post-h2 h2\">{$specific_news->getTitle()}</h2></a><p class=\"post-text\">{$specific_news->getDescription()}</p></div>";
                                  
                           }//else
                           
                       }//foreach
                       }//else
                       
                  ?>
            </div>
        </section>
    </div>
    <footer class="footer">
        <h2 class="foot copyright">© Info-plus 2015</h2>
    </footer>
    <div id="toTop" class="hidden">E</div>
</body>
</html>
