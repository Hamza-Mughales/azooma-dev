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
                
            </legend>        
        </fieldset>

        <div class="panel">
            
            <table id="users-table" class="table table-hover">
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
                <tbody>
          
                </tbody>
            </table>
 
        </div>
    </article>
</div>
<script type="text/javascript">
    var tab_config= {columns:[
        {data:"user_FullName"},
        {data:"user_Email"},
        {data:"user_Country"},
        {data:"user_nationality"},
        {data:"user_RegisDate"},
        {data:"count_login"},
        {data:"action",searchable:false,sortable:false},
    ],
       
        order:[[4,'desc']],
    
         

    };

    $(document).ready(function(){
  
    startDataTable("users-table","<?=route('getusersdata')?>",tab_config);
    });
    </script>
@endsection