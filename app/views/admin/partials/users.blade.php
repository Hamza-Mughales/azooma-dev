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
    <form name="admin-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminusers'); }}" method="get" >     
        <div class="form-group row">
            <label for="name" class="col-md-2 control-label">Name</label>
            <div class="col-md-6">
                <input type="text" name="name" class="form-control" id="name" placeholder="Name" >
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-md-2 control-label">Email</label>
            <div class="col-md-6">
                <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" >
            </div>
        </div>
        <div class="form-group row">
            <label for="country" class="col-md-2 control-label">Country</label>
            <div class="col-md-6">
                <input type="text" name="country" class="form-control" id="country" placeholder="Country" >
            </div>
        </div>
        <div class="form-group row">
            <label for="nationality" class="col-md-2 control-label">Nationality</label>
            <div class="col-md-6">
                <input type="text" name="nationality" class="form-control" id="nationality" placeholder="Nationality" >
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
                        $countries = Config::get('settings.countries');
                        foreach ($lists as $list) {
                            ?>
                            <tr>
                                <td><?php echo stripslashes($list->user_FullName); ?></td>
                                <td><?php echo stripslashes($list->user_Email); ?></td>     
                                <td>
                                    <?php
                                    if (!empty($list->user_Country)) {
                                        echo $list->user_Country;
                                    } else {
                                        echo 'Unknow';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (!empty($list->user_nationality)) {
                                        echo stripslashes($list->user_nationality);
                                    } else {
                                        echo 'Unknown';
                                    }
                                    ?>
                                </td>     
                                <td><?php echo date('d/m/Y', strtotime($list->user_RegisDate)); ?></td>            
                                <td><?php echo stripslashes($list->count_login); ?></td>
                                <td class="sufrati-action">
                                    <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminusers/view/',$list->user_ID) }}" title="Edit {{ $title }}"><i data-feather="eye"></i></a>
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