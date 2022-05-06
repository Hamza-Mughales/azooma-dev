$(document).ready(function(){
  var googleoptions={
      'clientid':'785731705025-s89fgb4c6vgjnl0j6g51phn2hjheuh5q.apps.googleusercontent.com',
      'cookiepolicy' : 'single_host_origin',
      'callback' : 'GAuthBack',
      'scope':'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email https://www.google.com/m8/feeds https://www.googleapis.com/auth/userinfo.profile'
  };
  gapi.signin.render('connect-google',googleoptions);
  if(typeof _fbid!="undefined"){
    //getFBFriends();
  }
  $("#connect-facebook-btn").click(function(e){
    try{
      sufratiloading();
        FB.login(
            function(response) {
                if (response.status === 'connected') {
                    FB.api('/me?access_token='+response.authResponse.accessToken, function(response) {
                        var dateofbirth=response.birthday;
                        dateofbirth=dateofbirth.split('/');
                        var dob=dateofbirth[2]+'-'+dateofbirth[0]+'-'+dateofbirth[1];
                        var location='';
                        if((typeof response.location!="undefined")&&typeof response.location.name!="undefined"){
                            location=response.location.name;
                        }
                        var photo='';
                        if(typeof response.picture!="undefined"){
                            photo=response.picture;
                        }
                        var tdata={email:response.email,first_name:response.first_name,last_name:response.last_name,dob:dob,fbid:response.id,location:location,name:response.name,gender:response.gender,photo:photo};
                        FB.login(function(response){
                            var publish=2;
                            FB.api('/me/permissions', function (permissions) {
                                if(typeof permissions['data'][0]['publish_actions']!="undefined"){
                                    publish=permissions['data'][0]['publish_actions'];
                                }else{
                                    publish=0;
                                }
                                tdata['publish']=publish;
                                getFBFriends();
                                $.ajax({
                                    url:base+'/aj/updatefbperm',
                                    type:'POST',
                                    data:tdata,
                                    success:function(data){
                                        
                                    },
                                    dataType:'json'
                                });
                                hideloading(true);
                            });
                        },{scope:'publish_actions'} );
                    });
                }
            },
            { scope: "email,user_birthday,user_location,user_friends" } 
        );
    }catch(error){
        alert(error);
    }
  });
});

$(document).on('click','#invite-all-gmail',function(e){
  e.preventDefault();
  sufratiloading();
  $.ajax({
    url:base+'/aj/gmailinvite',
    data:{full:1},
    type:'POST'
  });
  setTimeout(function(){
    sufratipopup('<div class="alert alert-success" role="alert"><b>'+langlibrary.thank_you+' '+langlibrary.invites_being_sent+'</b></div>');
    setTimeout(function(){
      closepopup();
    },1500);
  },2000);
});
$(document).on('click','.email-invite-btn',function(e){
  e.preventDefault();
  var email=$(this).attr('data-invite-email');
  sufratiloading();
  $.ajax({
    url:base+'/aj/gmailinvite',
    data:{email:email},
    type:'POST'
  });
  setTimeout(function(){
    sufratipopup('<div class="alert alert-success" role="alert"><b>'+langlibrary.thank_you+' '+langlibrary.invites_being_sent+'</b></div>');
    setTimeout(function(){
      closepopup();
    },1500);
  },2000);
});

function GAuthBack(authResult){
  sufratiloading();
  gapi.client.load('plus','v1').then(function() {
    if (authResult['access_token']) {
      gapi.client.plus.people.get({
        'userId': 'me'
      }).then(function(res) {
        var profile = res.result;
        var emails=profile.emails,email='';
        for(var i=0;i<emails.length;i++){
            if(emails[i].type=="account"){
                email=emails[i].value;
            }
        }
        var googleid=profile.id;
        var image=profile.image.url;
        $.ajax({
          url:base+'/aj/getgoogledata',
          data:{googleid:googleid,code:authResult['access_token'],photo:image},
          type:"POST",
          success:function(data){
            hideloading(true);
            if(typeof data['html']!="undefined"){
              $("#connect-google-tab").html(data['html']);
            }
          }
        });
      });
//      gPeople(authResult['access_token']);
    }else{
      alert('error');
    }
  });
}
function gPeople(token){
    $.ajax({
      url: 'https://www.google.com/m8/feeds/contacts/default/full?alt=json',
      dataType: 'jsonp',
      data: {access_token:token}
    }).done(function(data) {
      });
    gapi.client.plus.people.list({
      'userId': 'me',
      'collection': 'visible'
    }).then(function(res) {
      var people = res.result;
      for (var personIndex in people.items) {
        person = people.items[personIndex];
        //console.log(person);
      }
    });
}

function getFBFriends(){
    FB.getLoginStatus(function(response) {
      if (response.status === 'connected') {
        var acce=response.authResponse.accessToken;
        FB.api('/me/friends/?fields=installed',function(response){
          var k=new Array(),i=0;
          for(var key in response.data){
            k[i]=response.data[key].id;
            i++;
          }
          if(k.length>0){
            $.ajax({
              url:base+'/aj/checkfbfriends',
              data:{friends:k},
              type:"POST",
              success:function(data){
                if(typeof data['html']!="undefined"){
                  $("#connect-facebook-tab").html(data['html']);
                }
              }
            });
          }
        });
      }
    });
}