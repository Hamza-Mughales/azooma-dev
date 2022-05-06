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

<?php
    $countries = Config::get('settings.countries');
?>


<div id="filter-main" class="collapse well-white">
    <legend>   Filter Results </legend>  
    <form name="admin-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminsubscriptions'); }}" method="get" >
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
                <a href="{{ route('adminsubscriptions/form'); }}" class="btn btn-info btn-sm pull-right">Add new </a>
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
            <form onsubmit="return check();" name="admin-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('adminsubscriptions/compare'); }}" method="post" >
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <?php
                            foreach ($headings as $key => $value) {
                                ?>
                                <th class="col-md-2">{{ $value }}</th>
                                <?php
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($lists) > 0) {
                            $counter = 1;
                            foreach ($lists as $list) {
                                ?>
                                <tr>
                                    <td><?php echo stripslashes($list->accountName); ?></td>
                                    <td>
                                        <?php
                                        if ($list->country != 0) {
                                            echo $countries[$list->country];
                                        } else {
                                            echo 'Unknow';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (!empty($list->date_upd)) {
                                            echo date('d/m/Y', strtotime($list->date_add));
                                        } else {
                                            echo date('d/m/Y', strtotime($list->date_upd));
                                        }
                                        ?>
                                    </td>                                
                                    <td class="sufrati-action">
                                        <a class="btn btn-xs btn-info mytooltip" href="Javascript:void(0);" title="Compare Package">
                                            <input id="checkbox-<?php echo $counter; ?>" class="compare" type="checkbox" name="compare[]" style="margin: 0px;"  value="<?php echo $list->id; ?>" />
                                        </a>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminsubscriptions/form/',$list->id) }}" title="Edit Content"><i data-feather="edit"></i></a>
                                        <a onclick="return confirm('Do You Want to Delete?')" class="btn btn-xs btn-danger mytooltip" href="{{ route('adminsubscriptions/delete/',$list->id) }}" title="Delete"><i data-feather="trash-2"></i></a>
                                    </td>
                                </tr>
                                <?php
                                $counter++;
                            }
                            ?>
                            <tr>
                                <td colspan="3"></td>
                                <td>
                                    <button type="submit" class="btn btn-group-sm btn-info mytooltip" href="" title="Compare Package"><i class="glyphicon glyphicon-th-large"></i> Compare</button>
                                </td>
                            </tr>
                            <?php
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
            </form>
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
<script type="text/javascript">
    function check() {
        var numberOfChBox = $('.compare').length;
        var counter = 0;
        for (i = 1; i <= numberOfChBox; i++) {
            if ($('#checkbox-' + i).is(':checked')) {
                counter++;
            }
        }
        if(counter==2){
            return true;
        }else if(counter==1 || counter>2){
            alert('Please select 2 packages to compare');
        }else{
            alert('Please select packages to compare');
        }
        return false;
    }
</script>

@endsection