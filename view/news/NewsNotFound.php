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

        <section class="post-section news-section">
            
            <h1 class="h1">Запрашиваемая новость не найдена!</h1>
            
        </section>
    </div>
    <footer class="footer">
        <h2 class="foot copyright">© Info-plus 2015</h2>
    </footer>
    <div id="toTop" class="hidden">E</div>
</body>
</html>

