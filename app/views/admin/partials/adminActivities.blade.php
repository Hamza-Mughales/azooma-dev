@extends('admin.owner.index')
@section('content')
    

<ol class="breadcrumb">
    <li><a href="<?= route('ownerhome'); ?>">Dashboard</a></li> 
    <li><a href="<?= route('admins'); ?>">Administrators</a></li>  
    <li class="active">{{ $title }}</li>
</ol>

<div class="well-white">
    <article>    
        <fieldset>
            <legend>
                {{ $pagetitle }}
            </legend>        
        </fieldset>

        <div class="panel">
            <div class="panel-heading">
        
            </div>
            <table id="activity-table" class="table table-striped">
                <thead>
                    <tr>
                        <?php
                        foreach ($headings as $key => $value) {
                            ?>
                            <th >{{ $value }}</th>
                            <?php
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
        {data:"user"},
        {data:"message"},
        {data:"date_time"}
    ],
       
        order:[[2,'desc']],
    
         

    };

    $(document).ready(function(){
  
    startDataTable("activity-table","<?=route('adminsactivitydata',$user_id)?>",tab_config);
    });
</script>
@endsection