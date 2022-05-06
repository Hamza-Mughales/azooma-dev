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
                <a href="{{ route('adminrestaurants/polloptionform').'?rest_ID='.$rest->rest_ID.'&poll='.$pollID; }}" id="add-new-menu" class="btn btn-info btn-sm pull-right">Add new </a>
            </legend>        
        </fieldset>

        <div class="panel">
     
            <div class="table-responsive">
            <table id="data-table-one" class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <?php
                        foreach ($headings as $key => $option) {
                            if ($option == 'Location') {
                                ?>
                                <th class="col-md-2">{{ $option }}</th>
                                <?php
                            } else {
                                ?>
                                <th class="col-md-1">{{ $option }}</th>
                                <?php
                            }
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($options) > 0) {
                        $countries = Config::get('settings.countries');
                        foreach ($options as $option) {
                            ?>
                            <tr <?php
                            if (isset($option->status)) {
                                if ($option->status == 0) {
                                    echo 'class=" line-through"';
                                }
                            }
                            ?>>
                                <td>
                                    <?php echo $option->field; ?>
                                </td>
                                <td>
                                    <?php echo $option->votes; ?>
                                </td>
                                <td>
                                    <?php
                                    if ($option->createdAt == "") {
                                        echo date('d/m/Y', strtotime($option->createdAt));
                                    } else {
                                        echo date('d/m/Y', strtotime($option->updatedAt));
                                    }
                                    ?>
                                </td>
                                <td class="sufrati-action">
                                    <a class="btn btn-xs btn-info m-1" href="{{ route('adminrestaurants/polloptionform/', $option->id).'?rest_ID='.$rest->rest_ID.'&poll='.$pollID; }}" title="Edit Content">
                                        <i data-feather="edit"></i> 
                                    </a>
                                    <a class="btn btn-xs btn-info m-1" href="<?php echo route('adminrestaurants/polloptionstatus/', $option->id) . '?rest_ID=' . $rest->rest_ID.'&poll='.$pollID; ?>" rel="tooltip" title="Poll">
                                        <?php
                                        if ($option->status == 1) {
                                            ?>
                                            <i data-feather="minus-circle"></i> 
                                            <?php
                                        } else {
                                            ?>
                                            <i data-feather="plus-circle"></i> 
                                        <?php } ?>
                                    </a>
                                    <a  class="btn btn-xs btn-danger m-1 cofirm-delete-button" href="#" link="{{ route('adminrestaurants/polloptiondelete/', $option->id).'?rest_ID='.$rest->rest_ID.'&poll='.$pollID; }}" title="Delete">
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
            if (count($options) > 0) {
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
                    echo $options->appends($get)->links();
                } else {
                    echo $options->links();
                }
            }
            ?>
        </div>
    </article>
</div>

@endsection