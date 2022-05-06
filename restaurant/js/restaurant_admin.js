function getDistrict(field)
{
var id=field.value;
$('#districts').removeClass('nodisp');
$('#districts').addClass('disdisp');
$('#nodist').addClass('nodisp');
$.ajax({
   type: "POST",
   url: base_url+"restbranches/getdistrict/"+id,
   cache: false,
   
   success: function(data){
     	$('#districts').html(data);
		
     }
 });
}



function validatebranch()
{

if ( document.rest_branch.city_ID.selectedIndex == 0)
{
$('#cityID_error').addClass('inpbg_error');
document.rest_branch.city_ID.focus();
return false;
}

else if ( document.rest_branch.district_ID.selectedIndex == 0)
{
$('#cityID_error').removeClass('inpbg_error');
$('#distr_error').addClass('inpbg_error');
document.rest_branch.district_ID.focus();
return false;
}

else if ( document.rest_branch.br_loc.value == "" || document.rest_branch.br_loc.value == null )
{
$('#cityID_error').removeClass('inpbg_error');
$('#distr_error').removeClass('inpbg_error');
$('#brloc_error').addClass('inpbg_error');
document.rest_branch.br_loc.focus();
return false;

}

else if ( document.rest_branch.br_loc_ar.value == "" || document.rest_branch.br_loc_ar.value == null )
{
	$('#brloc_error').removeClass('inpbg_error');
alert("Please enter branch location in Arabic. Use the translation help box for arabic translation.");
$('#brlocar_error').addClass('inpbg_error');
document.rest_branch.br_loc_ar.focus();
return false;
}
}


$(document).ready(function(){
						   
$('#btnClear').click(function() {
$("#clearfile").attr({ value: '' });
});

$('#btnpdfClear').click(function() {
$("#clearpdfar").attr({ value: '' });
});	
						   
$(".flip").click(function(){
    $(".panel").slideToggle("fast");
});

$("#plus").click(function () {
		$("#plus").hide();
      $("#minus").show();
    });

$("#minus").click(function () {
		$("#plus").show();
      $("#minus").hide();
    });

$(".stflip").click(function(){
    $(".stpanel").slideToggle("fast");
  });

$("#bplus").click(function () {
		$("#bplus").hide();
      $("#bminus").show();
    });

$("#bminus").click(function () {
		$("#bplus").show();
      $("#bminus").hide();
    });


$(".flipsec").click(function(){
    $(".panelsec").slideToggle("fast");
  });

$("#week").click(function () {
		$("#week").hide();
      $("#weekmin").show();
    });

$("#weekmin").click(function () {
		$("#week").show();
      $("#weekmin").hide();
    });

$("#break").click(function () {
		$("#break").hide();
      $("#breakmin").show();
    });

$("#breakmin").click(function () {
		$("#break").show();
      $("#breakmin").hide();
    });

$("#weeknd").click(function () {
		$("#weeknd").hide();
      $("#weekndmin").show();
    });

$("#weekndmin").click(function () {
		$("#weeknd").show();
      $("#weekndmin").hide();
    });

$("#brnh").click(function () {
		$("#brnh").hide();
      $("#brnhmin").show();
    });

$("#brnhmin").click(function () {
		$("#brnh").show();
      $("#brnhmin").hide();
    });

$(".endflip").click(function(){
    $(".endpanel").slideToggle("fast");
  });

$(".brflip").click(function(){
    $(".brpanel").slideToggle("fast");
  });

$(".bnflip").click(function(){
    $(".bnpanel").slideToggle("fast");
  });
});

function validatephoto()
{

if ( document.add_image.title_ar.value == "" || document.add_image.title_ar.value == null )
{
$('#titlear_error').addClass('trerror');
document.add_image.title_ar.focus();
return false;
}

else if ( document.add_image.title.value == "" || document.add_image.title.value == null )
{
$('#titlear_error').removeClass('trerror');
$('#title_error').addClass('trerror');
document.add_image.title.focus();
return false;

}
else if ( document.add_image.image_full.value == "" || document.add_image.image_full.value == null )
{
	$('#title_error').removeClass('trerror');
$('#img_error').addClass('trerror');
document.add_image.image_full.focus();
return false;
}

}

function validateimageEn()
{

if ( document.add_image.title.value == "" || document.add_image.title.value == null )
{
	$('#title_error').addClass('inpbg_error');
	document.add_image.title.focus();
	return false;
}
else if ( document.add_image.title_ar.value == "" || document.add_image.title_ar.value == null )
{
	$('#title_error').removeClass('inpbg_error');
	$('#titlear_error').addClass('inpbg_error');
		document.add_image.title_ar.focus();
	return false;
}
else if ( document.add_image.image_full.value == "" || document.add_image.image_full.value == null )
{
	$('#titlear_error').removeClass('inpbg_error');
	$('#image_error').addClass('inpbg_error');
	document.add_image.image_full.focus();
	return false;
}

}

function validateEditImage()
{


if ( document.Editimage.title_ar.value == "" || document.Editimage.title_ar.value == null )
{
$('#artitle_error').addClass('inpbg_error');
	document.Editimage.title_ar.focus();
return false;
}

else if ( document.Editimage.title.value == "" || document.Editimage.title.value == null )
{
$('#artitle_error').removeClass('inpbg_error');
$('#title_error').addClass('inpbg_error');
document.Editimage.title.focus();
return false;
}

}



function validatedetails()
{

var chks = document.getElementsByName('cuisine_ID[]');
var checkCount = 0;
for (var i = 0; i < chks.length; i++)
{
if (chks[i].checked)
{
checkCount++;
}
}
if (checkCount < 1)
{

$('#cuisine_error').addClass('inpbg_error');

return false;
}


var bestfor = document.getElementsByName('bestfor_ID[]');

var bestCount = 0;
for (var i = 0; i < bestfor.length; i++)
{
if (bestfor[i].checked)
{
bestCount++;
}
}
if (bestCount < 1)
{

$('#best_error').addClass('inpbg_error');
return false;
}



if ( document.r_detail.rest_Name.value == "" || document.r_detail.rest_Name.value == null )
{
$('#restName_error').addClass('inpbg_error');
document.r_detail.rest_Name.focus();
return false;
}

else if ( document.r_detail.rest_Name_Ar.value == "" || document.r_detail.rest_Name_Ar.value == null )
{
$('#rest_Ar_error').addClass('inpbg_error');
document.r_detail.rest_Name_Ar.focus();
return false;
}
else if ( document.r_detail.class_category.selectedIndex == 0 )
{
$('#class_category_error').addClass('inpbg_error');
document.r_detail.class_category.focus();
return false;
}

}
function delete_record(delete_path, path ){
var r=confirm("Are you sure to delete?");
if (r==true)
  {
  $.ajax ({
			 url: delete_path,
			 type: 'POST',
			 datatype : "html",
			 success: function(html) {
				   main(path);
			   }
			  
			 });
  }

}

function main(path){
	$.ajax ({
			 url: path,
			 type: 'POST',
			 datatype : "html",
			 success: function(data) {
				 $('#ajax_data').html(data);
			   }
			  
			 });
}
function get_record(get_path, path){

	$.ajax ({
			 url: get_path,
			 type: 'POST',
			 datatype : "html",
			 success: function(html) {
				   main(path);
			   }
			  
			 });
}

function change_status(status_path, path){
	$.ajax ({
			 url: status_path,
			 type: 'POST',
			 datatype : "html",
			 success: function(html) {
				   main(path);
			   }
			  
			 });
}

function validatecategory()
{

if ( document.r_menu_cat.cat_name_ar.value == "" || document.r_menu_cat.cat_name_ar.value == null )
{
$('#catar_error').addClass('trerror');
document.r_menu_cat.cat_name_ar.focus();
return false;
}

else if ( document.r_menu_cat.cat_name.value == "" || document.r_menu_cat.cat_name.value == null )
{
$('#catar_error').removeClass('trerror');
$('#cat_error').addClass('trerror');
document.r_menu_cat.cat_name.focus();
return false;
}


}

function validateEngcategory()
{

if ( document.r_menu_cat.cat_name.value == "" || document.r_menu_cat.cat_name.value == null )
{
$('#cat_error').addClass('inpbg_error');
document.r_menu_cat.cat_name.focus();
return false;
}

else if ( document.r_menu_cat.cat_name_ar.value == "" || document.r_menu_cat.cat_name_ar.value == null )
{
$('#cat_error').removeClass('inpbg_error');
$('#catar_error').addClass('inpbg_error');
document.r_menu_cat.cat_name_ar.focus();
return false;
}
}


function validatemenu()
{

if ( document.add_menu.cat_id.selectedIndex == 0)
{	
$('#cat_error').addClass('trerror');
document.add_menu.cat_id.focus();
return false;
}

else if ( document.add_menu.menu_item_ar.value == "" || document.add_menu.menu_item_ar.value == null )
{
$('#cat_error').removeClass('trerror');
$('#menuAR_error').addClass('trerror');
document.add_menu.menu_item_ar.focus();
return false;
}

else if ( document.add_menu.menu_item.value == "" || document.add_menu.menu_item.value == null )
{
$('#menuAR_error').removeClass('trerror');
$('#menu_error').addClass('trerror');
document.add_menu.menu_item.focus();
return false;
}
}

function validatemenuEng()
{

if ( document.add_menu.cat_id.selectedIndex == 0)
{	
$('#cat_error').addClass('inpbg_error');

return false;
}

else if ( document.add_menu.menu_item.value == "" || document.add_menu.menu_item.value == null )
{
$('#cat_error').removeClass('inpbg_error');
$('#menu_error').addClass('inpbg_error');
document.add_menu.menu_item.focus();
return false;
}

else if ( document.add_menu.menu_item_ar.value == "" || document.add_menu.menu_item_ar.value == null )
{
$('#menu_error').removeClass('inpbg_error');
$('#menuar_error').addClass('inpbg_error');
document.add_menu.menu_item_ar.focus();
return false;
}

}

function commentresponseform()
{

if ( document.comment_response.replymsg.value == "" || document.comment_response.replymsg.value == null )
{
alert("Please write response message");
document.comment_response.replymsg.focus();
return false;
}
}

function responseform()
{

if ( document.booking_response.reser_status.selectedIndex == 0 )
{
alert("Please select booking status");
document.booking_response.reser_status.focus();
return false;
}
}

function selectserv(field)
 {
	var	id= field.value;
	
$('#default').removeClass('default_dis');
$('#default').addClass('display_non');
$('#selected_feat').removeClass('display_non');
$('#selected_feat').addClass('default_dis');

$.ajax({
   type: "POST",
   url: base_url+"booking/getseatfet/"+id, 
   cache: false,
   success: function(data){
	   		  $('#selected_feat').html(data)
     		
   }
 });
}

function timeselect(field)
{
	
$('#change_time').removeClass('time_disp');
$('#ch_time').addClass('timetime');
$('#change_time').removeClass('timetime');
$('#change_time').addClass('time_disp');

var timevalue = field.value;

$.ajax({
   type: "POST",
   url: base_url+"booking/bookingtime/"+timevalue,
   cache: false,
   
   success: function(data){
     	$('#change_time').html(data);
		
     }
 });
}

function dateselected(field)
{

var seldate=field.value;
var dddd = new Date(seldate);

var selecteddate=dddd.getDate();

var now = new Date();

var curdt=now.getDate();
var currhr=now.getHours();

if(selecteddate == curdt && currhr >= 18 ){
$('#lunchtime').removeClass('lutime');
$('#lunchtime').addClass('lunchtimeover');
$('#dinnertime').removeClass('lunchtimeover');
$('#dinnertime').addClass('lutime');
$('#ch_time').addClass('timetime');
}
else
{
$('#lunchtime').removeClass('lunchtimeover');
$('#lunchtime').addClass('lutime');
$('#dinnertime').removeClass('lutime');
$('#dinnertime').addClass('lunchtimeover');

}
}

function showtime(time_value,id)
{
	if ( document.booking_form.branchId.selectedIndex == 0)
			{
			
				alert("Please select restaurant branch first.");
				document.booking_form.branchId.focus();
				$('#branchId').addClass('bordercol');
				return false;
			}
	else if ( document.booking_form.guest_no.value == "" || document.booking_form.guest_no.value == null)
			{
				alert("Please enter how many people you have.");
				document.booking_form.guest_no.focus();
				$('#guest_no').addClass('bordercol');
				$('#branchId').removeClass('bordercol');
				return false;
			}
			
	else if ( data_change(document.booking_form.guest_no.value) == false)
			{
				
               alert("Please enter numeric value in guest");
			   return false;
		
			}
			
	else if ( document.booking_form.booking_date.value == "" || document.booking_form.booking_date.value == null)
			{
				alert("Please selecet date of booking first.");
				document.booking_form.booking_date.focus();
				$('#guest_no').removeClass('bordercol');
				$('#booking_date').addClass('bordercol');
				return false;
			}
			
	
	
$('#booking_time').val(time_value);
$('.time_des').removeClass('time_click');
$('#time_cl-'.concat(id)).addClass('time_click');

var brid=document.booking_form.branchId.value;
var dt_sel=document.booking_form.booking_date.value;
var guest_no=document.booking_form.guest_no.value;

$('#seats_available').removeClass('display_non');
$('#seats_available').addClass('default_dis');

var dataString 	= 'time_sel='+ time_value + '&date_sel=' + dt_sel + '&brid=' + brid+ '&guest_no=' + guest_no+ '&id=' + id;
var url=base_url+"booking/noOfseats_availabe";
$.ajax({
   type: "POST",
   url: url,
   data: dataString,
   success: function(data){
	  $('#seats_available').html(data)
     		
   }
 });
}
function validatebookinform()
{

	if ( document.booking_form.branchId.selectedIndex == 0)
			{
			
				alert("Please select restaurant branch.");
				document.booking_form.branchId.focus();
				$('#branchId').addClass('bordercol');
				return false;
			}
		
		else if ( document.booking_form.guest_no.value == "" || document.booking_form.guest_no.value == null)
			{
				alert("Please enter how many guests you will have.");
				document.booking_form.guest_no.focus();
				$('#rest_name').removeClass('bordercol');
				$('#guest_no').addClass('bordercol');
				return false;
			}
			
		else if ( data_change(document.booking_form.guest_no.value) == false)
			{
				
               alert("Please enter numeric value in guest");
			   return false;
		
			}
			
		else if ( document.booking_form.booking_date.value == "" || document.booking_form.booking_date.value == null)
			{
				alert("Please select enter your date of booking");
				document.booking_form.booking_date.focus();
				$('#guest_no').removeClass('bordercol');
				$('#booking_date').addClass('bordercol');
				return false;
			}
			
		else if ( document.booking_form.booking_time.value == "" || document.booking_form.booking_time.value == null)
			{
				alert("Please select your time of booking.");
				return false;
			}
	}
	
	function data_change(value)
     {
          var check = true;
		  var numchr = value;
          //var value = field.value; //get characters
          //check that all characters are digits, ., -, or ""
          for(var i=0;i < numchr.length; ++i)
          {
               var new_key = numchr.charAt(i); //cycle through characters
               if(((new_key < "0") || (new_key > "9")) && 
                    !(new_key == ""))
               {
                    check = false;
                    break;
               }
          }
          //apply appropriate colour based on value
          if(!check)
          {
               return false;
			   
          }
		  else{ return true;}
          
     }
	 
 function validatevideo()
{
if ( document.video_form.name_en.value == "" || document.video_form.name_en.value == null )
{
$('#name_en_error').addClass('trerror');
document.video_form.name_en.focus();
return false;

}

else if ( document.video_form.youtube_en.value == "" || document.video_form.youtube_en.value == null )
{
$('#name_en_error').removeClass('trerror');
$('#name_en_error').addClass('error_hide');
$('#youtube_error').addClass('trerror');
document.video_form.youtube_en.focus();
return false;
}

}


function validatevideoEng()
{
if ( document.video_form.name_en.value == "" || document.video_form.name_en.value == null )
{
$('#name_en_error').addClass('inpbg_error');
document.video_form.name_en.focus();
return false;

}

else if ( document.video_form.youtube_en.value == "" || document.video_form.youtube_en.value == null )
{
$('#name_en_error').removeClass('inpbg_error');
$('#youtube_error').addClass('inpbg_error');
document.video_form.youtube_en.focus();
return false;
}
}



function confirmValidate()
{
	
	var chks = document.getElementsByName('confirmBo[]');
	var checkCount = 0;
	for (var i = 0; i < chks.length; i++)
		{
			if (chks[i].checked)
		{
			checkCount++;
}
}
if (checkCount < 1)
{
alert("Please select any record to confirm.");
	return false;
}
}

function checkPermissions(field,url)
{
var id=field.value;
cheUrl=url+"bookingcp/menu/checkPermissions/"+id;

$.ajax({
   type: "POST",
   url: cheUrl,
   cache: false,
   success: function(data){
	 if(data=="free")
		{
			var redurl=url+"bookingcp/accounts";
			window.location = redurl;
		}
	   }
 });
}

function validatePoll()
{
if ( document.pollform.question_ar.value == "" || document.pollform.question_ar.value == null )
{
$('#questionAr_error').addClass('trerror');
document.pollform.question_ar.focus();
return false;
}

else if ( document.pollform.question.value == "" || document.pollform.question.value == null )
{
	$('#questionAr_error').removeClass('trerror');
$('#question_error').addClass('trerror');
document.pollform.question.focus();
return false;
}

}

function validatePollEng()
{
if ( document.pollform.question.value == "" || document.pollform.question.value == null )
{ 
$('#question_error').addClass('inpbg_error');
document.pollform.question.focus();
return false;
}

if ( document.pollform.question_ar.value == "" || document.pollform.question_ar.value == null )
{
$('#question_error').removeClass('inpbg_error');
$('#question_error').addClass('error_hide');
$('#ar_error').addClass('inpbg_error');
document.pollform.question_ar.focus();
return false;
}

}

function validatePollOption()
{
if ( document.editOptionAr.poll_id.selectedIndex == 0){
$('#pollidError').addClass('trerror');
document.editOptionAr.poll_id.focus();
return false;

}    

else if ( document.editOptionAr.field.value == "" || document.editOptionAr.field.value == null )
{ 
$('#pollidError').removeClass('trerror');
$('#polloptionError').addClass('trerror');
document.editOptionAr.field.focus();
return false;

}

else if ( document.editOptionAr.field_ar.value == "" || document.editOptionAr.field_ar.value == null )
{ 
$('#polloptionError').removeClass('trerror');
$('#aroptionError').addClass('trerror');
document.editOptionAr.field_ar.focus();
return false;

}
}

function pollOptionAr()
{
if ( document.pollOptionArabic.field_ar.value == "" || document.pollOptionArabic.field_ar.value == null )
{ 
$('#polloptionError').removeClass('trerror');
$('#aroptionError').addClass('trerror');
document.pollOptionArabic.field_ar.focus();
return false;
}

else if ( document.pollOptionArabic.field.value == "" || document.pollOptionArabic.field.value == null )
{ 
$('#polloptionError').addClass('trerror');
document.pollOptionArabic.field.focus();
return false;
}

}

function addOptionForm()
{
	
if ( document.pollOption.field.value == "" || document.pollOption.field.value == null )
{ 

$('#polloptionError').addClass('inpbg_error');
document.pollOption.field.focus();
return false;

}

else if ( document.pollOption.field_ar.value == "" || document.pollOption.field_ar.value == null )
{ 
$('#polloptionError').removeClass('inpbg_error');
$('#arError').addClass('inpbg_error');
document.pollOption.field_ar.focus();
return false;

}
}

function mutipleFormOptions()
{
	if ( document.getElementById("field-1").value == "" || document.getElementById("field-1").value == null )
	{ 
		$('#optionen-1').addClass('inpbg_error');
		document.getElementById("field-1").focus();
		return false;
	}
	else if ( document.getElementById("field_ar-1").value == "" || document.getElementById("field_ar-1").value == null )
	{ 
		$('#optionen-1').removeClass('inpbg_error');
		$('#optionar-1').addClass('inpbg_error');
		document.getElementById("field_ar-1").focus();
		return false;
	}
	else if ( document.getElementById("field-2").value == "" || document.getElementById("field-2").value == null )
	{ 
		$('#optionar-1').removeClass('inpbg_error');
		$('#optionen-2').addClass('inpbg_error');
		document.getElementById("field-2").focus();
		return false;
	}
	else if ( document.getElementById("field_ar-2").value == "" || document.getElementById("field_ar-2").value == null )
	{ 
		$('#optionen-2').removeClass('inpbg_error');
		$('#optionar-2').addClass('inpbg_error');
		document.getElementById("field_ar-2").focus();
		return false;
	}
	else if ( document.getElementById("field-1").value == document.getElementById("field-2").value )
	{ 
		$('#optionen-2').removeClass('inpbg_error');
		$('#optionar-2').removeClass('inpbg_error');
		$('#sameop-2').addClass('inpbg_error');
		document.getElementById("field-2").focus();
		return false;
	}
	else if ( document.getElementById("field_ar-1").value == document.getElementById("field_ar-2").value )
	{ 
		$('#optionar-2').removeClass('inpbg_error');
		$('#sameop-2').removeClass('inpbg_error');
		$('#samearop-2').addClass('inpbg_error');
		document.getElementById("field_ar-2").focus();
		return false;
	}
	
}


function mutipleFormOptionsAR()
{
	if ( document.getElementById("field_ar-1").value == "" || document.getElementById("field_ar-1").value == null )
	{ 
		$('#optionar-1').addClass('trerror');
		document.getElementById("field_ar-1").focus();
		return false;
	}
	else if ( document.getElementById("field-1").value == "" || document.getElementById("field-1").value == null )
	{ 
		$('#optionar-1').removeClass('trerror');
		$('#optionen-1').addClass('trerror');
		document.getElementById("field-1").focus();
		return false;
	}
	
	else if ( document.getElementById("field_ar-2").value == "" || document.getElementById("field_ar-2").value == null )
	{ 
		$('#optionen-1').removeClass('trerror');
		$('#optionar-2').addClass('trerror');
		document.getElementById("field_ar-2").focus();
		return false;
	}
	
	else if ( document.getElementById("field-2").value == "" || document.getElementById("field-2").value == null )
	{ 
		$('#optionar-2').removeClass('trerror');
		$('#optionen-2').addClass('trerror');
		document.getElementById("field-2").focus();
		return false;
	}
	else if ( document.getElementById("field_ar-1").value == document.getElementById("field_ar-2").value )
	{ 
		$('#optionar-2').removeClass('trerror');
		$('#optionen-2').removeClass('trerror');
		$('#samear-2').addClass('trerror');
		document.getElementById("field_ar-2").focus();
		return false;
	}
	else if ( document.getElementById("field-1").value == document.getElementById("field-2").value )
	{ 
		$('#optionen-2').removeClass('trerror');
		$('#samear-2').removeClass('trerror');
		$('#sameen-2').addClass('trerror');
		document.getElementById("field-2").focus();
		return false;
	}
	
}


function OptionEn()
{
	
if ( document.editpollOption.poll_id.selectedIndex == 0){
$('#pollidError').addClass('inpbg_error');

return false;

}    

else if ( document.editpollOption.field.value == "" || document.pollOption.field.value == null )
{ 
$('#pollidError').removeClass('inpbg_error');
$('#pollidError').addClass('error_hide');
$('#polloptionError').addClass('inpbg_error');
document.editpollOption.field.focus();
return false;

}

else if ( document.editpollOption.field_ar.value == "" || document.editpollOption.field_ar.value == null )
{ alert("we are here");
$('#polloptionError').removeClass('inpbg_error');
$('#polloptionError').addClass('error_hide');
$('#arabError').addClass('inpbg_error');
document.editpollOption.field_ar.focus();
return false;

}

}

function adminAccount()
{
var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/; 
if ( document.setting.full_name.value == "" || document.setting.full_name.value == null )
{
$('#nameError').addClass('inpbg_error');
document.setting.full_name.focus();

return false;
}

else if ( document.setting.phone.value == "" || document.setting.phone.value == null )
{
$('#nameError').removeClass('inpbg_error');
$('#mobileError').addClass('inpbg_error');
document.setting.phone.focus();
return false;
}

else if ( document.setting.email1.value == "" || document.setting.email1.value == null )
			{
				document.setting.email1.focus();
				$('#mobileError').removeClass('inpbg_error');
				$('#emailError').addClass('inpbg_error');
				return false;
			}

else if ( emailPattern.test(document.setting.email1.value) == false )
{
				document.setting.email1.focus();
				$('#emailError').removeClass('inpbg_error');
				$('#emailpattern').addClass('inpbg_error');
				return false;
}

else if (document.setting.email2.value!="" && emailPattern.test(document.setting.email2.value) == false )
{
				document.setting.email2.focus();
				$('#emailpattern').removeClass('inpbg_error');
				$('#email2pattern').addClass('inpbg_error');
				return false;
}
else if (document.setting.email3.value!="" && emailPattern.test(document.setting.email3.value) == false )
{
				document.setting.email2.focus();
				$('#email2pattern').removeClass('inpbg_error');
				$('#email3pattern').addClass('inpbg_error');
				return false;
}


else if(document.setting.email1.value ==document.setting.email2.value )
{
	alert("Please check your emails. Email 1 and Email 2 are same");
	return false;
}
else if(document.setting.email1.value == document.setting.email3.value)
{
	alert("Please check your emails. Email 1 and Email 3 are same");
	return false;
}
else if(document.setting.email2.value!="" && document.setting.email2.value ==document.setting.email3.value)
{
	alert("Please check your emails. Email 2 and Email 3 are same");
	return false;
}

}



function checkpassword()
{

if ( document.passwordForm.password.value == "" || document.passwordForm.password.value == null )
{
$('#passerror').addClass('inpbg_error');
document.passwordForm.password.focus();
return false;
}

else if ( document.passwordForm.newpassword.value == "" || document.passwordForm.newpassword.value == null )
{
$('#passerror').removeClass('inpbg_error');
$('#newpasserror').addClass('inpbg_error');
document.passwordForm.newpassword.focus();
return false;
}

else if ( document.passwordForm.confpassword.value == "" || document.passwordForm.confpassword.value == null )
{
$('#newpasserror').removeClass('inpbg_error');
$('#conpasserror').addClass('inpbg_error');
document.passwordForm.confpassword.focus();
return false;
}

else if ( document.passwordForm.newpassword.value != document.passwordForm.confpassword.value )
{
alert("Your New Password and Confirm Password are not same.");
return false;
}


}

function adminAccountAR()
{
var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/; 
if ( document.setting.full_name.value == "" || document.setting.full_name.value == null )
{
$('#nameErrorAR').addClass('trerror');
document.setting.full_name.focus();
return false;
}

else if ( document.setting.phone.value == "" || document.setting.phone.value == null )
{
$('#nameErrorAR').removeClass('trerror');
$('#mobileErrorAR').addClass('trerror');
document.setting.phone.focus();
return false;
}

else if ( document.setting.email1.value == "" || document.setting.email1.value == null )
			{
				document.setting.email1.focus();
				$('#mobileErrorAR').removeClass('trerror');
				$('#emailError').addClass('trerror');
				return false;
			}

else if ( emailPattern.test(document.setting.email1.value) == false )
{
				document.setting.email1.focus();
				$('#emailError').removeClass('trerror');
				$('#emailpattern').addClass('trerror');
				return false;
}

else if (document.setting.email2.value!="" && emailPattern.test(document.setting.email2.value) == false )
{
				document.setting.email2.focus();
				$('#emailpattern').removeClass('trerror');
				$('#email2pattern').addClass('trerror');
				return false;
}
else if (document.setting.email3.value!="" && emailPattern.test(document.setting.email3.value) == false )
{
				document.setting.email2.focus();
				$('#email2pattern').removeClass('trerror');
				$('#email3pattern').addClass('trerror');
				return false;
}


else if(document.setting.email1.value ==document.setting.email2.value )
{
	alert("Please check your emails. Email 1 and Email 2 are same");
	return false;
}
else if(document.setting.email1.value == document.setting.email3.value)
{
	alert("Please check your emails. Email 1 and Email 3 are same");
	return false;
}
else if(document.setting.email2.value!="" && document.setting.email2.value ==document.setting.email3.value)
{
	alert("Please check your emails. Email 2 and Email 3 are same");
	return false;
}

}



function checkpasswordAR()
{

if ( document.passwordForm.password.value == "" || document.passwordForm.password.value == null )
{
$('#passArerror').addClass('trerror');
document.passwordForm.password.focus();
return false;
}

else if ( document.passwordForm.newpassword.value == "" || document.passwordForm.newpassword.value == null )
{
$('#passArerror').removeClass('trerror');
$('#newArerror').addClass('trerror');
document.passwordForm.newpassword.focus();
return false;
}

else if ( document.passwordForm.confpassword.value == "" || document.passwordForm.confpassword.value == null )
{
$('#newArerror').removeClass('trerror');
$('#confErrorAr').addClass('trerror');
document.passwordForm.confpassword.focus();
return false;
}

else if ( document.passwordForm.newpassword.value != document.passwordForm.confpassword.value )
{
alert("Your New Password and Confirm Password are not same.");
return false;
}
}

function validatepdf()
{

if ( document.pdfForm.menu_pdf_en.value == "" || document.pdfForm.menu_pdf_en.value == null )
{
	alert("Please add PDF Menu");
	return false;
}

}

function validatepdfAR()
{

if ( document.pdfForm.menu_pdf_en.value == "" || document.pdfForm.menu_pdf_en.value == null )
{
	alert("PDF الرجاء إضافة قائمة");
	return false;
}
}


function validateOffer()
{
	
var totalChecked = 0;
   for (i = 0; i < document.offer.categoryID.options.length; i++) {
      if (document.offer.categoryID.options[i].selected) {
         totalChecked++;
      }
   }

var branchChecked = 0;
   for (i = 0; i < document.offer.branch.options.length; i++) {
      if (document.offer.branch.options[i].selected) {
         branchChecked++;
      }
   }

	
if (totalChecked <1) {
      $('#category_error').addClass('inpbg_error');
		document.offer.categoryID.focus();
		return false;
   }

else if ( document.offer.offerName.value == "" || document.offer.offerName.value == null )
{
	 $('#category_error').removeClass('inpbg_error');
$('#offerName_error').addClass('inpbg_error');
document.offer.offerName.focus();
return false;
}

else if ( document.offer.offerNameAr.value == "" || document.offer.offerNameAr.value == null )
{
$('#offerName_error').removeClass('inpbg_error');
$('#offerNameAr_error').addClass('inpbg_error');
document.offer.offerNameAr.focus();
return false;
}
else if (branchChecked <1) {
	$('#offerNameAr_error').removeClass('inpbg_error');
      $('#branch_error').addClass('inpbg_error');
		document.offer.branch.focus();
		return false;
   }
}

function validateOfferAr()
{
		
var totalChecked = 0;
   for (i = 0; i < document.offer.categoryID.options.length; i++) {
      if (document.offer.categoryID.options[i].selected) {
         totalChecked++;
      }
   }

var branchChecked = 0;
   for (i = 0; i < document.offer.branch.options.length; i++) {
      if (document.offer.branch.options[i].selected) {
         branchChecked++;
      }
   }

if (totalChecked <1) {
      $('#categoryIDerror').addClass('trerror');
		document.offer.categoryID.focus();
		return false;
   }	
if ( document.offer.offerNameAr.value == "" || document.offer.offerNameAr.value == null )
{
	$('#categoryIDerror').removeClass('trerror');
$('#offerErrorAR').addClass('trerror');
document.offer.offerNameAr.focus();
return false;
}

else if ( document.offer.offerName.value == "" || document.offer.offerName.value == null ) 
{
$('#offerErrorAR').removeClass('trerror');
$('#offerError').addClass('trerror');
document.offer.offerName.focus();
return false;
}
else if (branchChecked <1) {
	$('#offerError').removeClass('trerror');
      $('#brancherr').addClass('trerror');
		document.offer.branch.focus();
		return false;
   }
}

function checknum(numval)
     {
          var check = true;
          
          //check that all characters are digits, ., -, or ""
          for(var i=0;i < numval.length; ++i)
          {
               var new_key = numval.charAt(i); //cycle through characters
               if(((new_key < "0") || (new_key > "9")) && 
                    !(new_key == ""))
               {
                    check = false;
                    break;
               }
          }
          //apply appropriate colour based on value
          if(!check)
          {
               return false;
          }
		  else
		  {
		  return true;
		  }
          
     }

function checkprice(field){
	var price=field.value;
	if ( checknum(price) == false)
			{
			 alert("Please enter numeric value in price");
			 document.add_menu.price.value="";
			 document.add_menu.price.focus();
			}
}

function reviewstatus(field,reviewID){
	var restatus=field.value;
	
$.ajax({
   type: "POST",
   url: base_url+"home/reviewstatus/"+restatus+"/"+reviewID,
   cache: false,
   
   success: function(data){
	 
     }
 });
}

