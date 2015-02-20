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
                    <a href="">Личный кабинет(<?php
                        echo "{$this->view->current_user->getLogin()}"
                        ?>)</a> / 
                    <a href="?ctrl=user&act=leave">Выйти</a>
                </div>
            </div>
        </div>
    </heder>



    <div class="content">

        <section class="post-section news-section">
            <div class="personal-block">
                <h1 class="pers-title-h1 h1">Личный кабинет</h1>
                <div><h2 class="pers-h2 h2">Логин</h2><p class="pers-text" id="login"><?php echo"{$this->view->current_user->getLogin()}" ;?></p></div>
                <div id="emailSection">
                    <h2 class="pers-h2 h2">E-mail</h2><p class="pers-text" id="email"><?php echo"{$this->view->current_user->getEmail()}"; ?><span class="correct" title="Изменить">M</span></p>
                    <div class="pers-input-block">
                        <form id="ChangeEmail">
                            <input id="NewMailInPersonal" name="NewMailInPersonal" type="text" class="pers-input" placeholder="Введите новый e-mail">
                            <span id="ConfirmEmail" class="ok" title="Подтвердить изменения">N</span>
                        </form>
                    </div>
                </div>
                <div id="PasswordSection" ><h2 class="pers-h2 h2">Пароль</h2><p class="pers-text" id="password">******<span class="correct" title="Изменить">M</span></p>
                    
                        <div class="pers-input-block password-chng">
                            <input id="CurrentPassword" type="password" class="pers-input" placeholder="Введите текущий пароль">
                            <input id="FirstPassword" type="password" class="pers-input" placeholder="Введите новый пароль">
                            <input  id="SecondPassword" type="password" class="pers-input" placeholder="Повторите новый пароль">
                            <span id="ConfirmPassword" class="ok" title="Подтвердить изменения">N</span>
                        </div>

                
                </div>

                <div id="FirstNameSection"><h2 class="pers-h2 h2">Имя</h2><p class="pers-text" id="FirstName"><?php echo"{$this->view->current_user->getFirstName()}"; ?><span class="correct" title="Изменить">M</span></p>
                    <div class="pers-input-block">
                        <input id="NewFirstName" type="text" class="pers-input" placeholder="Введите новое имя">
                        <span id="ConfirmName" class="ok" title="Подтвердить изменения">N</span>
                    </div>

                </div>
                
                <div id="LastNameSection"><h2 class="pers-h2 h2">Фамилия</h2><p class="pers-text" id="LastName"><?php echo"{$this->view->current_user->getLastName()}";?><span class="correct" title="Изменить">M</span></p>
                                    <div class="pers-input-block">
                        <input id="NewLastName" type="text" class="pers-input" placeholder="Введите новую фамилию">
                        <span id="ConfirmLastName" class="ok" title="Подтвердить изменения">N</span>
                    </div>

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
