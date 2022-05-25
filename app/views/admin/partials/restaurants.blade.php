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
    <form name="admin-form" id="admin-form" class="form-horizontal" role="form" action="{{ route('adminrestaurants'); }}" method="get" >
   
        <div class="form-group row">
            <label for="statu" class="col-md-2 control-label">Restaurant Status</label>
            <div class="col-md-6">
                <select name="status" id="status" class="form-control">
                    <option value="">All</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="city" class="col-md-2 control-label">Restaurant City</label>
            <div class="col-md-6">
                <?php
                $cities = MGeneral::getAllCities($country);
                echo MGeneral::generate_list($cities, "city_ID", "city_Name", 'city', 'city');
                ?>
            </div>
        </div>

        <div class="form-group row">
            <label for="cuisine" class="col-md-2 control-label">Cuisine</label>
            <div class="col-md-6">
                <?php
                $cuisines = MGeneral::getAllCuisine(1);
                echo MGeneral::generate_list($cuisines, "cuisine_ID", "cuisine_Name", 'cuisine', 'cuisine');
                ?>
            </div>
        </div>

        <div class="form-group row">
            <label for="best" class="col-md-2 control-label">Best For</label>
            <div class="col-md-6">
                <?php
                $bestfor = MGeneral::getAllBestFor(1);
                echo MGeneral::generate_list($bestfor, "bestfor_ID", "bestfor_Name", 'best', 'best');
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="membership" class="col-md-2 control-label">Membership</label>
            <div class="col-md-6">
                <?php
                $bestfor = MGeneral::getAllSubscriptionTypes($country);
                echo MGeneral::generate_list($bestfor, "id", "accountName", 'membership', 'membership');
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="sort" class="col-md-2 control-label">Sort By</label>
            <div class="col-md-6">
                <select name="sort" id="sort" class="form-control">
                    <option value="">...</option>
                    <option value="latest">Latest</option>
                    <option value="popular">Popular</option>
                    <option value="favorite">Favorite</option>
                    
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="offset-md-2 col-md-6">
                <button type="button" onclick="reloadTable('rest-table');" class="btn btn-primary-gradien">Filter</button>          
            </div>
        </div>
    </form>
</div>

<div class="well-white">
    <article>    
        <fieldset>
            <legend>
                {{ $pagetitle }}
                <a href="{{ route('adminrestaurants/form'); }}" class="btn btn-info btn-sm pull-right">Add new </a>
            </legend>        
        </fieldset>

        <div class="panel">
            <div class="panel-heading">
           
            </div>
            <div class="table-responsive">
            <table class="table  table-bordered" id="rest-table">
                <thead>
                    <tr class="text-center">
                        <?php
                        foreach ($headings as $key => $value) {
                            if ($value == 'Actions') {
                                ?>
                                <th style="width:10%;" class="col-md-1">{{ $value }}</th>
                                <?php
                            } else {
                                ?>
                                <th class="col-md-1">{{ $value }}</th>
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
    </article>
</div>
<script type="text/javascript">
    var rest_table;
    var tab_config= {columns:[
        {data:"rest_Name"},
        {data:"cities",searchable:false},
        {data:"cuisines",searchable:false},
        {data:"rest_Subscription"},
        {data:"lastUpdatedOn"},
        {data:"action",searchable:false,sortable:false}],
        order:[[4,'desc']],
        
         data:function(d){
                    return $.extend({},d,{
                        "status":$('#status').val(),
                        "city":$('#city').val(),
                        "cuisine":$('#cuisine').val(),
                        "best":$('#best').val(),
                        "membership":$('#membership').val(),
                        "sort":$('#sort').val(),
                        
                    })
                }
         

    };
    
    function reloadTable(table_id){
   
        reloadDataTable(table_id);
    }
    $(document).ready(function(){
  
        rest_table=startDataTable("rest-table","<?=route('get_rest_data')?>",tab_config);
        $("body").on("click",".cofirm-delete-btn",function() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn-primary p-0 mx-2',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });
            var  url = $(this).attr('link');
            swalWithBootstrapButtons.fire({
                title: '<?= __('You really want to delete?') ?>',
                text: "<?= __("You can't undo it.") ?>",
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