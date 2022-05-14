<div class="overflow">
    <div class="col-md-8">
        <ol class="breadcrumb">
            <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
            <li><a href="<?= route('adminarticles'); ?>">Categories</a></li>  
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
    <form name="admin-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminarticles'); }}" method="get" >
        <div class="form-group row">
            <label for="name" class="col-md-2 control-label">Name</label>
            <div class="col-md-6">
                <input type="text" name="name" class="form-control" id="name" placeholder="Name" >
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-lg-2 col-md-6">
                <button type="submit" class="btn btn-primary-gradien">Filter</button>          
            </div>
        </div>
    </form>
</div>


<div class="well-white">
    <article>    
        <fieldset>
            <legend>
                {{ $pagetitle }}
                <a href="{{ route('adminarticles/articleform').'?category='.$pid; }}" class="btn btn-info btn-sm pull-right">Add new </a>
            </legend>        
        </fieldset>

        <div class="panel">
            
            <table class="table table-hover">
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
                <tbody>
                    <?php
                    if (count($lists) > 0) {
                        $j = 0;
                        $obj = new MBlog();
                        foreach ($lists as $list) {
                            ?>
                            <tr <?php
                    if ($list->status == 0) {
                        echo 'class="line-through rows"';
                    } else {
                        echo 'class=" rows"';
                    }
                            ?> data-id="<?php echo $list->id; ?>"  id="row-<?php echo $j; ?>" >
                                <td><?php echo stripslashes($list->name); ?></td>
                                <td>
                                    <?php echo $obj->getTotalArticles($list->id); ?> Articles
                                </td>
                                <td>
                                    <?php echo $list->views; ?>
                                </td>
                                <td><?php
                            if ($list->updatedAt == "") {
                                echo date('d/m/Y', strtotime($list->createdAt));
                            } else {
                                echo date('d/m/Y', strtotime($list->updatedAt));
                            }
                                    ?></td>

                                <td>
                                    <?php
                                    if ($list->articleType == '1') {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminarticles/slideform/',$list->id).'?category='.$list->category; }}" title="Edit Content"><i data-feather="edit"></i></a>
                                    <?php } else { ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminarticles/articleform/',$list->id).'?category='.$list->category; }}" title="Edit Content"><i data-feather="edit"></i></a>
                                    <?php } ?>
                                    <?php
                                    if ($list->status == 0) {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminarticles/articlestatus/',$list->id).'?category='.$list->category; }}" title="Activate "><i data-feather="minus-circle"></i></a>
                                        <?php
                                    } else {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminarticles/articlestatus/',$list->id).'?category='.$list->category; }}" title="Deactivate"><i data-feather="plus-circle"></i></a>
                                        <?php
                                    }
                                    ?>
                                    <a onclick="return confirm('Do You Want to Delete?')" class="btn btn-xs btn-danger mytooltip" href="{{ route('adminarticles/articledelete/',$list->id).'?category='.$list->category; }}" title="Delete"><i data-feather="trash-2"></i></a>
                                </td>
                            </tr>
                            <?php
                            $j++;
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
            <?php
            if (count($lists) > 0) {
                if (isset($_GET['name'])) {
                    echo $lists->appends(array('name' => $_GET['name']))->links();
                } else {
                    echo $lists->links();
                }
            }
            ?>
        </div>
    </article>
</div>

<script type="text/javascript">
    var limit='<?php echo $lists->getTo(); ?>';
    $(document).ready(function(){
        $(document).on('click','.move-up',function(){
            if($(this).attr('data-position')!=1){ 
                move($(this),'up');
            }
        }); 
        $(document).on('click','.move-down',function(){
            if($(this).attr('data-position')!=limit){ 
                move($(this),'down');
            }
        });
       
        function move($ele,arg){
            var position=$ele.attr('data-position');
            var ele=$('<tr>').append($('#row-'+position).clone()).html();;
            $("#row-"+position).remove();
            if(arg=='up'){
                position--;
                $(ele).insertBefore($("#row-"+position));
            }else{
                position++;
                $(ele).insertAfter($("#row-"+position));
            }
            var str='';
            $.each($('.rows'),function(index,item){
                var ht=index+1;
                if(ht!=0){
                    str+='-';
                }
                $(item).attr('id','row-'+ht); 
                $(item).find('.table-no').html(ht);
                $(item).find('.move-up,.move-down').attr('data-position',ht);
                str+=$(item).attr('data-id');
                str+=':'+$(item).find('.move-up,.move-down').attr('data-position');
            });
            $.post(base+'admin/adminarticles/updateposition',{position:str});
        }
    });
</script>