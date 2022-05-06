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
    <form name="admin-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminbanners' ); }}" method="get" >
        <div class="form-group row">
            <label for="name" class="col-md-2 control-label">City</label>
            <div class="col-md-6">
                <select class="form-control" data-placeholder="Select City" name="city_ID" id="city_ID"> 
                    <option value="0">Select City</option>
                    <?php
                    $country = Session::get('admincountry');
                    if (empty($country)) {
                        $country = 1;
                    }

                    $cities = MGeneral::getAllCities($country);
                    if (is_array($cities)) {
                        foreach ($cities as $value) {
                            ?>
                            <option value="{{ $value->city_ID }}" >
                                {{ $value->city_Name }}
                            </option>
                            <?php
                        }
                    }
                    ?>                        
                </select> 
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-md-2 control-label">Type</label>
            <div class="col-md-6">
                <select class="form-control required" data-placeholder="Select Banner Type" name="banner_type" id="banner_type"> 
                    <option value="0">Select Type</option>
                    <?php
                    $RestaurantStatus = Config::get('settings.bannertypes');
                    if (is_array($RestaurantStatus)) {
                        foreach ($RestaurantStatus as $key => $value) {
                            ?>
                            <option value="{{ $key }}">
                                {{ $value }}
                            </option>
                            <?php
                        }
                    }
                    ?>                        
                </select> 
            </div>
        </div>
        <div class="form-group row">
            <label for="title_ar" class="col-md-2 control-label">Cuisine</label>
            <div class="col-md-6">
                <select class="form-control" data-placeholder="Select Cuisine" name="cuisine_ID" id="cuisine_ID"> 
                    <option value="0">Select Cuisine</option>
                    <?php
                    $cuisines = MGeneral::getAllMasterCuisine(1);
                    if (is_array($cuisines)) {
                        foreach ($cuisines as $value) {
                            ?>
                            <option value="{{ $value->id }}">
                                {{ $value->name }}
                            </option>
                            <?php
                        }
                    }
                    ?>                        
                </select> 
            </div>
        </div>
        <div class="form-group row">
            <label for="views" class="col-md-2 control-label">Views</label>
            <div class="col-md-6">
                <select name="views" id="views" class="form-control">
                    <option value="">please select </option>
                    <option value="1">Most Views</option>
                    <option value="2">Least Views</option>
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
                <a href="{{ route('adminbanners/form') }}" class="btn btn-info btn-sm pull-right">Add new </a>
            </legend>        
        </fieldset>

        <div class="panel">
            <div class="panel-heading">
                <?php if (count($lists) > 0) { ?> Results {{ $lists->getFrom() }} to {{ $lists->getTo() }} out of <span class="label label-info">{{ $lists->getTotal() }}</span> <?php
                } else {
                    echo 'No Result Found';
                }
                ?>
            </div>
            <table class="table table-hover">
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
                        $countries = Config::get('settings.countries');
                        $bannerTypes = Config::get('settings.bannertypes');
                        foreach ($lists as $list) {
                            ?>
                            <tr <?php
                            if ($list->active == 0) {
                                echo 'class="line-through"';
                            }
                            ?>>
                                <td>
                                    <img src="<?php echo Config::get('settings.uploadurl') . '/banner/' . $list->image; ?>" border="0" width="100" >
                                </td>
                                <td>
                                    <?php
                                    if ($list->banner_type != 0) {
                                        echo $bannerTypes[$list->banner_type];
                                    } else {
                                        echo 'Unknown';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (!empty($list->city_ID)) {
                                        $city = "";
                                        $city = MGeneral::getCity($list->city_ID);
                                        echo $city->city_Name;
                                    } else {
                                        echo $countries[$list->country];
                                    }
                                    ?>
                                </td>
                                <td><?php echo $list->clicked; ?></td>
                                <td><?php echo $list->impressions; ?></td>
                                <td>
                                    <?php
                                    if ($list->start_date != "" && $list->start_date != "0000-00-00") {
                                        echo date('d/m/Y', strtotime($list->start_date));
                                    } else {
                                        echo 'Unknown';
                                    }
                                    
                                    if ($list->end_date != "" && $list->end_date != "0000-00-00") {
                                        echo ' ';
                                        echo date('d/m/Y', strtotime($list->end_date));
                                    } else {
                                        //echo 'Unknown';
                                    }
                                    ?>
                                </td>
                                <td class="sufrati-action">
                                    <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminbanners/form/',$list->id)  }}" title="Edit Content"><i data-feather="edit"></i></a>
                                    <?php
                                    if ($list->active == 0) {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminbanners/status/',$list->id) }}" title="Activate "><i data-feather="minus-circle"></i></a>
                                        <?php
                                    } else {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminbanners/status/',$list->id) }}" title="Deactivate"><i data-feather="plus-circle"></i></a>
                                        <?php
                                    }
                                    ?>
                                    <a onclick="return confirm('Do You Want to Delete?')" class="btn btn-xs btn-danger mytooltip" href="{{ route('adminbanners/delete/',$list->id) }}" title="Delete"><i data-feather="trash-2"></i></a>
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