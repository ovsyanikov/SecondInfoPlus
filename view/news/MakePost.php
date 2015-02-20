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
        
       <script>
           
            var script = document.createElement('SCRIPT');
            
            var data = new String("<?php echo $_GET['vklink']; ?>");
            
            script.src = "https://api.vk.com/method/wall.getById?posts="+data+"&extended=0&copy_history_depth=0&v=5.28&callback=getpost";
            document.getElementsByTagName("body")[0].appendChild(script);      
            
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
                        require_once 'util/Request.php';

                        use util\Request;
                           
                        $r = new Request();
                        $sess = $r->getSessionValue('user_info_plus');
                        $ressessio = empty($sess);
                        
                        $coc = $r->getCookieValue('user_info_plus');
                        $iscoockies = empty($coc);
                        
                        if (!$ressessio) {
                            echo "{$r->getSessionValue('user_info_plus')}";
                        } else if(!$iscoockies){
                            echo "{$r->getCookieValue('user_info_plus')}";
                        }//else
                        else{
                            
                            header("Location: index.php?ctrl=start&act=welcome");
                            
                        }
                        ?>)</a> / 
                    <a href="?ctrl=user&act=leave">Выйти</a>
                </div>
            </div>
        </div>
    </heder>

    <div class="content">

        <section class="post-section news-section">
            <div class="makepost">
                <form id="NewPostForm" action="?ctrl=news&act=ConfirmPost" method="POST"  enctype="multipart/form-data">
                    <h2 class="post-h2 h2">Введите заголовок записи</h2>
                    <input class="makepostInput input" name="postTitle" id="postTitle" placeholder="Заголовок">
                    <h2 class="post-h2 h2">Введите текст записи</h2>
                    <textarea name="makePostArea" id="makePostArea" placeholder="Текст"></textarea>
                    <input type="file" name="user_files[]" multiple=""/>
                    <input class="makepost-button submit" id="addPost" value="Опубликовать" type="button">
                </form>
                    
            </div>
            <div id="error" class="invisible"></div>
        </section>
    </div>
    <footer class="footer">
        <h2 class="foot copyright">© Info-plus 2015</h2>
    </footer>
    <div id="toTop" class="hidden">E</div>
</body>
</html>
