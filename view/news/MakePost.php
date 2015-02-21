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
    <?php
    
        require_once 'util/HTMLCOMPONENTS.php';
        use util\HTMLCOMPONENTS;
        
        $hc = new HTMLCOMPONENTS();
        $hc->GetHeader();
        
    ?>

    <div class="content">
       <?php        
           $hc->GetLeftBar($this->view->current_user);
       ?>
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
