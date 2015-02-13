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

var loginResult;

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
               else if(data == "acc_free"){

                   $("#registerForm").submit();

               }//else if
               else{
                  ShowRegisterMessage('Servor error');
               }
               
            }); 
            
           }//if not empty
           else{
               
               ShowRegisterMessage('Есть пустые поля!');
               
           }//else
            
        });
});
