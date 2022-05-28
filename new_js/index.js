$(document).ready(function () {

    $(".close-search").click(function () {
        $(".search-full").removeClass("open");
        $("body").removeClass("offcanvas");
    });
    $(".header-search").click(function () {
        $(".search-full").addClass("open");
    });

    $("select:not(.none-select2,.dataTables_length select, .swal2-select) ").select2();
    $('form .required').map(function () {
        $(this).prop('required', true);
    });

    // jQuery Validator - Validation Settings for AddNav form
    $("#jqValidate").validate(
        {

            highlight: function (element) { $(element).addClass("is-invalid").removeClass("is-valid"); },
            unhighlight: function (element) { $(element).addClass("is-valid").removeClass("is-invalid"); }
        });

    $("body").on("click", ".cofirm-delete-button", function () {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-danger p-0',
                cancelButton: 'btn btn-primary mx-2'
            },
            buttonsStyling: false
        })
        var url = $(this).attr('link');
        swalWithBootstrapButtons.fire({
            title: 'You really want to delete ?',
            text: "You can't undo it. ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: ' <a class="btn btn-danger text-white" href="' + url + '">Yes</a> ',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.value != true)
                (
                    result.dismiss === Swal.DismissReason.cancel
                )
        });
    });

});

function errorMsg(message, title = 'Error') {
    Swal.fire({
            title: title,
            text: message,
            icon: 'error',
        });
}

function infoMsg(message, title = 'info') {
    Swal.fire({
            title: title,
            text: message,
            icon: 'warning',
        });
}

function confirmAction(form_id, url= '', title='You really want to delete?', message='You can\'t undo it') {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-primary mx-2'
        },
        buttonsStyling: false
    })

    form_id.attr('action', url);
    
    swalWithBootstrapButtons.fire({
        title: title,
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.value == true) {
            form_id.submit();
        }
        if (result.value != true)
            (
                result.dismiss === Swal.DismissReason.cancel
            )
    });
}