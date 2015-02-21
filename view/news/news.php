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
