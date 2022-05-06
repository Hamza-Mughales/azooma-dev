$(document).on('submit','#reset-form',function(){
    if($("#new-password").val()==""){
        alert('<?php echo Lang::get("messages.enter_new_password");?>');
        return false;
    }
    if($("#new-password").val()!=$("#confirm-password").val()){
        alert('<?php echo Lang::get("messages.passwords_must_match");?>');
        return false;    
    }
});