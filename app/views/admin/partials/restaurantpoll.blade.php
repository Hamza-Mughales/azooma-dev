@extends('admin.index')
@section('content')


<div class="overflow">
    <div class="col-md-11 zero-padding">
        <ol class="breadcrumb">
            <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
            <li class="active">{{ $title }}</li>
        </ol>
    </div>

</div>


<?php
    include(app_path() . '/views/admin/common/restaurant.blade.php');
?>





<div class="well-white">
    <article>    
        <fieldset>
            <legend>
                {{ $pagetitle }}
                <a href="{{ route('adminrestaurants/pollform').'?rest_ID='.$rest->rest_ID; }}" id="add-new-menu" class="btn btn-info btn-sm pull-right">Add new </a>
            </legend>        
        </fieldset>

        <div class="panel">
            <div class="table-responsive">
            <table id="data-table-one" class="table table-hover table-bordered">
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
                <tbody>
                    <?php
                    if (count($lists) > 0) {
                        $countries = Config::get('settings.countries');
                        foreach ($lists as $value) {
                            ?>
                            <tr <?php
                            if (isset($value->status)) {
                                if ($value->status == 0) {
                                    echo 'class=" line-through"';
                                }
                            }
                            ?>>
                                <td>
                                    <?php echo stripslashes(($value->question)) . ' ' . stripslashes(($value->question_ar)); ?>
                                </td>
                                <td <?php if (isset($value->status)) if ($value->status == 0) echo 'class="strike"';  ?>>
                                    <?php
                                    if ($value->rest_ID != 0) {
                                        //echo stripslashes(($value['restaurant']));
                                    } else {
                                        echo 'Azooma Team';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php echo $value->totalvotes . ' Total Votes'; ?>
                                    <br/>
                                    <?php
                                    $results = $MPoll->getPollOptions($value->id);
                                    if (count($results) > 0) {
                                        foreach ($results as $result) {
                                            echo $result->field . ' - ' . $result->votes . ' Votes<br/>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($value->date_add == "") {
                                        echo date('d/m/Y', strtotime($value->date_add));
                                    } else {
                                        echo date('d/m/Y', strtotime($value->updatedAt));
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($value->date_add == "") {
                                        echo date('d/m/Y', strtotime($value->date_add));
                                    } else {
                                        echo date('d/m/Y', strtotime($value->updatedAt));
                                    }
                                    ?>
                                </td>
                                <td class="Azooma-action">
                                    <a class="btn btn-xs btn-info m-1" href="<?php echo route('adminrestaurants/polloptions/', $value->id) . '?rest_ID=' . $rest->rest_ID; ?>" rel="tooltip" title="View Options">
                                        <i data-feather="eye"></i>
                                    </a>
                                    <a class="btn btn-xs btn-info m-1" href="{{ route('adminrestaurants/pollform/', $value->id).'?rest_ID='.$rest->rest_ID; }}" title="Edit Content">
                                        <i data-feather="edit"></i> 
                                    </a>
                                    <a class="btn btn-xs btn-info m-1" href="<?php echo route('adminrestaurants/pollstatus/', $value->id) . '?rest_ID=' . $rest->rest_ID; ?>" rel="tooltip" title="Poll">
                                        <?php
                                        if ($value->status == 1) {
                                            ?>
                                            <i data-feather="minus-circle"></i> 
                                            <?php
                                        } else {
                                            ?>
                                            <i data-feather="plus-circle"></i> 
                                        <?php } ?>
                                    </a>
                                    <a  class="btn btn-xs btn-danger m-1 cofirm-delete-button" href="#" link="{{ route('adminrestaurants/polldelete/', $value->id).'?rest_ID='.$rest->rest_ID; }}" title="Delete">
                                        <i data-feather="trash-2"></i> 
                                    </a>

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

@endsection