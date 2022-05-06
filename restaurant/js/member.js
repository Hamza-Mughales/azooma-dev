function addmore(){
    var element='<div id="input-'+counter+'"><input type="text" name="emails[]"  placeholder="Contact Email"  /><a class="close sufrati-close" href="javascript:void(0);" data-dismiss="input-'+counter+'">&times;</a></div>';
    $("#memberemails").append(element);
    counter++;
}

function addmoreAr(){
    var element='<div id="input-'+counter+'"><a class="close sufrati-close" href="javascript:void(0);" data-dismiss="input-'+counter+'">&times;</a><input type="text" name="emails[]"  placeholder="البريد الإلكتروني"  /></div>';
    $("#memberemails").append(element);
    counter++;
}

function selectPermissions(){
    var type=$("#rest_Subscription").val();
    $.get(base+'hungryn137/member/getpermissions?ajax=1&type='+type,
    function(data){
       $("#permissions").html(data['html']); 
       $("#price").val(data['price']);
    },"json");
}
$(document).on("click",".sufrati-close",function(event){
       var dismiss=$(this).attr('data-dismiss');
       $(this).parent().remove();
    });