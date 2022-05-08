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

<?php
    $countries = Config::get('settings.countries');
?>


<div id="filter-main" class="collapse well-white">
    <legend>   Filter Results </legend>  
        <div class="form-group row">
            <label for="status" class="col-md-2 control-label">Status</label>
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
                <button type="submit" class="btn btn-primary-gradien" onclick="reloadTable('rest-occasions')">Filter</button>          
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
            <table class="table table-hover" id="rest-occasions">
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
                                <th class="col-md-1">{{ $value }}</th>
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
            {data:"name"},
            {data:"user_FullName"},
            {data:"user_Mobile"},
            {data:"date"},
            {data:"budget"},
            {data:"guests"},
            {data:"updatedAt"},
            {data:"action", sortable:false, searchable:false}
        ],
        data:function(d){
            return $.extend({},d,{
                "status":$('#status').val()
            })
        },
        order:[[3,'desc']]
    };

    $(document).ready(function(){
        
        style_table = startDataTable("rest-occasions","<?= route('adminoccasionsDT') ?>",tab_config);

    });

        
    function reloadTable(table_id){
   
       reloadDataTable(table_id);
    }

</script>

@endsection