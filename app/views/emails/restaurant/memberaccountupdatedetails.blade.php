<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
            Sufrati Email
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
                                            <a href="<?php echo Azooma::URL(); ?>" title="Sufrati">
                                                <?php
                                                if (isset($logo) && !empty($logo)) {
                                                    //do nothing
                                                } else {
                                                    $logo = MGeneral::getSufratiLogo();
                                                }
                                                ?>
                                                <img src="<?php echo Azooma::CDN('sufratilogo/' . $logo); ?>" height="60" alt="Sufrati" style="outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;border:none;"/>
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
                                                                    <p style="font-family:Arial, Helvetica, sans-serif; font-size:14px;">Your <?php echo stripslashes($heading_title); ?> at azooma.co. We appreciate your business and look forward to serving you. Your request for the <strong><?php echo $type;?></strong> membership has been activated. </p>
                                                                </td>
                                                            </tr> 
                                                            <tr>
                                                                <td colspan="2">&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" valign="top" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;" >Simply Login to your account to start managing and updating your page. Please find your login details below.</td>
                                                            </tr> 

                                                            <tr>
                                                                <td colspan="2">&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; padding-left:10px; padding-right:10px;" height="20" width="44%"><strong>Username: </strong></td>
                                                                <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding-left:10px; padding-right:10px;color:#00A2B1;" height="20" width="55%"><strong><?php echo stripslashes($username); ?></strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px;padding-left:10px; padding-right:10px;" height="20" width="44%"><strong>Password: </strong></td>
                                                                <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px;color:#00A2B1; padding-left:10px; padding-right:10px;" height="20" width="55%"><strong><?php echo $password; ?></strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; padding-left:10px; padding-right:10px;" height="20" width="44%"><strong>Click the link to access your account:</strong></td>
                                                                <td width="55%" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;color:#00A2B1; padding-left:10px; padding-right:10px;" height="20"><a style="color:#00A2B1;" href="http://restaurant.azooma.co" target="_blank">http://restaurant.azooma.co</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">&nbsp;</td>
                                                            </tr>                 
                                                            <tr>                                                                
                                                                <td colspan="2" height="20px" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; padding-left:10px; padding-right:10px; font-weight:bold;">Your <strong><?php echo $type ?></strong> account includes the following features:</td>
                                                            </tr>  
                                                            <tr>
                                                                <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding-left:10px; padding-right:10px;">
                                                                    <?php echo $sevices;  ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;"> Feel free to contact us for any information at <a href="mailto:info@azooma.co" style="color:#00A2B1;">info@azooma.co</a> or call us on <span style="color:#e60683;font-size:18px;"><?php echo $country->telephone; ?></span>
                                                                </td></tr>

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
                                                                <td colspan="2" style="font-size:14px;padding-bottom:10px;" > Sufrati.com Team </td>
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
                                                <a href="<?php echo $country->facebook; ?>" title="Sufrati Facebook">Facebook</a> | 
                                                <a href="<?php echo $country->twitter; ?>" title="Sufrati Twitter">Twitter</a>
                                            </p>
                                        </td>
                                        <td align="right" style=" padding:20px 30px;" valign="bottom">            
                                            <table>
                                                <tr>
                                                    <td>
                                                        <a href="https://itunes.apple.com/us/app/sufrati-lite/id709229893?ls=1&mt=8" title="Download Sufrati for iOS">
                                                            <img src="http://local.azooma.co/new-sufrati/apple-badge.png" />
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="https://play.google.com/store/apps/details?id=com.LetsEat.SufratiLite" title="Download Sufrati for Android">
                                                            <img src="http://local.azooma.co/new-sufrati/google-badge.png" />
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="background-color:whitesmoke;padding:5px 30px;text-align:center;color:#666;line-height:18px;">
                                            &copy; <?php echo date('Y'); ?> Sufrati<br/>
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