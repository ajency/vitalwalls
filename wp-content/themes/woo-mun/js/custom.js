"use strict";
jQuery(document).ready(function(){	
	jQuery('.portsingle.home .blogsingleimage img').hide();
	jQuery('.showpostload').hide();
	jQuery('.showpostpostcontent').hide();
	jQuery('.closeajax').hide();
	jQuery('.click').click(function() {
	
	
	
	var id = jQuery(this).attr("id");
	var url = jQuery('#root').attr("value");
	var invariable = id.split('_');
	var type = '';
	if(invariable[0] != 'post')
		type = '_port';
	else
		type = '_post';
	if(invariable[0] == 'recent' || invariable[0] == 'feautured')
		type = '_product';		

	jQuery('.tabsshort.'+invariable[0]+',.products-both .bx-controls-direction, .aq-block-aq_port_block_feed .titlebordrtext,.aq-block-aq_port_block_feed .bx-controls-direction').fadeOut(200);

	

	if(jQuery('#showpost-'+invariable[0]+'-'+invariable[2]+' .main').is(":visible")){
		jQuery('html, body').animate({scrollTop:jQuery('#showpost-'+invariable[0]+'-'+invariable[2]).offset().top -120}, 400);
		var oldheight = jQuery('#showpost-'+invariable[0]+'-'+invariable[2]+' .main').height();
		jQuery('#showpost-'+invariable[0]+'-'+invariable[2]+' .showpostpostcontent').fadeOut(200);	
		jQuery('#showpost-'+invariable[0]+'-'+invariable[2]+' .showpostpostcontent').empty();
		jQuery('#showpost-'+invariable[0]+'-'+invariable[2]+' .closehomeshow').fadeOut(200);		
		jQuery('#showpost-'+invariable[0]+'-'+invariable[2]+' .showpostload').delay(200).fadeIn(200);
		if(oldheight > 500){
			var heightnew = oldheight - 500;
			jQuery('#showpost-'+invariable[0]+'-'+invariable[2]).delay(300).animate({"height": "-="+heightnew+"px"}, 500);	
		}		
		if(oldheight < 500){
			var heightnew = 500 - oldheight ;
			jQuery('#showpost-'+invariable[0]+'-'+invariable[2]).delay(300).animate({"height": "+="+heightnew +"px"}, 500);	
		}
			jQuery('#showpost-'+invariable[0]+'-'+invariable[2]+' .showpostpostcontent').load(url+'/single_home'+type+'.php',{ 'id': invariable[1], 'type': invariable[0] , 'rand': invariable[2] } ,function () {

		jQuery('#showpost-'+invariable[0]+'-'+invariable[2]+' .posttext img').imagesLoaded(function () {
			height = jQuery('#showpost-'+invariable[0]+'-'+invariable[2]+' .showpostpostcontent').height();
			if(height >500) {
				heightnew = height - 500;
				jQuery('#showpost-'+invariable[0]+'-'+invariable[2]).animate({"height": "+="+heightnew+"px"}, 500);
			}
			if(height < 500) {
				heightnew =  500 - height;
				jQuery('#showpost-'+invariable[0]+'-'+invariable[2]).animate({"height": "-="+heightnew+"px"}, 500);
			}

			jQuery('#showpost-'+invariable[0]+'-'+invariable[2]+' .showpostload').fadeOut(600);
			jQuery('#showpost-'+invariable[0]+'-'+invariable[2]+' .showpostpostcontent').delay(700).fadeIn(200);
			jQuery('.closehomeshow-'+invariable[0]+'.closeajax').delay(700).fadeIn(200);
			jQuery('.imagesSPAll .loading').removeClass('loading');			
			jQuery('#slider').css('display','block');
			jQuery('#slider .images').animate({'opacity':1},300);
			jQuery('#slider,#slider img,.textSlide').css('opacity','1');
			
			} );
		} );
	}
	else{
		var height = 0;
		jQuery('#showpost-'+invariable[0]+'-'+invariable[2]).animate({"height": "+=500px"}, 500);
		jQuery('#showpost-'+invariable[0]+'-'+invariable[2]+' .showpostload').fadeIn(200);
		jQuery('#showpost-'+invariable[0]+'-'+invariable[2]+' .showpostpostcontent').load(url+'/single_home'+type+'.php',{ 'id': invariable[1], 'type': invariable[0] , 'rand': invariable[2]} ,function () {


		jQuery('html, body').animate({scrollTop:jQuery('#showpost-'+invariable[0]+'-'+invariable[2]).offset().top -120}, 400);
		jQuery('#showpost-'+invariable[0]+'-'+invariable[2]+' .postcontent img').imagesLoaded(function () {
			height = jQuery('#showpost-'+invariable[0]+'-'+invariable[2]+' .showpostpostcontent').height();
			if(height > 500) {
				var newheight = height - 500;
				jQuery('#showpost-'+invariable[0]+'-'+invariable[2]).animate({"height": "+="+newheight+"px"}, 500);
			}
			if(height < 500) {
				var newheight =  500 - height;
				jQuery('#showpost-'+invariable[0]+'-'+invariable[2]).animate({"height": "-="+newheight+"px"}, 500);
			}
			jQuery('#showpost-'+invariable[0]+'-'+invariable[2]+' .showpostload').fadeOut(500);
			jQuery('#showpost-'+invariable[0]+'-'+invariable[2]+' .showpostpostcontent').delay(600).fadeIn(200);
			jQuery('.closehomeshow-'+invariable[0]+'.closeajax').delay(600).fadeIn(200);	
			jQuery('.imagesSPAll .loading').removeClass('loading');
			jQuery('#slider').css('display','block');
			jQuery('#slider .images').animate({'opacity':1},300);
			jQuery('#slider,#slider img,.textSlide').css('opacity','1');

		}) 

		});

	}
	jQuery('.closehomeshow-'+invariable[0]).click(function() {
		var height = jQuery('#showpost-'+invariable[0]+'-'+invariable[2]).height();
		jQuery('#showpost-'+invariable[0]+'-'+invariable[2]+' .showpostpostcontent').fadeOut(200);
		jQuery('.closehomeshow-'+invariable[0]+'.closeajax').fadeOut(200);	
		jQuery('#showpost-'+invariable[0]+'-'+invariable[2]).animate({"height": "-="+height+"px"}, 750);
		jQuery('.tabsshort.'+invariable[0]+',.products-both .bx-controls-direction,.aq-block-aq_port_block_feed .titlebordrtext,.aq-block-aq_port_block_feed .bx-controls-direction').delay(450).fadeIn(300);

	});
	});
	});
	




jQuery(document).ready(function(){
jQuery('.overgallery').hide();
jQuery('.overvideo').hide();
jQuery('.overdefult').hide();
jQuery('.overport').hide();
jQuery(window).load(function () {

jQuery('.one_half').find('.loading').attr('class', '');
jQuery('.one_third').find('.loading').attr('class', '');
jQuery('.one_fourth').find('.loading').attr('class', '');
jQuery('.item').find('.loading').attr('class', '');
jQuery('.item4').find('.loading').attr('class', '');
jQuery('.item3').find('.loading').attr('class', '');
jQuery('.blogimage').find('.loading').attr('class', '');
jQuery('.image').css('background', 'none');
jQuery('.recentimage').css('background', 'none');
jQuery('.audioPlayerWrap').css({'background':'none','height':'25px','padding-top':'0px'});
jQuery('.blogpostcategory').find('.loading').removeClass('loading');
jQuery('.image').find('.loading').removeClass('loading');
//show the loaded image
jQuery('iframe').show();
jQuery('img').show();
jQuery('.audioPlayer').show();
jQuery('.overgallery').show();
jQuery('.overvideo').show();
jQuery('.overdefult').show();
jQuery('.overport').show();
jQuery('#slider-wrapper .loading').removeClass('loading');
jQuery('.imagesSPAll .loading').removeClass('loading');
jQuery('#slider').css('display','block');
jQuery('#slider .images').animate({'opacity':1},300);
jQuery('#slider,#slider img,.textSlide').css('opacity','1');
jQuery('#slider-wrapper').css('max-height','500px');
});
});


/*resp menu*/
jQuery(document).ready(function(){	
jQuery('.resp_menu_button').click(function() {
if(jQuery('.event-type-selector-dropdown').attr('style') == 'display: block;')
jQuery('.event-type-selector-dropdown').fadeOut(200);
else
jQuery('.event-type-selector-dropdown').fadeIn(200);
});	
jQuery('.event-type-selector-dropdown').click(function() {
jQuery('.event-type-selector-dropdown').fadeOut(200);
});


});


/*block team hover*/
jQuery(document).ready(function(){
	jQuery( ".team .social div" ).each(function() {		
		var back = jQuery(this).attr('style');
		var backC = back.split(":");

		jQuery(this).hover(function(){
		jQuery(this).find('a').css('background-color',backC[1]+' !important');
		},
		function(){
		jQuery(this).find('a').css('background-color','');		
		}
		);
	});		
});	

/*portfolio click hover*/
jQuery(document).ready(function(){	
jQuery('#remove h2 a:first-child').attr('class','catlink catlinkhover');
jQuery('.catlink').click(function() {
jQuery('#remove h2 a').attr('class','catlink');
jQuery(this).attr('class','catlink catlinkhover');
});	
});

/*animate search*/
jQuery(document).ready(function(){	

jQuery('.menu-src').hover(function(){
	jQuery('.menu-src-input').stop(true,true).animate({width:'toggle'},350);
	jQuery('.top-nav .menu-item').stop(true,true).fadeOut(150);
},
function () {
	jQuery('.menu-src-input').stop(true,true).animate({width:'toggle'},350);
	jQuery('.top-nav .menu-item').stop(true,true).delay(150).fadeIn(350);
});
});

/*animate support*/
jQuery(document).ready(function(){	
		if(jQuery('body').find('.bottom-support-tab').length){
			jQuery('.fa-chevron-down').hide();
			jQuery('.support-widget h3').click(function(){
				jQuery('.support-content').stop(true,true).animate({height:'toggle'},350);
				jQuery('.fa-chevron-down').delay(350).fadeIn(100);
				jQuery('.bottom-support-tab h3').stop(true,true).fadeOut(100);
			});
			jQuery('.fa-chevron-down').click(function(){
				jQuery('.support-content').stop(true,true).animate({height:'toggle'},350);	
				jQuery('.fa-chevron-down').hide();
				jQuery('.bottom-support-tab h3').delay(400).fadeIn(600);
				
			});
		}
});


/*show 2 product image*/
jQuery(document).ready(function(){	
	jQuery('.homerecent .recentimage').each(function() {
		if(jQuery(this).find('.image1').length){
			jQuery(this).hover(function(){
				jQuery(this).find('.image1').css({'opacity':'1','filter':'alpha(opacity=100)'});
				jQuery(this).find('.image0').css({'opacity':'0','filter':'alpha(opacity=0)'});
			},
			function () {
				jQuery(this).find('.image1').css({'opacity':'0','filter':'alpha(opacity=0)'});
				jQuery(this).find('.image0').css({'opacity':'1','filter':'alpha(opacity=100)'});			
			});
		}
	});
});


/*animate tabs*/
jQuery(document).ready(function(){	
	if(jQuery('body').find('.tabwrap').length){
		jQuery( ".tabwrap" ).tabs({ hide: { effect: "fade", duration: 400 } });
		jQuery( ".tabwrap" ).tabs({ show: { effect: "fade", duration: 400 } });
	}
});
/*tabs li width*/
jQuery(document).ready(function(){
	jQuery( window ).resize(function() {
		addWidth()
	});
	
	function addWidth(){
		if(jQuery( window ).width()<1180){
		
			jQuery('.productR .bx-wrapper li, .post-full-width-inner li').css('min-width',jQuery( window ).width());
			jQuery('.productR, .post-block').each(function() {
				jQuery(this).find('li').first().css('display','block');
			});
			jQuery('.shop-categories').each(function() {
				jQuery(this).find('li').css('display','block');
			});
			}
		else
		{
			jQuery('.productR .bx-wrapper li, .post-full-width-inner li').css('min-width','1180px');	
		}
	}
	addWidth();

});

/*add submenu class*/
jQuery(document).ready(function(){
jQuery('.menu > li').each(function() {
if(jQuery(this).find('ul').size() > 0 ){
jQuery(this).addClass('has-sub-menu');
}
});
});
/*animate menu*/
jQuery(document).ready(function(){
jQuery('ul.menu > li').hover(function(){
jQuery(this).find('ul').stop(true,true).fadeIn(300);
},
function () {
jQuery(this).find('ul').stop(true,true).fadeOut(300);
});
});
/*add lightbox*/
jQuery(document).ready(function(){
jQuery(".gallery a").attr("rel", "lightbox[gallery]");
});
/*form hide replay*/
jQuery(document).ready(function(){
jQuery(".reply").click(function(){
jQuery('#commentform h3').hide();
});
jQuery("#cancel-comment-reply-link").click(function(){
jQuery('#commentform h3').show();
});
});

function scroll_menu(){
jQuery(window).bind('scroll', function(){
if(jQuery(this).scrollTop() > 250) {
jQuery(".totop").fadeIn(200);
jQuery(".fixedmenu").slideDown(200);}
else{
jQuery(".totop").fadeOut(200);
jQuery(".fixedmenu").slideUp(200);}
});
}

scroll_menu();

/*browserfix*/
jQuery(document).ready(function(){
if(jQuery.browser.opera){
jQuery('#headerwrap').css('top','0');
jQuery('#wpadminbar').css('display','none');
}
if (jQuery.browser.msie && jQuery.browser.version.substr(0,1)<9) {
jQuery('.cartTopDetails').css('border','1px solid #eee');
jQuery('#headerwrap').css('border-bottom','1px solid #ddd');
}
});
/* lightbox*/
function loadprety(){
jQuery(".gallery a").attr("rel", "lightbox[gallery]").prettyPhoto({theme:'light_rounded',overlay_gallery: false,show_title: false,deeplinking:false});
}

jQuery(document).ready(function(){
jQuery('.gototop').click(function() {
jQuery('html, body').animate({scrollTop:0}, 'medium');
});
});
/*search*/
jQuery(document).ready(function(){
if(jQuery('.widget_search').length>0){
jQuery('#sidebarsearch input').val('Search...');
jQuery('#sidebarsearch input').focus(function() {
jQuery('#sidebarsearch input').val('');
});
jQuery('#sidebarsearch input').focusout(function() {
jQuery('#sidebarsearch input').val('Search...');
});
}
});
jQuery(document).ready(function(){
jQuery('.add_to_cart_button.product_type_simple').live('click', function() {
jQuery(this).parents(".product").children(".process").children(".loading").css("display", "block");
jQuery(this).parents(".product").children(".thumb").children("img").css("opacity", "0.1");
});
jQuery('body').bind('added_to_cart', function() {
jQuery(".product .loading").css("display", "none");
//$(".product .added").parents(".product").children(".process").children(".added-btn").css("display", "block").delay(500).fadeOut('slow');
jQuery(".product .added").parents(".product").children(".thumb").children("img").delay(600).animate( { "opacity": "1" });
return false;
});
});