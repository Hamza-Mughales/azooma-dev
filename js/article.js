$(document).ready(function(){
	$("#articlecomment-error-box").hide();
	$("#add-articlecomment-form").submit(function(e){
		if(loggedinuser){
			if($("#articlecomment").val().length<5){
				$("#articlecomment").focus();
				$("#articlecomment-error-box").show();
				return false;
			}else{
				$("#articlecomment-error-box").hide();
				return true;
			}
		}else{
			sufratiloginpopup("Azooma-login-form");
			return false;
		}
	});
	$("#recipe-recommend-btn").click(function(e){
		if(loggedinuser){
			var recommended=0;
			if($(this).hasClass('btn-clicked')){
				recommended=1;
			}
			$.ajax({
				url:base+'/add/reciperecommend',
				type:'GET',
				data:{'recipe':$(this).attr('data-recipe'),'recommended':recommended},
				success:function(data){
					$("#recipe-recommend-btn").html(data['recommendtext']);
					if($("#recipe-recommend-btn").hasClass('btn-clicked')){
						$("#recipe-recommend-btn").removeClass('btn-clicked');
					}else{
						$("#recipe-recommend-btn").addClass('btn-clicked');
					}
					$("#recipe-recommendations").html(data['total']);
				},
				dataType:'json'
			})
		}else{
			sufratiloginpopup("Azooma-login-form");return false;
		}
	});
	if($(".article-slide").length>0){
		$(".article-slide").addClass('hidden');
		$("#slide1").removeClass('hidden').addClass('active');
		var hash=location.hash;
		hash=hash.replace('#','');
		if(hash!=""){
			hash=hash.replace('cur-','');
			if($("#"+hash).length>0&&$("#"+hash).hasClass('article-slide')){
				$("#slide1").addClass('hidden').removeClass('active');
				$("#"+hash).removeClass('hidden').addClass('active');
			}
		}
		window.onhashchange=function(){
			hash=location.hash;
			hash=hash.replace('#','');
			if(hash!=""){
				hash=hash.replace('cur-','');
				if($("#"+hash).length>0&&$("#"+hash).hasClass('article-slide')){
					$(".article-slide.active").addClass('hidden').removeClass('active');
					$("#"+hash).removeClass('hidden').addClass('active');
				}
			}
		}
	}
});
$(document).on('click','.slide-btn',function(e){
	e.preventDefault();
	var totalslides=$(this).attr('data-total-slides');
	var currentslide=$('.article-slide.active').attr('id');
	currentslide=parseInt(currentslide.replace('slide',''));
	changeSlide(totalslides,currentslide,$(this));
});

function changeSlide(totalslides,currentslide,$this){
	var result;
	if($this.hasClass('prev-slide')){
		result=currentslide-1;
	}
	if($this.hasClass('next-slide')){
		result=currentslide+1;
	}
	if(result>0&&result<=totalslides){
		$("#slide"+currentslide).addClass('hidden').removeClass('active');	
		$("#slide"+result).removeClass('hidden').addClass('active');
		window.location.hash='cur-slide'+result;
	}
}
$(document).on('keyup','#articlecomment',function(e){
	if($("#articlecomment").val()!=""){
	    $("#articlecomment-error-box").hide();
	}else{
	    $("#articlecomment-error-box").show();
	}
});

