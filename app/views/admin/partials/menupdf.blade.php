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


<<<<<<< Updated upstream
<div id="filter-main" class="collapse well-white">
    <legend>   Filter Results </legend>  
    <form name="admin-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminrestaurants'); }}" method="get" >
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
=======

>>>>>>> Stashed changes


<div class="well-white">
    <article>    
        <fieldset>
            <legend>
                {{ $pagetitle }}
                <a href="{{ route('adminrestmenu/formpdf').'?rest='.$rest_ID; }}" id="add-new-menu" class="btn btn-info btn-sm pull-right">Add new </a>
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
                        $MGeneral = new MGeneral();
                        foreach ($lists as $list) {
                            ?>
                            <tr>
                                <td>
                                    <?php
                                    echo stripslashes($list->title);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo stripslashes($list->title_ar);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($list->updatedAt == "") {
                                        echo date('d/m/Y', strtotime($list->enter_time));
                                    } else {
                                        echo date('d/m/Y', strtotime($list->updatedAt));
                                    }
                                    ?>
                                </td>            
                                <td class="sufrati-action">
                                    <a class="btn btn-xs btn-info mytooltip m-1" href="{{ route('adminrestmenu/formpdf/',$list->id).'?rest='.$rest->rest_ID; }}" title="Edit Content">
                                        <i data-feather="edit"></i> 
                                    </a>
                                    <a  class="btn btn-xs btn-danger mytooltip m-1 cofirm-delete-button" href="#" link="{{ route('adminrestmenu/deletepdf/',$list->id).'?rest='.$rest->rest_ID; }}" title="Delete">
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

        </div>
    </article>
</div>

@endsection