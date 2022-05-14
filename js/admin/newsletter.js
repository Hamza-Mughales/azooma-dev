function checkReceiver() {
    checktotal('userType');
    var reciever = $("#userType").val();
    if (reciever == '0') {
        $("#testemails").removeClass('hidden');
        $("#cusineList").addClass('hidden');
        $("#cityList").addClass('hidden');
        $("#cityList").prop('required',false);
        $("#cusineList").prop('required',false);
    } else if (reciever == 2 || reciever == 3 || reciever == 4 || reciever == 5) {
        $("#testemails").addClass('hidden');
        $("#cusineList").removeClass('hidden');
        $("#cuisines_chosen").css('width', '575px')
        $("#cityList").removeClass('hidden');
        $("#cityList").prop('required',true);
        $("#cusineList").prop('required',true);
    } else if (reciever == 1 || reciever == 6) {
        $("#testemails").addClass('hidden');
        $("#cusineList").addClass('hidden');
        $("#cityList").removeClass('hidden');
        $("#cityList").prop('required',false);
        $("#cusineList").prop('required',false);
    } else {
        $("#testemails").addClass('hidden');
        $("#cusineList").addClass('hidden');
        $("#cityList").addClass('hidden');
        $("#cityList").prop('required',false);
        $("#cusineList").prop('required',false);
        $("#testemails").prop('required',false);
    }


}

function checktotal(rec) {
    var reciever = $("#"+rec).val();
    var itype = "";
    if (reciever == 0) { //NON
        $("#totreceiver").html('0');
    } else if (reciever == 1) { //ALL USERS
        type = "users";
    } else if (reciever == 2) { //All Paid Restaurants Members
        itype = "paidrest";
    } else if (reciever == 3) { //All Restaurants Members
        itype = "memberrest";
    } else if (reciever == 4) { //All Restaurants
        itype = "rest";
    } else if (reciever == 5) { //All Non Restaurants Members
        itype = "nonrest";
    } else if (reciever == 6) { //All Hotels
        itype = "hotels";
    } else if (reciever == 7) { //ALL SUBSCRIBERS
        $("#totreceiver").html(totalsubs);
    } else {
        $("#totreceiver").html('0');
    }

    if (itype != "") {
        $.get(base + "admin/adminnewsletter/getAjaxCount?type=" + itype, {}, function(data) {
            if (data != "") {
                $("#totreceiver").html(data['total']);
            } else {
                $("#totreceiver").html('0');
            }
        });
    }
}

function saveNewsletter() {
    $("#saveButton").addClass('loading');
    if (editor.getData() != "") {
        $("#newsletterForm").attr("action", base + "admin/newsletter/save");
        $("#newsletterForm").submit();
    } else {
        alert("Please Enter Newsletter Contents");
    }
}


  