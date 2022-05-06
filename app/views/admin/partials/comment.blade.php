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
    <form name="admin-form" id="jqValidate" class="form-horizontal" role="form" action="{{ route('admincomments' ); }}" method="get" >
        
        <div class="form-group row">
            <label for="name" class="col-md-2 control-label">Comment</label>
            <div class="col-md-6">
                <input type="text" name="name" class="form-control" id="name" placeholder="Comment" >
            </div>
        </div>
        
        <div class="form-group row">
            <label for="rest_ID" class="col-md-2 control-label">Restaurants</label>
            <div class="col-md-6">
                <select name="rest_ID" id="rest_ID" class="form-control">
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
            <label for="sort" class="col-md-2 control-label">Sort By</label>
            <div class="col-md-6">
                <select name="sort" id="sort" class="form-control">
                    <option value="">please select </option>
                    <option value="latest">Latest</option>
                    <option value="name">Name</option>
                    <option value="new">New</option>
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
            <legend>{{ $pagetitle }}</legend>        
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
                            <tr data-row="<?php echo $list->id; ?>" <?php
                            if ($list->is_read == 0) {
                                echo 'class="new-row" onclick="readcomment(' . $list->id . ')"';
                            } elseif ($list->status == 0) {
                                echo 'class="line-through"';
                            }
                            ?>>
                                <td>
                                    <?php
                                    echo stripslashes($list->review_Msg);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo stripslashes($list->uname);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo stripslashes($list->uname);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo stripslashes($list->restaurant);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo stripslashes($list->email);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($list->review_Date != "" && $list->review_Date != "0000-00-00") {
                                        echo date('d/m/Y', strtotime($list->review_Date));
                                        echo '<br>';
                                        echo date('h:i:s', strtotime($list->review_Date));
                                    } else {
                                        echo 'Unknown';
                                    }
                                    ?>
                                </td>
                                <td class="sufrati-action">
                                    <a class="btn btn-xs btn-info mytooltip" href="{{ route('admincomments/view/',$list->id)  }}" title="Edit Content"><i data-feather="edit"></i></a>
                                    <?php
                                    if ($list->status == 0) {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('admincomments/status/',$list->id) }}" title="Activate "><i data-feather="minus-circle"></i></a>
                                        <?php
                                    } else {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('admincomments/status/',$list->id) }}" title="Deactivate"><i data-feather="plus-circle"></i></a>
                                        <?php
                                    }
                                    ?>
                                    <a onclick="return confirm('Do You Want to Delete?')" class="btn btn-xs btn-danger mytooltip" href="{{ route('admincomments/delete/',$list->id) }}" title="Delete"><i data-feather="trash-2"></i></a>
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