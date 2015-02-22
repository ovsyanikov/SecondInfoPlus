if (!window.jQuery) {
    msg = 'Не загружен JQUERY';
    alert(msg);
}

function ShowAuthorizeMessage(message){
    
    var inp_class = $('#error_lp').attr("class");
    
    if(inp_class != 'error_block'){
        
        $('#authentication').animate({height: $('#authentication').height()+20},500);
        $('#error_lp').removeClass('invisible');
        $('#error_lp').addClass('error_block');

        $('#error_lp').text(message);
        
    }//if
    else{
        
        $('#error_lp').text(message);
        
    }
    
    
}//ShowAuthorizeMessage

function ShowRegisterMessage(message){
    
    var inp_class = $('#error').attr("class");
    
    if(inp_class != 'error_block'){
        
        $('#registration').animate({height: $('#registration').height()+20},500);
        $('#error').removeClass('invisible');
        $('#error').addClass('error_block');

        $('#error').text(message);
        
    }//if
    else{
        
        $('#error').text(message);
        
    }
    
    
}//ShowAuthorizeMessage

function ShowPostMessage(message){
    
    var inp_class = $('#error').attr("class");
    
    if(inp_class != 'error_block2'){
        
        $('section').animate({height: $('section').height()+20},500);
        $('#error').removeClass('invisible');
        $('#error').addClass('error_block2');
        $('#error').text(message);
        
    }//if
    else{
        
        $('#error').text(message);
    }
    
}

function LoaderOn(){
    $('body').css({cursor:"progress"});
    $('#loader').removeClass('hide');     
    $('#loader').addClass('show');
    
}

function LoaderOff(){
    $('body').css({cursor:"default"});
     $('#loader').removeClass('show');
     $('#loader').addClass('hide');
    
}

 function DEFAULT_SEARCH(){
     
     
     var script = document.createElement('SCRIPT');
     script.src = "https://api.vk.com/method/newsfeed.search?q=&extended=0&count=100&v=5.28&callback=callbackFunc";
     
     
     document.getElementsByTagName("body")[0].appendChild(script); 
     
 }
 
 function SEARCH(){
            
            var script = document.createElement('SCRIPT');

            script.src = "https://api.vk.com/method/newsfeed.search?q="+$('#search').val()+"&extended=0&count=100&v=5.28&callback=callbackFunc";
            
            document.getElementsByTagName("body")[0].appendChild(script);   
            
 }           
 
function getpost(response){

     if(response.response[0].text){
              
         title = new String(response.response[0].text);
         
         if(title.length > 100){
             
             title = (title.substr(0,100) + "...");
             
         }
         $("div.post").append("<h2 id=\"postTitle\" class=\"post-h2 h2\">"+title+"</h2>");
         
     }
     
     try{
         
         if(response.response[0].attachments[0].photo){//image equals
         if(response.response[0].attachments[0].photo.photo_1280){
             
             $("div.post").append("<div class=\"top-3\"><img id=\"post_image\" src=\""+response.response[0].attachments[0].photo.photo_1280+"\" alt=\"\"></div>");
             
         }//if
         else if(response.response[0].attachments[0].photo.photo_604){
             $("div.post").append("<div class=\"top-3\"><img id=\"post_image\" src=\""+response.response[0].attachments[0].photo.photo_604+"\" alt=\"\"></div>");
         }//if
         
         
         
     }//if
         
     }catch (ex){}
     
     try{
        
         if(response.response[0].attachments[0].video){
            
            videos_ids = new String(response.response[0].attachments[0].video.owner_id + "_" + response.response[0].attachments[0].video.id);
            if(response.response[0].attachments[0].video.photo_1280){
                
                $("div.post").append("<a href=\"http://vk.com/video"+videos_ids+"\" ><img src=\""+response.response[0].attachments[0].video.photo_1280+"\" alt=\"\"/></a>");
                
            }
            else if(response.response[0].attachments[0].video.photo_640){
                
                $("div.post").append("<a href=\"http://vk.com/video"+videos_ids+"\" ><img src=\""+response.response[0].attachments[0].video.photo_640+"\" alt=\"\"/></a>");
                
            }
            else if(response.response[0].attachments[0].video.photo_800){
                $("div.post").append("<a href=\"http://vk.com/video"+videos_ids+"\" ><img src=\""+response.response[0].attachments[0].video.photo_800+"\" alt=\"\"/></a>");
            }
            else if(response.response[0].attachments[0].video.photo_320){
                $("div.post").append("<a href=\"http://vk.com/video"+videos_ids+"\" ><img src=\""+response.response[0].attachments[0].video.photo_320+"\" alt=\"\"/></a>");
            }
            else if(response.response[0].attachments[0].video.photo_130){
                $("div.post").append("<a href=\"http://vk.com/video"+videos_ids+"\" ><img src=\""+response.response[0].attachments[0].video.photo_130+"\" alt=\"\"/></a>");
            }
            else{
                $("div.post").append("<a href=\"http://vk.com/video"+videos_ids+"\" >Посмотреть видео</a>");
            }
            
         }//if
         
     }catch(ex){
        
     }
     
     
     
     $("div.post").append("<p id=\"postContent\" class=\"post-text\">"+response.response[0].text+"</p>");
         
     is_group = new String(response.response[0].from_id);
     is_id = new String(response.response[0].id);     
     $('#newsContent').append("<a href=\"http://vk.com/feed?w=wall"+is_group+"_"+is_id+"\">Ссылка на первоисточник</a>");
     
     
 }
 
function WorkLoader(){
     
     if($('#loader').hasClass('hide') || $('#loader').hasClass('show')){
         
         if($('#loader').hasClass('hide')){
         
            $('#loader').removeClass('hide');     
            $('#loader').addClass('show');

         }
         else{

              $('#loader').removeClass('show');
              $('#loader').addClass('hide');

         }
     }
     
        
 }
 
function callbackFunc(result) {

                                       
                    $('#newsContent').empty();
                    $("section").append("<div id=\"newsContent\"></div>");
   
                    for(i = 0;i < result.response.items.length;i++){
                        
                        
                        is_group = new String(result.response.items[i].from_id);
                        
                        if(is_group.indexOf('-') != -1){
                            
                            news_id = result.response.items[i].id;
                            
                            if(result.response.items[i].text != ""){
                            
                            title = new String(result.response.items[i].text.split('.')[0]);
                            
                            if(title.length > 100){
                                
                                title = (title.substr(0,100)+"...");
                                
                            }//if
                            
                            
                            description = new String(result.response.items[i].text);
                            
                            if(description.length > 500){
                                
                                description = (description.substr(0,500) + "...");
                                
                            }//if
                            
                            if(result.response.items[i].attachments){
                                    
                                    try{
                                        
                                        if(result.response.items[i].attachments[0].video){

                                                title = (title + "(Есть видео)");

                                        }//if
                                        
                                    }catch(ex){
                                        
                                        console.writeln(ex);
                                        
                                    }
                                    
                                    
                                if(result.response.items[i].attachments[0].photo){
                                    
                                    $('#newsContent').append("<div class=\"post\"><img class=\"post-img\" alt=\"\" src=\""+result.response.items[i].attachments[0].photo.photo_130+"\"/><a href=\"?ctrl=news&act=SpecificPost&vklink="+is_group+"_"+news_id+"\"><h2 class=\"post-h2 h2\">"+title+"</h2></a><p class=\"post-text\">"+description+"</p></div>");
                                    
                                        
                                }//if
                                
                                else{
                                    
                                    $('#newsContent').append("<div class=\"post\"><a href=\"?ctrl=news&act=SpecificPost&vklink="+is_group+"_"+news_id+"\"><h2 class=\"post-h2 h2\">"+title+"</h2></a><p class=\"post-text\">"+description+"</p></div>");
                                    
                                }//else
                                
                            }//if
                            
                            else{
                                $('#newsContent').append("<div class=\"post\"><a href=\"?ctrl=news&act=SpecificPost&vklink="+is_group+"_"+news_id+"\"><h2 class=\"post-h2 h2\">"+title+"</h2></a><p class=\"post-text\">"+description+"</p></div>");
                            }//else
                            
                        }//if
                        
                        }//true
                        
                    if(i == result.response.items.length-1){
                        LoaderOff();
                    }    
                        
                    }//for
                        
                    if($('#newsContent').children().length == 0){
                        
                        $('section div.h1').remove();
                        $("section").append("<div class=\"h1\" id=\"newsContent\">Новости по данному запросу не найдены</div>");
                        
                    }//if
                    
                       
}//callback

function ShowPersonalRoomMessage(controll,message,type){
    

    
    if(type == "success"){
        
        $("#" + $(controll).attr('id')).children(".pers-error").remove();
        
        if($("#" + $(controll).attr('id')).children().last().attr("class") == "pers-success"){
            $("#" + $(controll).attr('id')).children().last().html("<h2 class=\"h2\">"+message+"</h2>");
        }
        
        else{
            $("#" + $(controll).attr('id')).append("<div class=\"pers-success\"><h2 class=\"h2\">"+message+"</h2></div>");
        }//else
         
    }//if
    else{
        
        $("#" + $(controll).attr('id')).children(".pers-success").remove();
        
        if($("#" + $(controll).attr('id')).children().last().attr("class") == "pers-error"){
            $("#" + $(controll).attr('id')).children().last().html("<h2 class=\"h2\">"+message+"</h2>");;
        }//if
        else {
            $("#" + $(controll).attr('id')).append("<div class=\"pers-error\"><h2 class=\"h2\">"+message+"</h2></div>");
        }//else
        
       
    }//if
}

function GetPostByStopWord(result){
    
        
        
        words = new String( $("#stop_words").val() );
        
        delimers_words = words.split(',');
        
        for(i = 0;i < result.response.items.length;i++){
            
                        is_group = new String(result.response.items[i].from_id);
                        
                        if(is_group.indexOf('-') != -1){
                            
                            news_id = result.response.items[i].id;
                            
                            if(result.response.items[i].text != ""){
                                
                                record_text = new String(result.response.items[i].text);
                                
                                for(j = 0; j < delimers_words.length; j++){
                                    if(record_text.indexOf(delimers_words[j]) != -1){//если запись содержит стоп слово
                                            title = new String(result.response.items[i].text.split('.')[0]);
                                        if(title.length > 100){
                                            title = (title.substr(0,100)+"...");
                                        }//if
                                            description = new String(result.response.items[i].text);
                                        if(description.length > 500){
                                            description = (description.substr(0,500) + "...");
                                        }//if
                                        if(result.response.items[i].attachments){   
                                                try{
                                                    if(result.response.items[i].attachments[0].video){
                                                            title = (title + "(Есть видео)");
                                                    }//if
                                                }catch(ex){
                                                    console.writeln(ex);
                                                }//catch
                                            if(result.response.items[i].attachments[0].photo){
                                                $('#newsContent').append("<div class=\"post\"><img class=\"post-img\" alt=\"\" src=\""+result.response.items[i].attachments[0].photo.photo_130+"\"/><a href=\"?ctrl=news&act=SpecificPost&vklink="+is_group+"_"+news_id+"\"><h2 class=\"post-h2 h2\">"+title+"</h2></a><p class=\"post-text\">"+description+"</p></div>");             
                                            }//if   

                                            else{
                                                $('#newsContent').append("<div class=\"post\"><a href=\"?ctrl=news&act=SpecificPost&vklink="+is_group+"_"+news_id+"\"><h2 class=\"post-h2 h2\">"+title+"</h2></a><p class=\"post-text\">"+description+"</p></div>");
                                            }//else  

                                        }//if
                                        else{
                                            $('#newsContent').append("<div class=\"post\"><a href=\"?ctrl=news&act=SpecificPost&vklink="+is_group+"_"+news_id+"\"><h2 class=\"post-h2 h2\">"+title+"</h2></a><p class=\"post-text\">"+description+"</p></div>");
                                        }//else
                                    
                            }//if содержить стоп слово
                        }//Перебор всех стоп-слов
                                
                            
                            
         }//if res.response
                            
                        }//true
                        if(i == result.response.items.length-1){
                            LoaderOff();
                            $("#search_news_by_stop_words").blur();
                        }//if  
                        
                    }//for
                    
        if($('#newsContent').children().length == 0){
             $('section div.h1').remove();
             $("section").append("<div class=\"h1\" id=\"newsContent\">Новости по данному запросу не найдены</div>");
        }//if   
        
}//GetPostByStopWord
$(function() {
        $(window).scroll(function() {
                if($(this).scrollTop() > 700) {
                        $('#toTop').removeClass("hidden");
                        $('#toTop').fadeIn();
                } else {
                        $('#toTop').fadeOut();
                }
                if($(this).scrollTop() > 650) {
                        $('aside.sidebar').css("display" , "none");
                        $('.news-section').css({margin : "auto", display : "block"});
                        //$('#news-section').css({display : "block"});
                        //$('#news-section').animate({ marginTop: 'auto', marginRight: 'auto', marginBottom: 'auto', marginLeft: 250},500);

                } else {
                        $('aside.sidebar').css({display : "inline-block"});
                        $('.news-section').css({margin : "10px 0px 0px 2px", display : "inline-block"});
                }
                });

                $('#toTop').click(function() {
                $('body,html').animate({scrollTop:0},800);
        });
});

$(document).ready(function(){
        
$("#search_news_by_stop_words").click(function(){
            
        LoaderOn();
        district = $("div.selectDistrict h2.h2-distr").text();
            
        if(district != 'Выберите район'){
                
                $("#newsContent div.post").remove();
                
                script = document.createElement('SCRIPT');
                
                script.src = "https://api.vk.com/method/newsfeed.search?q="+district+"&extended=0&count=200&v=5.28&callback=GetPostByStopWord";
                
                document.getElementsByTagName("body")[0].appendChild(script); 
                
            }//if
            else{//error
                alert("Не получен район");
            }//else
        });
        
        $("div.selectDistrict ul.district li").click(function(){
            
            $("div.selectDistrict h2.h2-distr").text($(this).text());
            
        });
        
        $fl = true;
        
        $("#minimize").click(function(){
            if($fl){
                $("#search-panel").fadeOut(200);
                $fl=false;
                $("#minimize").text('+');
            }
            else
            {
                $("#search-panel").fadeIn(200);
                $fl=true;
                $("#minimize").text('─');
            }
        });
        
        $("#ConfirmEmail").click(function(){
            
            if(!$("#NewMailInPersonal").val()){
                ShowPersonalRoomMessage($("#emailSection"),'Поле не может быть пустым','error');
            }//if
            else if($("#NewMailInPersonal").val().indexOf('@') == -1){
                ShowPersonalRoomMessage($("#emailSection"),'E-mail должен содержать символ @','error');
            }//if
            else{
                
                $.post("ajax.php",{EmailSuccess: 'set', NewPersonalMail: $("#NewMailInPersonal").val() , Owner:  $("#login").text()},function(data){
                    
                    if(data == "ok"){
                        ShowPersonalRoomMessage($("#emailSection"),'Изменения успешно внесены!','success');
                    }//if
                    else{
                        ShowPersonalRoomMessage($("#emailSection"),'Ошибка на сервере!','error');
                    }//else
                    
                });
                
            }//else
            
        });
        
        $("#ConfirmPassword").click(function(){
           
            if($("#CurrentPassword").val()){
                
                $.post("ajax.php",{CheckPassword: 'set', Owner: $("#login").text(), UserPassword: $("#CurrentPassword").val()},function(data){
                    if(data == "password_correct"){//Password is correct
                       
                       if($("#FirstPassword").val() && $("#SecondPassword").val()){//Not empty first pass and second pass
                           
                           if($("#FirstPassword").val() == $("#SecondPassword").val()){//Passwords equals
                               
                               if($("#FirstPassword").val().length > 6){//Pass length > 6
                                   
                                   $.post("ajax.php",{ChangePassword: 'set',NewPassword: $("#FirstPassword").val(), Owner: $("#login").text() },function(data){
                                       
                                       if(data == "ok"){
                                           ShowPersonalRoomMessage($("#PasswordSection"),'Пароль успешно изменен','success');
                                       }//if
                                       else{
                                           ShowPersonalRoomMessage($("#PasswordSection"),'Ошибка сервера','error');
                                       }//else
                                       
                                   });
                                   
                               }//if
                               else{
                                   ShowPersonalRoomMessage($("#PasswordSection"),'Длина нового пароля должна быть больше 6-ти символов','error');
                               }//else
                           }//if
                           else{
                               ShowPersonalRoomMessage($("#PasswordSection"),'Пароли не совпадают','error');
                           }//else
                       }//if
                       else{
                           ShowPersonalRoomMessage($("#PasswordSection"),'Заполните поля с новым паролем','error');
                       }//else
                       
                    }//if
                    else{
                        ShowPersonalRoomMessage($("#PasswordSection"),'Текущий пароль указан не верно','error');
                    }//else
                });//post
                
            }//if
            else{
                ShowPersonalRoomMessage($("#PasswordSection"),'Укажите текущий пароль пользователя','error');
            }//else
        });
        
        $("#ConfirmName").click(function(){
            
            if($("#NewFirstName").val()){
                
               $.post("ajax.php",{ChangeFirstName: 'set', Owner: $("#login").text(), NewFirstName: $("#NewFirstName").val()}, function(data){
                   
                   if(data == "ok"){
                       ShowPersonalRoomMessage($("#FirstNameSection"),'Имя успешно изменено','success');
                   }//if
                   else{
                       ShowPersonalRoomMessage($("#FirstNameSection"),'Ошибка сервера','error');
                   }
               });
            }//if
            else{
                ShowPersonalRoomMessage($("#FirstNameSection"),'Введите новое имя','error');
            }//else
            
        });
        
        $("#ConfirmLastName").click(function(){
            
            if($("#NewLastName").val()){
                
               $.post("ajax.php",{ChangeLastName: 'set', Owner: $("#login").text(), NewLastName: $("#NewLastName").val()}, function(data){
                   
                   if(data == "ok"){
                       ShowPersonalRoomMessage($("#LastNameSection"),'Фамилия успешно изменена','success');
                   }//if
                   else{
                       ShowPersonalRoomMessage($("#LastNameSection"),'Ошибка сервера','error');
                   }
               });
            }//if
            else{
                ShowPersonalRoomMessage($("#LastNameSection"),'Введите новую фамилию','error');
            }//else
            
        });
        
        var a = true; 
        
        $("span.correct").click(function(){
            if(a){
                
                if($(this).parent().next().hasClass("password-chng")){
                    $(this).parent().next().css({display: "block"}).animate({height: "144px"},300);
                }
                else{
                    $(this).parent().next().css({display: "block"}).animate({height: "48px"},200);
                }
                a = false;
            }
            else
            {
                
                if($(this).parent().next().hasClass("password-chng")){
                    $(this).parent().next().animate({height: "0px"},300);
                }
                else{
                    $(this).parent().next().animate({height: "0px"},200);
                }
                a = true;                
            }
        });
        
        window.onbeforeunload = function() {
            
            $("div.delete-post:contains(\"N\")").each(function(i,e){
               
               var post_id = $(this).data('post-id');
               
                $.post("ajax.php",{DeleteMyNews: 'set',post_id: post_id},function(data){
                
                  if(data == '1'){
                     
                    var el_count = $("div.delete-post").length;
                     
                     if(el_count == 0){
                         
                        $("#newsContent").append("<h2 class=\"post-h2 h2\" style=\"margin: 15px 0px\">У вас пока нет записей!</h2>");
                        
                     }//if
                     
                  }//if deleted succesful
                  
                  else {alert("Ошибка сервера! Не возможно удалить запись!data = " + data);}
                  
                });
                
            });
            
        };

        $("div.delete-post").click(function(){
            
            if($(this).text() == "J"){
                
                $(this).text("N");
                $(this).attr('title',"Восстановить");
                $(this).parent().animate({opacity: 0.5},200);
                
            }
            else{
                $(this).text("J");
                $(this).attr('title',"Удалить");
                $(this).parent().animate({opacity: 1},200);
                
            }
//            var post_id = $(this).data('post-id');
//            
//            $.post("ajax.php",{DeleteMyNews: 'set',post_id: post_id},function(data){
//                
//                  if(data == '1'){
//                      
//                     $("div.delete-post[data-post-id=\""+post_id+"\"]").parent().animate({opacity: 0.5},200);
//                     $("div.delete-post[data-post-id=\""+post_id+"\"]").next().attr("href","?ctrl=news&act=MyPosts");
//                     $("div.delete-post[data-post-id=\""+post_id+"\"]").remove();
//                     
//                     var el_count = $("div.delete-post").length;
//                     
//                     if(el_count == 0){
//                         
//                        $("#newsContent").append("<h2 class=\"post-h2 h2\" style=\"margin: 15px 0px\">У вас пока нет записей!</h2>");
//                        
//                     }//if
//                     
//                  }//if deleted succesful
//                  
//                  else {alert("Ошибка сервера! Не возможно удалить запись!");}
//                  
//            });
            
        });
        
        $("#addPost").click(function(){
            
            if($("#postTitle").val() && $("#makePostArea").val()){
                $("#NewPostForm").submit();
            }//if not empty post field
            else if($("#postTitle").val().length > 97){
                ShowPostMessage("Длина заголовка слишком велика!");
            }//else if
            else{
                ShowPostMessage("Поля не должны быть пустыми!");
            }
        });
        
        $("#search").keypress(function (e) {
               
                if (e.keyCode == 13) {

                for(i = 0;i < 3;i++){
                    if(i==0){
                        LoaderOn();
                        
                    }
                    if(i==1){
                        SEARCH();
                    }

                } 
                    
                }
                
        });
        
        $('#Authorise').click(function(){
          
        if ($('#userPS').val() && $('#userLE').val()){ //if not empty
                 
                $.post("ajax.php",
                {
                    authorize: 'set',
                    userLE: $('#userLE').val(),
                    userPS: $('#userPS').val()

                },function (data){
                    
                     if(data == "yes"){//
                         $('#AuthoriseForm').submit();
                     }//if
                     else{
                         ShowAuthorizeMessage('Неверный логин или пароль');
                         
                     }//else

                });
                
        }//end if empty
        else{
            
            ShowAuthorizeMessage('Есть пустые поля');
        }      
            
            
        });
        
        $('#register').click(function(){
            
           if($('#RLogin').val() && $('#RMail').val() && $('#RPass').val()){
               
               mail = new String($('#RMail').val());
               pass = new String($('#RPass').val());
               
               $.post("ajax.php",{
                   
                    fastregister: 'set',
                    userLogin: $('#RLogin').val(),
                    userEmail: $('#RMail').val()
               
                },function(data){
                    
               if(data == "used_login"){

                   ShowRegisterMessage('Такой логин уже есть');

               }//if
               else if(data == "used_email"){

                   ShowRegisterMessage('Такой email уже используется!');

               }//else if
               else if(mail.indexOf('@') == -1){

                   ShowRegisterMessage('Email должен содержать @');

               }//else if
               else if(pass.length < 7){

                   ShowRegisterMessage('Длина пароля слишком мала');

               }//else if
               else if(pass.length > 50){
                   ShowRegisterMessage('Длина пароля слишком велика');
               }//else if
               else if(data == "acc_free"){

                   $("#registerForm").submit();

               }//else if
               else{
                  ShowRegisterMessage('Server error');
               }//else
               
            }); 
            
           }//if not empty
           else{
               
               ShowRegisterMessage('Есть пустые поля!');
               
           }//else
            
        });
        
        $("#registerNewUser").click(function(){
            
            if($("#newUserLogin").val() && $("#newUserLogin").val().length < 50){
                
                
                $.post("ajax.php",{newUserLogin: $("#newUserLogin").val(), mainregister: 'set' },function(data){
                    
                    
                    if(data == "used_login"){
                        
                        ShowRegisterMessage('Указанный логин уже используется');
                        
                    }//if
                    else{
                            
                        if($("#newMail").val()){
                            
                            var mail = new String($("#newMail").val());

                            if(mail.indexOf('@') == -1){

                                ShowRegisterMessage('E-mail должен содержать @');

                            }//if
                            else{
                                
                                $.post("ajax.php",{
                                newUserLogin: $("#newUserLogin").val(),
                                newMail: $("#newMail").val(),
                                mainregister: 'set'
                            },function(data){
                                
                                if(data == "used_email"){

                                    ShowRegisterMessage('Указанный e-mail уже используется');

                                }//if
                                else if(!$("#userPS").val() || $("#userPS").val().length < 7 || $("#userPS").val() != $("#userPS2").val() ){
                                            ShowRegisterMessage('Пароли не совпадают или слишком малы');
                                }//else pass
                                else if(!$("#NewFirstName").val()){
                                    ShowRegisterMessage('Поле имя должно быть заполненно');
                                }//else

                                else if(!$("#NewLastName").val()){
                                    ShowRegisterMessage('Поле фамилия должно быть заполненно');
                                }//else
                                else{
                                    $("#registerForm").submit();
                                }//else ok
                            
                        });//post email
                                
                            }//else
                   
                 
            }//if email
            else{
                ShowRegisterMessage('Поле e-mail должно быть заполненно');
            }//else empty email 
                        
            }//else 
                           
                
            });//post.login
                
        }//if login
        else{
                
                ShowRegisterMessage('Поле логин должно быть заполненно');
                
        }//else empty login
            
            
        });//register click


});
