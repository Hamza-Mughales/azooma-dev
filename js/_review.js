$(document).on('click','.review-recommend-btn',function(e){
	e.preventDefault();
	if(loggedinuser){
		var review=$(this).attr('data-review'),agree=1;
		var support=parseInt($(this).find('span').html());
		if($(this).hasClass('agreed')){
			$(this).removeClass('agreed');
			support--;
			agree=0;
		}else{
			$(this).addClass('agreed');
			support++;
		}
		$(this).find('span').html(support);
		$.ajax({
			url:base+'/'+city['url']+'/aj/agreecomment',
			data:{'review':review,'agree':agree},
			type:'POST',
			success:function(){

			}
		});
	}else{
		sufratiloginpopup("Azooma-login-form");
	}
});