$(document).ready(function(){
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
