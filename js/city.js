$(document).ready(function(){
	var img = new Image();
    var bg=$("#home-featured-cities .item:first-child").attr('data-bg');
    img.src = $("#home-featured-cities .item:first-child").attr('data-bg');
    img.onload = function(){
    	$("#background-block").css('background-image','url('+bg+')');
    }
	$("#home-featured-cities").on('slid.bs.carousel',function(){
		var bg=$("#home-featured-cities .item.active").attr('data-bg');
		var img = new Image();
    	img.src=bg;
    	img.onload=function(){
    		$("#background-block").css('background-image','url('+bg+')');
    	}
	});
});