$(function(){
	$('.main_slider ul').bxSlider({
		speed: 800,
		auto: true,
		pause: 4000,
		mode: 'fade'
	});

	$('.products .carousel').owlCarousel({
		items: 4,
		slideSpeed: 500,
		navigation: true,
		pagination: false,
		autoPlay: true,
		autoplayTimeout:1000,
	    autoplayHoverPause:true,
	    loop:true,
		itemsDesktop: [1199,3],
		itemsDesktopSmall: [900,2],
		itemsMobile: [600,1],
	});

	$('.cats .carousel').owlCarousel({
		items: 3,
		slideSpeed: 500,
		navigation: true,
		pagination: false,
		itemsDesktop: [1199,3],
		itemsDesktopSmall: [900,3],
		itemsMobile: [600,1]
	});
	
	$('.menu_link').on("click",function(e){
		e.preventDefault();
		if($('.menu .menu-wrapper').css("display") == 'none')
			$('.menu .menu-wrapper').fadeIn();
		else {
			$('.menu .menu-wrapper').fadeOut();
		}
	});/*, function(e){
		e.preventDefault();
		$('.menu .menu-wrapper').fadeOut();
	});*/

	$('.product_info .big ul').bxSlider({
		speed: 500,
		controls: false,
		pagerCustom: '#bx-pager'
	});
	$('.product_info .thumbs ul').bxSlider({
		speed: 500,
		pager: false,
		slideMargin: 13,
		minSlides: 3,
		maxSlides: 3,
		moveSlides: 1,
		slideWidth: 113,
		infiniteLoop: false
	});
	$(".catalog_dropdown").hover(
		function(){
			$("#menu-catalog").fadeIn(100);
		},
		function(){
			$("#menu-catalog").fadeOut(100);
		}
	);
	
	$('.fancy_img').fancybox();

    $('.bx_add_basket').fancybox({
        dataType : 'html',
        headers  : { 'X-fancyBox': true }
    });
    $("[data-fancybox]").fancybox({dataType : 'ajax'});


    updateBasketSmall();
});


function updateBasketSmall() {
    $.ajax({
        url: '/ajax/basket.php',
        type: 'post',
        dataType: 'json',
        data: 'mode=getBasket',
        success: function(res) {
                $('.short_cart > .count').html(res.BASKET_PRINT);
                $('.short_cart > .price').html(res.BASKET_TOTAL_PRINT);
        }
    });
}

$(document).ready(function(){
	if($("html").width() < 1024){
		$(".catalog_dropdown").on("click touchstart", function(e){
			if(e.target.parentElement.className.indexOf('catalog_dropdown') != -1){
				e.preventDefault();
				e.stopPropagation();
				//console.log(e);
				$(".menu .cont .menu-wrapper > ul").animate({left: "-100vw"}, 600);
				$("#menu-catalog").show();
			}
		});
		$(".catalog_dropdown .back").on("click touchstart", function(e){
			e.preventDefault();
			e.stopPropagation();
			$("#menu-catalog").hide();
			$(".menu .cont .menu-wrapper > ul").animate({left: "0"}, 600);
		});
		/*$(".menu .cont .menu-wrapper").on("click touchstart", function(e){
			$(this).fadeOut(600,()=>{$(".menu .cont .menu-wrapper > ul").css("left","0");});
			
		});*/
	}

	// Вход на сайт
	$(".auth-form-wrapper, .auth-form-close").on("click",function(e){
		if($(".header-enter-form").hasClass("active")){
			$(".header-enter-form, .auth-form-wrapper").removeClass("active");
		}
	});
	$(".header-enter-form").on("click", function(e){
		e.stopPropagation();
	});
	$(".header-enter-form > button").on("click",function(e){
		//$(this).parent().toggleClass("active");
		if($(this).hasClass("in-header")){
			$(".bx-system-auth-form .opt-register-link").hide();
			$(".bx-system-auth-form .user-register-link").show();
		}
		else {
			$(".bx-system-auth-form .user-register-link").hide();
			$(".bx-system-auth-form li.rozn-user").hide();
			$(".bx-system-auth-form .opt-register-link").show();
		}
		$(".header-enter-form, .auth-form-wrapper").toggleClass("active");
	});
    $(".header-enter-form form").on("submit", function(e){
        e.preventDefault();
    	let formData = $(this).serialize();
    	$.post("/ajax/forms/auth_form.php",formData, function(data){
    	    if(data == "OK"){
                document.location.reload();
            }else{
    	    	let rez = JSON.parse(data);
    	        $("p.login-form-error").remove();
    	        let p = document.createElement("p");
    	        p.classList.add("login-form-error");
    	        p.innerHTML = rez.MESSAGE;
    	        $(".auth-form-left").prepend(p);
                console.log(data);
            }

        });
	});
	//
	$("a[href^='mailto']").on("click", function(e){
		yaCounter45214521.reachGoal("MAILTO_CLICK");
	});
	$("a[href^='tel']").on("click", function(e){
		yaCounter45214521.reachGoal("TEL_CLICK");
	});
});