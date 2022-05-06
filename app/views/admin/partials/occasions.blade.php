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
    <form name="admin-form" id="jqValidate" class="form-horizontal" role="form" action="" method="get" >
        <div class="form-group row">
            <label for="name" class="col-md-2 control-label">Name</label>
            <div class="col-md-6">
                <input type="text" name="name" class="form-control" id="name" placeholder="Name" >
            </div>
        </div>
        <div class="form-group row">
            <label for="sort" class="col-md-2 control-label">Sort By</label>
            <div class="col-md-6">
                <select name="sort" id="sort" class="form-control">
                    <option value="">please select </option>
                    <option value="latest">Latest</option>
                    <option value="name">Name</option>
                    <option value="budget">Budget</option>
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
                        $j = 0;
                        foreach ($lists as $list) {
                            $user = "";
                            if (!empty($list->user_ID)) {
                                $user = MOccasions::getUserInfo($list->user_ID);
                            }
                            ?>
                            <tr class="rows <?php
                            if (isset($list->status) && $list->status == 0) {
                                echo 'line-through ';
                            }
                            if ($list->is_read == 0) {
                                echo 'new-row';
                            }
                            ?>" data-id="<?php echo $list->id; ?>"  id="row-<?php echo $j; ?>" 
                                <?php
                                if ($list->is_read == 0) {
                                    echo 'onclick="readoccasions(' . $list->id . ')"';
                                }
                                ?>
                                >
                                <td><?php echo stripslashes($list->name); ?></td>
                                <td><?php echo stripslashes($user->user_FullName); ?></td>
                                <td><?php echo stripslashes($user->user_Mobile); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($list->date)); ?></td>
                                <td><?php echo stripslashes($list->budget); ?></td>
                                <td><?php echo stripslashes($list->guests); ?></td>
                                <td>
                                    <?php
                                    if (!empty($list->updatedAt)) {
                                        echo date('d/m/Y', strtotime($list->updatedAt));
                                    } else {
                                        echo date('d/m/Y', strtotime($list->createdAt));
                                    }
                                    ?>
                                </td>                                
                                <td class="sufrati-action">
                                    <a class="btn btn-xs btn-primary mytooltip" href="{{ route('adminoccasions/view/',$list->id) }}" title="View All Details for <?php echo $list->name; ?>"><i data-feather="info"></i></a>
                                    <?php
                                    if ($list->status == 0) {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminoccasions/status/',$list->id) }}" title="Activate "><i data-feather="minus-circle"></i></a>
                                        <?php
                                    } elseif ($list->status == 1) {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('adminoccasions/status/',$list->id) }}" title="Deactivate"><i data-feather="plus-circle"></i></a>
                                        <?php
                                    } elseif ($list->status == 2) {
                                        echo '<span class="btn btn-xs btn-info"><i data-feather="minus-circle"></i> Cancelled</span>';
                                    } elseif ($list->status == 3) {
                                        echo '<span class="btn btn-xs btn-success"><i data-feather="plus-circle"></i> Approved</span>';
                                    }
                                    if ($list->status == 0 || $list->status == 1) {
                                        ?>
                                        <a onclick="return confirm('Do You Want to Delete?')" class="btn btn-xs btn-danger mytooltip" href="{{ route('adminoccasions/delete/',$list->id) }}" title="Delete"><i data-feather="trash-2"></i></a>
                                            <?php
                                        }
                                        ?>
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