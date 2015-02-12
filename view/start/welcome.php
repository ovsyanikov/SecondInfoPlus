<!doctype html>
<html>
<head>
	<meta charset="utf-8">
    
        <link rel="stylesheet" href="css/style.css">
        <link rel="shortcut icon" href="img/info-puls.png">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
        
	<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.0.min.js"></script> 
        <script type="text/javascript" src="js/script.js"></script> 
    
	<title>Info-Plus</title>

</head>
<body> 
    <section>
		<div class="block" id="authentication">
            <form action="?ctrl=user&act=authorize" method= "POST">
                <input class="input" name="e-mail" placeholder="Введите e-mail или логин пользователя">
                <input class="input" name="password" placeholder="Пароль" id="pass">
                <input class="submit" value="Войти" type="submit">
                <input type="checkbox" name="remember_me" class="checkbox"><span class="span">Запомнить /</span>
                <span class="span getnewpass"><a href=""> Забыли пароль?</a></span>
            </form>	
                    <h1>Hello!</h1>
        </div>
        <div class="block" id="registration">
        	<h1 class="h1-form">Еще не зарегестрированы?</h1>
            <form method= "POST">
                
                <input class="input" name="e-mail" placeholder="Имя пользователя">
                <input class="input" name="e-mail" placeholder="E-mail">
                <input class="input" name="e-mail" placeholder="Пароль" id="pass">
                <input class="submit" value="Регистрация" type="submit">

            </form>	
        </div> 
        
    </section>
</body>
</html>