@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('admincompetitions'); ?>">All Competitions</a></li>  
    <li class="active">{{ $title }}</li>
</ol>
<?php

$error = Session::get('error');
?>
<div class="well-white container">
    <article>    
        <fieldset>
            <legend>{{ $pagetitle }} - Information</legend>        
        </fieldset>
        <form id="jqValidate"class="form-horizontal restaurant-form" method="post" action="" enctype="multipart/form-data">
            <fieldset>
                <div class="overflow">
                    <div class="col-lg-5 left">
                        <fieldset>

                            <div class="form-group row">
                                <label class="col-lg-5 control-label" >Reference Number</label>
                                <div class="col-lg-7">
                                    <b><?php echo 'SUF000' . $catering->id; ?></b>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-5 control-label" >Event Title</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->name);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-5 control-label" >Event Type</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->type);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-5 control-label" >Total Guests</label>
                                <div class="col-lg-7">
                                    <span class="label label-info" style="font-weight:bold;font-size: 15px;line-height: 22px;"><?php
                                        echo stripslashes($catering->guests);
                                        ?></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-5 control-label" >Budget</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->budget);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-5 control-label">Date</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->date);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-5 control-label">Meal Type</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->mealType);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-5 control-label">Meal</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->meals);
                                    ?>
                                </div>
                            </div>



                        </fieldset>
                    </div>
                    <div class="col-lg-5 left">
                        <fieldset>
                            <div class="form-group row">
                                <label class="col-lg-5 control-label">Location</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->location);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-5 control-label">Serving Style</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->servingStyle);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-5 control-label">Dining Setup</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->diningSetup);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-5 control-label">staff Required</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->staffReq);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-5 control-label">Additional Notes</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->notes);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-5 control-label">Preferred Cuisine</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo MOccasions::getCuisineNames($catering->cuisines);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-5 control-label">Beverage</label>
                                <div class="col-lg-7">
                                    <?php
                                    echo stripslashes($catering->beverage);
                                    ?>
                                </div>
                            </div>

                        </fieldset>
                    </div>
                </div>
                <div class="overflow clear span10">
                    <fieldset>
                        <legend>User Information</legend>
                        <div class="form-group row">
                            <label class="col-lg-5 control-label" >User Name</label>
                            <div class="col-lg-7">
                                <?php
                                echo stripslashes($user->user_FullName);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-5 control-label" >User Email</label>
                            <div class="col-lg-7">
                                <?php
                                echo stripslashes($user->user_Email);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-5 control-label" >User Mobile</label>
                            <div class="col-lg-7">
                                <?php
                                echo stripslashes($user->user_Mobile);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-5 control-label" ></label>
                            <div class="col-lg-7">
                                <?php
                                if (isset($catering) && ($catering->status == 0 || $catering->status == 1 )) {
                                    ?>
                                    <a class="btn btn-info" href="<?php echo URL::to('hungryn137/adminoccasions/forwardrest/' . $catering->id); ?>">Forward to Restaurant</a>
                                    <a class="btn btn-success" href="<?php echo URL::to('hungryn137/adminoccasions/approved/' . $catering->id); ?>">Approved</a>
                                    <a class="btn btn-danger" href="<?php echo URL::to('hungryn137/adminoccasions/cancel/' . $catering->id); ?>">Cancelled</a>
                                    <?php
                                } else {
                                    ?>

                                    <?php
                                    if ($catering->status == 2) {
                                        ?>
                                        <a class="btn btn-info btn-large" href="#" style="margin-right:10px;padding: 5px;">
                                            <i class="icon icon-ban-circle icon-white"></i> Cancelled
                                        </a>
                                        <?php
                                    } elseif ($catering->status == 3) {
                                        ?>
                                        <a class="btn btn-success btn-large" href="#">
                                            <i class="icon icon-ok icon-white   "></i> Approved
                                        </a>
                                        <?php
                                    }
                                    ?>


                                    <?php
                                }
                                ?>
                                <a class="btn btn-light" href="<?php echo URL::to('hungryn137/adminoccasions'); ?>">Back</a>    
                            </div>
                        </div>


                    </fieldset>
                </div>
            </fieldset>
        </form>
    </article>
</div>

@endsection