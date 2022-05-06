@extends('admin.index')
@section('content')

<div class="overflow row">
    <div class="col-md-8">
        <ol class="breadcrumb">
            <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
            <li class="active">{{ $title }}</li>
        </ol>
    </div>
</div>


<div class="well-white">
    <article>    
        <fieldset>
            <legend>
                {{ $pagetitle }}
            </legend>        
        </fieldset>

        <div class="panel table-responsive">
            
            <table class="table table-hover text-center" id="rest-fav">
                <thead>
                    <tr>
                        <?php
                        foreach ($headings as $key => $value) {
                            if ($value == 'Restaurant Name') {
                                ?>
                                <th class="col-md-3">{{ $value }}</th>
                                <?php
                            } else {
                                ?>
                                <th class="col-md-2">{{ $value }}</th>
                                <?php
                            }
                        }
                        ?>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            
        </div>
    </article>
</div>

<script type="text/javascript">
    var style_table; 
    var tab_config= {
        columns:[
            {data:"rest_Name"},
            {data:"rest_Name_Ar"},
            {data:"total_view"},
            {data:"action", sortable:false, searchable:false }
        ],
        data:function(d){
            return $.extend({},d,{
                "sortview":$('#sortview').val()
            })
        },
        order:[[2,'desc']]
    };

    $(document).ready(function(){
        
        style_table = startDataTable("rest-fav","<?= route('adminfavoritesDT') ?>",tab_config);
        
        $("body").on("click",".cofirm-delete-btn",function() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn-primary p-0 mx-2',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            var  url = $(this).attr('link');
            swalWithBootstrapButtons.fire({
                title: '<?= __('You really want to delete?') ?>',
                text: "<?= __("You can't undo it?") ?>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: ' <a class="btn btn-primary text-white" href="' + url + '"><?= __('Yes') ?>!</a> ',
                cancelButtonText: ' <?= __('Cancel') ?>! ',
                reverseButtons: true
            }).then((result) => {
                if (result.value != true)
                    (
                        result.dismiss === Swal.DismissReason.cancel
                    )
            });
        });

    });

    
    function reloadTable(table_id){
   
        reloadDataTable(table_id);
    }

</script>

@endsection