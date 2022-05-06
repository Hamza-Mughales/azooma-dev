
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('adminsubscriptions'); ?>">Subscriptions</a></li>  
    <li class="active">{{ $title }}</li>
</ol>


<div class="well-white">
    <article>    
        <fieldset>
            <legend>{{ $pagetitle }}</legend>        
        </fieldset>
        <?php
        $permissions1 = array();
        $permissions2 = array();
        if (isset($lists1) && !empty($lists1->sub_detail)) {
            $permissions1 = explode(",", $lists1->sub_detail);
        }
        if (isset($lists2) && !empty($lists2->sub_detail)) {
            $permissions2 = explode(",", $lists2->sub_detail);
        }
        ?>
        <form name="page-form" id="jqValidate" class="form-horizontal" role="form" action="" method="" >
            <div class="form-group row">
                <label class="col-lg-5 control-label" for="bestfor_Name">Package Features</label>
                <div class="col-lg-7">
                    <span class="col-lg-4">
                        <?php
                        //echo '<span class="label label-primary">' . $lists1->accountName . '</span>';
                        echo '<h4>'.$lists1->accountName.'</h4>';
                        ?>
                    </span>
                    <span class="col-lg-4">
                        <?php
                        //echo '<span class="label label-info">' . $lists2->accountName . '</span>';
                        echo '<h4>'.$lists2->accountName.'</h4>';
                        ?>
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-5 control-label" for="bestfor_Name">Profile Page</label>
                <div class="col-lg-7">
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists1) and in_array(1, $permissions1)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists2) and in_array(1, $permissions2)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-5 control-label" for="bestfor_Name">Branch Management</label>
                <div class="col-lg-7">

                    <span class="col-lg-4">
                        <?php
                        if (isset($lists1) and in_array(2, $permissions1)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists2) and in_array(2, $permissions2)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-5 control-label" for="bestfor_Name">Sample Menu</label>
                <div class="col-lg-7">
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists1) and in_array(3, $permissions1)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists2) and in_array(3, $permissions2)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-5 control-label" for="bestfor_Name">Full Menu + PDF</label>
                <div class="col-lg-7">
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists1) and in_array(4, $permissions1)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists2) and in_array(4, $permissions2)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-5 control-label" for="bestfor_Name">Photo Gallery - 3 Photos</label>
                <div class="col-lg-7">
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists1) and in_array(6, $permissions1)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists2) and in_array(6, $permissions2)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-5 control-label" for="bestfor_Name">Photo Gallery - 6 Photos</label>
                <div class="col-lg-7">
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists1) and in_array(7, $permissions1)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists2) and in_array(7, $permissions2)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-5 control-label" for="bestfor_Name">Photo Gallery - 12 Photos</label>
                <div class="col-lg-7">
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists1) and in_array(8, $permissions1)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists2) and in_array(8, $permissions2)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-5 control-label" for="bestfor_Name">Photo Gallery - 20 Photos</label>
                <div class="col-lg-7">
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists1) and in_array(9, $permissions1)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists2) and in_array(9, $permissions2)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-5 control-label" for="bestfor_Name">News Feed</label>
                <div class="col-lg-7">
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists1) and in_array(16, $permissions1)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists2) and in_array(16, $permissions2)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-5 control-label" for="bestfor_Name">Special Offer - 1 Offer</label>
                <div class="col-lg-7">
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists1) and in_array(10, $permissions1)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists2) and in_array(10, $permissions2)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-5 control-label" for="bestfor_Name">Special Offer - 3 offers</label>
                <div class="col-lg-7">
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists1) and in_array(11, $permissions1)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists2) and in_array(11, $permissions2)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-5 control-label" for="bestfor_Name">Comment Response</label>
                <div class="col-lg-7">
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists1) and in_array(14, $permissions1)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists2) and in_array(14, $permissions2)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-5 control-label" for="bestfor_Name">Fan Club</label>
                <div class="col-lg-7">
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists1) and in_array(17, $permissions1)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists2) and in_array(17, $permissions2)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-5 control-label" for="bestfor_Name">Video Gallery</label>
                <div class="col-lg-7">
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists1) and in_array(15, $permissions1)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists2) and in_array(15, $permissions2)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-5 control-label" for="bestfor_Name">Poll</label>
                <div class="col-lg-7">
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists1) and in_array(13, $permissions1)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists2) and in_array(13, $permissions2)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-5 control-label" for="bestfor_Name">Booking</label>
                <div class="col-lg-7">
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists1) and in_array(12, $permissions1)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                    <span class="col-lg-4">
                        <?php
                        if (isset($lists2) and in_array(12, $permissions2)) {
                            echo '<span class="label label-info"><i data-feather="plus-circle"></i></span>';
                        } else {
                            echo '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
                        }
                        ?>
                    </span>
                </div>
            </div>  
        </form>
    </article>
</div>