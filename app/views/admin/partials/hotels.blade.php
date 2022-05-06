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
    <legend>   Filter Results </legend>  
      
        <div class="form-group row">
            <label for="statu" class="col-md-2 control-label text-end">Status</label>
            <div class="col-md-6">
                <select name="status" id="h-status" class="form-control h-status none-select2">
                    <option value="">All</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>
        
        <div class="form-group row">
            <div class="offset-lg-2 col-md-6">
                <button type="button" onclick="reloadTable('hotel-table');" class="btn btn-primary-gradien">Filter</button>          
            </div>
        </div>
    
</div>


<div class="card">
  
<div class="card-body">
   
<fieldset>
            <legend>
                {{ $pagetitle }}
                <a href="{{ route('adminhotels/form'); }}" class="btn btn-info btn-sm pull-right">Add new </a>
            </legend>        
        </fieldset>

     <div class="table-responsive">
            <table id="hotel-table" class="table table-hover">
                <thead class="text-center">
                    <tr>
                        <?php
                        foreach ($headings as $key => $value) {
                            if ($value == 'Actions') {
                                ?>
                                <th style="width:10%;" class="col-md-1">{{ $value }}</th>
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
                <tbody class="text-center">
                 </tbody>
            </table>
            </div>
        </div>
</div>

<script type="text/javascript">
    var hotel_table;
    var tab_config= {columns:[
        {data:"hotel_name"},
        {data:"star"},
        {data:"status_html",name:'status'},
        {data:"updatedAt"},
        {data:"action",searchable:false,sortable:false}],
         data:function(d){
                    return $.extend({},d,{"h_status":$('.h-status').val()})
                }
         

    };
    
    function reloadTable(table_id){
   
        reloadDataTable(table_id);
    }
    $(document).ready(function(){
  
        hotel_table=startDataTable("hotel-table","<?=route('hotels_data')?>",tab_config);
        
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
</script>
@endsection
