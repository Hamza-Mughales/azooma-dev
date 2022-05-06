var popupshowing=false,popup_inside=false,superinside=false,historymoved=0,loading=0;
var searchTarget = "restaurantstitle";
var searchval = "";
$(document).ready(function(){
    var firebaseConfig = {
        apiKey: "AIzaSyC8tduoVHqY2gzUGPGohl4Ydttu8kcKiDg",
        authDomain: "azooma-fb074.firebaseapp.com",
        projectId: "azooma-fb074",
        storageBucket: "azooma-fb074.appspot.com",
        messagingSenderId: "1070882023924",
        appId: "1:1070882023924:web:b2cefb0b770270df1831a1",
        measurementId: "G-G5GG6JJ0DP"
      };
      // Initialize Firebase
      firebase.initializeApp(firebaseConfig);
      firebase.analytics();
        var cache = {},lastXhr;
      $("#rest_search").autocomplete({
          minLength:1,
          delay:300,
          appendTo:".search-from",
          source:function(request,response){
              var q=request.term;
            //   var q = searchval;
              if(q in cache){
                  response( cache[ q ] );
                  return;
              }
              var searchurl=base+'/'+$('#chooseCity').val()+'/find/'+q;
              lastXhr=$.getJSON(searchurl,function(data,status,xhr){
                  cache[ q ] = data;
                  if ( xhr === lastXhr ) {
                      response( data );
                  }
              });
              $("ul.ui-autocomplete").attr('class','search-suggest');
              $("ul.ui-autocomplete").attr('style','display:block !important');
              $('.search-tabs').css('display',"flex");

          },
          focus:function(event,ui){
            $(".search-from ul").css('display',"block");
            if($("#rest_search").val().length > 0){
            $('.search-tabs').css('display',"flex");
            }else{

            } $('.search-tabs').css('display',"none");

          },
          select:function(event,ui){
              var url=$("li.ui-menu-item a.ui-state-focus").attr('href');
              window.location=url;
              return false;
          }
      }).data("ui-autocomplete").
      _renderItem=function(ul,items){
          var $html='';
          if(typeof items =="object"){
              if(items.label == searchTarget){
                  $html+='<li class="search-cat many-list active" style="display:block" id="'+items.label+'"><div class="category-list">'+langlibrary[items.label]+'</div><ul>';
              }else{
                  $html+='<li class="search-cat many-list" id="'+items.label+'"><div class="category-list">'+langlibrary[items.label]+'</div><ul>';

              }
              $.each(items,function(index,item){
                  if(typeof item.name!="undefined"){
                      itemname=item.name;
                      if(lang!=="en"){
                          itemname=item.nameAr;
                      }
                      var rest_Logo = item.rest_Logo;
                      if(rest_Logo==""){
                          rest_Logo="default_logo.gif";
                      }
                      if(items.label == "restaurantstitle"){
                        $html+='<li class="ui-menu-item" role="menuitem"><a href="'+base+'/'+city.url+'/'+item.url+'"><img src="'+uploadbase+"logos/"+rest_Logo+'"> '+itemname+'</li>';    

                      }else{
                        $html+='<li class="ui-menu-item" role="menuitem"><a href="'+base+'/'+city.url+'/'+item.url+'"> '+itemname+'</li>';    

                      }
                  }
              });
              $html += '</ul></li>';
          }
          return $($html).appendTo( ul );;
      };
      var _searchhtml='<li class="search-cat active"><div class="category-list">'+_popularcategories+'</div><ul>';
      $.each(_searchhelpers,function(index,t){
          _searchhtml+='<li class="ui-menu-item" role="menuitem"><a href="'+base+'/'+city.url+'/'+t.url+'">'+t.name+'</a></li>';
      });
      _searchhtml+='</ul></li>';

      $("#rest_search").focus(function(e){
        if($("#rest_search").val().length > 0){
            $(".search-from ul").css('display',"block");
            $('.search-tabs').css('display',"flex");

        }else{
            $(".search-from ul").html(_searchhtml).addClass('search-suggest').css('display',"block");
        }
    });


    
    $('.search-tabs li').click(function(){
        $('.search-tabs li').removeClass('active');
        $(this).addClass('active');
        $('.search-suggest li').hide();
        $('.search-suggest').css('display',"block !important");
        $('.search-suggest li').removeClass('active');
        var targg = $(this).data('target');
        searchTarget = targg;
        $('#'+targg).show();
        $('#'+targg).addClass('active');
        $(".search-from ul").css('display',"block");
    })
    $(document).on('submit','.search-from',function(e){
      e.preventDefault();
      if($("#rest_search").val()!=""){
          window.location.href=base+'/'+city['url']+'/find/'+$("#rest_search").val();
      }else{
          window.location.href=base+'/'+city['url']+'/latest';
      }
      
    });

	if(typeof window.location.hash.split('#')[1]!="undefined"&&window.location.hash.split('#')[1]=="n"){
		$("#sufrati-top-bar").addClass('slideUp');
	}
	$("[data-toggle=tooltip]").tooltip();
	$("img.sufrati-super-lazy").lazyload({
        effect : "fadeIn"
    }).removeClass("sufrati-super-lazy");
    $("#filter-button").click(function(){
    	if($("#sufrati-filter-container").hasClass('hidden')){
    		$("#sufrati-filter-container").removeClass('hidden');
            $("#filter-button").html('<i class="fa fa-bars"></i> <i class="fa fa-long-arrow-up"></i>');
    	}else{
    		$("#sufrati-filter-container").addClass('hidden');
            $("#filter-button").html('<i class="fa fa-bars"></i> <i class="fa fa-long-arrow-down"></i>');
    	}
    });


    $('a[data-toggle="tab"]').click(function (e) {
        var hash=$(this).attr('href');
        window.location.hash=hash;
    });

    window.alert = function() {
        if($("#alert-modal").length>0){
            $("#alert-modal .modal-body h4").html(arguments[0]);
            $("#alert-modal").modal('show');
        }else{
            var thtml='<div id="alert-modal" class="modal fade"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"><h4>'+arguments[0]+'</h4></div><div class="modal-footer"><button type="button" class="btn btn-light" data-dismiss="modal">'+langlibrary.close+'</button></div></div></div></div>';
            $('body').append(thtml);
            $("#alert-modal").modal('show');
        }  
    };
});

$(document).on('click','.login-link',function(e){
    e.preventDefault();
    var container=$(this).attr('data-target');
    // $('#login-modal-main').modal('toggle');
     sufratiloginpopup(container);
});
$(document).on('click','.register-link',function(e){
    e.preventDefault();
    var container=$(this).attr('data-target');
    // $('#login-modal-main').modal('toggle');
     sufratiRegisterpopup(container);
});
$(document).on('click','.register-same-model',function(e){
    e.preventDefault();
    $(".login-block").addClass('hide');
    $(".login-block").removeClass('show');
    $(".register-block").removeClass('hide');
    $(".forget-block").addClass('hide');
    $(".forget-block").removeClass('show');
});
$(document).on('click','.login-same-model',function(e){
    e.preventDefault();
    $(".register-block").addClass('hide');
    $(".register-block").removeClass('show');
    $(".login-block").removeClass('hide');
    $(".forget-block").addClass('hide');
    $(".forget-block").removeClass('show');
});

function sufratiloginpopup(container,tdata){
    if(!loggedinuser){
        //  sufratipopupinitialize();
        // $('#login-modal-main').modal('toggle');
        $.ajax({
            type:"GET",
            url:base+'/login',
            data:tdata,
            success:function(data){
                closepopup();
                $('#login-modal-main').modal('toggle');
                $(".register-block").addClass('hide');
                $(".register-block").removeClass('show');
                $(".login-block").removeClass('hide');
                $(".forget-block").addClass('hide');
                $(".forget-block").removeClass('show');
            },
            dataType:'json'
        });
    }
}
function sufratiRegisterpopup(container,tdata){
    if(!loggedinuser){
        //  sufratipopupinitialize();
        // $('#login-modal-main').modal('toggle');
        $.ajax({
            type:"GET",
            url:base+'/login',
            data:tdata,
            success:function(data){
                $('#login-modal-main').modal('toggle');
                $(".login-block").addClass('hide');
                $(".login-block").removeClass('show');
                $(".register-block").removeClass('hide');
            },
            dataType:'json'
        });
    }
}
$(document).on('click','#connect-google-btn',function(e){
    e.preventDefault();
    GSigninCallBack();
    
});
function GSigninCallBack(){
    var provider = new firebase.auth.GoogleAuthProvider();
		firebase.auth()
		.signInWithPopup(provider)
		.then((result) => {
			var credential = result.credential;
			var token = credential.accessToken;
			var user = result.user;
			var profile = result.additionalUserInfo.profile;
            // var profile = res.result;
            var email=profile.email;
            var googleid=profile.id;
            var image= profile.picture;
            if(email!=""){
                $.ajax({
                    url:base+'/login/checkemail',
                    type:'POST',
                    data:{email:email,googleid:googleid},
                    success:function(data){
                        if(typeof data['exists']!="undefined"){
                            sufratipopup('<div class="alert alert-success" role="alert"><b>Logging in through Google...</b></div>');
                            window.location.reload();
                        }else{
                            // window.location = "./register";
                            if($(".register-block").hasClass('hide')){
                                $(".login-block").addClass('hide');
                                $(".login-block").removeClass('show');
                                $(".register-block").removeClass('hide');
                            }
                            $(".form-login-options").remove();
                            $("#registeremail").val(email);
                            $("#registername").val(profile.name);
                            $("<input>").attr({'name':'googleid','value':googleid,'type':'hidden'}).appendTo('#register-form');
                            $("<input>").attr({'name':'photo','value':image,'type':'hidden'}).appendTo('#register-form');
                        }
                    }
                });    
            }

			// ...
		}).catch((error) => {
			var errorCode = error.code;
			var errorMessage = error.message;
			console.log(errorMessage);
			var email = error.email;
			var credential = error.credential;
		});

  
}
//Login function
$(document).on('submit','#login-form',function(e){
    e.preventDefault();
    loginformsubmit();
});

function loginformsubmit(){
    $("#login-button").attr('disabled',true);
    if($("#user-email").val()==""){
        $("#user-email").focus();
        if($("#login-form .alert").length>0){
            $("#login-form .alert span").html(langlibrary.email_required);
        }else{
            $("#login-form").prepend('<div class="alert alert-warning fade show"><span>'+langlibrary.email_required+'</span></div>');
        }
        $("#login-button").removeAttr('disabled');
        return false;
    }
    if(!checkEmail($("#user-email").val())){
        $("#user-email").focus();
        if($("#login-form .alert").length>0){
            $("#login-form .alert span").html(langlibrary.email_incorrect);
        }else{
            $("#login-form").prepend('<div class="alert alert-warning fade show"><span>'+langlibrary.email_incorrect+'</span></div>');     
        }
        $("#login-button").removeAttr('disabled');
        return false;
    }
    if($("#user-password").val()==""){
        $("#user-password").focus();
        if($("#login-form .alert").length>0){
            $("#login-form .alert span").html(langlibrary.password_required);
        }else{
            $("#login-form").prepend('<div class="alert alert-warning fade show"><span>'+langlibrary.password_required+'</span></div>');
        }
        $("#login-button").removeAttr('disabled');
        return false;
    }
    if($("#login-form .alert").length>0){
        $("#login-form .alert").remove();
    }
    $.ajax({
        url:base+'/login/l',
        type:'POST',
        data:$("#login-form").serialize(),
        success:function(data){
            if(typeof data['error']!="undefined"){
                if($("#login-form .alert").length>0){
                    $("#login-form .alert span").html(data['error']);
                }else{
                    $("#login-form").prepend('<div class="alert alert-warning fade show"><span>'+data['error']+'</span></div>');
                }
                $("#login-button").removeAttr('disabled');
            }else{
                window.location.reload();
            }
        },
        dataType:'json'
    });
}


$(document).on('submit','#register-form',function(e){
    e.preventDefault();
    if($("#registername").val().length<3){
        if($("#register-form .alert").length>0){
            $("#register-form .alert span").html(langlibrary.name_required);
        }else{
            $("#register-form").prepend('<div class="alert alert-warning fade show"><span>'+langlibrary.name_required+'</span></div>');
        }
        $("#registername").focus();
        return false;
    }
    if($("#registeremail").val()==""){
        if($("#register-form .alert").length>0){
            $("#register-form .alert span").html(langlibrary.email_required);
        }else{
            $("#register-form").prepend('<div class="alert alert-warning fade show"><span>'+langlibrary.email_required+'</span></div>');
        }
        $("#registeremail").focus();
        return false;
    }
    if(!checkEmail($("#registeremail").val())){
        if($("#register-form .alert").length>0){
            $("#register-form .alert span").html(langlibrary.email_incorrect);
        }else{
            $("#register-form").prepend('<div class="alert alert-warning fade show"><span>'+langlibrary.email_incorrect+'</span></div>');
        }
        $("#registeremail").focus();
        return false;
    }
    if($("#registerpassword").val()==""){
        if($("#register-form .alert").length>0){
            $("#register-form .alert span").html(langlibrary.password_required);
        }else{
            $("#register-form").prepend('<div class="alert alert-warning fade show"><span>'+langlibrary.password_required+'</span></div>');
        }
        $("#registerpassword").focus();
        return false;
    }
    if($("#registerphone").val()==""){
        if($("#register-form .alert").length>0){
            $("#register-form .alert span").html(langlibrary.phone_required);
        }else{
            $("#register-form").prepend('<div class="alert alert-warning fade show"><span>'+langlibrary.phone_required+'</span></div>');
        }
        $("#registerphone").focus();
        return false;
    }
    $("#register-form-final").attr('disabled','disabled');
    $("#register-form-final").hide();
    $("#register-load-last").css('display','block');
    var number =  "+" + $("#registerphone").intlTelInput("getSelectedCountryData").dialCode + "" + $("#registerphone").val();
    $('[name="full_phone"]').val(number);
    $.ajax({
        url:base+'/login/r',
        type:'POST',
        data:$("#register-form").serialize(),
        success:function(data){
            $("#register-load-last").hide();
            if(typeof data['error']!="undefined"){
                $("#register-form-final").removeAttr('disabled');
                $("#register-form-final").show(); 
                $("#register-load-last").css('display','none');
                if($("#register-form .alert").length>0){
                    $("#register-form .alert span").html(data['error']);
                }else{
                    $("#register-form").prepend('<div class="alert alert-warning alert-dismissible fade show"><span>'+data['error']+'</span></div>');
                }
            }else{
                $(".register-block").html('<div class="alert alert-success"><span>'+data['message']+'</span></div>');
            }
        },
        dataType:'json'
    });
});
$(document).on('click',".sufrati-hide-seek",function(e){
    e.preventDefault();
    var parent=$(this).closest('div[data-hide-seek]').attr('id');
    $(".hide-seek").addClass('hidden');
    var cont=$(this).attr('data-cont');
    $("#"+cont).removeClass('hidden');
    $("#sufrati-modal-container").center();
});
$(document).on('click','#forgot-password-link',function(e){
    e.preventDefault();
    $(".login-block").addClass('hide');
    $(".login-block").removeClass('show');
    $(".forget-block").removeClass('hide');
    $(".form-login-options").addClass('hide');
    
});
$(document).on('click','#back-to-login',function(e){
    e.preventDefault();
    $(".forget-block").addClass('hide');
    $(".forget-block").removeClass('show');
    $(".login-block").removeClass('hide');
    $(".form-login-options").removeClass('hide');
});
$(document).on('submit','#forgot-form',function(e){
    if($("#forgotemail").length>0){
        if(!checkEmail($("#forgotemail").val())){
            alert(langlibrary.email_incorrect);
            return false;    
        }else{
            $("#forgot-button").attr('disabled');
            $.get(base+'/forgot',{email:$("#forgotemail").val()},function(data){
                console.log(data)
                var thtml;
                if(typeof data['error']!="undefined"){
                    $("#forgot-button").removeAttr('disabled');
                    thtml='<div class="alert alert-danger alert-dismissible" role="alert">'+data['error']+'</div>';
                }
                if(typeof data['message']!="undefined"){
                    thtml='<div class="alert alert-success alert-dismissible" role="alert">'+data['message']+'</div>';
                    $("#forgot-form p.help-block").after(thtml);
                    $("#forgot-form input").fadeOut();
                    $("#reset-password-cnt").fadeOut();
                    $("#forgotemail").addClass('hidden');
                }
            },"json");
            return false;
        }
    }else{
        alert(langlibrary.email_incorrect);
        return false;
    }
});
$(document).on('submit','#reset-form',function(){
    if($("#new-password").val()==""){
        alert(langlibrary.enter_new_password);
        return false;
    }
    if($("#new-password").val()!=$("#confirm-password").val()){
        alert(langlibrary.passwords_must_match);
        return false;    
    }
});
$(document).ajaxStop(function(){
    // $("img.sufrati-super-lazy").lazyload({
    //     effect : "fadeIn"
    // }).removeClass("sufrati-super-lazy");
    // $("[data-rel=tooltip]").tooltip();
});
(function($){
   $.fn.center = function() {
        return this.each(function() {
            var top = ($(window).height() - $(this).height()) / 2;
            var left = ($(window).width() - $(this).width()) / 2;
            if($(window).width()>700){
                $(this).css({position:'absolute', margin:0, top: (top > 0 ? top : 0)+'px', left: (left > 0 ? left : 0)+'px'});
            }else{
                var left='5';
                $(this).css({position:'absolute', margin:0, top: (top > 0 ? top : 0)+'px', left: (left > 0 ? left : 0)+'%',width:'90%'});
                $(this).find('.sufrati-popup-box').css({width:'100%'});
            }
            
        });
   };
}(jQuery));
function sufratipopupinitialize(){
    if($("#sufrati-modal-bg").length>0){
        $("#sufrati-modal-bg").remove();
    }
    if($("#sufrati-modal-container").length>0){
        $("#sufrati-modal-container").remove();
    }
    if(!popupshowing){
        var thtml='<div class="modal fade" id="sufrati-modal-bg" tabindex="-1" aria-hidden="true" tabindex="-1"><div id="sufrati-modal-container" class="modal-dialog modal-dialog-centered">';
        $('body').append(thtml);
        $('#sufrati-modal-bg').modal('show');
        // $("#floatingCirclesG").center();
        popupshowing=true;
    }
}
function sufratiloading(){
    var thtml='<div id="floatingCirclesG"><div class="f_circleG" id="frotateG_01"></div><div class="f_circleG" id="frotateG_02"></div><div class="f_circleG" id="frotateG_03"></div><div class="f_circleG" id="frotateG_04"></div><div class="f_circleG" id="frotateG_05"></div><div class="f_circleG" id="frotateG_06"></div><div class="f_circleG" id="frotateG_07"></div><div class="f_circleG" id="frotateG_08"></div></div>';
    if($("#sufrati-modal-bg").length>0){
        $("#sufrati-modal-bg").append(thtml);
    }else{
        thtml='<div id="sufrati-modal-bg"><div id="sufrati-modal-container">'+thtml+'</div></div>';
        $('body').append(thtml).addClass('hidden-overflow');    
    }
    $("#floatingCirclesG").center();
    loading=1;
}
function hideloading(closepop){
    if(loading==1){
        $("#floatingCirclesG").remove();
        loading=0;
        if(typeof closepop!="undefined"&&closepop){
            closepopup();
        }
    }
}
function sufratipopup(html,callback){
    // $("#sufrati-modal-container .modal-body").html(html);
    if($("#sufrati-modal-container").length>0){
        $("#sufrati-modal-container").html(html);
    }
  
    // $("#sufrati-modal-container").center();
    if(typeof callback!="undefined"){
        callback();
    }
}
function closepopup(foo){
    if(supports_history_api){
        if(historymoved!=0){
            window.history.go(-historymoved);
            historymoved=0;
        }
    }
    $('#sufrati-modal-bg').modal('hide');
    if($("#sufrati-modal-bg").length>0){
        $("#sufrati-modal-bg").remove();
    }
    if($("#sufrati-modal-container").length>0){
        $("#sufrati-modal-container").remove();
    }
    popupshowing=false;
    if(typeof foo!="undefined"){
        foo();
    }
}
$(document).on('click','*[data-ajax]',function(e){
    e.preventDefault();
    var url=$(this).attr('data-ajax');
    loadpopup(url);
});
$(document).on('click','.ajax-link',function(e){
    e.preventDefault();
    var url=$(this).attr('href');
    var title=$(this).attr('title');
    loadpopup(url,title);
});
function loadpopup(url,title){
    sufratipopupinitialize();
    var historymove=false;
    if(typeof title!= "undefined"){
        if(supports_history_api){
            history.pushState(null, title, url);
            historymoved++;
        }    
    }
    $.ajax({
        type:"GET",
        url:url,
        data:{},
        success:function(data){
            sufratipopup(data['html'],function(){
            });
        },
        dataType:'json'
    });
}
$(document).on('click',"#sufrati-modal-bg",function(e){
    if(e.target==e.currentTarget){
        closepopup();
    }
});

$(document).on('click','.sufrati-close-popup',function(e){
    closepopup();
});
$(document).on('submit','#sufSearchAuto',function(e){
    e.preventDefault();
    if($("#sufSearchSuggest").val()!=""){
        window.location.href=base+'/'+city['url']+'/find/'+$("#sufSearchSuggest").val();
    }else{
        window.location.href=base+'/'+city['url']+'/latest';
    }
    
});
$(document).on('mouseenter','.super-popup-image',function(e){
    superinside=true;
});
$(document).on('mouseleave','.super-popup-image',function(e){
    superinside=false;
});
$(document).on('mouseenter','.sufrati-gallery-photo',function(){
    $(this).find('.photo-like-container').removeClass('hidden');
});
$(document).on('mouseleave','.sufrati-gallery-photo',function(){
    $(this).find('.photo-like-container').addClass('hidden');
});
$(document).on('click',".switch-with",function(e){
    var target=$(this).attr('data-target');
    var parent=$(this).closest('[class="switch-with-container"]').attr('id');
    $("#"+parent).addClass('hidden');
    $("#"+target).removeClass('hidden');
});
$(document).on('click','.heart-btn',function(e){
    e.preventDefault();
    if(loggedinuser){
        var photo=$(this).attr('data-id'),liked=1,totallikes=$(this).attr('data-total-likes'),tdata,cityurl=$(this).attr('data-city');
        if($(this).hasClass('liked')){
            totallikes--;
            $(this).removeClass('liked').html('<i class="far fa-heart"></i> '+langlibrary.like);
            liked=0;
        }else{
            totallikes++;
            $(this).addClass('liked').html('<i class="fas fa-heart"></i> ' + langlibrary.liked);
        }
        $(this).attr('data-total-likes',totallikes);
        $('.photo-total-like-summary-'+photo+' span').html(totallikes);
        tdata={photo:photo,liked:liked}
        $.ajax({
            url:base+'/'+city['url']+'/aj/likephoto',
            type:'POST',
            data:tdata,
            success:function(data){
                var activityid=0;
                if(typeof data['image_ID']=="undefined"){
                    if(typeof _fbid!="undefined"&&_fbid!=""){
                        FB.getLoginStatus(function(response) {
                            if (response.status === 'connected') {
                                var acce=response.authResponse.accessToken;
                                FB.api(
                                    'me/og.likes',
                                    'post',
                                    {
                                    access_token: acce,
                                    object: base+"/"+cityurl+'/photo/'+photo
                                    },
                                    function(response) {
                                        if(typeof response.id !="undefined"){
                                            var fbactivity=response.id;    
                                            if(typeof data['liked']!="undefined"){
                                                tdata={liked:data['liked'],fbactivity:fbactivity};
                                                $.ajax({
                                                    url:base+'/'+city['url']+'/aj/addfblikephoto',
                                                    type:'POST',
                                                    data:tdata,
                                                    success:function(data){
                                                    }
                                                });
                                            }
                                        }
                                    }
                                );
                            }
                        });
                    }
                }
            }
        });
    }else{
        sufratiloginpopup("sufrati-login-form");    
    }
});
$(document).on('contextmenu','.sufrati-popup-image',function(e){
    if(!superinside){
        e.preventDefault();
        $(this).find('.super-popup-image').removeClass('hidden');
        $(this).find('textarea').select().focus();
        var tleft=$(this).width()/2-$(this).find('.super-popup-image').width()/2;
        $(this).find('.super-popup-image').css('left',tleft+'px');
    }
});
$(document).on('contextmenu','#photo-holder',function(e){
    e.preventDefault();
    sufratipopupinitialize();
    sufratipopup(_.template($("#photo-copyright-holder-tpl").html()),function(){
        $("#photo-copyright-pop textarea").select().focus();
    });
});

$(document).on('click','#super-popup-destroyer',function(e){
    e.preventDefault();
    $(this).closest('.super-popup-image').addClass('hidden');
});
$(document).on('click','#copy-button',function(e){
    e.preventDefault();
    var text=$(".super-popup-image textarea").innerText;
    var copy=text.createTextRange();
    copy.execCommand("Copy");
});

$(document).keyup(function(e) {
    switch(e.keyCode){
        case 27:
            if(popupshowing){
                closepopup();
            }
            break;
        case 37:
            if(popupshowing){
                if($('.arrow-icon.prev').length>0){
                    var title=$('.arrow-icon.prev').attr('title');
                    var url=$('.arrow-icon.prev').attr('href');
                    loadimagepopup(url,title); 
                    if(supports_history_api){
                        history.pushState(null, title, url);
                        historymoved++;
                    }   
                }
            }
            break;
        case 39:
            if(popupshowing){
                if($('.arrow-icon.next').length>0){
                    var title=$('.arrow-icon.next').attr('title');
                    var url=$('.arrow-icon.next').attr('href');
                    loadimagepopup(url,title);
                    if(supports_history_api){
                        history.pushState(null, title, url);
                        historymoved++;
                    }
                }
            }
    }
});

$(document).on('click','.arrow-icon',function(e){
    e.preventDefault();
    var image=$(this).attr('href');
    var title=$(this).attr('title');
    if(supports_history_api){
        history.pushState(null, title, image);
        historymoved++;
    }
    loadimagepopup(image,title);
});

function loadimagepopup(image,title){
    $.ajax({
        type:"GET",
        url:image,
        data:{},
        success:function(data){
            sufratipopup(data['html'],function(){
            });
        },
        dataType:'json'
    });
}

//Like a restaurant

$(document).on('click','.like-btn',function(e){
    if(loggedinuser){
        var like=1,removelike=0;
        var voted=$("#rest-like-total b").html();
        var likers=$("#rest-like-total").attr('data-likers');
        var rest=$(this).attr('data-rest');
        if($(this).hasClass('dislike')){
            like=0;
        }
        if($(this).hasClass('liked')){
            voted--;
            if($(this).attr('data-liked')==1){
                likers--;
            }
            removelike=1;
        }else{
            voted++;
            if(like==1){
                likers++;
            }else{
                likers--;
            }
        }
        if(voted!=0){
            var percentage=Math.round((likers/voted)*100);    
        }else{
            var percentage=0;
        }
        $("#rest-like-percentage span b").html(percentage);
        $("#rest-like-total b").html(voted);
        var likeresult_string=langlibrary.you_like_this;
        var likeresult_string2=langlibrary.dont_like_it;
        var likeicon = "up";
        var likeicon2 = "down";
        var likeclass = "dislike";
        var liked=1;
        if(like==0){
            likeresult_string=langlibrary.you_dont_like_this;
            likeresult_string2=langlibrary.like_it;
            likeicon = "down";
            likeicon2 = "up";
            liked=0;
            likeclass = "like";
        }
        if($("#rest-like-btns").length>0){
            if($(this).hasClass('liked')){
                $("#rest-like-btns").html('<a href="javascript:void(0)"class="btn rest-like-btn like-btn like" data-rest="'+rest+'"><i class="fa fa-thumbs-up"></i> '+langlibrary.like_it+'</a><a class="btn btn-light like-btn dislike" data-rest="'+rest+'"><i class="fa fa-thumbs-down"></i>'+langlibrary.dont_like_it+'</a>');
            }else{
                $("#rest-like-btns").html('<a href="javascript:void(0)" class="btn btn-active like-btn liked active" data-liked="'+liked+'" data-rest="'+rest+'"><i class="fa fa-thumbs-'+likeicon+'"></i>'+likeresult_string+'</a> <a class="btn btn-light like-btn '+likeclass+'" data-rest="'+rest+'"><i class="fa fa-thumbs-'+likeicon2+'"></i>'+likeresult_string2+'</a>');    
            }
        }
        if($(".rest-like-btns[data-rest='"+rest+"']").length>0){
            if($(this).hasClass('liked')){
                $("#rest-like-btns").html('<a href="javascript:void(0)"class="btn rest-like-btn like-btn like" data-rest="'+rest+'"><i class="fa fa-thumbs-up"></i> '+langlibrary.like_it+'</a><a class="btn btn-light like-btn dislike" data-rest="'+rest+'"><i class="fa fa-thumbs-down"></i>'+langlibrary.dont_like_it+'</a>');
            }else{
                $("#rest-like-btns").html('<a href="javascript:void(0)" class="btn btn-active like-btn liked active" data-liked="'+liked+'" data-rest="'+rest+'"><i class="fa fa-thumbs-'+likeicon+'"></i>'+likeresult_string+'</a> <a class="btn btn-light like-btn '+likeclass+'" data-rest="'+rest+'"><i class="fa fa-thumbs-'+likeicon2+'"></i>'+likeresult_string2+'</a>');    
            }
        }
        var tdata={like:liked,removelike:removelike};
        $.ajax({
            url:base+'/aj/likerest/'+rest,
            type:"GET",
            data:tdata,
            success:function(data){
                if(typeof _fbid!="undefined"&&_fbid!="" && typeof data['rest']!="undefined" && typeof data['city']!="undefined" && typeof data['like']!="undefined" && like==1){
                    //Todo
                    FB.getLoginStatus(function(response) {
                        if (response.status === 'connected') {
                                var acce=response.authResponse.accessToken;
                            FB.api(
                                'me/og.likes',
                                'post',
                                {
                                access_token: acce,
                                object: base+"/"+data['city']+"/"+data['rest']
                                },
                                function(response) {
                                    if(typeof response.id !="undefined"){
                                        var fbactivity=response.id;    
                                        tdata={liked:data['like'],fbactivity:fbactivity};
                                        $.ajax({
                                            url:base+'/aj/addfblike',
                                            type:'POST',
                                            data:tdata,
                                            success:function(data){

                                            }
                                        });
                                    }
                                }
                            );
                        }
                    });
                }
            },
            dataType:'json'
        });
    }else{
        sufratiloginpopup("sufrati-login-form");
    }
});
$(".cuisine-like-list").on('click','li a',function(){
    if($(this).attr('data-selected')){
        $(this).removeAttr('data-selected');
        $(this).find('span.selected i').removeClass('fas');    
        $(this).find('span.selected').addClass('hidden'); 
        $(this).find('span.selected i').addClass('far');    

    }else{
        $(this).attr('data-selected',1);
        $(this).find('span.selected i').removeClass('far');   
        $(this).find('span.selected').removeClass('hidden');
        $(this).find('span.selected i').addClass('fas');        
    }
});
$(document).on('click','.mini-like-btn',function(e){
    if(loggedinuser){
        var rest=$(this).attr('data-rest');
        var like=1,removelike=0;
        var likers=$("#liked-persons-"+rest).html();
        if($(this).hasClass('liked')){
            removelike=1;
            likers--;
            $(this).removeClass('liked');
            $(this).removeAttr('data-liked');
            $(this).html('<i class="far fa-thumbs-up"></i>' + langlibrary.like);
        }else{
            likers++;
            $(this).addClass('liked');
            $(this).attr('data-liked',1);
            $(this).html('<i class="far fa-thumbs-down"></i> '+langlibrary.liked);
        }
        $("#liked-persons-"+rest).html(likers);
        var tdata={like:like,removelike:removelike}
        $.ajax({
            url:base+'/aj/likerest/'+rest,
            type:"GET",
            data:tdata,
            success:function(data){
                if(typeof _fbid!="undefined"&&_fbid!="" && typeof data['rest']!="undefined" && typeof data['city']!="undefined" && typeof data['like']!="undefined" && like==1){
                    //Todo
                    FB.getLoginStatus(function(response) {
                        if (response.status === 'connected') {
                                var acce=response.authResponse.accessToken;
                            FB.api(
                                'me/og.likes',
                                'post',
                                {
                                access_token: acce,
                                object: base+"/"+data['city']+"/"+data['rest']
                                },
                                function(response) {
                                    if(typeof response.id !="undefined"){
                                        var fbactivity=response.id;    
                                        tdata={liked:data['like'],fbactivity:fbactivity};
                                        $.ajax({
                                            url:base+'/aj/addfblike',
                                            type:'POST',
                                            data:tdata,
                                            success:function(data){

                                            }
                                        });
                                    }
                                }
                            );
                        }
                    });
                }
            },
            dataType:'json'
        });
    }else{
        sufratiloginpopup("sufrati-login-form");
    }
});

$(document).on('click','.mini-like-btn-2',function(e){
    if(loggedinuser){
        var rest=$(this).attr('data-rest');
        var like=1,removelike=0;
        var likers=$("#liked-persons-"+rest).html();
        if($(this).hasClass('liked')){
            removelike=1;
            likers--;
            $(this).removeClass('liked');
            $(this).removeAttr('data-liked');
            $(this).html('<i class="far fa-heart"></i>');
        }else{
            likers++;
            $(this).addClass('liked');
            $(this).attr('data-liked',1);
            $(this).html('<i class="fas fa-heart"></i> ');
        }
        $("#liked-persons-"+rest).html(likers);
        var tdata={like:like,removelike:removelike}
        $.ajax({
            url:base+'/aj/likerest/'+rest,
            type:"GET",
            data:tdata,
            success:function(data){
                if(typeof _fbid!="undefined"&&_fbid!="" && typeof data['rest']!="undefined" && typeof data['city']!="undefined" && typeof data['like']!="undefined" && like==1){
                    //Todo
                    FB.getLoginStatus(function(response) {
                        if (response.status === 'connected') {
                                var acce=response.authResponse.accessToken;
                            FB.api(
                                'me/og.likes',
                                'post',
                                {
                                access_token: acce,
                                object: base+"/"+data['city']+"/"+data['rest']
                                },
                                function(response) {
                                    if(typeof response.id !="undefined"){
                                        var fbactivity=response.id;    
                                        tdata={liked:data['like'],fbactivity:fbactivity};
                                        $.ajax({
                                            url:base+'/aj/addfblike',
                                            type:'POST',
                                            data:tdata,
                                            success:function(data){

                                            }
                                        });
                                    }
                                }
                            );
                        }
                    });
                }
            },
            dataType:'json'
        });
    }else{
        sufratiloginpopup("sufrati-login-form");
    }
});
$(document).on('click','.follow-btn',function(e){
    if(loggedinuser){
        var user=$(this).attr('data-user'),follow=1;
        var followers=parseInt($("span[data-total-followers"+user+"]").attr("data-total-followers"+user));
        var followvar=$(this).attr('data-following');
        if(typeof followvar!="undefined"&&followvar!==false&&followvar==1){
            //unfollow
            $(this).removeClass('following-btn').attr('data-following', '0').html(langlibrary.follow);
            followers--;
            follow=0;
        }else{
            //Follow
            $(this).addClass('following-btn').attr('data-following', '1').html(langlibrary.following);
            followers++;
        }
        $("span[data-total-followers"+user+"]").attr("data-total-followers"+user,followers).html(followers);
        $.ajax({
            url:base+'/ajax/follow',
            data:{user:user,follow:follow},
            type:'POST',
            success:function(data){

            },
            dataType:'json'
        });
    }else{
        sufratiloginpopup("sufrati-login-form");
    }
});
//change location

$(document).on('click','#sufrati-top-city-selector',function(e){
    sufratipopupinitialize();
    $.ajax({
        url:base+'/locations',
        type:"GET",
        success:function(data){
            sufratipopup(data['html'],function(){

            });
        }
    });
});

function supports_history_api() {
  return !!(window.history && history.pushState);
}

function checkEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}


$("#contact-block").on('submit','#contact-us-form',function(e){
    if($("#contactname").val()==""){
        alert(langlibrary.name_required2);
        $("#contactname").focus();
        return false;
    }
    if($("#contactemail").val()==""){
        alert(langlibrary.email_required);
        $("#contactemail").focus();
        return false;   
    }
    if($("#contactmessage").val()==""){
        alert(langlibrary.message_required);
        $("#contactmessage").focus();
        return false;   
    }
    if($("#enquiry_type").val()==""){
        alert(langlibrary.select_enquiry);
        $("#enquiry_type").focus();
        return false;   
    }
    if(!checkEmail($("#contactemail").val())){
        alert(langlibrary.email_incorrect);
        $("#contactemail").focus();
        return false;
    }
});

$(document).on('submit','.poll-vote-form',function(e){
    var checked=$(this).find('input[name="polloption"]:checked').size();
    if(!checked){
        alert(langlibrary.please_select_an_option);
        return false;
    }
});
$(document).on('click','.facebook-login-btn',function(e){

      
    var provider = new firebase.auth.FacebookAuthProvider();
    firebase
    .auth()
    .signInWithPopup(provider)
    .then((result) => {
        /** @type {firebase.auth.OAuthCredential} */
        var credential = result.credential;

        // The signed-in user info.
        var user = result.user;
        var info = result.additionalUserInfo;
        console.log(info)
        // This gives you a Facebook Access Token. You can use it to access the Facebook API.
        var accessToken = credential.accessToken;

        // ...
    })
    .catch((error) => {
        // Handle Errors here.
        var errorCode = error.code;
        var errorMessage = error.message;
        console.log(errorMessage)
        // The email of the user's account used.
        var email = error.email;
        // The firebase.auth.AuthCredential type that was used.
        var credential = error.credential;

        // ...
    });
    
});

(function($){
   $.fn.sufratislide = function() {
        return this.each(function() {
            
        });
   };
}(jQuery));

$("#catering-btn a").click(function(e){
    e.preventDefault();
    getCateringPop();
});

function getCateringPop(){
    sufratiloading();
    $.ajax({
        url:base+'/'+city.url+'/aj/eventorganise',
        data:{},
        success:function(data){
            sufratipopup(data['html'],function(){
                $("#eventDate").datepicker({minDate:+14,dateFormat:"yy-mm-dd"}); 
                require(['bootstrap-multiselect'],function(){
                    $("#catering-cuisines").multiselect({
                        buttonWidth:'100%',
                        buttonClass:'btn btn-light btn-lg',
                        maxHeight:200,
                        enableFiltering:true,
                        filterBehavior:'text',
                        enableCaseInsensitiveFiltering:true
                    });
                });
            });
        }
    })
}
$(document).on('click','#catering-form1-button',function(e){
    var k=true;
    if(loggedinuser){
        if($("#organise-step1 #yourNumber").val().length<=0){
            k=false;
            alert(langlibrary.please_enter_phone);
            $("#organise-step1 #yourNumber").focus();
            return false;
        }
    }else{
        if($("#organise-step1 #yourName").val().length<=0){
            k=false;
            alert(langlibrary.name_required2);
            $("#organise-step1 #yourName").focus();
            return false;
        }
        if($("#organise-step1 #yourEmail").val().length<=0){
            k=false;
            alert(langlibrary.email_required);
            $("#organise-step1 #yourEmail").focus();
            return false;
        }
        if(!checkEmail($("#organise-step1 #yourEmail").val())){
            k=false;
            alert(langlibrary.email_incorrect);
            $("#organise-step1 #yourEmail").focus();
            return false;   
        }
    }
    if($("#organise-step1 #eventTitle").val().length<=0){
        k=false;
        alert(langlibrary.event_title_required);
        $("#organise-step1 #eventTitle").focus();
        return false;
    }
    var eventtypes=document.getElementsByName('eventType'),checked=false;
    for(var j=0;j<eventtypes.length;j++){
        if(eventtypes[j].checked==true){
            checked=true;
        }
    }
    if(!checked){
        k=false;
        alert(langlibrary.select_event_type);
        return false;
    }
    if($("#organise-step1 #guests").val().length<=0){
        k=false;
        alert(langlibrary.number_of_guest_required);
        $("#organise-step1 #guests").focus();
        return false;
    }
    checked=false;
    var budgets=document.getElementsByName('budget');
    for(var j=0;j<budgets.length;j++){
        if(budgets[j].checked==true){
            checked=true;
        }
    }
    if(!checked){
        k=false;
        alert(langlibrary.select_budget);
        return false;
    }
    if($("#organise-step1 #eventDate").val().length<=0){
        k=false;
        alert(langlibrary.event_date_required);
        $("#organise-step1 #eventDate").focus();
        return false;
    }
    if($("#organise-step1 #eventTime").val().length<=0){
        k=false;
        alert(langlibrary.event_time_req);
        $("#organise-step1 #eventTime").focus();
        return false;
    }
    if(k){
        $("#organise-step1").addClass('hidden');
        $("#organise-step2").removeClass('hidden');
    }
});
$(document).on('click','#catering-form2-button',function(e){
    $("#organise-step1").removeClass('hidden');
    $("#organise-step2").addClass('hidden');
});
$(document).on('change','#organise-event-form input[name="eventVenue"]:radio',function(e){
    e.preventDefault();
    if($(this).val()=="On Site"){
        $(".onsite").removeClass('hidden');
    }else{
        if(!$(".onsite").hasClass('hidden')){
            $(".onsite").addClass('hidden');
        }
    }
});
$(document).on('submit','#organise-event-form',function(e){
    e.preventDefault();
    var ok=1,checked=false;
    var eventVenue=document.getElementsByName('eventVenue');
    for(var k=0;k<eventVenue.length;k++){
        if(eventVenue[k].checked==true){
            checked=true;
        }
    }
    if(!checked){
        ok=0;
        alert(langlibrary.select_event_venue);
        return false;
    }
    if($("#organise-event-form #catering-cuisines").val().length<=0){
        ok=0;
        alert(langlibrary.select_cuisine);
        return false;
    }
    checked=false;
    var meals=document.getElementsByName('meal[]');
    for(var k=0;k<meals.length;k++){
        if(meals[k].checked==true){
            checked=true;
        }
    }
    if(!checked){
        ok=0;
        alert(langlibrary.select_meal_courses);
        return false;
    }
    checked=false;
    var servingStyle=document.getElementsByName('servingStyle');
    for(var k=0;k<servingStyle.length;k++){
        if(servingStyle[k].checked==true){
            checked=true;
        }
    }
    if(!checked){
        ok=0;
        alert(langlibrary.select_serving_style);
        return false;
    }
    if($("#eventLocation").val()==""){
        ok=0;
        alert(langlibrary.select_event_location);
        return false;
    }
    if($('input[name="eventVenue"][value="On Site"]')[0].checked){
        var diningSetup=document.getElementsByName('diningSetup[]');
        checked=false;
        for(var k=0;k<diningSetup.length;k++){
            if(diningSetup[k].checked==true){
                checked=true;
            }
        }
        if(!checked){
            ok=0;
            alert(langlibrary.select_dining_setup);
            return false;
        }
    }
    var agree=document.getElementById('cateringagree');
    if(!agree.checked){
        ok=0;
        alert(langlibrary.agree_catering_terms);
        return false;
    }
    var nopop=false;
    if($("#organise-event-form").attr('data-nopop')){
        nopop=true;
    }
    if(ok==1){
        var k=$(this).serializeArray(),kdata={};
        $.each(k,function(){
            if (kdata[this.name] !== undefined) {
                if (!kdata[this.name].push) {
                    kdata[this.name] = [kdata[this.name]];
                }
                kdata[this.name].push(this.value || '');
            } else {
                kdata[this.name] = this.value || '';
            }
            
        });
        $("#catering-submit-button").attr('disabled','disabled');
        sufratiloading();
        $.ajax({
            url:base+'/'+city.url+'/aj/eventsubmit',
            data:kdata,
            type:'POST',
            success:function(data){
                hideloading();
                if(typeof data['html']!="undefined"){
                    if(!nopop){
                        sufratipopup(data['html']);
                    }else{
                        $("#event-form-cont").html(data['html']).addClass('no-padding');
                        closepopup();
                    }
                }
            },
            dataType:'json'
        });
    }
});
$(document).on('click','#use-my-location',function(e){
    if (navigator.geolocation) {
        sufratiloading();
        navigator.geolocation.getCurrentPosition(function(position){
            require(['async!http://maps.google.com/maps/api/js?key=AIzaSyDlBwn7IHKMc9fTsdoACBRidhjfGESyYO0&sensor=true!callback'],function(){
                geocoder = new google.maps.Geocoder();
                geocoder.geocode({'latLng': new google.maps.LatLng(position.coords.latitude,position.coords.longitude)}, function(results, status) {
                    var tcity=tlocality='';
                    if (status == google.maps.GeocoderStatus.OK) {
                        $("#eventLocation").val(results[0].formatted_address);
                        hideloading();
                        if($("#organise-event-form").attr('data-nopop')){
                            closepopup();   
                        }
                    }
                });
            });
        });
    }else{
        alert('Geolocation is not supported by your browser');
    }
});

function langchoice(string,count){
    var k=string.split('|');
    switch(true){
        case (count==0):
            return k[0];
            break;
        case (count==1):
            return k[1];
            break;
        case (count>1):
            return k[2];
            break;
    }
}
