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
                      
                  }
                  
                  
                }
                
                
            });
            
        });
        
        $('#Authorise').on('click',function(e){
           
            $.post("ajax.php",
            {
                userLE: $('#userLE').val(),
                userPS: $('#userPS').val()
                
            },function (data){
                
                
                if(data === "yes"){
                    
                  $('#authentication').animate({height: $('#authentication').height()+20},500);
                  $('#error_lp').removeClass('invisible');
                  $('#error_lp').addClass('error_block');
                  
                    
                }//if
                else{
                    
                  var inp_class = $('#error_lp').attr("class");

                  if(inp_class == 'error_block'){
                      
                      $('#authentication').animate({height: $('#authentication').height()-20},500);
                      $('#error_lp').removeClass('error_block');
                      $('#error_lp').addClass('invisible');
                      
                  }
                  
                  
                }
                
                
            });
            
        });
        
	$('.bxslider').bxSlider({
		controls: false,
		auto: true,
		autoControls: false,
		pause: 5000  
	});
	$('.fadeUp').addClass("hidden").viewportChecker({
		delay: 0,
		classToAdd: 'visible animated fadeInUp',
		offset: 100
	});
	$('.flashA1').addClass("hidden").viewportChecker({
		delay: 0,
		classToAdd: 'visible animated rotateIn',
		offset: 200
	});	
	$('.flashA2').addClass("hidden").viewportChecker({
		delay: 700,
		classToAdd: 'visible animated rotateIn',
		offset: 200
	});	
	$('.flashA3').addClass("hidden").viewportChecker({
		delay: 1400,
		classToAdd: 'visible animated rotateIn',
		offset: 200
	});	
	$('.flashA4').addClass("hidden").viewportChecker({
		delay: 2100,
		classToAdd: 'visible animated rotateIn',
		offset: 200
	});
	$('.fadeUp1').addClass("hidden").viewportChecker({
		delay: 0,
		classToAdd: 'visible animated fadeInUp',
		offset: 100
	});	
	$('.fadeUp2').addClass("hidden").viewportChecker({
		delay: 700,
		classToAdd: 'visible animated fadeInUp',
		offset: 100
	});	
	$('.fadeUp3').addClass("hidden").viewportChecker({
		delay: 1400,
		classToAdd: 'visible animated fadeInUp',
		offset: 100
	});	
	$('.fadeUp4').addClass("hidden").viewportChecker({
		delay: 2100,
		classToAdd: 'visible animated fadeInUp',
		offset: 100
	});	
				
	$('.flip').addClass("hidden").viewportChecker({
		delay: 0,
		classToAdd: 'visible animated bounce',
		offset: 150
	});

	$(function() {
		$(window).scroll(function() {
			if($(this).scrollTop() > 1000) {
				$('#toTop').removeClass("hidden");
				$('#toTop').fadeIn();
			} else {
				$('#toTop').fadeOut();
			}
			});
			 
			$('#toTop').click(function() {
			$('body,html').animate({scrollTop:0},800);
		});
	});
        
        
       
});
