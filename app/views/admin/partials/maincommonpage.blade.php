@extends('admin.index')
@section('content')

<div class="overflow row">
    <div class="col-md-8">
        <ol class="breadcrumb">
            <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>              
            <li class="active">{{ $title }}</li>
        </ol>
    </div>
    <div class="col-md-4">
        <button type="button" class="btn pull-right" data-bs-toggle="collapse" data-bs-target="#filter-main">  <i data-feather="filter"></i> </button>
    </div>
</div>

<?php
    $countries = Config::get('settings.countries');
    $sortposition = FALSE;
?>

<div id="filter-main" class="collapse well-white">
    <legend>   Filter Results </legend>  
    <form name="admin-form" id="jqValidate" class="form-horizontal" role="form" action="" method="get" >
        <div class="form-group row">
            <label for="status" class="col-md-2 control-label">Status</label>
            <div class="col-md-6">
                <select name="status" id="status" class="form-control">
                    <option value="">please select Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>

        {{-- <div class="form-group row">
            <label for="views" class="col-md-2 control-label">Views</label>
            <div class="col-md-6">
                <select name="views" id="views" class="form-control">
                    <option value="">please select </option>
                    <option value="1">Most Views</option>
                    <option value="2">Least Views</option>
                </select>
            </div>
        </div> --}}

        <div class="form-group row">
            <div class="offset-lg-2 col-md-6">
                <button type="button" class="btn btn-primary-gradien" onclick="reloadTable('rest-articles')">Filter</button>          
            </div>
        </div>
    </form>
</div>


<div class="well-white">
    <article>    
        <fieldset>
            <legend>
                {{ $pagetitle }}
                <?php
                if (!isset($new)) {
                    if (isset($articlesflag) && $articlesflag) {
                        ?>
                        <a href="{{ route($addlink).'?category='.$pid; }}" class="btn btn-info btn-sm pull-right">Add new</a>
                        <?php
                    } else {
                        ?>
                        <a href="{{ route($addlink); }}" class="btn btn-info btn-sm pull-right">Add new</a>
                        <?php
                    }
                }
                ?>
            </legend>        
        </fieldset>

        <div class="panel table-responsive">
            <table class="table table-hover text-center" id="rest-articles">
                <thead>
                    <tr>
                        <?php
                        foreach ($headings as $key => $value) {
                            ?>
                            <th class="col-md-2">{{ $value }}</th>
                            <?php
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    {{-- <?php
                    if (count($lists) > 0) {
                        $j = 0;
                        foreach ($lists as $list) {
                            ?>
                            <tr <?php
                            if (isset($list->status) && $list->status == 0) {
                                echo 'class="line-through rows"';
                            } else {
                                echo 'class=" rows"';
                            }
                            ?> data-id="<?php echo $list->id; ?>"  id="row-<?php echo $j; ?>" >
                                <?php
                                if (isset($resultheads)) {
                                    foreach ($resultheads as $key => $value) {
                                        if (strpos($value, "/")) {
                                            $arr = $createdAt = $updateAt = "";
                                            $arr = explode("/", $value);
                                            $createdAt = $arr[0];
                                            $updatedAt = $arr[1];
                                            echo '<td>';
                                            if ($list->$updatedAt == "" || $list->$updatedAt == "0000-00-00 00:00:00") {
                                                echo date('d/m/Y', strtotime($list->$createdAt));
                                            } else {
                                                echo date('d/m/Y', strtotime($list->$updatedAt));
                                            }
                                            echo '</td>';
                                        } elseif ($value == "sortposition") {
                                            $sortposition = TRUE;
                                            echo '<td>';
                                            echo '<a href="javascript:void(0);" class="move-up" data-position="' . $j . '"><i class="glyphicon glyphicon-arrow-up "></i> Up</a>';
                                            echo '<br>';
                                            echo '<a href="javascript:void(0);" class="move-down" data-position="' . $j . '"><i class="glyphicon glyphicon-arrow-down "></i> Down</a>';
                                            echo '</td>';
                                        } elseif ($value == "details" || $value == "description" || $value=="detail" || $value=="full") {
                                            echo '<td>';
                                            echo Str::limit(stripslashes(strip_tags(html_entity_decode($list->$value))), 100);
                                            echo '</td>';
                                        }else {
                                            echo '<td>';
                                            echo stripslashes($list->$value);
                                            echo '</td>';
                                        }
                                    }
                                }

                                if (isset($actions)) {
                                    echo '<td class="Azooma-action">';
                                    foreach ($actions as $key => $value) {
                                        $addURL = "";
                                        if (isset($articlesflag) && $articlesflag) {
                                            $addURL = '?category=' . $list->category;
                                        }
                                        if ($value == 'sub') {
                                            echo '<a class="btn btn-xs btn-info mytooltip" href="' . URL::to("hungryn137/" . $sublink . '/' . $list->id . $addURL) . '" title="View Sub Articles"><i data-feather="eye"></i></a>';
                                        }
                                        if ($value == 'edit') {
                                            if (isset($articlesflag) && $articlesflag) {
                                                $addlinkNew = "";
                                                if ($list->articleType == '1') {
                                                    $addlinkNew = "adminarticles/slideform";
                                                } else {
                                                    $addlinkNew = "adminarticles/articleform";
                                                }
                                                echo '<a class="btn btn-xs btn-info mytooltip" href="' . URL::to("hungryn137/" . $addlinkNew . '/' . $list->id . $addURL) . '" title="Edit Content"><i data-feather="edit"></i></a>';
                                            } else {
                                                echo '<a class="btn btn-xs btn-info mytooltip" href="' . URL::to("hungryn137/" . $addlink . '/' . $list->id . $addURL) . '" title="Edit Content"><i data-feather="edit"></i></a>';
                                            }
                                        }
                                        if ($value == "status") {
                                            if ($list->status == 0) {
                                                echo '<a class="btn btn-xs btn-info mytooltip" href="' . URL::to("hungryn137/" . $statuslink . '/' . $list->id . $addURL) . '" title="Activate "><i data-feather="minus-circle"></i></a>';
                                            } else {
                                                echo '<a class="btn btn-xs btn-info mytooltip" href="' . URL::to("hungryn137/" . $statuslink . '/' . $list->id . $addURL) . '" title="Deactivate"><i data-feather="plus-circle"></i></a>';
                                            }
                                        }
                                        if ($value == 'delete') {
                                            echo '<a onclick="return confirm(Do You Want to Delete?)" class="btn btn-xs btn-danger mytooltip" href="' . URL::to("hungryn137/" . $deletelink . '/' . $list->id . $addURL) . '" title="Delete"><i data-feather="trash-2"></i></a>';
                                        }
                                        if($value=="view"){
                                            $addURL='?'.$viewID."=".$list->$viewID;
                                            echo '<a class="btn btn-xs btn-info mytooltip" href="' . URL::to("hungryn137/" . $viewlink . '/' . $list->id . $addURL) . '" title="View Content"><i data-feather="eye"></i> View </a>';
                                        }
                                    }
                                    echo '</td>';
                                }
                                ?>

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
                    ?> --}}
                </tbody>
            </table>
            <?php
            if (count($lists) > 0) {
                $get = array();
                if (count($_GET) > 0) {
                    foreach ($_GET as $key => $val) {
                        if ($key == "page") {
                            continue;
                        } else {
                            $get[$key] = $val;
                        }
                    }
                }
                if (count($get) > 0) {
                    echo $lists->appends($get)->links();
                } else {
                    echo $lists->links();
                }
            }
            ?>
        </div>
    </article>
</div>

<script type="text/javascript">
    
        $(document).ready(function() {
            $(document).on('click', '.move-up', function() {
                if ($(this).attr('data-position') != 1) {
                    move($(this), 'up');
                }
            });
            $(document).on('click', '.move-down', function() {
                if ($(this).attr('data-position') != limit) {
                    move($(this), 'down');
                }
            });

            function move($ele, arg) {
                var position = $ele.attr('data-position');
                var ele = $('<tr>').append($('#row-' + position).clone()).html();
                ;
                $("#row-" + position).remove();
                if (arg == 'up') {
                    position--;
                    $(ele).insertBefore($("#row-" + position));
                } else {
                    position++;
                    $(ele).insertAfter($("#row-" + position));
                }
                var str = '';
                $.each($('.rows'), function(index, item) {
                    var ht = index + 1;
                    if (ht != 0) {
                        str += '-';
                    }
                    $(item).attr('id', 'row-' + ht);
                    $(item).find('.table-no').html(ht);
                    $(item).find('.move-up,.move-down').attr('data-position', ht);
                    str += $(item).attr('data-id');
                    str += ':' + $(item).find('.move-up,.move-down').attr('data-position');
                });
                $.post(base + 'hungryn137/<?php echo $action; ?>/updateposition', {position: str});
            }
        });


</script>


<script type="text/javascript">
    var style_table; 
    var tab_config= {
        columns:[
            {data:"name"},
            {data:"nameAr"},
            {data:"totalarticles", searchable:false },
            {data:"lastupdatedArticle"},
            {data:"action", sortable:false, searchable:false}
        ],
        data:function(d){
            return $.extend({},d,{
                "status":$('#status').val()
            })
        },
        order:[[3,'desc']]
    };

    $(document).ready(function(){
        
        style_table = startDataTable("rest-articles","<?= route('adminarticlesDT') ?>",tab_config);

    });

        
    function reloadTable(table_id){
   
       reloadDataTable(table_id);
    }

</script>

@endsection