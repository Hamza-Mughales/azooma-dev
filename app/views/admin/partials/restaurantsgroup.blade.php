@extends('admin.index')
{{-- @include('admin.index') --}}
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
                <a href="{{ route('adminrestaurantsgroup/form'); }}" class="btn btn-info btn-sm pull-right">Add new </a>
            </legend>        
        </fieldset>

        <div class="panel table-responsive">
            
            <table class="table table-hover table-bordered text-center" id="rest-groups">
                <thead>
                    <tr>
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
            {data:"updatedAt"},
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
        
        style_table = startDataTable("rest-groups","<?= route('adminrestaurantsgroupDT') ?>",tab_config);
    
    });

        
    function reloadTable(table_id){
   
       reloadDataTable(table_id);
    }

</script>

@endsection