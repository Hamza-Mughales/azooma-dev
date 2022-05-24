
function enableCuisine(master_id) {
    $('#cuisine-list-' + master_id).removeClass('hidden');
}

function disableCuisine(master_id) {
    $('#cuisine-list-' + master_id).addClass('hidden');
}


function addmore() {
    var element = '<div id="input-' + counter + '" class="input-' + counter + '" ><input type="text" name="rest_Email[]"  placeholder="Contact Email" class="form-control"  /><a class="close Azooma-close" href="javascript:void(0);" data-dismiss="input-' + counter + '">&times;</a></div>';
    $("#memberemails").append(element);
    counter++;
}

$(document).on("click", ".Azooma-close", function(event) {
    var dismiss = $(this).attr('data-dismiss');
    $(this).parent().remove();
});

function selectgroup() {
    var type = $("#restbusiness_type").val();
    if (type == "2") {
        $("#group_value").removeClass('invisible');
    } else {
        $("#group_value").addClass('invisible');
    }
}


