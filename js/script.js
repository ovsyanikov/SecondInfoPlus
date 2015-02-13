var data;
if (!window.jQuery) {
    msg = 'УПС :-( JQuery не загрузился! ';
    alert(msg);
}

$(document).ready(function(){
    
        //Ajax проверка на совпадение введенного логина
         $('#RLogin').on('input',function(e){
           
            $.post("ajax.php",
            {
                userLogin: $('#RLogin').val()
                
            },function (data){
                
                if(data === "yes"){
                    
                  $('#registration').animate({height: $('#registration').height()+20},500);
                  $('#error').removeClass('invisible');
                  $('#error').addClass('error_block');
                  
                    
                }//if
                else{
                  
                  var inp_class = $('#error').attr("class");

                  if(inp_class == 'error_block'){
                      
                      $('#registration').animate({height: $('#registration').height()-20},500);
                      $('#error').removeClass('error_block');
                      $('#error').addClass('invisible');
                      
                  }//if
                  
                  
                }//else
                
                
            });
            
        });
        
        //Нажатие кнопки Вход
        $('#Authorise').click(function(){
          
            $.post("ajax.php",
            {
                userLE: $('#userLE').val(),
                userPS: $('#userPS').val()
                
            },function (data){
             
              if ($('#userPS').val() || $('#userLE').val()){ //if empty
                    
                 var inp_class = $('#error_lp').attr("class");
                 
                  if(inp_class != 'error_block'){
                      
                      $('#error').text('*Извините, логин уже занят!');
                      $('#authentication').animate({height: $('#authentication').height()+20},500);
                      $('#error_lp').removeClass('invisible');
                      $('#error_lp').addClass('error_block');
                      
                  }
                  
                  
                    
                
                else{
                    
                  $('#AuthoriseForm').submit();
                  
                  var inp_class = $('#error_lp').attr("class");
                  
                  if(inp_class == 'error_block'){
                      
                      $('#authentication').animate({height: $('#authentication').height()-20},500);
                      $('#error_lp').removeClass('error_block');
                      $('#error_lp').addClass('invisible');
                      
                  }//if
                  
                  
                }
              
              }//end if empty
            });
            
        });
        
        //Нажатие кнопки Регистрация
        $('#register').click(function(){
            if ($('#RLogin').val() && $('#RPass').val() && $('#RMail').val()){//if empty
            
                var inp_class = $('#error').attr("class");
                if(inp_class != 'error_block'){

                    $('#registerForm').submit();

                }//if
            }//end if empty    
            else{
                
                var inp_class = $('#error').attr("class");
                 
                  if(inp_class != 'error_block'){
                      
                      $('#error').text('*Все поля должны быть заполнены!');
                      $('#registration').animate({height: $('#registration').height()+20},500);
                      $('#error').removeClass('invisible');
                      $('#error').addClass('error_block');
                      
                  }
            }
        });
        
       
});
