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


<div id="filter-main" class="collapse well-white">
    <legend>   Filter Results </legend>  
    <form name="admin-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('admincuisine/subcuisines/',$mainID); }}" method="get" >
        <div class="form-group row">
            <label for="name" class="col-md-2 control-label">Name</label>
            <div class="col-md-6">
                <input type="text" name="name" class="form-control" id="name" placeholder="Name" >
            </div>
        </div>
        <div class="form-group row">
            <label for="city" class="col-md-2 control-label">City</label>
            <div class="col-md-6">
                <?php
                $cities = MGeneral::getAllCities($country);
                echo MGeneral::generate_list($cities, "city_ID", "city_Name", 'city', 'city');
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="sort" class="col-md-2 control-label">Sort By</label>
            <div class="col-md-6">
                <select name="sort" id="sort" class="form-control">
                    <option value="latest">Latest</option>
                    <option value="name">Name</option>
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
                <a href="{{ route('admincuisine/cuisineform').'?master_id='.$mainID }}" class="btn btn-info btn-sm pull-right">Add new </a>
            </legend>        
        </fieldset>

        <div class="panel">
            
            <table class="table table-hover">
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
                <tbody>
                    <?php
                    if (count($lists) > 0) {
                        foreach ($lists as $list) {
                            ?>
                            <tr <?php
                    if ($list->cuisine_Status == 0) {
                        echo 'class="line-through"';
                    }
                            ?>>
                                <td><?php echo stripslashes($list->cuisine_Name); ?></td>
                                <td><?php echo Str::limit(stripslashes(strip_tags(html_entity_decode($list->cuisine_description))), 100); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($list->updatedAt)); ?></td>
                                <td class="Azooma-action">              
                                    <a class="btn btn-xs btn-info mytooltip" href="{{ route('admincuisine/cuisineform/',$list->cuisine_ID) }}" title="Edit Content"><i data-feather="edit"></i></a>
                                    <?php
                                    if ($list->cuisine_Status == 0) {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('admincuisine/cuisinestatus/',$list->cuisine_ID) }}" title="Activate "><i data-feather="minus-circle"></i></a>
                                        <?php
                                    } else {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('admincuisine/cuisinestatus/',$list->cuisine_ID) }}" title="Deactivate"><i data-feather="plus-circle"></i></a>
                                        <?php
                                    }
                                    ?>
                                    <a onclick="return confirm('Do You Want to Delete?')" class="btn btn-xs btn-danger mytooltip" href="{{ route('admincuisine/cuisinedelete/',$list->cuisine_ID) }}" title="Delete"><i data-feather="trash-2"></i></a>
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