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
                <a href="{{ route('adminnewsletter/form'); }}" class="btn btn-info btn-sm pull-right">Add new </a>
            </legend>        
        </fieldset>

        <div class="panel">
            <div class="table-responsive">
            <table id="newsletter-table" class="table table-striped">
                <thead>
                    <tr>
                        <?php
                        foreach ($headings as $key => $value) {
                            if ($value == 'Description') {
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
                <tbody>
                   
                </tbody>
            </table>
            </div>
        </div>
    </article>
</div>
<script type="text/javascript">
    var tab_config= {columns:[
        {data:"name"},
        {data:"message"},
        {data:"receiver"},
        {data:"result",name:"receiver"},
        {data:"status_html",name:"status",searchable:false},
        {data:"updatedAt"},
        {data:"action",searchable:false,sortable:false}],
        order:[[5,'desc']],
     
         

    };
    $(document).ready(function(){
    startDataTable("newsletter-table","<?=route('adminnewsletterdata')?>",tab_config);
});
    function reloadTable(table_id){
   
        reloadDataTable(table_id);
    }
    </script>
@endsection