/* shortcode*/
jQuery(document).ready(function(){
if(jQuery('.accordion').length>0){
jQuery(function() {
jQuery( ".accordion" ).accordion({
autoHeight: false,
navigation: true
});
});
}
if(jQuery('.progressbar').length>0){
jQuery(function() {
jQuery( ".progressbar" ).progressbar();
});
}
});
jQuery(document).ready(function() {
jQuery(".toggle_container").hide();
jQuery("h2.trigger").click(function(){
jQuery(this).toggleClass("active").next().slideToggle("slow");
});
});
jQuery(document).ready(function(){
jQuery(function() {
jQuery(".tabwrap").tabs();
});
});

