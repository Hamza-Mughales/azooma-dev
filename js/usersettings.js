$(document).ready(function(){
    var hash=location.hash;
    $("#user-settings-tab a[href='"+hash+"']").tab('show');
    $("#notification_emails").bootstrapSwitch();
    $("#weekly").bootstrapSwitch();
    $("#monthly").bootstrapSwitch();

});
$(document).on('submit','#user-general-form',function(e){
    if($("#user_FullName").val()==""){
        alert("<?php echo Lang::get('messages.name_empty');?>");
        e.preventDefault();
        return false;
    }
});
$(document).on('submit','#user-password-form',function(e){
    if($("#password").length>0){
        if($("#password").val()==""){
            alert(langlibrary.password_required);
            e.preventDefault();
            return false;
        }
    }else{
        if($("#old_password").val()==""){
            alert("<?php echo Lang::get('messages.enter_old_password');?>");
            e.preventDefault();
            return false;
        }
        if($("#new_password").val()==""){
            alert("<?php echo Lang::get('messages.new_password_empty');?>");
            e.preventDefault();
            return false;
        }
    }
});
var k=false;
$("#user-photo-form").on('change','#user-photo-btn',function(e){
    var _URL = window.URL || window.webkitURL;
    if($(this).val()!=""){
        var img=new Image();
        img.onload = function () {
            $("#user-photo-preview").attr('src',this.src);
            var width=this.width,height=this.height;
            if(width<200||height<200){
                alert(langlibrary.select_bigger_image);
            }else{
                $("#resize-actions").removeClass('hidden');
                $("#resize-photo").addClass('hidden');
                $(".image-upload-btn").addClass('hidden');
                if(k){
                    k.destroy();
                }
                k=$("#user-photo-preview").Jcrop({
                    aspectRatio:1,
                    trueSize:[width,height],
                    minSize:[200,200],
                    setSelect:[0,0,200,200],
                    onSelect:function(cords){
                        $("#x1").val(cords.x);
                        $("#y1").val(cords.y);
                        $("#x2").val(cords.x2);
                        $("#y2").val(cords.y2);
                        $("#height").val(cords.h);
                        $("#width").val(cords.w);
                    }
                });
            }
        }
        img.onerror = function() {
            alert( "not a valid file: " + file.type);
        };
        img.src=_URL.createObjectURL(this.files[0]);
    }
});

$("#save-photo").click(function(e){
    e.preventDefault();
    $("#user-photo-form").submit();
});

$("#resize-photo").click(function(e){
    var width=$("#resize-actions").attr('data-width');
    var height=$("#resize-actions").attr('data-height');
    if(k){
        k.destroy();
    }
    $("#user-photo-preview").Jcrop({
        aspectRatio:1,
        trueSize:[width,height],
        minSize:[200,200],
        setSelect:[0,0,200,200],
        onSelect:function(cords){
            $("#x1").val(cords.x);
            $("#y1").val(cords.y);
            $("#x2").val(cords.x2);
            $("#y2").val(cords.y2);
            $("#height").val(cords.h);
            $("#width").val(cords.w);
        }
    });
});
$("#cancel-photo").click(function(e){
    e.preventDefault();
    $("#resize-actions").addClass('hidden');
    $("#resize-photo").removeClass('hidden');
    $(".image-upload-btn").removeClass('hidden');
    $("#user-photo-preview").attr('src',$("#resize-actions").attr('data-original'));
})