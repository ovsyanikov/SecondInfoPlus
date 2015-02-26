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
        <script>
                        //DEFAULT_SEARCH();
                for(i = 0;i < 3;i++){
                    if(i==0){
                        LoaderOn();
                        
                    }
                    if(i==1){
                        DEFAULT_SEARCH();
                    }

                }    
                    

        </script>
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
                <img src="img/loader.gif" alt="" id="loader" class="show loader">
            </div>
        </div>
        <div class="bottom-head">
            <div class="content">
                <ul class="menu">
                    <a href="?ctrl=news&act=news"><li class="active menu-li">ГЛАВНАЯ</li></a>
                    <a href="?ctrl=news&act=Districts"><li class="menu-li">РАЙОНЫ</li></a>
                    <a href="?ctrl=news&act=MyTasks"><li class="menu-li">ЗАДАЧИ</li></a>
                    <a href=""><li class="menu-li">УЧАСНИКИ</li></a>
                    <a href="?ctrl=news&act=MyPosts"><li class="menu-li">МОИ ЗАПИСИ</li></a>
                </ul>

                <div class="personal">
                    <a href="?ctrl=user&act=MyProfile">Личный кабинет(<?php
                        require_once 'util/Request.php';

                        use util\Request;
                           
                        $r = new Request();
                        $sess = $r->getSessionValue('user_info_plus');
                        $ressessio = empty($sess);
                        
                        $cookie_pass = $r->getCookieValue('user_info_plus');
                        $iscoockies = empty($cookie_pass);
                        
                        if(!$iscoockies){
                            
                            $decode = htmlspecialchars_decode($_COOKIE['user_info_plus']);
                            $pass = (explode(';',$decode)[1]);
                            if($pass == $this->view->current_user->getPassword()){
                                echo (explode(';',$decode)[0]);
                            }//if
                            else{
                                header("Location: index.php?ctrl=start&act=welcome");
                            }//else
                            
                        }//if
                        else if (!$ressessio) {
                            
                            $db_user_pass = $this->view->current_user->getPassword();
                            $user_pass = (explode('|',$r->getSessionValue('user_info_plus'))[1]);
                            
                            if($db_user_pass != $user_pass){
                                $r->unsetSeesionValue('user_info_plus');
                                header("Location: index.php?ctrl=start&act=welcome");
                            }//if
                            else{
                                $user_login = (explode('|',$r->getSessionValue('user_info_plus'))[0]);
                                echo "$user_login";
                            }//else
                            
                        }
                        else{
                            
                            header("Location: index.php?ctrl=start&act=welcome");
                            
                        }//else
                        
                        ?>)</a> / 
                    <a href="?ctrl=user&act=leave">Выйти</a>
                </div>
            </div>
        </div>
    </heder>

    <div class="content">
        <aside class="sidebar">
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
        <section class="news-section" id="news-section">
            <div class="top-3">
                <img src="img/moscow_1.jpg" alt="">
            </div>
            <h1 class="h1">Все новости по дате</h1>
            <div id="newsContent">
                
            </div>
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
