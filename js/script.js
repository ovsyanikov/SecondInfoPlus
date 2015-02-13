var data;
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
    

$(document).ready(function(){
        
        //Авторизация
        $('#Authorise').click(function(){
          
        if ($('#userPS').val() && $('#userLE').val()){ //if not empty
                 
                $.post("ajax.php",
                {
                    userLE: $('#userLE').val(),
                    userPS: $('#userPS').val()

                },function (data){
                     
                     if(data == "yes"){//РІРµСЂРЅС‹Р№ Р»РѕРіРёРЅ РёР»Рё РїР°СЂРѕР»СЊ
                         $('#AuthoriseForm').submit();
                     }//if
                     else{
                         
                         ShowAuthorizeMessage('РќРµ РІРµСЂРЅС‹Р№ Р»РѕРіРёРЅ РёР»Рё РїР°СЂРѕР»СЊ!');
                         
                     }//else

                });
                
        }//end if empty
        else{
            
            ShowAuthorizeMessage('Р’СЃРµ РїРѕР»СЏ РґРѕР»Р¶РЅС‹ Р±С‹С‚СЊ Р·Р°РїРѕР»РЅРµРЅС‹!');
        }      
            
            
        });
        
        //Регистрация
        $('#register').click(function(){
            
           if($('#RLogin').val() && $('#RMail').val() && $('#RPass').val()){
               
               mail = new String($('#RMail').val());
               pass = new String($('#RPass').val());
               
               $.post("ajax.php",{
               
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

                   ShowRegisterMessage('email не содержит символ @');

               }//else if
               else if(pass.length < 7){

                   ShowRegisterMessage('Пароль должен быть дленнее 7-ми символов');

               }//else if
               else if(pass.length > 50){
                   ShowRegisterMessage('Слишком длинный пароль');
               }//else if
               else if(data == "acc_free"){

                   $("#registerForm").submit();

               }//else if
               else{
                  ShowRegisterMessage('Servor error');
               }//else
               
            }); 
            
           }//if not empty
           else{
               
               ShowRegisterMessage('Есть пустые поля!');
               
           }//else
            
        });
        
        $("#registerNewUser").click(function(){
            
            //проверка логина
            if($("#newUserLogin").val() && $("#newUserLogin").val().length < 50){
                
                
                $.post("ajax.php",{newUserLogin: $("#newUserLogin").val(), mainregister: 'set' },function(data){
                    
                    
                    if(data == "used_login"){
                        
                        ShowRegisterMessage('Такой логин уже используется!');
                        
                    }//if
                    else{
                            
                        if($("#newMail").val()){//если email не пуст
                            
                            var mail = new String($("#newMail").val());

                            if(mail.indexOf('@') == -1){//если не содержит @

                                ShowRegisterMessage('Поле email не содержит символ @');

                            }//if
                            else{
                                
                                $.post("ajax.php",{
                                newUserLogin: $("#newUserLogin").val(),
                                newMail: $("#newMail").val(),
                                mainregister: 'set'
                            },function(data){
                                
                                if(data == "used_email"){

                                    ShowRegisterMessage('Такой email уже используется');

                                }//if
                                //Проверка паролей
                                else if(!$("#userPS").val() || $("#userPS").val().length < 7 || $("#userPS").val() != $("#userPS2").val() ){
                                            ShowRegisterMessage('Пароли пусты или длина менее 7-ми символов или не совпадают!');
                                }//else pass
                                //Проверка Имени
                                else if(!$("#NewFirstName").val()){
                                    ShowRegisterMessage('Имя не может быть пустым!');
                                }//else

                                //Проверка Фамилии
                                else if(!$("#NewLastName").val()){
                                    ShowRegisterMessage('Фамилия не может быть пустым!');
                                }//else
                                //Иначе все нормально. Регистрируем пользователя
                                else{
                                    $("#registerForm").submit();
                                }//else ok
                            
                        });//post email
                                
                            }//else
                   
                 
            }//if email
            else{
                ShowRegisterMessage('Поле email не должно быть пустым!');
            }//else empty email 
                        
            }//else 
                           
                
            });//post.login
                
        }//if login
        else{
                
                ShowRegisterMessage('Логин пуст или его длина более 50-ти символов!');
                
        }//else empty login
            
            
        });//register click
});
