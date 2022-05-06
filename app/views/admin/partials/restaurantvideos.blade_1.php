<div class="overflow">
    <div class="col-md-11 zero-padding">
        <ol class="breadcrumb">
            <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
            <li class="active">{{ $title }}</li>
        </ol>
    </div>
    <div class="col-md-1">
        <button type="button" class="btn pull-right" data-bs-toggle="collapse" data-bs-target="#filter-main">  <i data-feather="filter"></i> </button>
    </div>
</div>


<?php
    include(app_path() . '/views/admin/common/restaurant.blade.php');
?>


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


<div class="well-white">
    <article>    
        <fieldset>
            <legend>
                {{ $pagetitle }}
                <a href="{{ route('adminrestaurants/videoform').'?rest_ID='.$rest->rest_ID; }}" id="add-new-menu" class="btn btn-info btn-sm pull-right">Add new </a>
            </legend>        
        </fieldset>

        <div class="panel">
            
            <table class="table table-hover table-bordered">
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
                        foreach ($lists as $list) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo stripslashes(($list->name_en)) . ' - ' . stripslashes(($list->name_ar)); ?>
                                </td>
                                <td>
                                    <?php echo $list->youtube_en; ?>
                                </td>
                                <td>
                                    <?php echo stripslashes(($list->video_description)) . ' - ' . stripslashes(($list->video_description_ar)); ?>
                                </td>
                                <td>
                                    <?php
                                    if ($list->add_date == "") {
                                        echo date('d/m/Y', strtotime($list->add_date));
                                    } else {
                                        echo date('d/m/Y', strtotime($list->updatedAt));
                                    }
                                    ?>
                                </td>            
                                <td>
                                    <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminrestaurants/videoform/',$list->id).'?rest_ID='.$rest->rest_ID; }}" title="Edit Content">
                                        <i data-feather="edit"></i> 
                                    </a>
                                    <?php
                                    if ($list->status == 0) {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminrestaurants/videostatus/',$list->id).'?rest_ID='.$rest->rest_ID; }}" title="Activate "><i data-feather="minus-circle"></i></a>
                                        <?php
                                    } else {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminrestaurants/videostatus/',$list->id).'?rest_ID='.$rest->rest_ID; }}" title="Deactivate"><i data-feather="plus-circle"></i></a>
                                        <?php
                                    }
                                    ?>
                                    <a onclick="return confirm('Do You Want to Delete?')" class="btn btn-xs btn-danger mytooltip" href="{{ route('adminrestaurants/videodelete/',$list->id).'?rest_ID='.$rest->rest_ID; }}" title="Delete">
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
            <?php
            if (count($lists) > 0) {
                $get = array();
                if (count($_GET) > 0) {
                    foreach ($_GET as $key => $val) {
                        $get[$key] = $val;
                    }
                    echo $lists->appends($get)->links();
                } else {
                    echo $lists->links();
                }
            }
            ?>
        </div>
    </article>
</div>