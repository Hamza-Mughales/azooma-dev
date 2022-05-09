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
                <button type="submit" onclick="reloadTable('banner-table');" class="btn btn-primary-gradien">Filter</button>          
            </div>
        </div>
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
           
            </div>
            <div class="table-responsive">
            <table id="banner-table" class="table table-striped">
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
       
                </tbody>
            </table>
            </div>
        </div>
    </article>
</div>
<script type="text/javascript">
    var tab_config = {
        columns: [
            {
                data: "image",
                searchable: false
            },
            {
                data: "banner_type"
            },
            {
                data: "city_Name",
                name:"city_list.city_Name"
            },
            {
                data: "clicked"
            },
            {
                data: "impressions"
            },
            {
                data: "start_date"
            },
            {
                data: "end_date"
            },
            {
                data: "status_html",
                name: "active",searchable: false
            },
         
            {
                data: "action",
                searchable: false,
                sortable: false
            }
        ],
        order: [
            [3, 'asc']
        ],
        data: function(d) {
            return $.extend({}, d, {
                "status": $('#status').val(),
                "city_ID": $('#city_ID').val(),
                "cuisine_ID": $('#cuisine_ID').val(),
                "banner_type": $('#banner_type').val(),                

            })
        }


    };

    function reloadTable(table_id) {

        reloadDataTable(table_id);
    }
    $(document).ready(function() {

        startDataTable("banner-table", "<?= route('adminbannersdata') ?>", tab_config);
    });
    </script>
@endsection