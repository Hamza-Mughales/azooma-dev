@extends('admin.index')
@section('content')
    
<div class="overflow">
    <div class="col-md-8">
        <ol class="breadcrumb">
            <li><a href="<?php echo URL::route('adminhome'); ?>">Dashboard</a></li>              
            <li class="active">{{ $title }}</li>
        </ol>
    </div>
    <div class="col-md-4">
        <button type="button" class="btn btn-default pull-right" data-toggle="collapse" data-target="#filter-main">  <i class="glyphicon glyphicon-filter"></i> </button>
    </div>
</div>
<?php
$countries = Config::get('settings.countries');
$sortposition = FALSE;
?>


<div class="well-white">
    <article>    
        <fieldset>
            <legend>
                {{ $pagetitle }}
                <?php
                if (!isset($new)) {
                    if (isset($articlesflag) && $articlesflag) {
                        ?>
                        <a href="{{ URL::route($addlink).'?category='.$pid; }}" class="btn btn-info btn-sm pull-right">Add new</a>
                        <?php
                    } else {
                        ?>
                        <a href="{{ URL::route($addlink); }}" class="btn btn-info btn-sm pull-right">Add new</a>
                        <?php
                    }
                }
                ?>
            </legend>        
        </fieldset>

        <div class="panel">
            <div class="panel-heading">
                <?php if (count($lists) > 0) { ?> 
                    Showing Results <b>{{ $lists->getFrom() }}</b> to <b>{{ $lists->getTo() }}</b> 
                    <span class="right" style="font-size: 14px; font-weight: bold;">
                        Total Results &nbsp;
                        <span class="label label-default ">
                            {{ $lists->getTotal() }}
                        </span> 
                    </span>
                    <?php
                } else {
                    echo 'No Result Found';
                }
                ?>        
            </div>
            <table class="table table-hover" id="data-table-one">
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
                    <?php
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
                                    echo '<td class="sufrati-action">';
                                    foreach ($actions as $key => $value) {
                                        $addURL = "";
                                        if (isset($articlesflag) && $articlesflag) {
                                            $addURL = '?category=' . $list->category;
                                        }
                                        if ($value == 'sub') {
                                            echo '<a class="btn btn-xs btn-info mytooltip" href="' . URL::to("hungryn137/" . $sublink . '/' . $list->id . $addURL) . '" title="View Sub Articles"><i class="glyphicon glyphicon-eye-open"></i></a>';
                                        }
                                        if ($value == 'edit') {
                                            if (isset($articlesflag) && $articlesflag) {
                                                $addlinkNew = "";
                                                if ($list->articleType == '1') {
                                                    $addlinkNew = "adminarticles/slideform";
                                                } else {
                                                    $addlinkNew = "adminarticles/articleform";
                                                }
                                                echo '<a class="btn btn-xs btn-info mytooltip p-1" href="' . URL::to("hungryn137/" . $addlinkNew . '/' . $list->id . $addURL) . '" title="Edit Content"><i class="fa fa-edit"></i></a>';
                                            } else {
                                                echo '<a class="btn btn-xs btn-info mytooltip p-1" href="' . URL::to("hungryn137/" . $addlink . '/' . $list->id . $addURL) . '" title="Edit Content"><i class="fa fa-edit"></i></a>';
                                            }
                                        }
                                        if ($value == "status") {
                                            if ($list->status == 0) {
                                                echo '<a class="btn btn-xs btn-info mytooltip p-1" href="' . URL::to("hungryn137/" . $statuslink . '/' . $list->id . $addURL) . '" title="Activate "><i class="fa fa-minus"></i></a>';
                                            } else {
                                                echo '<a class="btn btn-xs btn-info mytooltip p-1" href="' . URL::to("hungryn137/" . $statuslink . '/' . $list->id . $addURL) . '" title="Deactivate"><i class="fa fa-plus"></i></a>';
                                            }
                                        }
                                        if ($value == 'delete') {
                                            echo '<a class="btn btn-xs btn-danger mytooltip cofirm-delete-button p-1" href="#" link="' . URL::to("hungryn137/" . $deletelink . '/' . $list->id . $addURL) . '" title="Delete"><i class="fa fa-trash"></i></a>';
                                        }
                                        if($value=="view"){
                                            $addURL='?'.$viewID."=".$list->$viewID;
                                            echo '<a class="btn btn-xs btn-info mytooltip p-1" href="' . URL::to("hungryn137/" . $viewlink . '/' . $list->id . $addURL) . '" title="View Content"><i class="fa fa-eye"></i> View </a>';
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
                    ?>
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
<?php
if (count($lists) > 0) {
    ?>
        var limit = '<?php echo $lists->getTo(); ?>';
    <?php
}

if ($sortposition) {
    ?>
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

    <?php
}
?>
</script>

@endsection