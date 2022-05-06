@extends('admin.index')
@section('content')


<div class="overflow row">
    <div class="col-md-8">
        <ol class="breadcrumb">
            <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
            <li class="active">{{ $title }}</li>
        </ol>
    </div>
    <div class="col-md-4">
        <button type="button" class="btn pull-right" data-bs-toggle="collapse" data-bs-target="#filter-main">  <i data-feather="filter"></i> </button>
    </div>
</div>

<div id="filter-main" class="collapse well-white">
    <legend> Filter Results </legend>  
        <div class="form-group row">
            <label for="statu" class="col-md-2 control-label text-end">Status</label>
            <div class="col-md-6">
                <select name="status" id="status" class="form-control">
                    <option value="">All</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-lg-2 col-md-6">
                <button type="button" class="btn btn-primary-gradien" onclick="reloadTable('rest-style')">Filter</button>          
            </div>
        </div>
</div>

<div class="well-white">
    <article>    
        <fieldset>
            <legend>
                {{ $pagetitle }}
                <a href="{{ route('adminreststyle/form'); }}" class="btn btn-info btn-sm pull-right">Add new </a>
            </legend>        
        </fieldset>

        <div class="panel table-responsive">
            
            <table class="table table-hover text-center" id="rest-style">
                <thead>
                    <tr>
                        <?php
                        foreach ($headings as $key => $value) {
                            if ($value == 'Description') {
                                ?>
                                <th class="col-md-4">{{ $value }}</th>
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
                <tbody class="text-center"></tbody>
            </table>

        </div>
    </article>
</div>


<script type="text/javascript">
    var style_table; 
    var tab_config= {
        columns:[
            {data:"title", name:"name"},
            {data:"createdAt"},
            {data:"action", sortable:false, searchable:false}
        ],
        data:function(d){
            return $.extend({},d,{
                "status":$('#status').val()
            })
        },
        order:[[1,'desc']]
    };

    $(document).ready(function(){
        
        style_table = startDataTable("rest-style","<?= route('adminreststyleDT') ?>",tab_config);
    
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