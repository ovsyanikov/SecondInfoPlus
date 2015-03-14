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
                    <h1 class="logo-h1">PULSE</h1>
                </div></a>
                <div class="div-menu">
                    <ul class="menu">
                        <a href="?ctrl=news&act=news"><li class="menu-li">ГЛАВНАЯ</li></a>
                        <a href="?ctrl=news&act=Districts"><li class="menu-li">РАЙОНЫ</li></a>
                        <a href="?ctrl=news&act=MyTasks"><li class="menu-li">ЗАДАЧИ</li></a>
                        <a href=""><li class="menu-li">УЧАСНИКИ</li></a>
                        <a href="?ctrl=news&act=MyPosts"><li class="menu-li">МОИ ЗАПИСИ</li></a>
                    </ul>

                    <div class="search">
                        <input id="search" type="search" class="isearch" placeholder="Поиск">
                        <span class="search-icon">A</span>
                    </div>
                <img src="img/loader2.gif" alt="" id="loader" class="hide loader">

                </div>

            </div>
        </div>
        <div class="bottom-head">
            <div class="content">
                <ul class="menu">
                    <a href="?ctrl=news&act=news"><li class="active menu-li">ГЛАВНАЯ</li></a>
                    <a href="?ctrl=news&act=Districts"><li class="menu-li">РАЙОНЫ</li></a>
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
            
            
            
            
            <h1 class="h1">Лента новостей</br>Выводятся новости 1ой рубрики, кратко</h1>
            <div class="side-post">
                <h2 class="h2">Section 1.10.32 of "de Finibus Bonorum et Malorum" <span class="span-time">14:32</span></h2>
            </div>
            <div class="side-post">
                <h2 class="h2">Section 1.10.32 of "de Finibus Bonorum et Malorum" <span class="span-time">14:32</span></h2>
            </div>
            <div class="side-post">
                <h2 class="h2">Section 1.10.32 of "de Finibus Bonorum et Malorum" <span class="span-time">14:32</span></h2>
            </div>
            <div class="side-post last">
                <h2 class="h2">Section 1.10.32 of "de Finibus Bonorum et Malorum" <span class="span-time">14:32</span></h2>
            </div>

        </aside>
        <section class=" news-section">
            
            <div id="newsContent">
                <div class="specific-post post">
                    <?php 
                        $post_distr = $this->view->global_news->getDistrict_str();
                        $post_sw = $this->view->global_news->getStop_words();
                        $tit = $this->view->global_news->getTitle();
                        $tit = preg_replace("/[^а-яa-z\\\\.,;\\/!@#$%^&*()_+-=\\\'\\\"«»]/ius",' ',$tit);;
                        $tit = str_replace("\\n", " ", $tit);
                        echo "<h2 class=\"sp_h2 post-h2 h2\">$tit</h2><br />";
                        echo "<p  class=\"post_bottom\">Район: $post_distr, cтоп-слово:$post_sw</p>";
                        $img = $this->view->global_news->getImage();
                        
                        if ($img){
                            echo "<div class=\"top-3\"><img id=\"post_image\" src=\"{$img}\" alt=\"\"></div>";                        
                        }
                        $ch_sw = "<span class=\"bold\">".$post_sw."</span>";
                        
                        $descr = $this->view->global_news->getDescription();
                        $descr = str_replace("\\n", "<br />", $descr);
                        $descr = str_replace("\\", "", $descr);
                        $descr = str_replace($post_sw, $ch_sw, $descr);
                        //$descr = str_replace($post_distr, "<span class=\"bold\">$post_distr</span>", $descr);
                        

                        
        
                        echo "<p class=\"post-text\">$descr</p>";
                        
                    ?>
                </div>
                <?php 
                    $source = $this->view->global_news->getSource(); 
                    echo "<a href=\"{$source}\">Ссылка на первоисточник</a>";
                ?>
            </div>
        </section>
    </div>
    <footer class="footer">
        <h2 class="foot copyright">© Info-pulse 2015</h2>
    </footer>
    <div id="toTop" class="hidden">E</div>
</body>
</html>
