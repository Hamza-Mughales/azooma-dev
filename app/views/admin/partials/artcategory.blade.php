@extends('admin.index')
@section('content')


<div class="overflow">
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
            <legend>{{ $pagetitle }}</legend>        
        </fieldset>

        <div class="panel table-responsive">
            <table class="table table-hover" id="rest-artcats">
                <thead>
                    <tr>
                        <?php
                        foreach ($headings as $key => $value) {
                            ?>
                            <th class="col-md-1">{{ $value }}</th>
                            <?php
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($lists) > 0) {
                        foreach ($lists as $list) {
                            ?>
                            <tr data-row="<?php echo $list->id; ?>" <?php
                            if ($list->status == 0) {
                                echo 'class="line-through"';
                            }
                            ?>>
                                <td>
                                    <?php
                                    echo stripslashes($list->name);
                                    echo '<br>';
                                    echo stripslashes($list->nameAr);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $list->totalcomment;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($list->lastupdatedArticle == "" || $list->lastupdatedArticle == "0000-00-00 00:00:00") {
                                        echo date('d/m/Y', strtotime($list->createdAt));
                                    } else {
                                        echo date('d/m/Y', strtotime($list->lastupdatedArticle));
                                    }
                                    ?>
                                </td>
                                <td class="sufrati-action">
                                    <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminarticlecomments/view/',$list->id)  }}" title="Edit Content"><i data-feather="eye"></i> View Comments </a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="100%">No record found.</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </article>
</div>


<script type="text/javascript">
    var style_table; 
    var tab_config= {
        columns:[
            {data:"name"},
            {data:"totalcomment", searchable:false},
            {data:"lastupdatedArticle"},
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
        
        style_table = startDataTable("rest-artcats","<?= route('adminarticlecommentsDT') ?>",tab_config);
    
    });

        
    function reloadTable(table_id){
   
       reloadDataTable(table_id);
    }

</script>
@endsection