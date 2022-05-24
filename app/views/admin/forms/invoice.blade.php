@extends('admin.index')
@section('content')
    
<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('admininvoice'); ?>">Manage Invoice</a></li>  
    <li class="active">{{ $title }}</li>
</ol>

<link rel="stylesheet" type="text/css" href="<?php echo asset(css_path()); ?>/date-picker.css">

<div class="well-white">
    <article>    
        <fieldset>
            <legend>{{ $pagetitle }}</legend>        
        </fieldset>
        <form id="jqValidate"class="form-horizontal restaurant-form" method="post" action="{{ route('admininvoice/saveinvoice'); }}" enctype="multipart/form-data">
            <fieldset>
                <div class="overflow">
                    <div class="col-lg-6 left">
                        <legend>Billing Contact Details</legend>
                        <div class="form-group row">
                            <label class="control-label col-lg-5">Client Name </label>
                            <div class="col-lg-7">
                                <b><?php echo $rest->rest_Name; ?></b>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-lg-5">Contact Person Name </label>
                            <div class="col-lg-7">
                                <b><?php echo $member->full_name; ?></b>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-lg-5">Contact Person Email </label>
                            <div class="col-lg-7">
                                <b><?php echo str_replace(",", "<br/>", $member->email); ?></b>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-lg-5">Contact Person Number </label>
                            <div class="col-lg-7">
                                <b><?php echo $member->phone; ?></b>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 left">
                        <legend>Subscription Details</legend>
                        <div class="form-group row">
                            <label class="control-label col-lg-5">Account Type </label>
                            <div class="col-lg-7">
                                <b>
                                    <?php
                                    if ($rest->rest_Subscription == 0) {
                                        echo 'Free';
                                    } elseif ($rest->rest_Subscription == 1) {
                                        echo 'Bronze';
                                    } elseif ($rest->rest_Subscription == 2) {
                                        echo 'Silver';
                                    } elseif ($rest->rest_Subscription == 3) {
                                        echo 'Gold';
                                    }
                                    ?>
                                </b>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-lg-5">Membership Duration </label>
                            <div class="col-lg-7">
                                <b><?php
                                    if ($rest->member_duration == 0) {
                                        echo 'Unlimited';
                                    } else {
                                        echo $rest->member_duration . 'Months';
                                    };
                                    ?> </b>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-lg-5">Membership Start Date </label>
                            <div class="col-lg-7">
                                <b><?php echo $rest->member_date; ?> </b>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clear">
                    <legend>Payment Details</legend>
                    <div class="form-group row">
                        <label class="control-label col-md-2">Invoice Number </label>
                        <div class="col-md-6">
                            <b>
                                <?php
                                $reference = "";
                                $restname = str_replace(" ", "", $rest->rest_Name);
                                $restname = str_replace("'", "", $rest->rest_Name);
                                $restnameLength = strlen($restname);
                                if ($restnameLength == 1) {
                                    $ref = $restname . '00';
                                } elseif ($restnameLength == 2) {
                                    $ref = $restname . '0';
                                } else {
                                    $ref = substr($restname, 0, 3);
                                }

                                echo $reference = $ref . $member->id_user . date("d") . date("m") . date("y");
                                ?>
                            </b>
                            <input type="hidden" name="invoice_number" value="<?php echo $reference; ?>" />
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="control-label col-md-2">Invoice Date </label>
                        <div class="col-md-6">
                            <input class="form-control " required type="text" autocomplete="off" name="invoice_date" id="invoice_date" <?php echo isset($invoice) ? 'value="' . stripslashes(($invoice->invoice_date)) . '"' : ""; ?> placeholder="Inovice Date" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-2">Reference Number </label>
                        <div class="col-md-6">
                            <input class="form-control required" type="text" name="reference_number" id="reference_number" <?php echo isset($invoice) ? 'value="' . stripslashes(($invoice->reference_number)) . '"' : ""; ?> placeholder="Proposal / Reference Number" />
                        </div>
                    </div>
                    <div class="border-top">&nbsp;</div>
                    <div class="form-group row">
                        <label class="control-label col-md-2"><strong>Subscription Price</strong></label>
                        <div class="col-md-6">
                            <div class="banner-div">
                                <input type="checkbox" name="subscription_yes" id="subscription_yes" value="1"  style="margin-top: 0px" <?php
                                if (isset($invoice) && !empty($invoice->subscription_price)) {
                                    echo 'checked';
                                }
                                ?> />
                                <span>Subscription Price</span>
                            </div>                                                        
                            <input class="short-width form-control number" type="text" name="subscription_price" id="subscription_price" <?php echo isset($invoice) ? 'value="' . stripslashes(($invoice->subscription_price)) . '"' : ""; ?> placeholder="Subscription Price <?php echo $member['price']; ?>" />
                        </div>
                    </div>
                    <?php
                    $option_list_arr = array();
                    $gen_arr = array();
                    if (isset($invoice)) {
                        $option_list = $invoice->option_list;
                        $option_list_arr = explode(",", $option_list);

                        $option_value = $invoice->option_value;
                        $option_value_arr = explode(",", $option_value);

                        foreach ($option_list_arr as $key => $value) {
                            $gen_arr[$value] = $option_value_arr[$key];
                        }
                    }
                    //print_r($gen_arr);                    
                    ?>

                    <div class="border-top">&nbsp;</div>
                    <div class="form-group row">
                        <label class="control-label col-md-2"><strong>Creative Services</strong></label>
                        <div class="row">  
                            <div class="margin-bottom col-md-6">
                                <div class="banner-div">
                                    <input type="checkbox" name="spot_light_video" id="spot_light_video" value="1" style="margin-top: 0px" <?php
                                    if (in_array("Spot-Light-Video", $option_list_arr)) {
                                        echo 'checked';
                                    }
                                    ?> />
                                    <span>Spot light Video</span>
                                </div>
                                <input class="short-width form-control number" type="number" name="spot_light_video_value" id="spot_light_video_value" value="<?php
                                if (in_array("Spot-Light-Video", $option_list_arr)) {
                                    echo $gen_arr['Spot-Light-Video'];
                                }
                                ?>" placeholder="Price 6000" />
                            </div>
                            <div class="margin-bottom col-md-6">
                                <div class="banner-div">
                                    <input type="checkbox" name="hi_light_video" id="hi_light_video" value="2"  style="margin-top: 0px;" <?php
                                    if (in_array("Hi-Light-Video", $option_list_arr)) {
                                        echo 'checked';
                                    }
                                    ?> />
                                    <span>Hi light Video </span>
                                </div>
                                <input class="short-width form-control number" type="number" name="hi_light_video_value" id="hi_light_video_value" value="<?php
                                if (in_array("Hi-Light-Video", $option_list_arr)) {
                                    echo $gen_arr['Hi-Light-Video'];
                                }
                                ?>" placeholder="Price 8000" />
                            </div>
                            <div class="margin-bottom col-md-6">
                                <div class="banner-div">
                                    <input type="checkbox" name="banner_design" id="banner_design" value="2"  style="margin-top: 0px;" <?php
                                    if (in_array("Banner-Design", $option_list_arr)) {
                                        echo 'checked';
                                    }
                                    ?>  />
                                    <span>Banner Design</span>
                                </div>
                                <input class="short-width form-control number" type="number" name="banner_design_value" id="banner_design_value" value="<?php
                                if (in_array("Banner-Design", $option_list_arr)) {
                                    echo $gen_arr['Banner-Design'];
                                }
                                ?>" placeholder="Price 2000" />
                            </div>



                        </div>
                    </div>
                    <div class="border-top">&nbsp;</div>
                    <div class="form-group row">
                        <label class="control-label col-md-2"><strong>Advertising Rates</strong></label>
                        <div class="row">                        
                            <div class="margin-bottom col-md-6">
                                <div class="banner-div">
                                    <input type="checkbox" name="top_banner" id="top_banner" value="1" style="margin-top: 0px" <?php
                                    if (in_array("Top-Banner", $option_list_arr)) {
                                        echo 'checked';
                                    }
                                    ?>  />
                                    <span>Top Banner </span>
                                </div>
                                <input class="short-width form-control number" type="number" name="top_banner_value" id="top_banner_value" value="<?php
                                if (in_array("Top-Banner", $option_list_arr)) {
                                    echo $gen_arr['Top-Banner'];
                                }
                                ?>" placeholder="Shared 7000 , Exclusive 15000" />
                            </div>
                            <div class="margin-bottom col-md-6">
                                <div class="banner-div">
                                    <input type="checkbox" name="bottom_banner" id="bottom_banner" value="1" style="margin-top: 0px" <?php
                                    if (in_array("Bottom-Banner", $option_list_arr)) {
                                        echo 'checked';
                                    }
                                    ?>  />
                                    <span>Bottom Banner <i class="small-font">(for whole website)</i> </span> 
                                </div>
                                <input class="short-width form-control number" type="number" name="bottom_banner_value" id="bottom_banner_value" value="<?php
                                if (in_array("Bottom-Banner", $option_list_arr)) {
                                    echo $gen_arr['Bottom-Banner'];
                                }
                                ?>" placeholder="Shared 5000 , Exclusive 9000" />                            
                            </div>
                            <div class="margin-bottom col-md-6">
                                <div class="banner-div">
                                    <input type="checkbox" name="home_page_slider" id="home_page_slider" value="1" style="margin-top: 0px" <?php
                                    if (in_array("Home-Page-Slider", $option_list_arr)) {
                                        echo 'checked';
                                    }
                                    ?>  />
                                    <span>Home Page Slider </span> 
                                </div>
                                <input class="short-width form-control number" type="number" name="home_page_slider_value" id="home_page_slider_value" value="<?php
                                if (in_array("Home-Page-Slider", $option_list_arr)) {
                                    echo $gen_arr['Home-Page-Slider'];
                                }
                                ?>" placeholder="Shared 10000" />
                            </div>
                            <div class="margin-bottom col-md-6">
                                <div class="banner-div">
                                    <input type="checkbox" name="horizon_banner" id="horizon_banner" value="1" style="margin-top: 0px"  <?php
                                    if (in_array("Horizon-Banner", $option_list_arr)) {
                                        echo 'checked';
                                    }
                                    ?> />
                                    <span>Horizon Banner One </span> 
                                </div>
                                <input class="short-width form-control number" type="number" name="horizon_banner_value" id="horizon_banner_value" value="<?php
                                if (in_array("Horizon-Banner", $option_list_arr)) {
                                    echo $gen_arr['Horizon-Banner'];
                                }
                                ?>" placeholder="Shared 6000 , Exclusive 12000" />
                            </div>
                            <div class="margin-bottom col-md-6">
                                <div class="banner-div">
                                    <input type="checkbox" name="bottom_banner_home" id="bottom_banner_home" value="1" style="margin-top: 0px"  <?php
                                    if (in_array("Bottom-Bbanner-Home", $option_list_arr)) {
                                        echo 'checked';
                                    }
                                    ?>  />
                                    <span>Bottom Banner <i class="small-font">(for Home Page)</i> </span> 
                                </div>
                                <input class="short-width form-control number" type="number" name="bottom_banner_home_value" id="bottom_banner_home_value" value="<?php
                                if (in_array("Bottom-Bbanner-Home", $option_list_arr)) {
                                    echo $gen_arr['Bottom-Bbanner-Home'];
                                }
                                ?>" placeholder="Shared 5000 , Exclusive 9000" />                            
                            </div>
                            <div class="margin-bottom col-md-6">
                                <div class="banner-div">
                                    <input type="checkbox" name="horizon_banner_second" id="horizon_banner_second" value="1" style="margin-top: 0px"  <?php
                                    if (in_array("Horizon-Banner-Second", $option_list_arr)) {
                                        echo 'checked';
                                    }
                                    ?>  />
                                    <span>Horizon Banner Two </span> 
                                </div>
                                <input class="short-width form-control number" type="number" name="horizon_banner_second_value" id="horizon_banner_second_value" value="<?php
                                if (in_array("Horizon-Banner-Second", $option_list_arr)) {
                                    echo $gen_arr['Horizon-Banner-Second'];
                                }
                                ?>" placeholder="Shared 5000 , Exclusive 9000" />
                            </div>
                            <div class="margin-bottom col-md-6">
                                <div class="banner-div">
                                    <input type="checkbox" name="gold_box_banner" id="gold_box_banner" value="1" style="margin-top: 0px"  <?php
                                    if (in_array("Gold-Box-Banner", $option_list_arr)) {
                                        echo 'checked';
                                    }
                                    ?>  />
                                    <span>Gold Box Banner</span>
                                </div>
                                <input class="short-width form-control number" type="number" name="gold_box_banner_value" id="gold_box_banner_value" value="<?php
                                if (in_array("Gold-Box-Banner", $option_list_arr)) {
                                    echo $gen_arr['Gold-Box-Banner'];
                                }
                                ?>" placeholder="Exclusive 6500" />
                            </div>
                            <div class="margin-bottom col-md-6">
                                <div class="banner-div">
                                    <input type="checkbox" name="sliver_box_banner" id="sliver_box_banner" value="1" style="margin-top: 0px"  <?php
                                    if (in_array("Sliver-Box-Banner", $option_list_arr)) {
                                        echo 'checked';
                                    }
                                    ?>  />
                                    <span>Sliver Box Banner</span>
                                </div>
                                <input class="short-width form-control number" type="number" name="sliver_box_banner_value" id="sliver_box_banner_value" value="<?php
                                if (in_array("Sliver-Box-Banner", $option_list_arr)) {
                                    echo $gen_arr['Sliver-Box-Banner'];
                                }
                                ?>" placeholder="Exclusive 5000" />
                            </div>
                            <div class="margin-bottom col-md-6">
                                <div class="banner-div">
                                    <input type="checkbox" name="bronze_box_banner" id="bronze_box_banner" value="1" style="margin-top: 0px"  <?php
                                    if (in_array("Bronze-Box-Banner", $option_list_arr)) {
                                        echo 'checked';
                                    }
                                    ?>  />
                                    <span>Bronze Box Banner</span>
                                </div>
                                <input class="short-width form-control number" type="number" name="bronze_box_banner_value" id="bronze_box_banner_value" value="<?php
                                if (in_array("Bronze-Box-Banner", $option_list_arr)) {
                                    echo $gen_arr['Bronze-Box-Banner'];
                                }
                                ?>" placeholder="Exclusive 4500" />
                            </div>
                            <br>
                            <legend>Newsletter Banner</legend>
                            <div class="margin-bottom col-md-6">
                                <div class="banner-div">
                                    <input type="checkbox" name="sponsorship_banner" id="sponsorship_banner" value="1" style="margin-top: 0px" <?php
                                    if (in_array("Sponsorship-Banner", $option_list_arr)) {
                                        echo 'checked';
                                    }
                                    ?>  />
                                    <span>Sponsorship Banner </span> 
                                </div>
                                <input class="short-width form-control number" type="number" name="sponsorship_banner_value" id="sponsorship_banner_value" value="<?php
                                if (in_array("Sponsorship-Banner", $option_list_arr)) {
                                    echo $gen_arr['Sponsorship-Banner'];
                                }
                                ?>" placeholder="Exclusive 12000" />
                            </div>
                            <div class="margin-bottom col-md-6">
                                <div class="banner-div">
                                    <input type="checkbox" name="horizon_banner_third" id="horizon_banner_third" value="1" style="margin-top: 0px" <?php
                                    if (in_array("Horizon-Banner-Third", $option_list_arr)) {
                                        echo 'checked';
                                    }
                                    ?> />
                                    <span>Horizon Banner Third </span> 
                                </div>
                                <input class="short-width form-control number" type="number" name="horizon_banner_third_value" id="horizon_banner_third_value" value="<?php
                                if (in_array("Horizon-Banner-Third", $option_list_arr)) {
                                    echo $gen_arr['Horizon-Banner-Third'];
                                }
                                ?>" placeholder="Exclusive 5000" />
                            </div>
                            <div class="margin-bottom col-md-6">
                                <div class="banner-div">
                                    <input type="checkbox" name="logo_box" id="logo_box" value="1" style="margin-top: 0px" <?php
                                    if (in_array("Logo-Box", $option_list_arr)) {
                                        echo 'checked';
                                    }
                                    ?> />
                                    <span>Logo Box </span> 
                                </div>
                                <input class="short-width form-control number" type="number" name="logo_box_value" id="logo_box_value" value="<?php
                                if (in_array("Logo-Box", $option_list_arr)) {
                                    echo $gen_arr['Logo-Box'];
                                }
                                ?>" placeholder="Exclusive 1500" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-2">Sub Total Price</label>
                        <div class="col-md-6">
                            <div class="banner-div">
                                <div id="sub-total-price"><?php echo isset($invoice) ? '' . ($invoice->total_price + $invoice->discount_price) . '' : "-"; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-2">Discount Price</label>
                        <div class="col-md-6">
                            <input value="<?php echo isset($invoice) ? '' . stripslashes(($invoice->discount_price)) . '' : ""; ?>" class="form-control number" type="text" name="discount_price" id="discount_price" placeholder="Discount Price" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-2"><b>Total Price</b></label>
                        <div class="col-md-6">
                            <div class="banner-div">
                                <div id="total-price"><?php echo isset($invoice) ? '' . stripslashes(($invoice->total_price)) . '' : "-"; ?></div>
                            </div>
                            <a href="javascript:void(0);" class="btn btn-light" onclick="calculate_total_price();">Calculate Total Price</a>
                            <input type="hidden" name="total_price" id="total_price" value="" />
                            <div id="total-price-error" class="hidden error">Please calculate the Total Price</div>
                        </div>
                    </div>
                    <div class="border-top">&nbsp;</div>
                    <div class="form-group row">
                        <label class="control-label col-md-2">Payment Option </label>
                        <div class="col-md-6">
                            <select class="form-control required" name="payment_option" id="payment_option" onchange="select_packge(this.value);">
                                <option value="">Please select</option>
                                <option value="1" <?php
                                if (isset($invoice) && $invoice->payment_option == '1') {
                                    echo 'selected';
                                }
                                ?> >Full Payment</option>
                                <option value="2" <?php
                                if (isset($invoice) && $invoice->payment_option == '2') {
                                    echo 'selected';
                                }
                                ?> >Monthly Plan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group hidden row" id="id_startup_price">
                        <label class="control-label col-md-2">Down Payment</label>
                        <div class="col-md-6">
                            <input class="required form-control number" type="number" name="down_payment" id="down_payment" placeholder="Down Payment" <?php echo isset($invoice) ? 'value="' . stripslashes(($invoice->down_payment)) . '"' : ""; ?> />
                        </div>
                    </div>
                    <div class="form-group hidden row" id="id_monthly_price">
                        <label class="control-label col-md-2">Monthly Payment</label>
                        <div class="col-md-6">
                            <input class="required form-control number" type="number" name="monthly_price" id="monthly_price" placeholder="Monthly Payment" <?php echo isset($invoice) ? 'value="' . stripslashes(($invoice->monthly_price)) . '"' : ""; ?>/>
                        </div>
                    </div>
                    <div class="form-group hidden row" id="installment_duration_div">
                        <label class="control-label col-md-2">Installment Duration</label>
                        <div class="col-md-6">
                            <input class="required form-control number" type="number" name="installment_duration" id="installment_duration" placeholder="Installment Duration"  <?php echo isset($invoice) ? 'value="' . stripslashes(($invoice->installment_duration)) . '"' : ""; ?>/>
                            <div id="inst-price-error" class="hidden error">Please calculate the Correct installment</div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col offset-md-2">
                            <?php if (isset($member)) {
                                ?>
                                <input type="hidden" name="rest_ID" value="<?php echo $member->rest_id; ?>"/>
                                <input type="hidden" name="id_user" value="<?php echo $member->id_user; ?>"/>                                
                                <?php
                            }
                            if (isset($invoice)) {
                                ?>
                                <input type="hidden" name="invoiceID" value="<?php echo $invoice->id; ?>"/>                                
                                <?php
                            }
                            ?>
                            <input type="hidden" name="is_draft" id="is_draft" value=""/>
                            <input type="submit" name="submit" value="Generate Invoice" class="btn btn-primary" onclick="return sendDraft(1);" />
                            <input type="submit" name="draft" value="Send as Draft" class="btn btn-success" onclick="return sendDraft(0);" />
                            <button type="button" href="#invoice-container" onclick="view_invoice();" data-bs-target="#invoice-container" data-bs-toggle="modal" class="btn btn-info mb-0" title="View Invoice">View Invoice</button>
                            <a href="<?php
                            if (isset($_SERVER['HTTP_REFERER']))
                                echo $_SERVER['HTTP_REFERER'];
                            else
                                echo route('admininvoice');
                            ?>" class="btn btn-light" title="Cancel Changes">Cancel</a>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </article>
</div>
<?php

echo HTML::script('js/admin/invoice.js');
?>
<script type="text/javascript">
    
<?php
if (isset($invoice) && $invoice->payment_option != '0') {
    ?>
        select_packge('<?php echo $invoice->payment_option; ?>');
    <?php
}
?>
</script>
<style>
    label{
        font-weight: normal;
    }
    .banner-div{
        display: inline-block;
        width: 230px;
        float: left;
    }
    .border-top{
        border-top: 1px solid #eee;
    }
    .inline-block{
        display: inline-block;
    }
    .margin-right{
        margin-right: 20px;   
    }
    .short-width {
        width: 315px;
    }
    .Azooma-backend-input-seperator div{
        float: left;
    }
    .margin-bottom col-md-6{
        margin-bottom col-md-6: 10px;
        overflow: hidden;
    }
</style>

<div id="invoice-container" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myLargeModalLabel">Invoice Details</h4>
            </div>
            <div class="modal-body">
                <div class="margin-bottom col-md-6"> 
                    <label class="inline-block banner-div ">Invoice Number </label>
                    <span> <b><?php echo $reference; ?></b> </span> 
                </div>
                <div class="margin-bottom col-md-6"> 
                    <label class="inline-block banner-div ">Invoice Date </label>
                    <span> <b id="invoice-date-div"></b> </span> 
                </div>
                <div class="margin-bottom col-md-6"> 
                    <label class="inline-block banner-div">Reference Number</label>
                    <span> <b id="ref-no"></b> </span> 
                </div>
                <div class="margin-bottom col-md-6"> 
                    <label class="inline-block banner-div">Subscription Price</label>
                    <span> <b id="subscribe-price"></b> </span> 
                </div>
                <div class="margin-bottom col-md-6"> 
                    <label class="inline-block banner-div">Creative Services</label>
                    <span> <b id="creative-id"></b> </span> 
                </div>
                <div class="margin-bottom col-md-6"> 
                    <label class="inline-block banner-div">Advertising Rates</label>
                    <span> <b id="advertising-id"></b> </span> 
                </div>
                <div class="margin-bottom col-md-6"> 
                    <label class="inline-block banner-div"><b>Sub Total Price</b></label>
                    <span> <b id="sub-total-id"></b> </span> 
                </div>
                <div class="margin-bottom col-md-6"> 
                    <label class="inline-block banner-div">Discount Price</label>
                    <span> <b id="discount-id"></b> </span> 
                </div>
                <div class="border-top margin-bottom col-md-6"></div>
                <div class="margin-bottom col-md-6"> 
                    <label class="inline-block banner-div"><b>Total Price</b></label>
                    <span> <b id="total-id"></b> </span> 
                </div>
                <div class="border-top margin-bottom col-md-6"></div>
                <div class="margin-bottom col-md-6"> 
                    <label class="inline-block banner-div">Payment Option</label>
                    <span> <b id="payment-option-id"></b> </span> 
                </div>
                <div class="margin-bottom col-md-6 hidden"id="down-payment-tr"> 
                    <label class="inline-block banner-div">Down Payment</label>
                    <span> <b id="down-payment-id"></b> </span> 
                </div>
                <div class="margin-bottom col-md-6 hidden" id="monthly-payment-tr"> 
                    <label class="inline-block banner-div">Monthly Payment</label>
                    <span> <b id="monthly-payment-id"></b> </span> 
                </div>
                <div class="margin-bottom col-md-6 hidden" id="duration-payment-tr"> 
                    <label class="inline-block banner-div">Installment Duration</label>
                    <span> <b id="duration-payment-id"></b> </span> 
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= asset(js_path()) ?>/date-picker/datepicker.js"></script>
<script src="<?= asset(js_path()) ?>/date-picker/datepicker.en.js"></script>
<script src="<?= asset(js_path()) ?>/date-picker/datepicker.custom.js"></script>
<script>
    $(document).ready(function() {
        $('#invoice_date').datepicker({
            language: 'en',
            dateFormat: 'yyyy-mm-dd'
        });
  
    });
</script>

@endsection