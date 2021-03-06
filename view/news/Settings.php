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

    <body id="body" class="news-bg"> 
    <heder>
        <div class="top-head">
            <div class="content">
                <a href="?ctrl=news&act=news"><div class="logo">
                    <img src="img/info-puls1.png" alt="">
                    <h1 class="logo-h1">PULSE</h1>
                </div></a>
                <div class="div-menu">
                    <ul class="menu">
                        <a href="?ctrl=news&act=news"><li class=" menu-li">ГЛАВНАЯ</li></a>
                        <a href="?ctrl=news&act=Districts"><li class="active menu-li">РАЙОНЫ</li></a>
                        <a href="?ctrl=news&act=MyTasks"><li class="menu-li">ЗАДАЧИ</li></a>
                        <a href=""><li class="menu-li">УЧАСНИКИ</li></a>
                        <a href="?ctrl=news&act=MyPosts"><li class=" menu-li">МОИ ЗАПИСИ</li></a>
                    </ul>

                    <div class="search">
                        <input id="search" type="search" class="isearch" placeholder="Поиск">
                        <span class="search-icon">A</span>
                    </div>
                    <img src="img/loader2.gif" alt="" id="loader" class="hide loader">
                </div>
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
                        
        <h1 class="h1">Лента новостей</br>Найдено новостей - <span id="count">0</span></h1>
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

        <h1 class="h1">Список всех районов и стоп-слов:</h1>
        <div id="DistrictSectionConfirm">
            <h2 class="srch-h2 pers-h2 h2">Добавить район</h2><input id="NewDistrict" name="Stop_word_inp" type="text" class="srch_panel pers-input" placeholder="Введите новый район"><span id="AddNewDistrictSettings" class="srch_ok ok" title="Подтвердить изменения">N</span>
        </div>
        <div id="StopWordSectionConfirm">
            <h2 class="srch-h2 pers-h2 h2">Добавить стоп-слова</h2><input id="NewStopWord" name="Stop_word_inp" type="text" class="srch_panel pers-input" placeholder="Введите новый район"><span id="AddStopWordSettings" class="srch_ok ok" title="Подтвердить изменения">N</span>
        </div>

        <div id="search-panel" class="post">
            <form id="start_search_news" method="POST" action="?ctrl=news&act=getNewsByStopWords">
                <div id="districts" class="chng_distr">
                    <?php

                    require_once 'util/Request.php';
                    use util\Request;
                    $r = new Request();
                    $cd = $r->getSessionValue('currecnt_district');
                    ?>
                    <ul id="districts_order" class="chng_distr_div">
                        <li class="tit chng_distr_li">Районы</li>
                        <?php   
                            foreach ($this->view->districts as $district){
                                echo "<div><li data-district-id=\"{$district->getId()}\" class=\"chng_distr_li\">{$district->getTitle()}<span class=\"chng_distr_correct correct\" title=\"Изменить\">M</span></li>";
                                echo "<div class=\"hg_null\"><input id=\"\" type=\"text\" class=\"chng_distr_inp pers-input\" placeholder=\"Редактирование района\">"
                                    . "<span id=\"ConfirmName\" class=\"dis chnd_distr_ok ok\" title=\"Подтвердить изменения\">N</span></div></div>";

                            }//foreach
                        ?>               
                    </ul>
                    <ul id="StopWordsOrder" class="chng_distr_div">
                        <li class="tit chng_distr_li">Cтоп-слова</li>
                        <?php   
                            foreach ($this->view->stop_words as $stopWord){
                                echo "<div><li data-stop-id=\"{$stopWord->getId()}\" class=\"chng_distr_li\">{$stopWord->getWord()}<span class=\"chng_distr_correct correct\" title=\"Изменить\">M</span></li>";
                                echo "<div class=\"hg_null\"><input id=\"\" type=\"text\" class=\"chng_distr_inp pers-input\" placeholder=\"Редактирование стоп слова\">"
                                    . "<span class=\"chnd_distr_ok ok\" title=\"Подтвердить изменения\">N</span></div></div>";
                                
                            }//foreach
                        ?>               
                    </ul>
                </div>
            

            </form>   


    
        </div>  
    </section>
    </div>
    <footer class="footer">
        <h2 class="foot copyright">© Info-pulse 2015</h2>
    </footer>
    <div id="toTop" class="hidden">E</div>
</body>

</html>
