function addmore(){
    var element='<div class="form-group row"><label class="col-md-2 control-label" for="option-'+counter+'">Poll Option '+counter+'</label><div class="col-md-6"><input class="form-control required" type="text" name="option[]" id="option-'+counter+'" placeholder="Poll Option '+counter+'" /></div></div><div class="form-group row"><label class="col-md-2 control-label" for="option_ar-'+counter+'">Poll Option Arabic '+counter+'</label><div class="col-md-6"><input class="form-control required" dir="rtl" type="text" name="option_ar[]" id="option_ar-'+counter+'" placeholder="Poll Option Arabic '+counter+'" /></div></div>';
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