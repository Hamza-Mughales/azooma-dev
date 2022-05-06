/*
  ----------------------
 | Custom Javascript File
 | Built By Adham Mahmoud.
 | Portfolio : https://adhamz.me 
  ----------------------
 */

(function () {
  /* 
  | Wow.js Init 
  */
  new WOW().init();

  /*
  | Header Fixed of scroll
  */
    $(window).scroll(function(){
      var sticky = $('.navbar'),
          scroll = $(window).scrollTop();
    
      if (scroll >= 100) sticky.addClass('fixed');
      else sticky.removeClass('fixed');
    });
  /* 
  | Header Location Choose Button 
  */
  $('#locationdropDown').click(function () {
    $('.world-map').toggleClass('active-map');
  });
  $(document).click(function (e) {
    if ($('.location-choose-header').is(':visible') && !$(e.target).closest('.location-choose-header').length) {
      $(".world-map").removeClass("active-map");
    }
  });
  $(document).on('click', '.dropdown-menu', function (e) {
    e.stopPropagation();
  });

  $('.dropdown-submenu').hover(function(e){
    $(this).find('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
  });
  /*
  | Header Search Button
  */
  $('.search-icon').click(function(){
    $('.header-search-top').toggle();
  })
 
  $(document).click(function (e) {
    if ($('.header-search-top').is(':visible') && !$(e.target).closest('.search-icon').length && !$(e.target).closest('.header-search-top').length) {
      $(".header-search-top").hide();
      $("#searchResult").empty();
      $('#rest_search').val(null);
    }
    if ($('#searchResult').is(':visible') && !$(e.target).closest('.search-from').length) {
      $("#searchResult").hide();
      $("#searchResult").empty();
      $('#rest_search').val(null);
    }
  });
  // $("#chooseCity").change(function(){
  //   var search = $('#rest_search').val();
  //   var city = $('#chooseCity').val();
  //   if(search == "" || search == null){
  //     $("#searchResult").empty();
  //   }
  //   if(search != "" && search != null){
  //       $.ajax({
  //           url: originalbase+'/'+'azoomasearch',
  //           type: 'post',
  //           data: {search:search,city:city},
  //           dataType: 'json',
  //           success:function(response){
  //             $("#searchResult").show();
  //               var len = response.restaurants.length;
  //               $("#searchResult").empty();
  //               for( var i = 0; i<len; i++){
  //                   var url = response.restaurants[i]['url'];
  //                   if(lang!=="en"){
  //                     var name = response.restaurants[i]['nameAr'];
  //                     }else{
  //                       var name = response.restaurants[i]['name'];
  //                     }
  //                   var rest_Logo = response.restaurants[i]['rest_Logo'];
  //                   if(rest_Logo==""){
  //                     rest_Logo="default_logo.gif";
  //                   }
  //                   $("#searchResult").append("<li><a href='"+originalbase+"/"+city+"/"+url+"'><img src='"+uploadbase+"/logos/"+rest_Logo+"'>"+name+"</a></li>");

  //               }

  //           }
  //       });
  //   }
  // });

//   $("#rest_search").keyup(function(){
//     var search = $(this).val();
//     var city = $('#chooseCity').val();
//     if(search == "" || search == null){
//       $("#searchResult").empty();
//     }
//     if(search != "" && search != null){

//         $.ajax({
//             url: originalbase+'/'+'azoomasearch',
//             type: 'post',
//             data: {search:search,city:city},
//             dataType: 'json',
//             success:function(response){
//               $("#searchResult").show();
//                 var len = response.restaurants.length;
//                 $("#searchResult").empty();
//                 for( var i = 0; i<len; i++){
//                     var url = response.restaurants[i]['url'];
//                     if(lang!=="en"){
//                       var name = response.restaurants[i]['nameAr'];
//                       }else{
//                         var name = response.restaurants[i]['name'];
//                       }
//                     var rest_Logo = response.restaurants[i]['rest_Logo'];
//                     if(rest_Logo==""){
//                       rest_Logo="default_logo.gif";
//                     }
//                     $("#searchResult").append("<li><a href='"+originalbase+"/"+city+"/"+url+"'><img src='"+uploadbase+"/logos/"+rest_Logo+"'>"+name+"</a></li>");

//                 }

//             }
//         });
//     }

// });

  /* 
  | Header Map List
  */
  $('.countries li').click(function () {
    $('.countries li').removeClass('active');
    $('.region li').hide(100);
    var mytarget = $(this).attr('data-target');
    $('.region li[data-target="' + mytarget + '"').show(100);
    $(this).addClass('active');
  });


  /*
  | Services toggle
  */
  $('#filter-city-services li').click(function () {
    $('#filter-city-services li').removeClass('active');
    $(this).addClass('active');
    var mytarget = $(this).attr('data-target');
    $('.city-services-slider .show').removeClass('show');
    $('.city-services-slider .' + mytarget).addClass('show');
    $('.city-services-slider .' + mytarget).parant().find('.viewall').addClass('show');
  });

   /*
  | explore toggle
  */
  $('#filter-city-explore li').click(function () {
    $('#filter-city-explore li').removeClass('active');
    $(this).addClass('active');
    var mytarget = $(this).attr('data-target');
    $('.city-explore-slider .show').removeClass('show');
    $('.city-explore-slider .' + mytarget).addClass('show');
    // $('.city-explore-slider .' + mytarget).parant().find('.viewall').addClass('show');
  });

  /* 
  | Map & List Resturant View Toggle
  */

    $('.list-types .filter-btn').click(function () {
      // $(this).toggleClass('active');
      $('.side-filter').toggleClass('show-filter');
    });
    $('#close_filter').click(function(e){
      e.preventDefault();
      $('.side-filter').removeClass('show-filter');
    })

    $(document).click(function (e) {
      if ($('.side-filter').is(':visible') && !$(e.target).closest('.side-filter').length && !$(e.target).closest('.list-types').length) {
        $('.side-filter').removeClass('show-filter');
      }
    });


    $('.map_id').click(function () {
      // $('.list-types li').toggleClass('active');
      $('#map_modal').modal('toggle')
    });
    $('[data-toggle="collapse"]').click(function(){ var targ = $(this).attr('href'); $(targ).toggleClass('show')})

  /* 
  | Sliders
  */

  $('.services-slider').owlCarousel({
    loop: false,
    margin: 15,
    // autoWidth:true,
    responsiveClass: true,
    nav: true,
    dots: false,
    items: 6,
    rtl:RtlMode,
    navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
    responsive: {
      0: {
        items: 2,
        nav: false
      },
      600: {
        items: 4,
        nav: true
      },
      1000: {
        items:5,
        nav: true,
      },
      1400: {
        items: 7,
        nav: true,
      }
    },
  });
  $('#places-slider').owlCarousel({
    loop: true,
    margin: 30,
    // autoWidth:true,
    responsiveClass: true,
    nav: true,
    dots: false,
    items: 5,
    rtl:RtlMode,
    navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
    responsive: {
      0: {
        items: 1,
        nav: true
      },
      600: {
        items: 3,
        nav: true
      },
      1000: {
        items: 4,
        nav: true,
      },
      1400: {
        items: 4,
        nav: true,
      }
    },
  });
  $('#images-slider').owlCarousel({
    loop: true,
    margin: 30,
    // autoWidth:true,
    responsiveClass: true,
    nav: true,
    dots: false,
    items: 5,
    rtl:RtlMode,
    navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
    responsive: {
      0: {
        items: 1,
        nav: true
      },
      600: {
        items: 3,
        nav: true
      },
      1000: {
        items: 4,
        nav: true,
      },
      1400: {
        items: 4,
        nav: true,
      }
    },
  });
  $('#images-slider').owlCarousel({
    loop: true,
    margin: 30,
    // autoWidth:true,
    responsiveClass: true,
    nav: true,
    dots: false,
    items: 5,
    rtl:RtlMode,
    navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
    responsive: {
      0: {
        items: 1,
        nav: true
      },
      600: {
        items: 3,
        nav: true
      },
      1000: {
        items: 4,
        nav: true,
      },
      1400: {
        items: 4,
        nav: true,
      }
    },
  });
  $('#videos-slider').owlCarousel({
    loop: true,
    margin: 30,
    // autoWidth:true,
    responsiveClass: true,
    nav: true,
    dots: false,
    items: 5,
    rtl:RtlMode,
    navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
    responsive: {
      0: {
        items: 1,
        nav: true
      },
      600: {
        items: 3,
        nav: true
      },
      1000: {
        items: 4,
        nav: true,
      },
      1400: {
        items: 4,
        nav: true,
      }
    },
  });
  $('#time-slider,#recommended-slider').owlCarousel({
    loop: true,
    margin: 30,
    // autoWidth:true,
    responsiveClass: true,
    nav: true,
    dots: false,
    items: 5,
    rtl:RtlMode,
    navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
    responsive: {
      0: {
        items: 1,
        nav: true
      },
      600: {
        items: 3,
        nav: true
      },
      1000: {
        items: 4,
        nav: true,
      },
      1400: {
        items: 4,
        nav: true,
      }
    },
  });
  $('#explore-slider,#explore-slider-locations').owlCarousel({
    // loop:true,
    margin: 30,
    // autoWidth:true,
    responsiveClass: true,
    nav: true,
    dots: false,
    items: 5,
    rtl:RtlMode,
    navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
    responsive: {
      0: {
        items: 2,
        nav: true
      },
      600: {
        items: 4,
        nav: true
      },
      1000: {
        items: 5,
        nav: true,
      },
      1400: {
        items: 5,
        nav: true,
      }
    },
  });




  /* 
  | Rate Range Slider
  */
  $('[data-rangeslider]').rangeslider({
    polyfill:false,

      rangeClass:'rangeslider',
    
      disabledClass:'rangeslider--disabled',
    
      activeClass:'rangeslider--active',
    
      horizontalClass:'rangeslider--horizontal',
    
      verticalClass:'rangeslider--vertical',
    
      fillClass:'rangeslider__fill',
    
      handleClass:'rangeslider__handle',
      isRTL:RtlMode

      
});
$('.review-food [data-rangeslider]').on('change', function(){
  var label = langlibrary.Worst;
  var num = $(this).val();
  switch (num) {
  case "1":
      label = langlibrary.Worst;
      break;
  case "2":
      label = langlibrary.Poor;
      break;
  case "3":
      label = langlibrary.Average;
      break;
  case "4":
      label = langlibrary.Good;
      break;
  case "5":
      label = langlibrary.Excellent;
      break;
  default:
  label = langlibrary.Worst;
  }
  $(this).nextAll('.value:first').html($(this).val() + "<span>( " + label + " )</span>");
});

$('.ranges-star [data-rangeslider]').on('change', function(){
  var num = $(this).val();
  var starss = document.querySelectorAll('.rande-stars ion-icon');
  switch (num) {
  case "1":
    starss[0].setAttribute('name','star');
    starss[4].setAttribute('name','star-outline');
    starss[3].setAttribute('name','star-outline');
    starss[2].setAttribute('name','star-outline');
    starss[1].setAttribute('name','star-outline');
      break;
  case "2":
    starss[4].setAttribute('name','star-outline');
    starss[3].setAttribute('name','star-outline');
    starss[2].setAttribute('name','star-outline');
    starss[0].setAttribute('name','star');
    starss[1].setAttribute('name','star');
      break;
  case "3":
    starss[4].setAttribute('name','star-outline');
    starss[3].setAttribute('name','star-outline');
    starss[0].setAttribute('name','star');
    starss[1].setAttribute('name','star');
    starss[2].setAttribute('name','star');
      break;
  case "4":
    starss[4].setAttribute('name','star-outline');
    starss[0].setAttribute('name','star');
    starss[1].setAttribute('name','star');
    starss[2].setAttribute('name','star');
    starss[3].setAttribute('name','star');
      break;
  case "5":
    starss[1].setAttribute('name','star');
    starss[2].setAttribute('name','star');
    starss[3].setAttribute('name','star');
    starss[4].setAttribute('name','star');
      break;
  default:
    starss[0].setAttribute('name','star');
  }
});
$('.ranges-price [data-rangeslider]').on('change', function(){
  var num = $(this).val();
  console.log(num)
  switch (num) {
    case "1":
      $('.ranges-price .price').attr("value","5-10");
      break;
      case "2":
        $('.ranges-price .price').attr("value","15-30");
      break;
      case "3":
        $('.ranges-price .price').attr("value","45-75");
        break;
      case "4":
        $('.ranges-price .price').attr("value","100+");
        break;
  }
});
/* 
| Restaurant Menu Nav
*/
$('.menu-tabs li button').click(function () {
  $('.menu-tabs li button').removeClass('active');
  $(this).addClass('active');
  var mytarget = $(this).attr('data-target');
  $('.menu-tab.active').removeClass('active');
  $('.menus-content #' + mytarget).addClass('active');
});

/* 
| Register Sex Choose 
*/
$('.sex-choose label').click(function () {
  $('.sex-choose label').removeClass('active');
  $(this).addClass('active');
});

/*
| User Setting Nav 
*/
$('.setting-nav li').click(function () {
  $('.setting-nav .active').removeClass('active');
  $(this).addClass('active');
  var mytarget = $(this).attr('data-target');
  $('.setting-tabs .show').removeClass('show');
  $('.setting-tabs #' + mytarget).addClass('show');
  window.location.hash = mytarget;
});
})();
/*
| User Profile Nav 
*/
// $('.user-profile-nav .nav-list a').click(function (e) {
//   e.preventDefault();
//   $('.user-profile-nav .nav-list .active').removeClass('active');
//   $(this).closest('li').addClass('active');
//   var mytarget = $(this).attr('href');
//   $('.azooma-tabs .show').removeClass('show');
//   $('.azooma-tabs ' + mytarget).addClass('show');
// });
/*
| Search Nav 
*/
$('.search-result-page .nav-list a').click(function (e) {
  e.preventDefault();
  $('.search-result-page .nav-list .active').removeClass('active');
  $(this).closest('li').addClass('active');
  var mytarget = $(this).attr('href');
  $('.search-tabs .show').removeClass('show');
  $('.search-tabs ' + mytarget).addClass('show');
});
/*
| Form Control Focus 
*/
$("input").focusin(function(){
  $(this).closest('.form-group').addClass('focus');
});
$("input").focusout(function(){
  $(this).closest('.form-group').removeClass('focus');
});

/* 
| Check Box On Click
*/
$('.group-check').click(function(){
var mycheck = $(this).find('.form-check-input');
if (mycheck.is(':checked')) { 
  mycheck.attr('checked', false);
  console.log('yes')
} else {
  console.log('no')
  mycheck.attr('checked', true);;
}
});

/*
  | Box Collabase
*/
$('.box_primary').click(function(){
  $(this).find('.expand-content').toggleClass('collapse');
})
/*
| Azooma Tabs
*/
$('.azooma-tabs-nav ul a').click(function (e) {
  e.preventDefault();
  $('.azooma-tabs-nav ul .active').removeClass('active');
  $(this).closest('li').addClass('active');
  var mytarget = $(this).attr('href').substr(1);
  $('.azooma-tabs-dev .show').removeClass('show');
  $('.azooma-tabs-dev [data-target='+ mytarget+']').addClass('show');
});
$('.azooma-tabs-nav-round ul a').click(function (e) {
  e.preventDefault();
  $('.azooma-tabs-nav-round ul .active').removeClass('active');
  $(this).closest('li').addClass('active');
  var mytarget = $(this).attr('href').substr(1);
  $('.azooma-tabs-dev .show').removeClass('show');
  $('.azooma-tabs-dev [data-target='+ mytarget+']').addClass('show');
});

var mypage2 = 2;
$('.load-more-photos').click(function(){
    $('.spin-load').css('display','block');
    $('.load-more-photos').hide();
    var mysort = $(this).data("sort");
    $.ajax(
    {
        url: '?page=' + mypage2 + '&limit=24&sort=' + mysort,
        type: "get",
        datatype: "html"
    }).done(function(data){
        var newdate =$($.parseHTML(data)).find('.restaruant-images-gallary')[0].innerHTML;
     //    $('.load-more-rest').remove();
        $(".restaruant-images-gallary").append(newdate);
        mypage2 += 1;
        $('.load-more-photos').show();
        $('.spin-load').hide();
    }).fail(function(jqXHR, ajaxOptions, thrownError){
        $('.load-more-photos').remove();
        $('.spin-load').hide();
    });
 });

var mypage = 1;
function loadMoreRest(){
  $('.spin-load').css('display','block');
  $('.load-more-rest').hide();
  $.ajax(
  {
    url: '?page=' + mypage + '&tab=restaurant',
    type: "get",
    datatype: "html"
  }).done(function(data){
    var newdate =$($.parseHTML(data)).find('.restaurants-boxes')[0].innerHTML;
   //    $('.load-more-rest').remove();
    $(".restaurants-boxes").append(newdate);
    mypage += 1;
    if(newdate.length == 0){
      $('.load-more-rest').remove();
      $('.spin-load').hide();
    }
    // initMap();
    $('.load-more-rest').show();
    $('.spin-load').hide();
  }).fail(function(jqXHR, ajaxOptions, thrownError){
    $('.load-more-rest').remove();
    $('.spin-load').hide();
  });
}




var aaxpage = 1;
function loadMoreRest2(){
    $('.spin-load').css('display','block');
    $('.load-more-rest').hide();
    $.ajax(
    {
        url: '?page=' + aaxpage,
        type: "get",
        datatype: "html"
    }).done(function(data){
        var newdate =$($.parseHTML(data)).find('.res-view .restaurants-boxes')[0].innerHTML;
     //    $('.load-more-rest').remove();
        $(".res-view .restaurants-boxes").append(newdate);
        aaxpage += 1;
        initMap();
        $('.load-more-rest').show();
        $('.spin-load').hide();
        if(newdate.length == 0){
          $('.load-more-rest').remove();
          $('.spin-load').hide();
        }
    }).fail(function(jqXHR, ajaxOptions, thrownError){
        $('.load-more-rest').remove();
        $('.spin-load').hide();
    });
}