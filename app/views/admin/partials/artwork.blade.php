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
        <button type="button" class="btn pull-right" data-bs-toggle="collapse" data-bs-target="#filter-main"> <i data-feather="filter"></i> </button>
    </div>
</div>


<div id="filter-main" class="collapse well-white">
    <legend> Filter Results </legend>
   <input type="hidden" name="type" id="url-type" value="<?=get('type')?>" />
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
                            <option value="{{ $value->seo_url }}">
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
                <button onclick="reloadTable('artwork-table');" type="button" class="btn btn-primary-gradien">Filter</button>
            </div>
        </div>
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
            </div>
            <table id="artwork-table" class="table table-hover">
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

                </tbody>
            </table>

        </div>
    </article>
</div>
<script type="text/javascript">
    var tab_config = {
        columns: [{
                data: "a_title"
            },
            {
                data: "image",
                searchable: false
            },

            {
                data: "status_html",
                name: "active",searchable: false
            },
            {
                data: "updatedAt"
            },
            {
                data: "action",
                searchable: false,
                sortable: false
            }
        ],
        order: [
            [3, 'desc']
        ],
        data: function(d) {
            return $.extend({}, d, {
                "status": $('#status').val(),
                "city_ID": $('#city_ID').val(),
                "sort": $('#sort').val(),
                "type": $('#url-type').val(),
                

            })
        }


    };

    function reloadTable(table_id) {

        reloadDataTable(table_id);
    }
    $(document).ready(function() {

        startDataTable("artwork-table", "<?= route('get_artwork_data') ?>", tab_config);
    });
</script>
@endsection