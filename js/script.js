var data;
if (!window.jQuery) {
    msg = 'УПС :-( JQuery не загрузился! ';
    alert(msg);
}

$(document).ready(function(){
        
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
                      
                  }//
                  
                  
                }
                
                
            });
            
        });
        
        $('#Authorise').click(function(){
          
            $.post("ajax.php",
            {
                userLE: $('#userLE').val(),
                userPS: $('#userPS').val()
                
            },function (data){
               
              if ($('#APass').val() && $('#ALogin').val()){ //if empty
                    
                 var inp_class = $('#error_lp').attr("class");
                 
                  if(inp_class != 'error_block'){
                      
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
        
        
        $('#register').click(function(){
            if ($('#RLog').val() && $('#Rpass').val() && $('#Rmail').val()){//if empty
            
                var inp_class = $('#error').attr("class");
                if(inp_class != 'error_block'){

                    $('#registerForm').submit();

                }//if
            }//end if empty        
        });
        
       
});
