function addmore(){
    var element='<div class="control-group"><label class="control-label" for="option-'+counter+'">Poll Option '+counter+'</label><div class="controls"><input class="required" type="text" name="option[]" id="option-'+counter+'" placeholder="Poll Option '+counter+'" /></div></div><div class="control-group"><label class="control-label" for="option_ar-'+counter+'">Poll Option Arabic '+counter+'</label><div class="controls"><input class="required" dir="rtl" type="text" name="option_ar[]" id="option_ar-'+counter+'" placeholder="Poll Option Arabic '+counter+'" /></div></div>';
    $("#poll-options-container").append(element);
    counter++;
}

function addmoreAr(){
    var element='<div class="control-group"><label class="control-label" for="option-'+counter+'">اسم الخيار '+counter+'</label><div class="controls"><input class="required" type="text" name="option[]" id="option-'+counter+'" placeholder="اسم الخيار '+counter+'" /></div></div><div class="control-group"><label class="control-label" for="option_ar-'+counter+'">اسم الخيار - اللغة العربية '+counter+'</label><div class="controls"><input class="required" dir="rtl" type="text" name="option_ar[]" id="option_ar-'+counter+'" placeholder="اسم الخيار - اللغة العربية '+counter+'" /></div></div>';
    $("#poll-options-container").append(element);
    counter++;
}

$(document).on("click",".sufrati-close",function(event){
    if(confirm("Are you sure")){
       var dismiss=$(this).attr('data-dismiss');
       $(this).parent().parent().parent().remove();
       counter--;
    }
    });