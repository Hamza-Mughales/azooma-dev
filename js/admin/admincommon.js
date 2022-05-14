$(document).ready(function() {
 

    $('.admin-action').click(function() {
        var url = $('.admin-action').attr('data-url');
        var action = $('.admin-action').attr('data-action');
        $.get(url, {}, function(data) {
            if (data == 1) {

            } else {

            }
            //$(this).css('display','none');
        });

    });
});

function deleterest(id) {
    window.location = base + "admin/adminrestaurants/delete/" + id;
}

function addmoreEmails() {
    var element = '<div id="input-' + counter + '" class="input-' + counter + '" ><input type="text" name="emails[]"  placeholder="Contact Email" class="form-control"  /><a class="close sufrati-close" href="javascript:void(0);" data-dismiss="input-' + counter + '">&times;</a></div>';
    $("#memberemails").append(element);
    counter++;
}

$(document).on("click", ".sufrati-close", function(event) {
    var dismiss = $(this).attr('data-dismiss');
    $(this).parent().remove();
});


function readcomment(id){
    $.get(base+'admin/admincomments/read/'+id,function(data){
        $('.table tr[data-row="'+id+'"]').removeClass('new-row');
    })
}

function readartcomment(id){
    $.get(base+'admin/adminarticlecomments/read/'+id,function(data){
        $('.table tr[data-row="'+id+'"]').removeClass('new-row');
    })
}

function readMenuRequest(id){
    $.get(base+'admin/adminmenurequest/read/'+id,function(data){
        $('.table tr[data-row="'+id+'"]').removeClass('new-row');
    })
}

function readoccasions(id){
    $.get(base+'admin/adminoccasions/read/'+id,function(data){
        $('.table tr[data-id="'+id+'"]').removeClass('new-row');
    })
}