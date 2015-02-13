var data;
if (!window.jQuery) {
    msg = 'УПС :-( JQuery не загрузился! ';
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
    
        //Ajax проверка на совпадение введенного логина
         $('#RLogin').on('input',function(e){
           
            $.post("ajax.php",
            {
                userLogin: $('#RLogin').val()
                
            },function (data){
                
                if(data === "yes"){
                    
                  ShowRegisterMessage('Логин уже используется!');
                  
                    
                }//if
                
                else{
                    
                    ShowRegisterMessage('Данный логин свободен!');
                    
                }
            });
            
        });
        
        //Нажатие кнопки Вход
        $('#Authorise').click(function(){
          
        if ($('#userPS').val() && $('#userLE').val()){ //if not empty
                 
                $.post("ajax.php",
                {
                    userLE: $('#userLE').val(),
                    userPS: $('#userPS').val()

                },function (data){
                     
                     if(data == "yes"){//верный логин или пароль
                         $('#AuthoriseForm').submit();
                         
                         
                     }//if
                     else{
                         
                         ShowAuthorizeMessage('Не верный логин или пароль!');
                         
                     }//else

                });
                
        }//end if empty
        else{
            
            ShowAuthorizeMessage('Все поля должны быть заполнены!');
        }      
            
            
        });
        
        //Нажатие кнопки Регистрация
        $('#register').click(function(){
            
            if ($('#RLogin').val() && $('#RPass').val() && $('#RMail').val()){//if empty
                
                var a = String($('#RMail').val());
                
                if(a.indexOf("@") == -1){
                    
                    ShowRegisterMessage('Поле имейл не корректно!');
                    
                }
                else if($('#RLogin').val().length < 7){
                    
                    ShowRegisterMessage('Логин должен содержать более 6-ти букв');
                    
                }//else if
                
                else if($('#RPass').val().length < 7){
                    
                    ShowRegisterMessage('Пароль должен содержать более 6-ти букв');
                    
                }//else if
                else{
                    
                    $('#registerForm').submit();
                    
                }//else
                
                
            }//end not empty    
            else{
                
                ShowRegisterMessage('Все поля должны быть заполнены!');
                  
            }//else
        });
        
});
