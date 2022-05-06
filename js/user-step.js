$(document).ready(function(){
	$("#step1-btn").click(function(e){
		if($("#user_City").val()==""){
			$("#step1-container .alert").removeClass('hidden');
			$('.step-errors').addClass('hidden');
			$("#city-error").removeClass('hidden');
			$("#user_City").focus();
			return false;
		}
		if($("#user_Sex").val()==""){
			$("#step1-container .alert").removeClass('hidden');
			$('.step-errors').addClass('hidden');
			$("#gender-error").removeClass('hidden');
			$("#user_Sex").focus();
			return false;
		}
		if($("#user_occupation").val()==""){
			$("#step1-container .alert").removeClass('hidden');
			$('.step-errors').addClass('hidden');
			$("#occupation-error").removeClass('hidden');
			$("#user_occupation").focus();
			return false;
		}
		$("#step1-container form").submit();
	});
	$(".user-step2-btn").click(function(e){
		e.preventDefault();
		if($(".cuisine-like-list li a[data-selected]").length>0){
			var k=[],i=0;
			$.each($(".cuisine-like-list li a[data-selected]"),function(index,value){
				k[i]=$(value).attr('data-cuisine');
				i++;
			});
			$("#user-liked-cuisines").val(k);
			$("#step2-container form").submit();
		}else{
			alert(langlibrary.please_select_cuisines);
		}
	});
	$(".user-step3-btn").click(function(e){
		e.preventDefault();
		if($(".mini-like-btn.liked").length>0){
			window.location.href=base+'/user/'+loggedinuser;
		}else{
			alert(langlibrary.like_some_restaurants);
		}
	});
	$(".user-step4-btn").click(function(e){
		e.preventDefault();
		if($(".follow-btn.following-btn").length>0){
			window.location.href=base+'/user/'+loggedinuser;
		}else{
			alert(langlibrary.follow_some_users);
		}
	});
});