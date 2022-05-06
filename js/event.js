$(document).ready(function(){
	$("#eventDate").datepicker({minDate:+14,dateFormat:"yy-mm-dd"});
    $("#catering-cuisines").multiselect({
        buttonWidth:'100%',
        buttonClass:'btn btn-light btn-lg',
        maxHeight:200,
        enableFiltering:true,
        filterBehavior:'text',
        enableCaseInsensitiveFiltering:true
    });
});