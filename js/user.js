$(document).ready(function(){
    var hash=location.hash ;
    hash=hash.replace("#",'');
    $("#user-profile-tabs a[href='#"+hash+"']").tab('show');
    $("#user-bragging a").click(function(e){
    	var hash=$(this).attr('href');
    	console.log(hash);
    	$("#user-profile-tabs a[href='"+hash+"']").tab('show');
    });
});
$(document).on('mouseenter','.user-recommended-list .list',function(){
    if($(this).find('.unlike-btn').length>0){
    	$(this).find('.unlike-btn').removeClass('hidden');	
    }else{
    	$(this).find('.remove-from-list').removeClass('hidden');
    }
});
$(document).on('mouseleave','.user-recommended-list .list',function(){
    if($(this).find('.unlike-btn').length>0){
    	$(this).find('.unlike-btn').addClass('hidden');	
    }else{
    	$(this).find('.remove-from-list').addClass('hidden');
    }
});
$(document).on('mouseenter','.user-recommended-menu .food-item',function(){
    $(this).find('.remove-recommend').removeClass('hidden');
});
$(document).on('mouseleave','.user-recommended-menu .food-item',function(){
    $(this).find('.remove-recommend').addClass('hidden');
});

$(document).on('click','.remove-recommend',function(e){
	var item=$(this).attr('data-id');
	var cityurl=$(this).attr('data-city');
	$("#food-item-"+item).remove();
	$.ajax({
		url:base+'/'+cityurl+'/aj/recommendmenu',
		data:{'menu':item,'recommend':0},
		type:'POST',
		success:function(){

		}
	});
})

$(document).on('click','.unlike-btn',function(e){
	var rest=$(this).attr('data-rest');
	if(loggedinuser){
		var r=confirm(langlibrary.are_you_sure);
		if(r==true){
			$("#rest-recommend-"+rest).remove();
			var tdata={removelike:1};
			$.ajax({
	            url:base+'/aj/likerest/'+rest,
	            type:"GET",
	            data:tdata,
	            success:function(data){
	            }
			});
		}
	}
});

$(document).on('click','.remove-from-list',function(){
	var rest=$(this).attr('data-rest');
	var list=$(this).attr('data-list');
	if(loggedinuser){
		var r=confirm(langlibrary.are_you_sure);
		if(r==true){
			$("#rest-list-"+rest).remove();
			var tdata={rest:rest,list:list}
			$.ajax({
	            url:base+'/aj/removelist',
	            type:"POST",
	            data:tdata,
	            success:function(data){
	            }
			});
		}
	}
});
$(document).on('click','.delete-list',function(e){
	e.preventDefault();
	var list=$(this).attr('data-list');
	var r=confirm(langlibrary.are_you_sure);
	if(r==true){
		$("#rest-list-cont-"+list).remove();
			var tdata={list:list}
			$.ajax({
	            url:base+'/aj/deletelist',
	            type:"POST",
	            data:tdata,
	            success:function(data){
	            }
			});
	}
});
$(document).on('click','.user-load-more-button',function(e){
	var loaded=$(this).attr('data-loaded');
	var user=$(this).attr('data-user');
	var cnt=$(this).attr('id');
	var scenario=$(this).attr('data-scenario');
	$(this).addClass('loading').html(loading_txt+'....');
	$.ajax({
		url:base+'/userhelp/'+scenario,
		data:{loaded:loaded,user:user},
		type:'GET',
		success:function(data){
			$("#"+cnt).removeClass('loading').html(load_more_txt);
			if(scenario== 'restlikes'){
				scenario = 'recommends';
				$("#user-"+scenario+" #userLikes .row").append(data['html']);
				$("#"+cnt).attr('data-loaded',data['totalloaded']);
			}else if(scenario== 'activity'){
				$("#news-feed .mynews").append(data['html']);
				$("#"+cnt).attr('data-loaded',data['totalloaded']);
			}else{
				$("#user-"+scenario+" .d-flex").append(data['html']);
			$("#"+cnt).attr('data-loaded',data['totalloaded']);
			}
			if(data['totalloaded']>=data['total']||(data['html']=='')){
				$("#"+cnt).remove();
			}
		}
	});
});
$(document).on('click','.event-title',function(e){
	e.preventDefault();
	var eventid=$(this).attr('data-event');
	sufratiloading();
	$.ajax({
		url:base+'/aj/getevent/'+eventid,
		data:{},
		success:function(data){
			sufratipopup(data['html'],function(){});
		}
	})
});

$(document).on('click','.cancel-event',function(e){
	e.preventDefault();
    var id=$(this).attr('data-event');
    var r=confirm(langlibrary.are_you_sure);
    if(r){
        window.location.href=base+'/aj/cancelevent/'+id;
    }
});


	  $(window).scroll(function(){
	var sticky2 = $('.user-profile-nav'),
		scroll2 = $(window).scrollTop();
  
	if (scroll2 >= 100) sticky2.addClass('fixed-user-menu');
	else sticky2.removeClass('fixed-user-menu');
  });
  $(window).on( 'hashchange', function(e) {
	if(window.location.hash) {
		var ar = ""+decodeURIComponent(location.hash)+"";
		ar = ar.replace(/\s/g, '').substr(1);
		$('.user-profile-nav .nav-list .active').removeClass('active');
		$("[href='#"+ar+"']").addClass('active');
		$('.azooma-tabs .show').removeClass('show');
		$('.azooma-tabs #' + ar).addClass('show');
	} 
});
$(window).on( 'load', function(e) {
	if(window.location.hash) {
		var ar = ""+decodeURIComponent(location.hash)+"";
		ar = ar.replace(/\s/g, '').substr(1);
		$('.user-profile-nav .nav-list .active').removeClass('active');
		$("[href='#"+ar+"']").addClass('active');
		$('.azooma-tabs .show').removeClass('show');
		$('.azooma-tabs #' + ar).addClass('show');
	} 
});
$('#user-profile-nav-list').click(function(){
	$('.nav-list').toggle();
})
$('#large-user-nav-btn').click(function(){      
	$('.large-sub-menu').toggle();
	$(this).toggleClass('active-btn');
})