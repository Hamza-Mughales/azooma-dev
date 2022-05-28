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
        <div class="">
            <h4 class="d-inline-block">
                {{ $pagetitle }}
            </h4>
            <!-- Button trigger modal -->
            <button class="btn btn-outline-secondary btn-md mx-5" type="button" id="pulck-delete-user" data-bs-original-title="btn btn-outline-secondary btn-md" data-original-title="btn btn-outline-secondary btn-md">
                Pulck Delete 
                <i class="fa fa-trash"></i>
            </button>    
            
        </div>

        <div class="panel">
            <form id="multi-delete" method="POST" >

                <table id="users-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" class="select-all" name="select-all" id="">
                            </th>
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
           </form>
 
        </div>
        
    </article>
</div>
<script type="text/javascript">
    var tab_config= {columns:[
        {data:"select", sortable:false, searchable:false},
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


        $('.select-all').click( function() {
            
            if ($(this).is(':checked')) {
                
                $('.check-class').map(function () {
                    $(this).prop('checked', true);
                    
                });
            
            } else{
                $('.check-class').map(function () {
                    $(this).prop('checked', false);
                    
                });
            }
        });


        $('#pulck-delete-user').click( function() {

            let selected = false;

            $('.check-class').map(function () {
               if ($(this).is(':checked')) {
                   selected = true;
               }
               
            });
            
            if (selected == false) {
                infoMsg('Please select one record at least!');
                return false;
            }

            confirmAction($('#multi-delete'), "<?= route('adminusersMultiDelete') ?> ");

        });


</script>
@endsection