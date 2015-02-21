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
                    <a href="?ctrl=news&act=MyPosts"><li class="menu-li">МОИ ЗАПИСИ</li></a>
                </ul>

                <div class="personal">
                    <a href="?ctrl=user&act=MyProfile">Личный кабинет(<?php
                        echo "{$this->view->current_user->getLogin()}"
                        ?>)</a> / 
                    <a href="?ctrl=user&act=leave">Выйти</a>
                </div>
            </div>
        </div>
    </heder>



    <div class="content">

        <section class="post-section news-section">
            
            <div id="newsContent">
                <div class="post">
                    <?php 
                        echo "<h2 class=\"post-h2 h2\">{$this->view->specific_news->getTitle()}</h2><br />";
                        $img_files = $this->view->specific_news->getFiles();
                        $imges = explode(',',$img_files);
                        
                        $img_count = count($imges);
                        
                        if($img_count != 0){
                            $i = 0;
                            
                            foreach ($imges as $image){
                                
                                if($i != $img_count-1){
                                    echo "<img class=\"specificIMG\" src=\"files/$image\" alt=\"\"/>";
                                }//if
                                
                                $i++;
                                
                            }//foreach
                            
                            
                        }//if not empty images
                        
                        echo "<p class=\"post-text\">{$this->view->specific_news->getDescription()}</p>";
                        
                    ?>
                </div>
            </div>
        </section>
    </div>
    <footer class="footer">
        <h2 class="foot copyright">© Info-plus 2015</h2>
    </footer>
    <div id="toTop" class="hidden">E</div>
</body>
</html>
