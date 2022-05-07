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

<?php
    $countries = Config::get('settings.countries');
?>


<div class="well-white">
    <article>    
        <fieldset>
            <legend>
                {{ $pagetitle }}
                <a href="{{ route('adminrecipe/form'); }}" class="btn btn-info btn-sm pull-right">Add new </a>
            </legend>        
        </fieldset>

        <div class="panel table-responsive">
            
            <table class="table table-hover text-center" id="rest-recipes">
                <thead>
                    <tr>
                        <?php
                        foreach ($headings as $key => $value) {
                            if ($value == 'Title') {
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
            {data:"name"},
            {data:"nameAr"},
            {data:"views"},
            {data:"updatedAt"},
            {data:"action", sortable:false, searchable:false}
        ],
        order:[[3,'desc']]
    };

    $(document).ready(function(){
        
        style_table = startDataTable("rest-recipes","<?= route('adminrecipeDT') ?>",tab_config);
    
    });

        
    function reloadTable(table_id){
   
       reloadDataTable(table_id);
    }

</script>

@endsection