<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
            Azooma Email
        </title>
        <style media="all" type="text/css">
            table td {border-collapse: collapse;}
            td{ font-family:Arial, Helvetica, sans-serif; }
        </style>
    </head>
    <body style="margin:0;padding:0;-webkit-text-size-adjust:none;width:100% !important;font-family: Helvetica,Arial, sans-serif;font-size:14px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f4f4f4" style="background-color:#f4f4f4; margin:0; padding:0; width:100% !important; line-height: 100% !important;">
            <tr>
                <td style="height:30px;" height="30"></td>
            </tr>
            <tr>
                <td align="center">
                    <table cellpadding="0" cellspacing="0" border="0" width="640" bgcolor="#ffffff" style="background:#ffffff;border:1px solid #cccccc;border-radius:3px;">
                        <tr>
                            <td>
                                <table cellpadding="0" cellspacing="0" border="0" width="640" >
                                    <tr>
                                        <td colspan="2" align="left" style="padding:20px 30px;" valign="top">
                                            <a href="<?php echo Azooma::URL(); ?>" title="Azooma">
                                                <?php
                                                if (isset($logo) && !empty($logo)) {
                                                    //do nothing
                                                } else {
                                                    $logo = MGeneral::getAzoomaLogo();
                                                }
                                                ?>
                                                <img src="<?php echo Azooma::CDN('sufratilogo/' . $logo); ?>" height="60" alt="Azooma" style="outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;border:none;"/>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" height="100px" valign="top" style="padding:0 30px 20px;">
                                            <table cellpadding="0" cellspacing="0" border="0" width="640">
                                                <tr>
                                                    <td align="left">
                                                        <h2 style="color:#000;">Hi <?php echo ucwords($restname); ?>,</h2>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" height="5">
                                                        <table cellpadding="1" cellspacing="0" border="0" width="620" align="center">
                                                            <tr>
                                                                <td colspan="2">&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:14px; line-height: 22px;" >
                                                                    Thanks for your payment sum of
                                                                    <?php
                                                                    if ($payment_option == 2) {
                                                                        echo $down_payment;
                                                                    } else {
                                                                        echo $total_price;
                                                                    }
                                                                    ?>
                                                                    SAR. We appreciate your business and look forward to serving you.
                                                                </td>
                                                            </tr> 
                                                            <tr>
                                                                <td colspan="2">&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;" >
                                                                    <h3 style="border-bottom:1px solid #000;margin:5px 0px;font-size:12px;">
                                                                        Transaction Details:
                                                                    </h3>
                                                                </td>
                                                            </tr> 

                                                            <tr>
                                                                <td colspan="2">&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <table cellpadding="1" cellspacing="0" border="0" width="620" align="center">
                                                                        <tr>
                                                                            <td style="padding-top:10px;font-size:12px;" width="44%">Reference / Invoice Number: </td>
                                                                            <td style="padding-top:10px;font-size:12px;" width="56%"><?php echo $invoice_number; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="padding-top:10px;font-size:12px;" width="44%">Invoice Date:</td>
                                                                            <td style="padding-top:10px;font-size:12px;" width="56%"><?php echo $invoice_date; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="padding-top:10px;font-size:12px;" width="44%">Payment Option: </td>
                                                                            <td style="padding-top:10px;font-size:12px;" width="56%"><?php
                                                                                if ($payment_option == 1) {
                                                                                    echo 'Full';
                                                                                } else {
                                                                                    echo 'Monthly';
                                                                                };
                                                                                ?></td>
                                                                        </tr>
                                                                        <?php if (!empty($subscription_price)) { ?>
                                                                            <tr>
                                                                                <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding-top:10px;font-size:12px;" width="44%">Subscription Price: </td>
                                                                                <td style="padding-top:10px;font-size:12px;" width="56%"><?php echo $subscription_price; ?> SAR</td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        <?php if (!empty($creative_price)) { ?>
                                                                            <tr>
                                                                                <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding-top:10px;font-size:12px;" width="44%">Creative Services: </td>
                                                                                <td style="padding-top:10px;font-size:12px;" width="56%"><?php echo $creative_price; ?> SAR</td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        <?php if (!empty($advertings_price)) { ?>
                                                                            <tr>
                                                                                <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding-top:10px;font-size:12px;" width="44%">Advertising Services: </td>
                                                                                <td style="padding-top:10px;font-size:12px;" width="56%"><?php echo $advertings_price; ?> SAR</td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        <?php if (!empty($discount_price)) { ?>
                                                                            <tr>
                                                                                <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                                                                            </tr>
                                                                            <tr bgcolor="#339900">
                                                                                <td valign="middle" style="padding:5px 0px;color:#fff;font-size:12px;" width="44%">&nbsp;Discount: </td>
                                                                                <td valign="middle" style="padding:5px 0px;color:#fff;font-size:12px;" width="56%"><?php echo $discount_price; ?> SAR</td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        <tr>
                                                                            <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                                                                        </tr>
                                                                        <tr bgcolor="#CCCCCC">
                                                                            <td valign="middle" style="padding:5px 0px;font-size:12px;" width="44%"><strong>&nbsp;Total Price:</strong></td>
                                                                            <td valign="middle" style="padding:5px 0px;font-size:12px;" width="56%"><strong><?php echo $total_price; ?> SAR</strong></td>
                                                                        </tr>
                                                                        <?php if ($payment_option == 2) { ?>
                                                                            <tr>
                                                                                <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding-top:10px;font-size:12px;" width="44%"><strong>Down Payment:</strong></td>
                                                                                <td style="padding-top:10px;font-size:12px;" width="56%"><strong><?php echo $down_payment; ?> SAR</strong></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="padding-top:10px;font-size:12px;" width="44%"><strong>Monthly Payment:</strong></td>
                                                                                <td style="padding-top:10px;font-size:12px;" width="56%"><strong><?php echo $monthly_price; ?> SAR</strong> for <?php echo $installment_duration; ?> Months</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        <tr>
                                                                            <td style="padding:10px 0px;font-size:12px;" colspan="2"><h3 style="border-bottom:1px solid #000;margin:0px;">Subscription Details:</h3></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="top" valign="top">
                                                                                <table cellpadding="1" cellspacing="0" border="0" width="100%" align="top">
                                                                                    <tr>
                                                                                        <td style="padding-top:10px;font-size:12px;" width="55%">Membership Type:</td>
                                                                                        <td style="padding-top:10px;font-size:12px;" width="45%"><?php echo $type; ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="padding-top:10px;font-size:12px;" width="55%">Duration: </td>
                                                                                        <td style="padding-top:10px;font-size:12px;" width="45%"><?php echo $duration; ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="padding-top:10px;font-size:12px;" width="55%">Start Date: </td>
                                                                                        <td style="padding-top:10px;font-size:12px;" width="45%"><?php echo $memDate; ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="padding-top:10px;font-size:12px;" width="55%">Expire Date: </td>
                                                                                        <td style="padding-top:10px;font-size:12px;" width="45%"><?php echo $expiredate; ?></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                            <td align="top" valign="top">
                                                                                <table cellpadding="1" cellspacing="0" border="0" width="100%" align="top">
                                                                                    <tr>
                                                                                        <td style="padding-top:10px;font-size:12px;" width="55%">Client Name:</td>
                                                                                        <td style="padding-top:10px;font-size:12px;" width="45%"><?php echo stripslashes($manager_name); ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="padding-top:10px;font-size:12px;" width="55%">Email: </td>
                                                                                        <td style="padding-top:10px;font-size:12px;color:#00A2B1 !important;" width="45%"><?php echo str_replace(",", "<br/>", $email); ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="padding-top:10px;font-size:12px;" width="55%">Phone: </td>
                                                                                        <td style="padding-top:10px;font-size:12px;" width="45%"><?php echo $phone; ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                                                                                    </tr>
                                                                                </table>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td colspan="2" >&nbsp;</td>
                                                                        </tr>

                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">&nbsp;</td>
                                                            </tr>                 
                                                            <tr>
                                                                <td colspan="2" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;"> Feel free to contact us for any information at <a href="mailto:info@azooma.co" style="color:#00A2B1;">info@azooma.co</a> or call us on <span style="color:#e60683;font-size:18px;"><?php echo $country->telephone; ?></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="font-size:14px;padding-bottom:10px;" > Thank you,  </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="font-size:14px;padding-bottom:10px;" > Best regards </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="font-size:14px;padding-bottom:10px;" > Azooma.co Team </td>
                                                            </tr>                  
                                                            <tr>
                                                                <td colspan="2" height="10" style="padding-bottom:10px;" ></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" height="20" style="height:20px;"></td>
                                    </tr>
                                    <tr height="100px"  style="color:#646464; background-color:whitesmoke;">
                                        <td width="330" align="left" valign="bottom" style=" padding:20px 30px; ">
                                            <p>
                                                <a href="<?php echo Azooma::URL('contact'); ?>" target="_blank">
                                                    Contact Us
                                                </a> | 
                                                <a href="<?php echo $country->facebook; ?>" title="Azooma Facebook">Facebook</a> | 
                                                <a href="<?php echo $country->twitter; ?>" title="Azooma Twitter">Twitter</a>
                                            </p>
                                        </td>
                                        <td align="right" style=" padding:20px 30px;" valign="bottom">            
                                            <table>
                                                <tr>
                                                    <td>
                                                        <a href="https://itunes.apple.com/us/app/Azooma-lite/id709229893?ls=1&mt=8" title="Download Azooma for iOS">
                                                            <img src="http://local.azooma.co/new-Azooma/apple-badge.png" />
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="https://play.google.com/store/apps/details?id=com.LetsEat.AzoomaLite" title="Download Azooma for Android">
                                                            <img src="http://local.azooma.co/new-Azooma/google-badge.png" />
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="background-color:whitesmoke;padding:5px 30px;text-align:center;color:#666;line-height:18px;">
                                            &copy; <?php echo date('Y'); ?> Azooma<br/>
                                            Tel:- <?php echo $country->telephone; ?><br/>
                                            <?php echo $country->address; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" colspan="2" style="min-height:20px !important;background-color:whitesmoke;">

                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td height="50">

                </td>
            </tr>
        </table>
    </body>
</html>