﻿if (!window.jQuery) {
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
 
function StartAllServices(){
     
     $.post("ajax.php",{GetCountOfNews: 'set'},function(ajax_data){
                 
        $('#count').text(ajax_data);        
     });
     
     setInterval(function(){
         
         $.post("cron_queries.php",{},function(cron_data){
            
             $.post("ajax.php",{GetCountOfNews: 'set'},function(ajax_data){
                 
                 $('#count').text(ajax_data);
                 
             });
             
         });
         
     },300000);
     
 }//StartAllServices
 
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
                            
                            date = result.response.items[i].date;
                            
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
                                    
                                    $('#newsContent').append("<div class=\"post\"><img class=\"post-img\" alt=\"\" src=\""+result.response.items[i].attachments[0].photo.photo_130+"\"/><a href=\"?ctrl=news&act=SpecificPost&vklink="+is_group+"_"+news_id+"\"><h2 class=\"post-h2 h2\">"+title+"</h2></a><p data-date="+date+" class=\"post-text\">"+description+"</p></div>");
                                    
                                        
                                }//if
                                
                                else{
                                    
                                    $('#newsContent').append("<div class=\"post\"><a href=\"?ctrl=news&act=SpecificPost&vklink="+is_group+"_"+news_id+"\"><h2 class=\"post-h2 h2\">"+title+"</h2></a><p data-date="+date+" class=\"post-text\">"+description+"</p></div>");
                                    
                                }//else
                                
                            }//if
                            
                            else{
                                $('#newsContent').append("<div class=\"post\"><a href=\"?ctrl=news&act=SpecificPost&vklink="+is_group+"_"+news_id+"\"><h2 class=\"post-h2 h2\">"+title+"</h2></a><p data-date="+date+" class=\"post-text\">"+description+"</p></div>");
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
            $("#" + $(controll).attr('id')).children().last().html("<h2 class=\"h2\">"+message+"</h2>");;
        }
        
        else{
            $("#" + $(controll).attr('id')).append("<div class=\"pers-success\"><h2 class=\"h2\">"+message+"</h2></div>");
        }//else
        $(controll).children().last().fadeOut(0).fadeIn(300); 
    }//if
    else{
        
        $("#" + $(controll).attr('id')).children(".pers-success").remove();
        
        if($("#" + $(controll).attr('id')).children().last().attr("class") == "pers-error"){
            $("#" + $(controll).attr('id')).children().last().html("<h2 class=\"h2\">"+message+"</h2>");
        }//if
        else {
            $("#" + $(controll).attr('id')).append("<div class=\"pers-error\"><h2 class=\"h2\">"+message+"</h2></div>");
        }//else
        $(controll).children().last().fadeOut(0).fadeIn(300);
       
    }//if
}

function GetPostByStopWord(){
    
        words = new String( $("#stop_words").val() );
        delimers_words = words.split(',');
        
}//GetPostByStopWord

$(function() {
    
        $(window).scroll(function() {
           
                
                
                
                if($(this).scrollTop() > 700) {
                        $('#toTop').removeClass("hidden");
                        $('#toTop').fadeIn(); 
                } else {
                        $('#toTop').fadeOut();
                }//else
                if($(this).scrollTop() > 650) {
                        $('aside.sidebar').css("display" , "none");
                        $('.news-section').css({margin : "auto", display : "block"});

                } else {
                        $('aside.sidebar').css({display : "inline-block"});
                        $('.news-section').css({margin : "8px 0px 0px 2px", display : "inline-block"});
                }
                });

                $('#toTop').click(function() {
                $('body,html').animate({scrollTop:0},800);
                
        });
});

$(document).ready(function(){
    
    //Добавить район в "Настройках"
    $("#AddNewDistrictSettings").click(function(){
        
        new_district_title = new String($("#NewDistrict").val());
        new_district_title = new_district_title.split(',');
        for (i=0; i<new_district_title.length; i++){

            new_district_title[i].trim();
         ///   alert(new_district_title[i]);            
        //new_district_title = new_district_title.trim();
            //if(i){
//            if(new_district_title.length != 0){
//
                $.post("ajax.php",{ADD_DISTRICT: 'SET',District: new_district_title[i]},function(data){
                    if(data != "exist" && data != "not inserted"){
                        ShowPersonalRoomMessage($("#DistrictSectionConfirm"),'Район успешно добавлен','success');
                        $("#DistrictSectionConfirm").children().last().addClass("srch_success");
                        $("#DistrictSectionConfirm").children().last().delay(2000).fadeOut(500);
                        $("#districts_order").append('<div><li data-district-id=\"'+data+'\" class=\"chng_distr_li\">'+new_district_title+'<span class=\"chng_distr_correct correct\" title=\"Изменить\">M</span></li><div class=\"hg_null\"><input id=\"\" type=\"text\" class=\"chng_distr_inp pers-input\" placeholder=\"Редактирование района\"><span id=\"ConfirmName\" class=\"dis chnd_distr_ok ok\" title=\"Подтвердить изменения\">N</span></div></div>');
                    }//if
                    else if(data == "exist"){
                        ShowPersonalRoomMessage($("#DistrictSectionConfirm"),'Указанный район уже существует','error');
                        $("#DistrictSectionConfirm").children().last().addClass("srch_error");
                        $("#DistrictSectionConfirm").children().last().delay(2000).fadeOut(500);
                    }//else
                    else{
                        ShowPersonalRoomMessage($("#DistrictSectionConfirm"),'Ошибка на сервере','error');
                        $("#DistrictSectionConfirm").children().last().addClass("srch_error");
                        $("#DistrictSectionConfirm").children().last().delay(2000).fadeOut(500);
                    }//else
             });



       //        }//if
//            else{
//                ShowPersonalRoomMessage($("#DistrictSectionConfirm"),'Поле не может быть путым','error');
//                 $("#DistrictSectionConfirm").children().last().addClass("srch_error");
//                 $("#DistrictSectionConfirm").children().last().delay(2000).fadeOut(500);
//            }//else
    }
    });
    //Добавить стопслово в "Настройках"
    $("#AddStopWordSettings").click(function(){
        
        new_stop_word = new String($("#NewStopWord").val());       
        new_stop_word = new_stop_word.split(',');
        
        for (i=0; i<new_stop_word.length; i++){

            new_stop_word[i].trim();        
    //    if(new_stop_word.length != 0){
            
            $.post("ajax.php",{ADD_STOP_WORD: 'SET',stop_word: new_stop_word[i]},function(data){
                
                if(data != "exist"){
                    $("#StopWordsOrder").append('<div><li data-stop-id=\"'+data+'\" class="chng_distr_li">'+new_stop_word+'<span class="chng_distr_correct correct" title="Изменить">M</span></li><div class="hg_null"><input type="text" class="chng_distr_inp pers-input" placeholder="Редактирование стоп слова"><span id="ConfirmName" class="chnd_distr_ok ok" title="Подтвердить изменения">N</span></div><div>');
                    ShowPersonalRoomMessage($("#StopWordSectionConfirm"),'Стоп слово добавлено','success');
                    $("#StopWordSectionConfirm").children().last().addClass("srch_success");
                    $("#StopWordSectionConfirm").children().last().delay(2000).fadeOut(500);
                    
                }//if
                else if(data == "exist"){
                    ShowPersonalRoomMessage($("#StopWordSectionConfirm"),'Такое стоп слово уже есть','error');
                    $("#StopWordSectionConfirm").children().last().addClass("srch_error");
                    $("#StopWordSectionConfirm").children().last().delay(2000).fadeOut(500);
                }//else
            });
           
//        }//if
//        else{
//             ShowPersonalRoomMessage($("#StopWordSectionConfirm"),'Стоп слово не может быть путым','error');
//             $("#StopWordSectionConfirm").children().last().addClass("srch_error");
//             $("#StopWordSectionConfirm").children().last().delay(2000).fadeOut(500);
//        }//else
        }
    });
    //Получить новости (Главная)
    $("#more_news").click(function(){
        
    //
    $.post("get_news.php",null,function(data){
                        
        news = $.parseJSON(data);

        $.each(news, function(idx, glob_news) {

               
                d_id = glob_news.id;
                ch_social = new String(glob_news.Source);
                title =  new String(glob_news.title);
                description = new String(glob_news.description);
                image = glob_news.Images;
                date_public = glob_news.Date;

                if(title.length > 50){

                    title = title.substr(0,47);
                    title += "...";

                }//if

                if(description.length > 300){

                    description = description.substr(0,297);
                    description += "...";

                }//if


                if(ch_social.indexOf("vk") != -1){

                    if(image != null){
                        $("#newsContent").append("<div data-post_id="+d_id+" class=\"post\"><a href=\""+ch_social+"\" title=\"Ссылка на первоисточник\"><span  class=\"vk post-icon\">Q</span></a><span  class=\"post-date2\" title=\"Время публикации\">"+date_public+"</span><img  class=\"post-img\" src=\""+image+"\" alt=\"\"/><a href=\"?ctrl=news&act=SpecificPostHome&id="+d_id+"\"><h2 id=\"postTitle\" class=\"post-h2 h2\">"+title+"</h2></a><p id=\"postContent\" class=\"post-text\">"+description+"</p>");
                    }//if
                    else{
                        $("#newsContent").append("<div data-post_id="+d_id+" class=\"post\"><a href=\""+ch_social+"\" title=\"Ссылка на первоисточник\"><span  class=\"vk post-icon\">Q</span></a><span  class=\"post-date2\" title=\"Время публикации\">"+date_public+"</span><a href=\"?ctrl=news&act=SpecificPostHome&id="+d_id+"\"><h2 id=\"postTitle\" class=\"post-h2 h2\">"+title+"</h2></a><p id=\"postContent\" class=\"post-text\">"+description+"</p>");
                    }


                }//if vk.com
                else{
                     if(image != null){
                        $("#newsContent").append("<div data-post_id="+d_id+" class=\"post\"><a href=\""+ch_social+"\" title=\"Ссылка на первоисточник\"><span  class=\"vk post-icon\">R</span></a><span  class=\"post-date2\" title=\"Время публикации\">"+date_public+"</span><img  class=\"post-img\" src=\""+image+"\" alt=\"\"/><a href=\"?ctrl=news&act=SpecificPostHome&id="+d_id+"\"><h2 id=\"postTitle\" class=\"post-h2 h2\">"+title+"</h2></a><p id=\"postContent\" class=\"post-text\">"+description+"</p>");
                    }//if
                    else{
                        $("#newsContent").append("<div data-post_id="+d_id+" class=\"post\"><a href=\""+ch_social+"\" title=\"Ссылка на первоисточник\"><span  class=\"vk post-icon\">R</span></a><span  class=\"post-date2\" title=\"Время публикации\">"+date_public+"</span><a href=\"?ctrl=news&act=SpecificPostHome&id="+d_id+"\"><h2 id=\"postTitle\" class=\"post-h2 h2\">"+title+"</h2></a><p id=\"postContent\" class=\"post-text\">"+description+"</p>");
                    }//else if not image
                    
                }//else        
                
        });
        
        $.post("ajax.php",{GetCountOfNews: 'set'},function(ajax_data){
            posts_count =  $("#newsContent div.post").length;
            
            if(posts_count < ajax_data){
                $("#newsContent").children().last().after($("#more_news"));
            }//if
            else{
               $("#more_news").remove();
            }//else
        });
        
        

    });
    
    });
    //Добавить район в "Районы"
    $("#AddDistrict").click(function(){
        
        new_district_title = new String($("#NewDistrictTitle").val());
        new_district_title = new_district_title.trim();
        
        if(new_district_title.length != 0){
            
            $.post("ajax.php",{ADD_DISTRICT: 'SET',District: new_district_title},function(data){
                if(data == "inserted"){
                    ShowPersonalRoomMessage($("#DistrictSectionConfirm"),'Район добавлен','success');
                    $("#DistrictSectionConfirm").children().last().addClass("srch_success");
                    $("#DistrictSectionConfirm").children().last().delay(2000).fadeOut(500);
                    $("#districts ul.district").append("<li>"+new_district_title+"</li>");
                }//if
                else if(data == "exist"){
                    ShowPersonalRoomMessage($("#DistrictSectionConfirm"),'Такой район уже есть','error');
                    $("#DistrictSectionConfirm").children().last().addClass("srch_error");
                    $("#DistrictSectionConfirm").children().last().delay(2000).fadeOut(500);
                }//else
                else{
                    ShowPersonalRoomMessage($("#DistrictSectionConfirm"),'Ошибка на сервере','error');
                    $("#DistrictSectionConfirm").children().last().addClass("srch_error");
                    $("#DistrictSectionConfirm").children().last().delay(2000).fadeOut(500);
                }//else
            });
            
            
           
        }//if
        else{
            ShowPersonalRoomMessage($("#DistrictSectionConfirm"),'Поле не может быть путым','error');
             $("#DistrictSectionConfirm").children().last().addClass("srch_error");
             $("#DistrictSectionConfirm").children().last().delay(2000).fadeOut(500);
        }//else
        
    });
    //Добавить стопслово в "Районы"
    $("#AddStopWord").click(function(){
        
        new_stop_word = new String($("#NewStopWord").val());
        new_stop_word = new_stop_word.trim();
        
        if(new_stop_word.length != 0){
            
            $.post("ajax.php",{ADD_STOP_WORD: 'SET',stop_word: new_stop_word},function(data){
                
                if(data == "inserted"){
                    ShowPersonalRoomMessage($("#StopWordSectionConfirm"),'Стоп слово добавлено','success');
                    $("#StopWordSectionConfirm").children().last().addClass("srch_success");
                    $("#StopWordSectionConfirm").children().last().delay(2000).fadeOut(500);
                    $("#stopWords ul.district").append("<li>"+new_stop_word+"</li>");
                }//if
                else if(data == "exist" || data == "not inserted"){
                    ShowPersonalRoomMessage($("#StopWordSectionConfirm"),'Такое стоп слово уже есть','error');
                    $("#StopWordSectionConfirm").children().last().addClass("srch_error");
                    $("#StopWordSectionConfirm").children().last().delay(2000).fadeOut(500);
                }//else
                else{

                    ShowPersonalRoomMessage($("#StopWordSectionConfirm"),'Ошибка на сервере','error');
                    $("#StopWordSectionConfirm").children().last().addClass("srch_error");
                    $("#StopWordSectionConfirm").children().last().delay(2000).fadeOut(500);
                }//else
            });
           
        }//if
        else{
             ShowPersonalRoomMessage($("#StopWordSectionConfirm"),'Стоп слово не может быть путым','error');
             $("#StopWordSectionConfirm").children().last().addClass("srch_error");
             $("#StopWordSectionConfirm").children().last().delay(2000).fadeOut(500);
        }//else
        
    });
    //Показать остальнае новости по нажатию кнопки
    $("#more_news_by_stop_words").click(function(){
        
        $("#more_news_by_stop_words").blur();
        
        $("#District").val(district);
                
                $.post("get_news_by_stop_words.php",{District: district},function(data){
                    
                    if(data != "end"){
                    $("#more_news_by_stop_words").css("display","inline-block");
                    news = $.parseJSON(data);
                    for(i = 0; i< news.length; i++){
                        
                        $.each(news[i],function(idx,glob_news){
                                
                                d_id = glob_news.id;

                                ch_social = new String(glob_news.Source);
                                title =  new String(glob_news.title);
                                description = new String(glob_news.description);
                                image = glob_news.Images;
                                date_public = glob_news.Date;

                                if(title.length > 50){

                                    title = title.substr(0,47);
                                    title += "...";

                                }//if

                                if(description.length > 300){

                                    description = description.substr(0,297);
                                    description += "...";

                                }//if


                                if(ch_social.indexOf("vk") != -1){

                                    if(image != null){
                                        $("#newsContent").append("<div data-post_id="+d_id+" class=\"post\"><a href=\""+ch_social+"\" title=\"Ссылка на первоисточник\"><span  class=\"vk post-icon\">Q</span></a><span  class=\"post-date2\" title=\"Время публикации\">"+date_public+"</span><img  class=\"post-img\" src=\""+image+"\" alt=\"\"/><a href=\"?ctrl=news&act=SpecificPostHome&id="+d_id+"\"><h2 id=\"postTitle\" class=\"post-h2 h2\">"+title+"</h2></a><p id=\"postContent\" class=\"post-text\">"+description+"</p>");
                                    }//if
                                    else{
                                        $("#newsContent").append("<div data-post_id="+d_id+" class=\"post\"><a href=\""+ch_social+"\" title=\"Ссылка на первоисточник\"><span  class=\"vk post-icon\">Q</span></a><span  class=\"post-date2\" title=\"Время публикации\">"+date_public+"</span><a href=\"?ctrl=news&act=SpecificPostHome&id="+d_id+"\"><h2 id=\"postTitle\" class=\"post-h2 h2\">"+title+"</h2></a><p id=\"postContent\" class=\"post-text\">"+description+"</p>");
                                    }//else


                                }//if vk.com
                                else{
                                     if(image != null){
                                        $("#newsContent").append("<div data-post_id="+d_id+" class=\"post\"><a href=\""+ch_social+"\" title=\"Ссылка на первоисточник\"><span  class=\"vk post-icon\">R</span></a><span  class=\"post-date2\" title=\"Время публикации\">"+date_public+"</span><img  class=\"post-img\" src=\""+image+"\" alt=\"\"/><a href=\"?ctrl=news&act=SpecificPostHome&id="+d_id+"\"><h2 id=\"postTitle\" class=\"post-h2 h2\">"+title+"</h2></a><p id=\"postContent\" class=\"post-text\">"+description+"</p>");
                                    }//if
                                    else{
                                        $("#newsContent").append("<div data-post_id="+d_id+" class=\"post\"><a href=\""+ch_social+"\" title=\"Ссылка на первоисточник\"><span  class=\"vk post-icon\">R</span></a><span  class=\"post-date2\" title=\"Время публикации\">"+date_public+"</span><a href=\"?ctrl=news&act=SpecificPostHome&id="+d_id+"\"><h2 id=\"postTitle\" class=\"post-h2 h2\">"+title+"</h2></a><p id=\"postContent\" class=\"post-text\">"+description+"</p>");
                                    }//else if not image

                                }//else       

                        });
                        
                        
                    }//for
                        $("#newsContent").children().last().after($("#more_news_by_stop_words"));
                    }//if
                    else{
                        if($("#newsContent div.post").length == 0){
                             $("#newsContent").append("<div class=\"post\"><h2 class=\"post-h2 h2\">Новости по заданному запросу не найдены<h2></div>");
                        }
                       $("#more_news_by_stop_words").css("display","none");
                    }//else
                });
                
    });
    //поиск по стопсловам
    $("#search_news_by_stop_words").click(function(){
        
        $("#search_news_by_stop_words").blur();
        $("#more_news_by_stop_words").blur();
        
        district =  $("#districts h2.h2-distr").text();
            
        if(district != 'Районы'){
                
                $("#District").val(district);
                
                $.post("get_news_by_stop_words.php",{District: district},function(data){
                    
                    if(data != "end"){
                    $("#more_news_by_stop_words").css("display","inline-block");
                    news = $.parseJSON(data);
                    for(i = 0; i< news.length; i++){
                        
                        $.each(news[i],function(idx,glob_news){
                                
                                d_id = glob_news.id;

                                ch_social = new String(glob_news.Source);
                                title =  new String(glob_news.title);
                                description = new String(glob_news.description);
                                image = glob_news.Images;
                                date_public = glob_news.Date;

                                if(title.length > 50){

                                    title = title.substr(0,47);
                                    title += "...";

                                }//if

                                if(description.length > 300){

                                    description = description.substr(0,297);
                                    description += "...";

                                }//if


                                if(ch_social.indexOf("vk") != -1){

                                    if(image != null){
                                        $("#newsContent").append("<div data-post_id="+d_id+" class=\"post\"><a href=\""+ch_social+"\" title=\"Ссылка на первоисточник\"><span  class=\"vk post-icon\">Q</span></a><span  class=\"post-date2\" title=\"Время публикации\">"+date_public+"</span><img  class=\"post-img\" src=\""+image+"\" alt=\"\"/><a href=\"?ctrl=news&act=SpecificPostHome&id="+d_id+"\"><h2 id=\"postTitle\" class=\"post-h2 h2\">"+title+"</h2></a><p id=\"postContent\" class=\"post-text\">"+description+"</p>");
                                    }//if
                                    else{
                                        $("#newsContent").append("<div data-post_id="+d_id+" class=\"post\"><a href=\""+ch_social+"\" title=\"Ссылка на первоисточник\"><span  class=\"vk post-icon\">Q</span></a><span  class=\"post-date2\" title=\"Время публикации\">"+date_public+"</span><a href=\"?ctrl=news&act=SpecificPostHome&id="+d_id+"\"><h2 id=\"postTitle\" class=\"post-h2 h2\">"+title+"</h2></a><p id=\"postContent\" class=\"post-text\">"+description+"</p>");
                                    }//else


                                }//if vk.com
                                else{
                                     if(image != null){
                                        $("#newsContent").append("<div data-post_id="+d_id+" class=\"post\"><a href=\""+ch_social+"\" title=\"Ссылка на первоисточник\"><span  class=\"vk post-icon\">R</span></a><span  class=\"post-date2\" title=\"Время публикации\">"+date_public+"</span><img  class=\"post-img\" src=\""+image+"\" alt=\"\"/><a href=\"?ctrl=news&act=SpecificPostHome&id="+d_id+"\"><h2 id=\"postTitle\" class=\"post-h2 h2\">"+title+"</h2></a><p id=\"postContent\" class=\"post-text\">"+description+"</p>");
                                    }//if
                                    else{
                                        $("#newsContent").append("<div data-post_id="+d_id+" class=\"post\"><a href=\""+ch_social+"\" title=\"Ссылка на первоисточник\"><span  class=\"vk post-icon\">R</span></a><span  class=\"post-date2\" title=\"Время публикации\">"+date_public+"</span><a href=\"?ctrl=news&act=SpecificPostHome&id="+d_id+"\"><h2 id=\"postTitle\" class=\"post-h2 h2\">"+title+"</h2></a><p id=\"postContent\" class=\"post-text\">"+description+"</p>");
                                    }//else if not image

                                }//else       

                        });
                        
                        
                    }//for
                        $("#newsContent").children().last().after($("#more_news_by_stop_words"));
                    }//if
                    else{
                        
                        
                        $("#more_news_by_stop_words").css("display","none");
                    }//else
                    if($("#newsContent div.post").length == 0){
                        $("#newsContent").append("<div class=\"post\"><h2 class=\"post-h2 h2\">Новости по заданному запросу не найдены<h2></div>");
                    }
                    
                });
                
            }//if
            else{//error
                ShowPersonalRoomMessage($("#start_search_news"),'Выбирите район','error');
                $("#start_search_news").children().last().addClass("srch_success");
                $("#start_search_news").children().last().delay(2000).fadeOut(500);
                
            }//else
        });
    //Выбор района и установка его имни в блоке
    $("#districts ul.district li").click(function(){
            
            $("#districts h2.h2-distr").text($(this).text());
            $("#newsContent div.post").remove();
            $("#more_news_by_stop_words").css("display","none");
            
            $.post("ajax.php",{SET_COOKIE_OFFSET: 'set'},function(data){});
            
    });
        
        $fl = true;
        //Сокрытие панели поиска в "райнонах"
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
        //Изменение имэйла в личном кабинете
        $("#ConfirmEmail").click(function(){
            new_mail = new String($("#NewMailInPersonal").val());
            new_mail = new_mail.trim();
            
            if(new_mail.length == 0){
                ShowPersonalRoomMessage($("#emailSection"),'Поле не может быть пустым','error');
                $("#emailSection").children().last().delay(2000).fadeOut(300);
            }//if
            else if(new_mail.indexOf('@') == -1){
                ShowPersonalRoomMessage($("#emailSection"),'E-mail должен содержать символ @','error');
                $("#emailSection").children().last().delay(2000).fadeOut(300);
            }//if
            else{
                
                $.post("ajax.php",{EmailSuccess: 'set', NewPersonalMail: new_mail , Owner:  $("#login").text()},function(data){
                    
                    if(data == "ok"){
                        ShowPersonalRoomMessage($("#emailSection"),'Изменения успешно внесены!','success');
                        $("#emailSection").children().last().delay(2000).fadeOut(300);
                    }//if
                    else{
                        ShowPersonalRoomMessage($("#emailSection"),'Ошибка на сервере!','error');
                        $("#emailSection").children().last().delay(2000).fadeOut(300);
                    }//else
                    
                });
                
            }//else
            
        });
        //Изменение пароля в личном кабинете
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
                                           $("#PasswordSection").children().last().delay(2000).fadeOut(300);
                                       }//if
                                       else{
                                           ShowPersonalRoomMessage($("#PasswordSection"),'Ошибка сервера','error');
                                           $("#PasswordSection").children().last().delay(2000).fadeOut(300);
                                       }//else
                                       
                                   });
                                   
                               }//if
                               else{
                                   ShowPersonalRoomMessage($("#PasswordSection"),'Длина нового пароля должна быть больше 6-ти символов','error');
                                    $("#PasswordSection").children().last().delay(2000).fadeOut(300);
                                }//else
                           }//if
                           else{
                               ShowPersonalRoomMessage($("#PasswordSection"),'Пароли не совпадают','error');
                               $("#PasswordSection").children().last().delay(2000).fadeOut(300);
                           }//else
                       }//if
                       else{
                           ShowPersonalRoomMessage($("#PasswordSection"),'Заполните поля с новым паролем','error');
                           $("#PasswordSection").children().last().delay(2000).fadeOut(300);
                       }//else
                       
                    }//if
                    else{
                        ShowPersonalRoomMessage($("#PasswordSection"),'Текущий пароль указан не верно','error');
                        $("#PasswordSection").children().last().delay(2000).fadeOut(300);
                    }//else
                });//post
                
            }//if
            else{
                ShowPersonalRoomMessage($("#PasswordSection"),'Укажите текущий пароль пользователя','error');
                $("#PasswordSection").children().last().delay(2000).fadeOut(300);
            }//else
        });
        //Изменение имени в личном кабинете
        $("#ConfirmName").click(function(){
            
            new_name = new String($("#NewFirstName").val());
            new_name = new_name.trim();
            
            if(new_name.length != 0){
                
               $.post("ajax.php",{ChangeFirstName: 'set', Owner: $("#login").text(), NewFirstName: $("#NewFirstName").val()}, function(data){
                   
                   if(data == "ok"){
                       ShowPersonalRoomMessage($("#FirstNameSection"),'Имя успешно изменено','success');
                       $("#FirstNameSection").children().last().delay(2000).fadeOut(300);
                   }//if
                   else{
                       ShowPersonalRoomMessage($("#FirstNameSection"),'Ошибка сервера','error');
                       $("#FirstNameSection").children().last().delay(2000).fadeOut(300);
                   }
               });
            }//if
            else{
                ShowPersonalRoomMessage($("#FirstNameSection"),'Поле не может быть пустым','error');
                $("#FirstNameSection").children().last().delay(2000).fadeOut(300);
                
               // $("#FirstNameSection").children().last().empty();

            }//else
            
        });
        //Изменение Фамилии в личном кабинете
        $("#ConfirmLastName").click(function(){
            new_last_name = new String($("#NewLastName").val());
            new_last_name = new_last_name.trim();
            
            if(new_last_name.length != 0){
                
               $.post("ajax.php",{ChangeLastName: 'set', Owner: $("#login").text(), NewLastName: $("#NewLastName").val()}, function(data){
                   
                   if(data == "ok"){
                       ShowPersonalRoomMessage($("#LastNameSection"),'Фамилия успешно изменена','success');
                       $("#LastNameSection").children().last().delay(2000).fadeOut(300);
                   }//if
                   else{
                       ShowPersonalRoomMessage($("#LastNameSection"),'Ошибка сервера','error');
                       $("#LastNameSection").children().last().delay(2000).fadeOut(300);
                   }
               });
            }//if
            else{
                ShowPersonalRoomMessage($("#LastNameSection"),'Поле не может быть пустым','error');
                $("#LastNameSection").children().last().delay(2000).fadeOut(300);
            }//else
            
        });
        
        var a = true; 
        //Анимация блока с редактированием стопслов и районов
        $("span.correct_js").click(function(){
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
        
        var b = true; 
        //Редактирование СтопСлов
        $('body').on('click','span.chnd_distr_ok',function(){
            
            if(!$(this).hasClass("dis")){
            elem = $(this).parent().parent();
            elem_to_change = $(this).parent().parent();
            
            word_to_update = $(this).parent().prev().data("stop-id");
            new_stop_word = new String($(this).prev().val());
            new_stop_word = new_stop_word.trim();
            if(new_stop_word.length != 0){
                $.post("ajax.php",{CHECK_STOP_WORD: 'SET',stop_word: new_stop_word},function(data){
                
                    if(data == "ok"){
                    $.post('ajax.php',{UPDATE_STOP_WORD: 'set',stop_id: word_to_update, new_word: new_stop_word},function(data){
                        if(data == "ok"){
                            
                             $(elem).first().html('<div><li data-stop-id=\"'+word_to_update+'\" class="chng_distr_li">'+new_stop_word+'<span class="chng_distr_correct correct" title="Изменить">M</span></li><div class="hg_null"><input type="text" class="chng_distr_inp pers-input" placeholder="Редактирование стоп слова"><span id="ConfirmName" class="chnd_distr_ok ok" title="Подтвердить изменения">N</span></div><div>');
                             $(elem).append("<div class=\"srch_success pers-success\"><h2 class=\"h2\">Изменения успешно внесены</h2></div>");
                             $(elem).children().last().delay(2000).fadeOut(500);
                        }//if
                        else{
                            $(elem).append("<div class=\"srch_error pers-error\"><h2 class=\"h2\">Такое стоп-слово есть или пустое поле</h2></div>");                              
                            $(elem).children().last().delay(2000).fadeOut(500);
                        }
                    });
                    }//if
                    else{
                        $(elem).append("<div class=\"srch_error pers-error\"><h2 class=\"h2\">Такое стоп-слово есть</h2></div>");                    
                        $(elem).children().last().delay(2000).fadeOut(500);
                    }
               
                
                });
            }//if length not 0
            else{
                $(elem).append("<div class=\"srch_error pers-error\"><h2 class=\"h2\">Поле не может быть пустым<h2></div>");                    
                $(elem).children().last().delay(2000).fadeOut(500);
            }
            
             }//if has not class dis
        });
        //Редактирование районов
        $('body').on('click','span.dis',function(){
             
            if($(this).hasClass("dis")){
                
                elem = $(this).parent().parent();
                dist_id = $(this).parent().prev().data("district-id");
                new_district_title = $(this).prev().val();
                new_district_title = new  String (new_district_title);
                new_district_title = new_district_title.trim();
                
                if( new_district_title.length != 0){
                     $.post("ajax.php",{CHECK_DISTRICT: 'SET',district: new_district_title},function(data){

                        if(data == "ok"){
                        $.post('ajax.php',{UPDATE_DISTRICT: 'set',new_district_title: new_district_title, district_id: dist_id},function(data){
                            if(data == "ok" && new_district_title != ''){
                                 $(elem).first().html('<div><li data-district-id=\"'+dist_id+'\" class=\"chng_distr_li\">'+new_district_title+'<span class=\"chng_distr_correct correct\" title=\"Изменить\">M</span></li><div class=\"hg_null\"><input id=\"\" type=\"text\" class=\"chng_distr_inp pers-input\" placeholder=\"Редактирование района\"><span id=\"ConfirmName\" class=\"dis chnd_distr_ok ok\" title=\"Подтвердить изменения\">N</span></div></div>');
                                 $(elem).append("<div class=\"srch_success pers-success\"><h2 class=\"h2\">Изменения успешно внесены</h2></div>");
                                 $(elem).children().last().delay(2000).fadeOut(500);
                            }//if
                            else{
                                $(elem).append("<div class=\"srch_error pers-error\"><h2 class=\"h2\">Такое район есть или пустое поле</h2></div>");                              
                                $(elem).children().last().delay(2000).fadeOut(500);
                            }
                        });
                        }//if
                        else{
                            $(elem).append("<div class=\"srch_error pers-error\"><h2 class=\"h2\">Такое район уже есть</h2></div>");                    
                            $(elem).children().last().delay(2000).fadeOut(500);
                        }


                    });
                }
                else{
                     $(elem).append("<div class=\"srch_error pers-error\"><h2 class=\"h2\">Поле не может быть пустым</h2></div>");                    
                     $(elem).children().last().delay(2000).fadeOut(500);
                }
             }//if has not class dis
        });
        
        $('body').on('click','span.chng_distr_correct',function(){
           
            if(b){
                $(this).parent().next().css({display: "block"}).animate({height: "44px"},200);
                b = false; 
            }//if
            else
            {
                $(this).parent().next().animate({height: "0px"},200);
                b = true;                
                
            }//else            
        });
        //Удаление поста
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
        //Анимация удаления
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
        });
        //добавление записи
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
        //Авторизация
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
        //регистрация на welcome.php
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
        //Полная регистрация 
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
