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
    <body class="news-bg"> 
    <heder>
        <div class="top-head">
            <div class="content">
                <a href="?ctrl=news&act=news"><div class="logo">
                    <img src="img/info-puls1.png" alt="">
                    <h1 class="logo-h1">PULSE</h1>
                </div></a>
                <div class="div-menu">
                    <ul class="menu">
                        <a href="?ctrl=news&act=news"><li class="active menu-li">ГЛАВНАЯ</li></a>
                        <a href="?ctrl=news&act=Districts"><li class="menu-li">РАЙОНЫ</li></a>
                        <a href="?ctrl=news&act=MyTasks"><li class="menu-li">ЗАДАЧИ</li></a>
                        <a href=""><li class="menu-li">УЧАСНИКИ</li></a>
                        <a href="?ctrl=news&act=MyPosts"><li class="menu-li">МОИ ЗАПИСИ</li></a>
                    </ul>

                    <div class="search">
                        <input id="search" type="search" class="isearch" placeholder="Поиск">
                        <span class="search-icon">A</span>
                    </div>
                <img src="img/loader2.gif" alt="" id="loader" class="hide">

                </div>

            </div>
        </div>
        <div class="bottom-head">
            <div class="content">
                <ul class="menu">
                    <a href="?ctrl=news&act=news"><li class="active menu-li">ГЛАВНАЯ</li></a>
                    <a href="?ctrl=news&act=districts"><li class="menu-li">РАЙОНЫ</li></a>
                    <a href=""><li class="menu-li">ЗАДАЧИ</li></a>
                    <a href=""><li class="menu-li">УЧАСНИКИ</li></a>
                    <a href="?ctrl=news&act=MyPosts"><li class="menu-li">МОИ ЗАПИСИ</li></a>
                </ul>


            </div>
        </div>
    </heder>



    <div class="content">
        <aside class="sidebar">
                        
            <div class="personal">
                <a href="?ctrl=user&act=MyProfile">Личный кабинет(<?php
                    echo "{$this->view->current_user->getLogin()}"
                    ?>)</a> / 
                <a href="?ctrl=user&act=leave">Выйти</a>
            </div>
            
            <h1 class="h1">Сервисы поиска сайта</h1>
            <div class="side-post">
                <a href="vk_queries.php">Вконтакте поиск <?php echo "{$this->view->vk_posts}"; ?></a>
            </div>
            <div class="side-post">
                <a  href="tw_queries.php">Twitter поиск <?php echo "{$this->view->tw_posts}"; ?></a>
            </div>
            <div class="side-post">
                <a  href="google_queries.php">Google-web поиск <?php echo "{$this->view->google_posts}"; ?></a>
            </div>
            <div class="side-post">
                <a  href="google_news_queries.php">Google-news поиск <?php echo "{$this->view->google_news_posts}"; ?></a>
            </div>            
            <div class="side-post">
                <a  href="fb_queries.php">Facebook поиск <?php echo "{$this->view->fb_posts}"; ?></a>
            </div>
            <div class="side-post">
                <a  href="ya_queries.php">Yandex поиск <?php echo "{$this->view->ya_posts}"; ?></a>
            </div>
        </aside>
        
        <section class="news-section" id="news-section">
            <div class="main-img top-3">
                <img src="img/moscow_1.jpg" alt="">
            </div>
            <h1 class="h1">Все новости по дате</h1>
            <div id="newsContent">
                <?php

                        foreach($this->view->all_news as $news){
                            echo '<div class="post">';
                            $d_id = $news->getId();
                            $ch_social = $news->getSearchType();
                            $post_distr = $news->getDistrict_str();
                            $post_sw = $news->getStop_words();
                            $title = str_replace('\n', '', $news->getTitle());
                            $source = $news->getSource();
                            
                            $description = $news->getDescription();
                            
                            if(strlen($description) > 300){
                                
                                $description = iconv_substr($description,0, 300, 'UTF-8');
                                $description .= "...";
                                
                            }//if
                            $description = str_replace($post_distr, "<span class=\"bold\">$post_distr</span>", $description);
                            $description = str_replace($post_sw, "<span class=\"bold\">$post_sw</span>", $description);
                            
                            $description = str_replace("\\n", " ", $description);
                            $description = stripslashes($description);
                            
                            $date = $news->getDate();
                            
                            $image = $news->getImage();
                            
                            if($ch_social == 't'){
                                echo "<a href=\"$source\" title=\"Ссылка на первоисточник\"><span  class=\"twitter post-icon\">R</span></a>";
                            }//if
                            else if($ch_social == 'v'){
                                    echo "<a href=\"$source\" title=\"Ссылка на первоисточник\"><span  class=\"vk post-icon\">Q</span></a>";
                            }//else if
                            else if($ch_social == 'f'){
                                echo "<a href=\"$source\" title=\"Ссылка на первоисточник\"><span  class=\"facebook post-icon\">S</span></a>";
                            }//else if
                            else if($ch_social == 'g' || $ch_social == 'n'){
                                echo "<a href=\"$source\" title=\"Ссылка на первоисточник\"><span  class=\"google post-icon\">V</span></a>";
                            }//else if
                            else if($ch_social == 'y'){
                                echo "<a href=\"$source\" title=\"Ссылка на первоисточник\"><span  class=\"yandex post-icon\">Я</span></a>";
                            }//else if
                            
                            //qr
                            echo "<span  class=\"post-date2\" title=\"Время публикации\">$date</span>";    
                            if($image != null){
                                
                                echo "<img  class=\"post-img\" src=\"$image\" alt=\"\"/>";
                                echo "<a href=\"?ctrl=news&act=SpecificPostHome&id={$d_id}\"><h2 id=\"postTitle\" class=\"post-h2 h2\">$title</h2></a>";
                                echo "<p id=\"postContent\" class=\"post-text\">$description</p>";
                                
                            }//if
                            else{
                                echo "<a href=\"?ctrl=news&act=SpecificPostHome&id={$d_id}\"><h2 id=\"postTitle\" class=\"post-h2 h2\">$title</h2></a>";
                                echo "<p id=\"postContent\" class=\"post-text\">$description</p>";
                            }//else
                            

                            echo "<p  class=\"post_bottom\">Район: $post_distr, cтоп-слово:$post_sw</p>";
                            //echo "<p  class=\"post_bottom\">Стоп-слово: $post_sw</p>";                            
                            echo '</div>';
                            
                        }//foreach
                    
                    
                ?>
            </div>
            <script>
            
                    if($("#newsContent div.post").length != 0){
                        $("#newsContent").append('<input class="My-posts-button submit" id="more_news" value="Следующие новости" type="button">');
                    }//if
                    
            </script>
<!--            <div class="post">
                <h2 id="postTitle" class="post-h2 h2"></h2>
                <p id="postContent" class="post-text"></p>
            </div>-->

        </section>
    </div>
    <footer class="footer">
        <h2 class="foot copyright">© Info-pulse 2015</h2>
    </footer>
    <div id="toTop" class="hidden">E</div>
</body>
</html>
