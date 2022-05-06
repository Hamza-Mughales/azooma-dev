@extends('admin.index')
@section('content')

<div class="overflow">
    <ol class="breadcrumb">
        <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
        <li><a href="<?= route('adminrestaurants'); ?>">Restaurants</a></li>  
        <li class="active">{{ $title }}</li>
    </ol>
</div>


<div class="well-white">
    <article>    
        <fieldset>
            <legend>
                {{ $pagetitle }}
            </legend>        
        </fieldset>

        <div class="panel table-responsive">
            
            <table class="table table-hover table-bordered text-center" id="rest-mostview">
                <thead>
                    <tr>
                        <?php
                        foreach ($headings as $key => $value) {
                            if ($value == 'Location') {
                                ?>
                                <th class="col-md-2">{{ $value }}</th>
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
                <tbody class="text-center"></tbody>
            </table>
            
        </div>
    </article>
</div>
<script>

var style_table; 
    var tab_config= {
        columns:[
            {data:"restaurant",name:'rest_Name'},
            {data:"total",name:'rest_Subscription'},
            {data:"membership_status",name:'rest_Viewed'},
            {data:"last_update",name:'lastUpdatedOn'}
        ],
        order:[[3,'desc']]
    };

    $(document).ready(function(){
        
        style_table = startDataTable("rest-mostview","<?= route('adminrestaurants/mostviewDT') ?>",tab_config);
    });

</script>

@endsection