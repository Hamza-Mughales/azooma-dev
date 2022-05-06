@extends('admin.index')
@section('content')

<div class="overflow">
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


<div id="filter-main" class="collapse well-white">
    <legend>   Filter Results </legend>  
    <form name="admin-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('admingallery'); }}" method="get" >
        <div class="form-group row">
            <label for="sort" class="col-md-2 control-label">Sort By</label>
            <div class="col-md-6">
                <select name="sort" id="sort" class="form-control">
                    <option value="">please select </option>
                    <option value="latest">Latest</option>
                    <option value="name">Name</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="sort" class="col-md-2 control-label">Restaurants</label>
            <div class="col-md-6">
                <select name="rest" id="rest" class="form-control">
                    <option value="">please select </option>
                    <?php
                    $allrest = MRestActions::getAllRestaurants($country, "", 1, "", false, "", 0, "", "", "", "", "", "name");
                    if (count($allrest) > 1) {
                        foreach ($allrest as $rest) {
                            ?>
                            <option value="<?php echo $rest->rest_ID; ?>"><?php echo $rest->rest_Name; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="statu" class="col-md-2 control-label">Status</label>
            <div class="col-md-6">
                <select name="status" id="status" class="form-control">
                    <option value="">please select Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="offset-lg-2 col-md-6">
                <input type="hidden" name="type" id="type" value="<?php if(isset($_GET['type'])){ echo $_GET['type']; } ?>">
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
                <a href="{{ route('admingallery/form'); }}" class="btn btn-info btn-sm pull-right">Add new </a>
            </legend>        
        </fieldset>

        <div class="panel">
            <div class="panel-heading">
                <?php
                if (count($lists) > 0) {
                    ?> 
                    Results {{ $lists->getFrom() }} to {{ $lists->getTo() }} out of 
                    <span class="label label-info">{{ $lists->getTotal() }}</span> 
                    <?php
                } else {
                    echo 'No Result Found';
                }
                ?>        
            </div>
            <table class="table table-hover">
                <?php if (count($lists) > 0) { ?>
                    <thead>
                        <tr>
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
                <?php } ?>
                <tbody>
                    <?php
                    if (count($lists) > 0) {
                        $obj = new MGeneral();
                        foreach ($lists as $list) {
                            ?>
                            <tr <?php
                            if ($list->status == 0) {
                                echo 'class="line-through"';
                            }
                            ?>>
                                <td>
                                    <img src="<?php echo Config::get('settings.uploadurl'); ?>/Gallery/thumb/<?php echo $list->image_full; ?>" border="0" width="100" >
                                </td>                                
                                <td>
                                    <?php
                                    echo $list->restName;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($type == "Sufrati") {
                                        echo 'Sufrati';
                                    } else {
                                        if ($list->user_ID != "") {
                                            $user_data = $obj->getUser($list->user_ID);
                                            if (is_object($user_data)) {
                                                echo $user_data->user_FullName . '<br>';
                                                echo '<a href="mailto:' . $user_data->user_Email . '">' . $user_data->user_Email . '</a>';
                                            } else {
                                                echo 'User';
                                            }
                                        } else {
                                            echo 'Sufrati';
                                        }
                                    }
                                    ?>
                                </td>
                                <td><?php
                                    if ($list->updatedAt == "") {
                                        echo date('d/m/Y', strtotime($list->enter_time));
                                    } else {
                                        echo date('d/m/Y', strtotime($list->updatedAt));
                                    }
                                    ?></td>                                
                                <td class="sufrati-action">
                                    <a class="btn btn-xs btn-info mytooltip" href="{{ route('admingallery/form/',$list->image_ID).'?rest_ID='.$list->rest_ID.'&type='.$type }}" title="Edit Content"><i data-feather="edit"></i></a>
                                    <?php
                                    if ($list->status == 0) {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('admingallery/status/',$list->image_ID).'?rest_ID='.$list->rest_ID.'&type='.$type }}" title="Activate "><i data-feather="minus-circle"></i></a>
                                        <?php
                                    } else {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('admingallery/status/',$list->image_ID).'?rest_ID='.$list->rest_ID.'&type='.$type }}" title="Deactivate"><i data-feather="plus-circle"></i></a>
                                        <?php
                                    }
                                    ?>
                                    <a onclick="return confirm('Do You Want to Delete?')" class="btn btn-xs btn-danger mytooltip" href="{{ route('admingallery/delete/',$list->image_ID).'?rest_ID='.$list->rest_ID.'&type='.$type }}" title="Delete"><i data-feather="trash-2"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
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

@endsection