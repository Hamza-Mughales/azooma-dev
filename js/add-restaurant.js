$(document).ready(function(){
	$("#cuisines").multiselect({
		buttonText: function(options, select) {
            if (options.length == 0) {
                return langlibrary.select_cuisine+' ('+langlibrary.maximum+' 2) ' + ' <b class="caret"></b>';
            }
            else {
                if (options.length > this.numberDisplayed) {
                    return options.length + ' ' + this.nSelectedText + ' <b class="caret"></b>';
                }
                else {
                    var selected = '';
                    options.each(function() {
                        var label = ($(this).attr('label') !== undefined) ? $(this).attr('label') : $(this).html();
 
                        selected += label + ', ';
                    });
                    return selected.substr(0, selected.length - 2) + ' <b class="caret"></b>';
                }
            }
        },
        onChange:function(element,checked){
    		var length=0;
            if($("#cuisines").val()!=null){
                length=$("#cuisines").val().length;
            }
    		var dropdown=$("#cuisines").siblings('.multiselect-container');
    		if(length>=2){
    			var nonsel=$("#cuisines option").filter(function(){
    				return !$(this).is(':selected');
    			});
    			nonsel.each(function(){
    				var input=$('input[value="'+$(this).val()+'"]');
    				input.prop('disabled',true);
    				input.parent('li').addClass('disabled');
    			})
    		}else{
    			$("#cuisines option").each(function(){
    				var input = $('input[value="' + $(this).val() + '"]');
                    input.prop('disabled',false);
                    input.parent('li').removeClass('disabled');
    			});
    		}
        },
		buttonWidth:'100%',
		buttonClass:'btn btn-light btn-lg',
		maxHeight:200,
		enableFiltering:true,
		filterBehavior:'text',
		enableCaseInsensitiveFiltering:true,
	});
});

$(document).on('submit','#addrestaurant-form',function(e){
    var k=true;
	$("#addrestaurant-form .required").each(function(){
		if($(this).val().length<=0){
			k=false;
            $(this).focus();
			$(this).parent('.form-group').addClass('has-error');
			return false;
		}
	});
    if(!checkEmail($("#restaurantEmail").val())){
        k=false;
        $(this).focus();
        return false;
    }
    if(!checkEmail($("#yourEmail").val())){
        k=false;
        $(this).focus();
        return false;
    }
    if(k){
        return true;
    }
});
$("#addrestaurant-form").on('keyup',".required",function(){
	if($(this).val().length>0){
		$(this).parent('.form-group').removeClass('has-error');
	}
});