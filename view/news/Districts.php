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


                <h2 class="h2">Для начала поиска выберите район</h2>             

<!--                <div id="DistrictSectionConfirm">
                    <h2 class="srch-h2 pers-h2 h2">Добавить район</h2><input id="NewDistrictTitle" name="Distr_inp" type="text" class="srch_panel pers-input" placeholder="Введите новый район"><span id="AddDistrict" class="srch_ok ok" title="Подтвердить изменения">N</span>
                </div>

                <div id="StopWordSectionConfirm">
                    <h2 class="srch-h2 pers-h2 h2">Добавить стоп слово</h2><input id="NewStopWord" name="Stop_word_inp" type="text" class="srch_panel pers-input" placeholder="Введите новое стоп-слово"><span id="AddStopWord" class="srch_ok ok" title="Подтвердить изменения">N</span>
                </div>-->
                    <a href="?ctrl=news&act=Setting"><input class="distr-button submit mr" id="" value="Редактировать" type="button"></a>
                    <input class="distr-button submit " id="search_news_by_stop_words" value="Найти" type="button">

                <form id="start_search_news" method="POST" action="?ctrl=news&act=getNewsByStopWords">
                    <div id="districts" class="selectDistrict">
                        <?php
                        
                        require_once 'util/Request.php';
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
                        
                        <ul class="district">
                            <?php   
                                
                                $cnt = round(count($this->view->districts)/2);
                                $i = 0;
                                foreach ($this->view->districts as $district){
                                    echo "<li data-district-id = \"{$district->getId()}\">{$district->getTitle()}</li>";
                                    $i++;
                                    if($i == $cnt){break;}
                                }//foreach
                            ?>               
                        </ul>
                        <ul class="district">
                            <?php
                                $i=0;
                                foreach ($this->view->districts as $district){
                                    if($i>=$cnt)
                                    {
                                        echo "<li data-district-id = \"{$district->getId()}\">{$district->getTitle()}</li>";
                                    }
                                    $i++;
                                }//foreach
                            ?>               
                        </ul>

                    </div>
                    <div id="stopWords" class="right selectDistrict">
                        <input style="display: none" id="District" name="District" />
                        <h2 class="h2-distr">Стоп-слова</h2>
                        <ul class="district">
                            <?php   
                                $cnt = round(count($this->view->stop_words)/2);
                                $i = 0;                            
                                foreach ($this->view->stop_words as $stop_word){
                                    echo "<li data-district-id = \"{$stop_word->getId()}\">{$stop_word->getWord()}</li>";
                                    $i++;
                                    if($i == $cnt){
                                        break;
                                    }
                                }//foreach
                            ?>               
                        </ul>
                        <ul class="district">
                            <?php
                                $i=0;
                                foreach ($this->view->stop_words as $stop_word){
                                    if($i>=$cnt){
                                        echo "<li data-district-id = \"{$stop_word->getId()}\">{$stop_word->getWord()}</li>";
                                    }
                                    $i++;
                                }//foreach
                            ?>               
                        </ul>

                    </div>
                </form>       

            </div>
        </div>
        <div id="newsContent">
        </div>
            <input class="My-posts-button submit" style="display: none" id="more_news_by_stop_words" value="Следующие новости" type="button">
    </section>
    </div>
    <footer class="footer">
        <h2 class="foot copyright">© Info-pulse 2015</h2>
    </footer>
    <div id="toTop" class="hidden">E</div>
</body>

</html>
