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
    <form name="admin-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminartkwork' ); }}" method="get" >
        <div class="form-group row">
            <label for="name" class="col-md-2 control-label">Name</label>
            <div class="col-md-6">
                <input type="text" name="name" class="form-control" id="name" placeholder="Name" >
                <input type="hidden" name="type" value="{{ $type }}" >
            </div>
        </div>
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
            <label for="status" class="col-md-2 control-label">Status</label>
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
                <a href="{{ route('adminartkwork/form').'?type='.$type }}" class="btn btn-info btn-sm pull-right">Add new </a>
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
                        $obj = new MGeneral();
                        $countries = Config::get('settings.countries');
                        foreach ($lists as $list) {
                            ?>
                            <tr <?php
                            if ($list->active == 0) {
                                echo 'class="line-through"';
                            }
                            ?>>
                                <td><?php echo stripslashes($list->a_title); ?></td>
                                <td>
                                    <?php
                                    if ($type == "Azooma Logo") {
                                        ?>
                                        <img src="<?php echo Config::get('settings.uploadurl') . '/sufratilogo/' . $list->image; ?>" border="0" width="100" >
                                        <?php
                                    } else {
                                        ?>
                                        <img src="<?php echo Config::get('settings.uploadurl') . '/images/' . $list->image; ?>" border="0" width="100" >
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($list->updateAt == "" && $list->updateAt == "0000-00-00 00:00:00") {
                                        echo date('d/m/Y', strtotime($list->createdAt));
                                    } else {
                                        echo date('d/m/Y', strtotime($list->updatedAt));
                                    }
                                    ?>
                                </td>
                                <td class="sufrati-action">
                                    <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminartkwork/form/',$list->id).'?type='.$type  }}" title="Edit Content"><i data-feather="edit"></i></a>
                                    <?php
                                    if ($list->active == 0) {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminartkwork/status/',$list->id) }}" title="Activate "><i data-feather="minus-circle"></i></a>
                                        <?php
                                    } else {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminartkwork/status/',$list->id) }}" title="Deactivate"><i data-feather="plus-circle"></i></a>
                                        <?php
                                    }
                                    ?>
                                    <a onclick="return confirm('Do You Want to Delete?')" class="btn btn-xs btn-danger mytooltip" href="{{ route('adminartkwork/delete/',$list->id) }}" title="Delete"><i data-feather="trash-2"></i></a>
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