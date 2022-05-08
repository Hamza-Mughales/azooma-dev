@extends('admin.index')
@section('content')

<?php
    // dd($id);
?>
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
                <a href="{{ route('admincompetitions/form'); }}" class="btn btn-info btn-sm pull-right">Add new </a>
            </legend>        
        </fieldset>

        <div class="panel table-responsive" >
            <table class="table table-hover" id="rest-pairti">
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
            {data:"birthday"},
            {data:"number"},
            {data:"status"},
            {data:"updatedAt"},
            {data:"action", sortable:false, searchable:false}
        ],
        order:[[4,'desc']]
    };

    $(document).ready(function(){
        var route = "<?= route('admincompetitions/participantsDT/',$id) ?>";
        style_table = startDataTable("rest-pairti",route,tab_config);    
    });

</script>
@endsection