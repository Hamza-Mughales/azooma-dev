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
            <label for="name" class="col-md-2 control-label">Restaurant Name</label>
            <div class="col-md-6">
                <input type="text" name="rst_name" id="rest_name" class="form-control" id="name" placeholder="Restaurant Name" >
            </div>
        </div>


        <div class="form-group row">
            <label for="name" class="col-md-2 control-label">Meal Type</label>
            <div class="col-md-6">
                <select class="form-control" name="meal_type" id="meal_type">
                    <option value="">All</option>
                    <?php
                    foreach ($mealsType as $key => $meal) {
                        ?>
                        <option value="<?php echo $meal; ?>"><?php echo $meal; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="statu" class="col-md-2 control-label">Status</label>
            <div class="col-md-6">
                <select name="status" id="status" class="form-control">
                    <option value="">please select Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>


        <div class="form-group row">
            <div class="offset-lg-2 col-md-6">
                <button type="button" class="btn btn-primary-gradien" onclick="reloadTable('rest-suggest')">Filter</button>          
            </div>
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
            
            <table class="table table-hover text-center" id="rest-suggest">
                <thead>
                    <tr>
                        <?php
                        foreach ($headings as $key => $value) {
                            if ($value == 'Restaurant Name') {
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
            {data:"breakfast"},
            {data:"lunch"},
            {data:"dinner"},
            {data:"latenight"},
            {data:"iftar"},
            {data:"suhur"}
        ],
        data:function(d){
            return $.extend({},d,{
                "rest_name":$('#rest_name').val(),
                "meal_type":$('#meal_type').val(),
                "status":$('#status').val()
            })
        },
    };

    $(document).ready(function(){
        
        style_table = startDataTable("rest-suggest","<?= route('adminsuggestedDT') ?>",tab_config);
        
    });

    function reloadTable(table_id){
        reloadDataTable(table_id);
    }
</script>

@endsection