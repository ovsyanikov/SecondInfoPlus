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
    <script>
        StartAllServices();
    </script>


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
        <div class="srch">
            <h1 class="h1">Панель поиска <span id="minimize" title="Скрыть панель">─</span></h1>
            <div id="search-panel" class="post">

                <h2 class="h2">Введите стоп слова, разделяя их запятыми, и выберите район:</h2>  

                <div id="DistrictSectionConfirm">
                    <h2 class="srch-h2 pers-h2 h2">Добавить район</h2><input id="NewDistrictTitle" name="Distr_inp" type="text" class="srch_panel pers-input" placeholder="Введите новый район"><span id="AddDistrict" class="srch_ok ok" title="Подтвердить изменения">N</span>
                </div>

                <div id="StopWordSectionConfirm">
                    <h2 class="srch-h2 pers-h2 h2">Добавить стоп слово</h2><input id="NewStopWord" name="Stop_word_inp" type="text" class="srch_panel pers-input" placeholder="Введите новое стоп-слово"><span id="AddStopWord" class="srch_ok ok" title="Подтвердить изменения">N</span>
                </div>

                <form id="start_search_news" method="POST" action="?ctrl=news&act=getNewsByStopWords">
                    <div id="districts" class="selectDistrict">
                        <?php
                                        require_once 'util\Request.php';
                                        use util\Request;
                                        $r = new Request();
                                        $cd = $r->getSessionValue('currecnt_district');
                                        
                        if(isset($cd)){
                            echo "<h2 class=\"h2-distr\">$cd</h2>";
                        }//else
                        else{
                            echo "<h2 class=\"h2-distr\">Районы</h2>";
                        }//else
                        ?>
                        
                        <input id="" name="Stop_word_inp" type="text" class="srch_panel_srch pers-input" placeholder="Поиск по районам">
                        <ul class="district">
                            <?php   
                                foreach ($this->view->districts as $district){
                                    echo "<li data-district-id = \"{$district->getId()}\">{$district->getTitle()}</li>";
                                }//foreach
                            ?>               
                        </ul>
                        <ul class="district">
                            <?php   
                                foreach ($this->view->districts as $district){
                                    echo "<li data-district-id = \"{$district->getId()}\">{$district->getTitle()}</li>";
                                }//foreach
                            ?>               
                        </ul>

                    </div>
                    <div id="stopWords" class="selectDistrict">
                        <input style="display: none" id="District" name="District" />
                        <h2 class="h2-distr">Стоп-слова</h2>
                        <input id="" name="Stop_word_inp" type="text" class="srch_panel_srch pers-input" placeholder="Поиск по стоп-словам">
                        <ul class="district">
                            <?php   
                                foreach ($this->view->stop_words as $stop_word){
                                    echo "<li data-district-id = \"{$stop_word->getId()}\">{$stop_word->getWord()}</li>";
                                }//foreach
                            ?>               
                        </ul>
                        <ul class="district">
                            <?php   
                                foreach ($this->view->stop_words as $stop_word){
                                    echo "<li data-district-id = \"{$stop_word->getId()}\">{$stop_word->getWord()}</li>";
                                }//foreach
                            ?>               
                        </ul>

                    </div>
                    <input class="distr-button submit" id="search_news_by_stop_words" value="Найти" type="button">
                </form>       
            </div>
        </div>
        <div id="newsContent">
            <?php

                if(is_array($this->view->finded_news)){

                    foreach($this->view->finded_news as $news){

                        foreach($news as $one_news){
                            echo "<div class=\"post\">";   
                            $d_title = $one_news->getTitle();

                            if(strlen($d_title)>100){
                                $d_title = iconv_substr($title,0, 100, 'UTF-8');
                                $d_title .= '...';
                            }

                            $d_description = $one_news->getDescription();
                            if(strlen($d_description)>500){

                                $d_description = iconv_substr($d_description,0, 500, 'UTF-8');
                                $d_description .= '...';
                            }
                            $d_id = $one_news->getId();
                            $date = date("D H:i:s",$one_news->getDate());
                            $ch_social = $one_news->getSource();   

                            $image = $one_news->getImage();
                            if(strripos($ch_social,'twitter') != false){
                                echo "<a href=\"$ch_social\" title=\"Ссылка на первоисточник\"><span  class=\"twitter post-icon\">R</span></a>";
                            }
                            if(strripos($ch_social,'vk') != false){
                                echo "<a href=\"$ch_social\" title=\"Ссылка на первоисточник\"><span  class=\"vk post-icon\">Q</span></a>";
                            }                                 
                            echo "<span  class=\"post-date2\" title=\"Время публикации\">$date</span>";
                            if(!empty($image)){
                                echo "<img class=\"post-img\" alt=\"\" src=\"{$one_news->getImage()}\"/>";
                            }

                            echo "<a href=\"?ctrl=news&act=SpecificPostHome&id={$d_id}\"><h2 class=\"post-h2 h2\">{$d_title}</h2></a>"
                            . "<p class=\"post-text\">{$d_description}</p></div>";
                            echo "";
                        }//foreach

                    }//foreach

                }//if

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
