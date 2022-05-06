var sliderarray={tooltip:'hide'};
$(document).ready(function(){
	$('.go-same-page').click(function(e){
		e.preventDefault();
		var mytar = $(this).attr('href');
		if(location.hash == "n"){
			location.hash = "about";
		}
		$([document.documentElement, document.body]).animate({
			scrollTop: $(mytar).offset().top - 100
		}, 500);
	  });
	var hash=location.hash;
  	if(hash!=""){
  		if(($("#rest-profile-tabs a[href='"+hash+"']").length>0)){
	  		$("#rest-profile-tabs a[href='"+hash+"']").tab('show');
	  	}else{
	  		hash=hash.replace("#",'');
		  	if(hash.indexOf("user-review-")!=-1){
		  		$("#rest-profile-tabs a[href='#rest-reviews']").tab('show');
		  		var scrollindex=$('#'+hash).offset().top-100;
		  		$('body').animate({scrollTop: scrollindex},'slow');
		  		$("#"+hash).addClass('bring-front');
		  		setTimeout(function(){
		  			$("#"+hash).removeClass('bring-front');
		  		},1500);
		  	}
		  	if(hash.indexOf("user-photo-")!=-1){
		  		$("#rest-profile-tabs a[href='#rest-gallery']").tab('show');
		  		var scrollindex=$('#'+hash).offset().top;
		  		$('body').animate({scrollTop: scrollindex},'slow');
		  		if($("#"+hash).hasClass('hidden')){
		  			$("#"+hash).removeClass('hidden');
		  		}
		  		$("#"+hash).focus();
		  	}
		  	if(hash.indexOf("menu-item-")!=-1){
		  		$("#rest-profile-tabs a[href='#rest-menu']").tab('show');
		  		var scrollindex=$('#'+hash).offset().top-100;
		  		$('body').animate({scrollTop: scrollindex},'slow');
		  		$("#"+hash).addClass('bring-front');
		  		setTimeout(function(){
		  			$("#"+hash).removeClass('bring-front');
		  		},1500);
		  	}
	  	}
  	}
  	$("#recommend").bootstrapSwitch({wrapperClass:'ltr'});
  	$("#comment-error-box").hide();
  	
  	$("input.slider").slider(sliderarray).on('slideStop slide',function(value){
  	 	var cls=getClass(value);
  	 	var curel=$(this).attr('id')+'Slider';
  	 	$("#"+curel).next().find('i').attr('class','').addClass(cls);
  	});
  	$("#rt-food-anime").css('width',foodavg+'%');
  	$("#rt-service-anime").css('width',serviceavg+'%');
  	$("#rt-atmosphere-anime").css('width',atmosphereavg+'%');
  	$("#rt-value-anime").css('width',valueavg+'%');
  	$("#rt-variety-anime").css('width',varietyavg+'%');
  	$("#rt-presentation-anime").css('width',presentationavg+'%');
  	$("#rest-website-link").click(function(){
  		var rest=$(this).attr('data-id');
  		$.get(base+'/'+city['url']+'/aj/websiteref',{rest:rest},function(data){});
  	});
  	if(typeof noreviews!="undefined"){ 
  		var $thtml=$('<div>').append($('#add-review-form').clone(true)).html();
  		if(location.hash!=""&&location.hash!="#n"&&location.hash!="#rest-about"){
  			$("#add-review-form").remove();
  		}
  		if(location.hash=="#rest-reviews"){
  			$("#rest-reviews").append($thtml);
  			$("input.slider").slider(sliderarray).on('slideStop slide',function(value){
		  	 	var cls=getClass(value);
		  	 	var curel=$(this).attr('id')+'Slider';
		  	 	$("#"+curel).next().find('i').attr('class','').addClass(cls);
		  	});
  		}
  		$("#rest-profile-tabs a").on('shown.bs.tab',function(e){
  			$thtml=$('<div>').append($('#add-review-form').clone(true)).html();
  			if($("#add-review-form").length>0){
  				$("#add-review-form").remove();
  			}
  			if($(e.target).attr('href')=="#rest-about"){
  				$("#rest-about").append($thtml);
  				$("input.slider").slider(sliderarray).on('slideStop slide',function(value){
			  	 	var cls=getClass(value);
			  	 	var curel=$(this).attr('id')+'Slider';
			  	 	$("#"+curel).next().find('i').attr('class','').addClass(cls);
			  	});
  			}
  			if($(e.target).attr('href')=="#rest-reviews"){
  				$("#rest-reviews").append($thtml);	
  				$("input.slider").slider(sliderarray).on('slideStop slide',function(value){
			  	 	var cls=getClass(value);
			  	 	var curel=$(this).attr('id')+'Slider';
			  	 	$("#"+curel).next().find('i').attr('class','').addClass(cls);
			  	});
  			}
  		});
  	}

});
$("#add-review-btn,#add-review-from-reviews-page").click(function(e){
	e.preventDefault();
	var activetab=$("#rest-profile-tabs li.active a").attr('href');
	if(activetab!="#rest-about"){
		$("#rest-profile-tabs a[href='#rest-about']").tab('show');
	}
	smoothScroll.animateScroll(null,'#rest-review-form',{callbackAfter:function(){ $("#user-comment").focus(); }});
})
$(".load-gallery-tab").click(function(e){
	e.preventDefault();
	$('#rest-profile-tabs a[href="#rest-gallery"]').tab('show');
});
$("#load-more-reviews").click(function(e){
	e.preventDefault();
	var loaded=$(this).attr('data-loaded');
	var rest=$(this).attr('data-rest');
	var total=$(this).attr('data-total');
	$.ajax({
		url:base+'/'+city['url']+'/aj/c/'+rest+'/'+loaded,
		type:'GET',
		success:function(data){
			if(data['loaded']>=total||data['html']==""){
				$("#load-more-reviews").remove();
			}else{
				$("#load-more-reviews").attr('data-loaded',data['loaded']);
				$("#user-reviews-container .sufrati-user-review.last").removeClass('last');
				$("#user-reviews-container").append(data['html']);
			}
		}
	});
});

$("#load-more-sfphotos").click(function(e){
	e.preventDefault();
	$("#sufrati-profile-gallery li").removeClass('hidden');
	$("#load-more-sfphotos").remove();
});
$("#load-more-uphotos").click(function(e){
	e.preventDefault();
	$("#user-profile-gallery li").removeClass('hidden');
	$("#load-more-uphotos").remove();
});
$(document).on('click','.mealtype-btn',function(e){
	e.preventDefault();
	$(".mealtype-btn").removeClass('btn-clicked');
	$(this).addClass('btn-clicked');
	$("#mealtype").val($(this).attr('data-val'));
});
$(document).on('keyup','#user-comment',function(e){
	if($("#user-comment").val()!=""){
	    $("#comment-error-box").hide('2000');
	}else{
	    $("#comment-error-box").show('2000');
	}
});
$(document).on('submit','#rest-review-form',function(e){
	if($("#user-comment").val()==""){
		$("#user-comment").focus();
		$("#comment-error-box").show('2000');
		return false;
	}
	if($("#user-comment").val().length<5){
		$("#user-comment").focus();
		$("#comment-error-box").show('2000');
		return false;	
	} 
	if(loggedinuser){
		return true;
	}else{
		var kdata=$("#rest-review-form").serialize(),tdata={'function':'comment'};
		kdata=kdata.split('&');
		$.each(kdata,function(index,item){
	        var t=item.split('=');
	        if(t[0]!=""){
	          tdata[t[0]]=t[1];
	        }
	    });
		sufratiloginpopup("sufrati-login-form",tdata);
		return false;
	}
});

$("#add-photo-btn").click(function(e){
	e.preventDefault();
	if(loggedinuser){
		// sufratipopupinitialize();
		// sufratipopup(_.template($("#photo-upload-form-tpl").html()),function(){
            
        // });	
		$('#photo-upload-form').modal('toggle');
	}else{
		sufratiloginpopup("sufrati-login-form");
	}
});

$("#add-to-list-btn").click(function(e){
	e.preventDefault();
	if(loggedinuser){
		sufratipopupinitialize();
		sufratipopup(_.template($("#add-to-list-form-tpl").html()),function(){
            
        });

	}else{
		sufratiloginpopup("sufrati-login-form");
	}
});

$("#add-rating-btn").click(function(e){
	e.preventDefault();
	if(loggedinuser){
		sufratipopupinitialize();
		sufratipopup(_.template($("#add-rating-pop-tpl").html()),function(){
            $("input.pop-slider").slider(sliderarray).on('slideStop slide',function(value){
		  	 	var cls=getClass(value);
		  	 	var curel=$(this).attr('id')+'Slider';
		  	 	$("#"+curel).next().find('i').attr('class','').addClass(cls);
		  	});
        });

	}else{
		sufratiloginpopup("sufrati-login-form");
	}
});

$("#claim-business-btn").click(function(e){
	e.preventDefault();
	// sufratipopupinitialize();
	$('#claim-pop').modal('toggle');
	// sufratipopup(_.template($("#claim-pop-tpl").html()),function(){
	// 	if(loggedinuser){
	// 		$("#claim-rest-form input[name='claim_tel']").focus();
	// 	}else{
	// 		$("#claim_name").focus();
	// 	}
	// });
});

function readFile(input){
	var _URL = window.URL || window.webkitURL;
	var validfiles = [".jpg", ".jpeg", ".bmp", ".png"];
	if (input.files && input.files[0]) {
		var filename=input.value;
		if(filename.length>0){
			var valid=false;
			for(var j=0;j<validfiles.length;j++){
				var substr=filename.substr(filename.length - validfiles[j].length, validfiles[j].length).toLowerCase();
				if (substr == validfiles[j].toLowerCase()) {
                    valid = true;
                    break;
                }	
			}
			if(valid){
				var img=new Image();
		        img.onload = function () {
		        	if(this.width<400||this.height<400){
		        		alert(langlibrary.select_bigger_image)
		        	}else{
		        		$(".image-placeholder").html('<img src="'+this.src+'" width="135" height="118"/>');	
		        	}
		        	
		        }
		        img.src=_URL.createObjectURL(input.files[0]);
		        $("textarea[name='photo-caption']").focus();
			}else{
				alert('Please select an image');
			}
		}
        
    }
}

function getClass(value){
	var classes=['icon-emo-angry','icon-emo-sleep','icon-emo-tongue','icon-emo-happy','icon-emo-grin','icon-emo-sunglasses'];
	return classes[value.value/2];
}

$(document).on('click','#submit-rating-btn',function(e){
	e.preventDefault();
	if(loggedinuser){
		var tdata=$("#add-rating-block").serializeArray();
		$.ajax({
			url:base+'/'+city['url']+'/aj/rating',
			data:tdata,
			type:'POST',
			success:function(data){
				if(typeof data['ratinginfo']!="undefined"){
					var count=data['ratinginfo']['total'];
					var total=((parseInt(data['ratinginfo']['totalfood'])+parseInt(data['ratinginfo']['totalservice'])+parseInt(data['ratinginfo']['totalatmosphere'])+parseInt(data['ratinginfo']['totalvalue'])+parseInt(data['ratinginfo']['totalvariety'])+parseInt(data['ratinginfo']['totalpresentation']))/data['ratinginfo']['total']).toFixed(1);
					$("#total-rating-value").html(total);
					$("#total-rating-count").html(count);
					$("#total-rating-count").html(count);
					foodavg=parseInt(data['ratinginfo']['totalfood'])/data['ratinginfo']['total'];
					serviceavg=parseInt(data['ratinginfo']['totalservice'])/data['ratinginfo']['total'];
					atmosphereavg=parseInt(data['ratinginfo']['totalatmosphere'])/data['ratinginfo']['total'];
					valueavg=parseInt(data['ratinginfo']['totalvalue'])/data['ratinginfo']['total'];
					varietyavg=parseInt(data['ratinginfo']['totalvariety'])/data['ratinginfo']['total'];
					presentationavg=parseInt(data['ratinginfo']['totalpresentation'])/data['ratinginfo']['total'];
					$("#rating-value-food").html(Math.round(foodavg));
					$("#rating-value-service").html(Math.round(serviceavg));
					$("#rating-value-atmosphere").html(Math.round(atmosphereavg));
					$("#rating-value-variety").html(Math.round(varietyavg));
					$("#rating-value-value").html(Math.round(valueavg));
					$("#rating-value-presentation").html(Math.round(presentationavg));
					$("#add-rating-pop .popup-content").html('<h2>'+langlibrary.thank_you+'</h2>');
					setTimeout(function(){
						closepopup(function(){
							$("#rt-food-anime").css('width',Math.round(foodavg*10)+'%');
							$("#rt-service-anime").css('width',Math.round(serviceavg*10)+'%');
							$("#rt-atmosphere-anime").css('width',Math.round(atmosphereavg*10)+'%');
							$("#rt-value-anime").css('width',Math.round(valueavg*10)+'%');
							$("#rt-variety-anime").css('width',Math.round(varietyavg*10)+'%');
							$("#rt-presentation-anime").css('width',Math.round(presentationavg*10)+'%');
						});
					},2000);
				}
			}
		})
	}else{
		sufratiloginpopup("sufrati-login-form");
	}
});
function downloadMenu(menu){
	$.get(base+'/'+city.url+'/aj/dlmenu/'+menu,function(){});
}
$(document).on("click","#save-to-list-btn",function(e){
	e.preventDefault();
	$("#add-to-list-form form").submit();
});
$(document).on("submit","#claim-rest-form",function(e){
	var k=true;
	$.each($("#claim-rest-form .required"),function(key,value){
		if($(value).val()==""){
			alert(langlibrary.please_add_all_fields)
			k=false;
			return false;
		}
	});
	if(!k){
		return false;
	}
	if(!checkEmail($("#claim-rest-form input[name='claim_email']").val())){
		alert(langlibrary.email_incorrect);
		return false;
	}
});
$("#menu-request-form").submit(function(e){
	if(loggedinuser){
		return true;
	}else{
		if($("#menuemail").val()==""){
			$("#menuemail").focus();
			alert(langlibrary.email_required);
			return false;
		}
		if(!checkEmail($("#menuemail").val())){
			$("#menuemail").focus();
			alert(langlibrary.email_incorrect)
			return false;	
		}
	}
});
$(document).on('click','.submit-photo',function(e){
	e.preventDefault();
	var $form=$(this).parents('form:first')
	if($form.find(".photo-btn").val()!=""){
		$form.submit();
	}else{
		alert(langlibrary.please_select_photo);
	}
});

$(document).on('click','.menu-recommend-btn',function(e){
	if(loggedinuser){
		var menu=$(this).attr('data-menu'),total=0,recommend=1;
		var $total=$("#menu-recommend-total-"+menu);
		if($("#menu-recommend-total-"+menu+" span").html()!=""){
			total=parseInt($("#menu-recommend-total-"+menu+" span").html());
		}
		if($(this).hasClass('recommended')){
			total--;
			$(this).removeClass('recommended');
			$(this).html('<i class="fa fa-thumbs-o-up"></i>');
			recommend=0;
		}else{
			total++;
			$(this).addClass('recommended');
			$(this).html('<i class="fa fa-thumbs-up"></i>')
		}
		var str='<span id="menu-recommend-total-'+menu+'">';
		if(total>0){
			str+=total;
		}
		str+='</span> '+langchoice(langlibrary.recommendation_choices,total);
		$total.html(str);
		$.ajax({
			url:base+'/'+city['url']+'/aj/recommendmenu',
			data:{'menu':menu,'recommend':recommend},
			type:'POST',
			success:function(){

			}
		});
	}else{
		sufratiloginpopup("sufrati-login-form");
	}
});

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
		sufratiloginpopup("sufrati-login-form");
	}
});
$(document).on('click','.show-comment-btn',function(e){
	$('#rest-profile-tabs a[href="#rest-reviews"]').tab('show');
	if($(this).attr('data-review')){
		var review=$(this).attr('data-review');
		var scrollindex=$('#user-review-'+review).offset().top-100;
  		$('body').animate({scrollTop: scrollindex},'slow');
  		$('#user-review-'+review).addClass('bring-front');
  		setTimeout(function(){
  			$('#user-review-'+review).removeClass('bring-front');
  		},1500);
	}
});
$(document).on('click','#branch-correct-btn',function(e){
	$("#branch-correction-form").removeClass('hidden');
	$("#branch-contents").addClass('hidden');
	$("#branch-box").css('width','500px');
	$("#sufrati-modal-container").center();
	var zoom=14;
	var title=$("#branch-correction-form").attr('data-title');
	require(['async!http://maps.google.com/maps/api/js?key=AIzaSyDlBwn7IHKMc9fTsdoACBRidhjfGESyYO0&sensor=true!callback'],function(){
		if($("#branch-correction-form").attr('data-latitude')&&$("#branch-correction-form").attr('data-longitude')){
			var latitude=$("#branch-correction-form").attr('data-latitude');
			var longitude=$("#branch-correction-form").attr('data-longitude');
	        var LatLng=new google.maps.LatLng(latitude,longitude);
	        var mapOptions = {
		        center: LatLng,
		        zoom: zoom
		    };
		    var map = new google.maps.Map(document.getElementById("branch-suggest-map"),mapOptions);
		    var marker = new google.maps.Marker({
		        position: LatLng,
		        map: map,
		        title:title,
		        draggable:true
		    });
		    google.maps.event.addListener(marker,'dragend',function(e){
		    	$("#new-latitude").val(e.latLng.lat());
		    	$("#new-longitude").val(e.latLng.lng());
		    });
	    }else{
	    	var address=$("#branch-correction-form").attr('data-address');
	    	var geocoder=new google.maps.Geocoder();
	    	if(geocoder){
	    		geocoder.geocode(
	    		{'address': address}, function(results, status) {
	    			if (status == google.maps.GeocoderStatus.OK) {
	        			if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
	        				var LatLng=results[0].geometry.location;
	        				var mapOptions = {
						        center: LatLng,
						        zoom: zoom
						    };
						    var map = new google.maps.Map(document.getElementById("branch-suggest-map"),mapOptions);
						    var marker = new google.maps.Marker({
						        position: LatLng,
						        map: map,
						        title:title,
						        draggable:true
						    });
						    google.maps.event.addListener(marker,'dragend',function(e){
						    	$("#new-latitude").val(e.latLng.lat());
						    	$("#new-longitude").val(e.latLng.lng());
						    });
	        			}
	        		}
			    });
	    	}
	    }
	});
});
$(document).on('submit','#branch-correct-form',function(e){
	e.preventDefault();
	if(!loggedinuser){
		if($("#branch-correct-form input[name='yourName']").val().length<=0){
			alert(langlibrary.name_required2);
			return false;
		}
		if($("#branch-correct-form input[name='yourEmail']").val().length<=0){
			alert(langlibrary.email_required);
			return false;
		}
		if(!checkEmail($("#branch-correct-form input[name='yourEmail']").val())){
			alert(langlibrary.email_incorrect);
			return false;
		}
	}	
	if($("#new-latitude").val()==""&&$("#new-longitude").val()==""){
		alert(langlibrary.please_drag_location);
		return false;
	}
	var kdata=$("#branch-correct-form").serialize(),tdata={};
	kdata=kdata.split('&');
	$.each(kdata,function(index,item){
        var t=item.split('=');
        if(t[0]!=""){
        	tdata[t[0]]=t[1];
        }
    });
    sufratipopup('<div class="alert alert-success" role="alert"><b>Thank you, we\'ll verify and make the necessary changes...</b></div>',function(){
		setTimeout(function(){
			closepopup();
		},2000);
	});
	$.ajax({
		url:base+'/'+city.url+'/'+'aj/correctbranch',
		data:tdata,
		type:'POST',
		success:function(data){
		},
		dataType:'json'
	});
});
$(document).on('click','.menu-image',function(e){
	var menu=$(this).attr('data-menu');
	sufratiloading();
	$.ajax({
		url:base+'/'+city.url+'/aj/menuitem/'+menu,
		type:'GET',
		success:function(data){
			sufratipopup(data['html'],hideloading());
		}
	});
});
$(document).on('click','#branch-edit-cancel',function(e){
	$("#branch-correction-form").addClass('hidden');
	$("#branch-contents").removeClass('hidden');
	$("#branch-box").attr('style','');
	$("#sufrati-modal-container").center();
});
function getRelatedLists(rest){
	if(loggedinuser){
		sufratiloading();
		$.ajax({
			url:base+'/'+city.url+'/aj/relatedlists/'+rest,
			data:{},
			success:function(data){
				sufratipopup(data['html'],hideloading());
			}
		});
	}else{
		sufratiloginpopup();
	}
}


$(window).scroll(function(){
	var sticky = $('.restaurant-header .rest-info-all'),
		scroll = $(window).scrollTop();
  
	if (scroll >= 500) sticky.addClass('fixed-rest-header');
	else sticky.removeClass('fixed-rest-header');
  });
  window.location.hash= "about";
  $('.restaurant-nav li').click(function () {
	var mytarget = $(this).attr('data-target');
	window.location.hash= mytarget;
});

	$('#recommendTrue').click(function() {
		$('#recommend').prop('checked', true);
		$('#recommendFalse').removeClass('active');
		$(this).addClass('active');
	});
	$('#recommendFalse').click(function() {
		$('#recommend').prop('checked', false);
		$('#recommendTrue').removeClass('active');
		$(this).addClass('active');
	});
	$('.button-check').click(function() {
		var checkBoxes =  $(this).find('input');
		checkBoxes.attr("checked", !checkBoxes.attr("checked"));
		if(checkBoxes.attr("checked") == "checked"){
			$(this).addClass('active');
		}
		else{
			$(this).removeClass('active');
		}
	});

