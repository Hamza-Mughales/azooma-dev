@extends('admin.index')
@section('content')

<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('admininvoice'); ?>">Manage Invoice</a></li>  
    <li class="active">{{ $title }}</li>
</ol>


<div class="well-white">
    <article>    
        <fieldset>
            <legend>{{ $pagetitle }}</legend>        
        </fieldset>
        <form id="jqValidate" class="form-horizontal restaurant-form" method="post" action="{{ route('admininvoice/saveinvoice'); }}" enctype="multipart/form-data">
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
                    <div class="overflow">
                        <div class="col-lg-6 left">
                            <legend class="clear" >Payment Details</legend>
                            <div class="form-group row">
                                <label class="control-label col-lg-5">Invoice Number </label>
                                <div class="col-lg-7">
                                    <b>
                                        <?php
                                        echo $invoice->invoice_number;
                                        ?>
                                    </b>                            
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-lg-5">Invoice Date </label>
                                <div class="col-lg-7">
                                    <b>
                                        <?php
                                        echo $invoice->invoice_date;
                                        ?>
                                    </b> 
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-lg-5">Reference Number </label>
                                <div class="col-lg-7">
                                    <b>
                                        <?php
                                        echo $invoice->reference_number;
                                        ?>
                                    </b> 
                                </div>
                            </div>
                        </div> 
                        <div class="col-lg-6 left">
                            <legend class="clear" >Payment Plan</legend>
                            <div class="form-group row">
                                <label class="control-label col-lg-5">Payment Option</label>
                                <div class="col-lg-7">
                                    <b>
                                        <?php
                                        if ($invoice->payment_option == 1) {
                                            echo 'Full';
                                        } else {
                                            echo 'Monthly';
                                        }
                                        ?>
                                    </b> 
                                </div>
                            </div>
                            <?php
                            if ($invoice->payment_option == 2) {
                                ?>
                                <div class="form-group row">
                                    <label class="control-label col-lg-5">Down Payment</label>
                                    <div class="col-lg-7">
                                        <b>
                                            <?php echo $invoice->down_payment . ' SAR'; ?>
                                        </b> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-lg-5">Monthly Payment</label>
                                    <div class="col-lg-7">
                                        <b>
                                            <?php echo $invoice->monthly_price . ' for ' . $invoice->installment_duration . ' Months'; ?>
                                        </b> 
                                    </div>
                                </div>
                                <?php
                            }
                            if (!empty($invoice->discount_price)) {
                                ?>
                                <div class="form-group row">
                                    <label class="control-label col-lg-5">Discount</label>
                                    <div class="col-lg-7">
                                        <b>
                                            <?php echo $invoice->discount_price . ' SAR'; ?>
                                        </b> 
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="form-group row">
                                <label class="control-label col-lg-5">Total Payment</label>
                                <div class="col-lg-7">
                                    <b>
                                        <?php echo $invoice->total_price . ' SAR'; ?>
                                    </b> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">  
                        <label class="control-label col-lg-5"><strong>Payment Status</strong></label>
                        <div class="col-lg-7">
                            <a href="<?php echo route('admininvoice/status/',1).'?rest_ID=' . $rest->rest_ID . '&invoiceID=' . $invoice->id; ?>" class="btn btn-success" title="Paid Receipt">Paid Receipt</a>
                            <a href="<?php echo route('admininvoice/status/',2).'?rest_ID=' . $rest->rest_ID . '&invoiceID=' . $invoice->id; ?>" class="btn btn-info" title="Reminder!">Reminder!</a>
                            <a href="<?php echo route('admininvoice/status/',3).'?rest_ID=' . $rest->rest_ID . '&invoiceID=' . $invoice->id; ?>" class="btn btn-danger" title="Send Receipt">Cancelled</a>
                        </div>
                    </div>
                    <div class="clear">
                        <legend class="clear" >Package Details</legend>

                        <?php
                        $option_value = $invoice->option_value;
                        $option_value_arr = explode(",", $option_value);
                        $option_list = $invoice->option_list;
                        $option_list_arr = explode(",", $option_list);

                        foreach ($option_list_arr as $key => $value) {
                            ?>
                            <div class="form-group row">
                                <label class="control-label col-lg-5"><?php echo ucwords($value); ?></label>
                                <div class="col-lg-7">
                                    <?php echo $option_value_arr[$key]; ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                    if ($invoice->payment_option == 2) {
                        ?>
                        <div class="span10">
                            <legend class="clear" >Monthly Payment Details</legend>
                            <?php
                            $monthly_invoice = $MRestActions->getMonthlyInvoiceDetails($invoice->rest_ID, $invoice->id, $invoice->invoice_number);
                            if (is_array($monthly_invoice)) {
                                ?>
                                <table id="admin-activity-table" class="table table-bordered table-striped">
                                    <thead>
                                    <th>Sr#</th>
                                    <th>Month</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($monthly_invoice as $value) {
                                            ?>
                                            <tr> 
                                                <td> <?php echo $value->id; ?> </td>
                                                <td> <?php echo $value->installment_month; ?> </td>
                                                <td> <?php echo $value->invoice_date; ?> </td>
                                                <td> <?php echo $value->monthly_price; ?> </td>
                                                <td> 
                                                    <?php
                                                    if ($value->status == 0) {
                                                        echo 'Pending';
                                                    } elseif ($value->status == 1) {
                                                        echo 'Sent';
                                                    }
                                                    ?> 
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>

            </fieldset>
        </form>
    </article>
</div>
<?php
echo HTML::script('js/admin/invoice.js');
?>

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
    .sufrati-backend-input-seperator div{
        float: left;
    }
    .margin-bottom{
        margin-bottom: 10px;
        overflow: hidden;
    }
</style>
@endsection
