$(document).ready(function(){
	$("#load-more-suggestion").click(function(){
		var loaded=$(this).attr('data-loaded');
		var user=$(this).attr('data-user');
		var cnt=$(this).attr('id');
		$(this).addClass('loading').html(loading_txt+'....');
		$.ajax({
			url:base+'/usersuggestions',
			data:{loaded:loaded,user:user},
			type:'GET',
			success:function(data){
				$("#"+cnt).removeClass('loading').html(load_more_txt).blur();
				$(data['html']).insertBefore("#suggest-morebtn-cnt");
				$("#"+cnt).attr('data-loaded',data['totalloaded']);
				if(data['totalloaded']>=data['total']||(data['html']=='')){
					$("#"+cnt).remove();
				}
			}
		});
	});

	$("#load-more-restaurant-tolike").click(function(){
		var loaded=$(this).attr('data-loaded');
		var user=$(this).attr('data-user');
		var cnt=$(this).attr('id');
		$(this).addClass('loading').html(loading_txt+'....');
		$.ajax({
			url:base+'/likesuggestions',
			data:{loaded:loaded,user:user},
			type:'GET',
			success:function(data){
				$("#"+cnt).removeClass('loading').html(load_more_txt).blur();
				$(data['html']).insertBefore("#suggest-morebtn-cnt");
				$("#"+cnt).attr('data-loaded',data['totalloaded']);
				if(data['totalloaded']>=data['total']||(data['html']=='')){
					$("#"+cnt).remove();
				}
			}
		});
	});
	$(".user-preference-save-btn").click(function(e){
		e.preventDefault();
		if($(".cuisine-like-list li a[data-selected]").length>0){
			var k=t=[],i=0;
			$.each($(".cuisine-like-list li a[data-selected]"),function(index,value){
				k[i]=$(value).attr('data-cuisine');
				i++;
			});
			$("#user-liked-cuisines").val(k);
			i=0;
			$.each($(".cuisine-like-list li a:not([data-selected])"),function(index,value){
				t[i]=$(value).attr('data-cuisine');
				i++;
			});
			$("#user-disliked-cuisines").val(t);
			$("#user-preferences-block form").submit();
		}else{
			alert(langlibrary.please_select_cuisines);
		}
	});
});