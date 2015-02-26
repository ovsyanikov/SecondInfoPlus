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
                        <a href=""><li class="menu-li">ЗАДАЧИ</li></a>
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
                    <form id="start_search_news" method="POST" action="?ctrl=news&act=getNewsByStopWords">
                        <h2 class="h2">Введите стоп слова, разделяя их запятыми, и выберите район:</h2>  
                    <textarea id="stop_words" name="stop_words" class="stop-area" placeholder="Стоп слова"></textarea>
                    
                    <div class="selectDistrict">
                        <input style="display: none" id="District" name="District" />
                        <h2 class="h2-distr">Выберите район</h2>
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
                        <ul class="district">
                            <?php   
                                foreach ($this->view->districts as $district){
                                    echo "<li data-district-id = \"{$district->getId()}\">{$district->getTitle()}</li>";
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

                                $d_title = $one_news->getTitle();
                                if(strlen($d_title)>100){
                                    $d_title = substr($d_title, 0, 100);
                                    $d_title .= '...';
                                }

                                $d_description = $one_news->getDescription();
                                if(strlen($d_description)>500){
                                    $d_description = substr($d_description, 0, 500);
                                    $d_description .= '...';
                                }
                                $d_id = $one_news->getId();
                                
                                $image = $one_news->getImage();
                                if(!empty($image)){

                                    
                                    echo "<div class=\"post\"><img class=\"post-img\" alt=\"\" src=\"{$one_news->getImage()}\"/><a href=\"?ctrl=news&act=SpecificPostHome&id={$d_id}\"><h2 class=\"post-h2 h2\">{$d_title}</h2></a><p class=\"post-text\">{$d_description}</p></div>";
                                }
                                else{
                                    echo "<div class=\"post\"><a href=\"?ctrl=news&act=SpecificPostHome&id={$d_id}\"><h2 class=\"post-h2 h2\">{$d_title}</h2></a><p class=\"post-text\">{$d_description}</p></div>";
                                }
                            
                            }//foreach
                            
                        }//foreach
                        
                    }//if
                    
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
