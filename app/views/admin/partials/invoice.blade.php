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
    <form name="admin-form" id="jqValidate" class="form-horizontal" role="form" action="" method="get" >
        <div class="form-group row">
            <label for="name" class="col-md-2 control-label">Restaurant Name</label>
            <div class="col-md-6">
                <input type="text" name="restaurant" class="form-control" id="name" placeholder="Restaurant Name" >
            </div>
        </div>
        <div class="form-group row">
            <label for="statu" class="col-md-2 control-label">Restaurant Status</label>
            <div class="col-md-6">
                <select name="status" id="status" class="form-control">
                    <option value="">please select Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="city" class="col-md-2 control-label">Restaurant City</label>
            <div class="col-md-6">
                <?php
                $cities = MGeneral::getAllCities($country);
                echo MGeneral::generate_list($cities, "city_ID", "city_Name", 'city', 'city');
                ?>
            </div>
        </div>

        <div class="form-group row">
            <label for="cuisine" class="col-md-2 control-label">Cuisine</label>
            <div class="col-md-6">
                <?php
                $cuisines = MGeneral::getAllCuisine(1);
                echo MGeneral::generate_list($cuisines, "cuisine_ID", "cuisine_Name", 'cuisine', 'cuisine');
                ?>
            </div>
        </div>

        <div class="form-group row">
            <label for="best" class="col-md-2 control-label">Best For</label>
            <div class="col-md-6">
                <?php
                $bestfor = MGeneral::getAllBestFor(1);
                echo MGeneral::generate_list($bestfor, "bestfor_ID", "bestfor_Name", 'best', 'best');
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="membership" class="col-md-2 control-label">Membership</label>
            <div class="col-md-6">
                <?php
                $bestfor = MGeneral::getAllSubscriptionTypes($country);
                echo MGeneral::generate_list($bestfor, "id", "accountName", 'membership', 'membership');
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="sort" class="col-md-2 control-label">Sort By</label>
            <div class="col-md-6">
                <select name="sort" id="sort" class="form-control">
                    <option value="latest">Latest</option>
                    <option value="name">Name</option>
                    <option value="popular">Popular</option>
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
            
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <?php
                        foreach ($headings as $key => $value) {
                            if ($value == 'Restaurant Name') {
                                ?>
                                <th style="width:13%;" class="col-md-1">{{ $value }}</th>
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
                        //$countries = Config::get('settings.countries');
                        //$MGeneral = new MGeneral();
                        foreach ($lists as $list) {
                            ?>
                            <tr class="<?php
                            if ($list->status == 0) {
                                echo ' line-through';
                            }
                            ?>" >
                                <td>
                                    <?php
                                    echo stripslashes($list->rest_Name) . ' ' . stripslashes($list->rest_Name_Ar);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo stripslashes($list->referenceNo);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo '<span class="label';
                                    if ($list->rest_Subscription == 0) {
                                        echo ' label-danger">Not a Member';
                                    } else {
                                        switch ($list->rest_Subscription) {
                                            case 0:
                                                echo ' label-default">Free member';
                                                break;
                                            case 1;
                                                echo ' label-success">Bronze member';
                                                break;
                                            case 2:
                                                echo ' label-info">Silver member';
                                                break;
                                            case 3:
                                                echo ' label-warning">Gold Member';
                                                break;
                                        }
                                    }
                                    echo "</span>";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo date("d/m/Y", strtotime($list->member_date));
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($list->lastUpdatedOn == "") {
                                        echo date('d/m/Y', strtotime($list->rest_RegisDate));
                                    } else {
                                        echo date('d/m/Y', strtotime($list->lastUpdatedOn));
                                    }
                                    ?>
                                </td>  
                                <td>
                                    <?php
                                    if ($list->rest_Subscription == 0) {
                                        echo 'Unlimited - Free Account';
                                    } else {
                                        $duration = $list->member_duration;
                                        echo date('d/m/Y', strtotime(date("Y-m-d", strtotime($list->member_date)) . " +$duration month"));
                                    }
                                    ?>
                                </td>
                                <td class="azooma-action">
                                    <?php
                                    $invoice_ar = "";
                                    $invoice_ar = $MRestActions->getInvoiceDetails($list->rest_ID);
                                    if (is_object($invoice_ar)) {
                                        if ($invoice_ar->is_draft == 1) {
                                            ?>
                                            <a class="btn btn-xs btn-info mytooltip" href="{{ route('admininvoice/invoiceform/',$list->rest_ID).'?invoice='.$invoice_ar->id; }}" title="View & Generate Invoice"><i class="glyphicon glyphicon-list"></i></a>
                                            <?php
                                        } else {
                                            ?>
                                            <a class="btn btn-xs btn-info mytooltip" href="{{ route('admininvoice/view/',$list->rest_ID) }}" title="View Invoice"><i class="glyphicon glyphicon-search"></i></a>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <a class="btn btn-xs btn-info mytooltip" href="{{ route('admininvoice/generate/',$list->rest_ID) }}" title="Generate Invoice"><i data-feather="file-plus"></i></a>
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