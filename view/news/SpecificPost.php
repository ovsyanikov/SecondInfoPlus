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
            
            <div id="newsContent">
                <div class="post">
                    
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
