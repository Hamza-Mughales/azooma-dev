<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $title . ' - ' . $sitename; ?></title>
        <style media="all" type="text/css">
            table td {
                border-collapse: collapse;
            }
            td {
                font-family:Arial, Helvetica, sans-serif;
            }
        </style>
    </head>
    <body style="margin:0;padding:0;-webkit-text-size-adjust:none;width:100% !important;font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#646464 !important;">
        <?php
        if ($event['status'] == 0 && isset($action)) {
            ?>
            <div style="position: fixed;background: #000;height: 35px;text-align: center;padding: 10px;width: 100%;">
                <a href="<?php echo base_url('mydiners/edit/' . $event['id']); ?>" style="background-color: #0074cc; background-image: -moz-linear-gradient(top, #0088cc, #0055cc); background-image: -ms-linear-gradient(top, #0088cc, #0055cc); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0055cc)); background-image: -webkit-linear-gradient(top, #0088cc, #0055cc); background-image: -o-linear-gradient(top, #0088cc, #0055cc); background-image: linear-gradient(top, #0088cc, #0055cc); background-repeat: repeat-x; padding: 9px 30px; font-size: 15px; line-height: normal; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; color: #fff; text-decoration: initial; margin-right: 30px;"><?=lang('edit_now')?></a>
                <a href="<?php echo base_url('mydiners/dinermessages'); ?>" style=" display: inline-block; padding: 4px 10px 4px; margin-bottom: 0; font-size: 13px; line-height: 18px; color: #333333; text-align: center; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75); vertical-align: middle; background-color: #f5f5f5; background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6); background-image: -ms-linear-gradient(top, #ffffff, #e6e6e6); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6)); background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6); background-image: -o-linear-gradient(top, #ffffff, #e6e6e6); background-image: linear-gradient(top, #ffffff, #e6e6e6); background-repeat: repeat-x;  border-color: #e6e6e6 #e6e6e6 #bfbfbf; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);  border: 1px solid #cccccc; border-bottom-color: #b3b3b3; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05); -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05); box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05); cursor: pointer; padding: 8px 20px; font-size: 15px; line-height: normal; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; margin-right: 30px; text-decoration: initial; "><?=lang('send_latter')?></a>
                <a href="<?php echo base_url('mydiners/send/' . $event['id']); ?>" style=" background: #5bb75b; padding: 9px 30px; font-size: 15px; line-height: normal; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; background-color: #5bb75b; background-image: -moz-linear-gradient(top, #62c462, #51a351); background-image: -ms-linear-gradient(top, #62c462, #51a351); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#62c462), to(#51a351)); background-image: -webkit-linear-gradient(top, #62c462, #51a351); background-image: -o-linear-gradient(top, #62c462, #51a351); background-image: linear-gradient(top, #62c462, #51a351); background-repeat: repeat-x; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25); color: #fff; text-decoration: initial; margin-right: 30px; "><?=lang('send_now')?></a>
                <a href="<?php echo base_url('mydiners/dinermessages'); ?>" style=" display: inline-block; padding: 4px 10px 4px; margin-bottom: 0; font-size: 13px; line-height: 18px; color: #333333; text-align: center; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75); vertical-align: middle; background-color: #f5f5f5; background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6); background-image: -ms-linear-gradient(top, #ffffff, #e6e6e6); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6)); background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6); background-image: -o-linear-gradient(top, #ffffff, #e6e6e6); background-image: linear-gradient(top, #ffffff, #e6e6e6); background-repeat: repeat-x;  border-color: #e6e6e6 #e6e6e6 #bfbfbf; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);  border: 1px solid #cccccc; border-bottom-color: #b3b3b3; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05); -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05); box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05); cursor: pointer; padding: 8px 20px; font-size: 15px; line-height: normal; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; text-decoration: initial; "><?=lang('cancel')?></a>
            </div>
        <?php } ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#E2E2E2" style="background-color:#E2E2E2; margin:0; padding:0; width:100% !important; line-height: 100% !important;">
            <tr>
                <td align="center"><table cellpadding="0" cellspacing="0" border="0" width="640" bgcolor="#ffffff">
                        <tr>
                            <td colspan="2" style="background:#E2E2E2">
                                <center>
                                    <p style="color:#646464;margin-bottom: 10px;font-size: 11px;font-family:Arial, Helvetica, sans-serif;">
                                        You received this email because you signed up for Sufrati newsletter.<br/>
                                        The email is not displayed properly?&nbsp;&nbsp;<a href="<?php echo base_url('newsletter/event/' . $event['id']); ?>" target="_blank" style="color:#222;padding:0;">View the online version</a>
                                    </p>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" style="padding:10px 0 10px 15px;background: #FFFFFF;border-top: 1px solid #EAE9E9;border-left: 1px solid #D4D2D3;" valign="top">
                                <a href="<?php echo base_url(); ?>" title="<?php echo $sitename; ?>">
                                    <img src="http://uploads.azooma.co/logos/<?php echo $rest['rest_Logo']; ?>" height="100" alt="<?php echo ($rest['rest_Name']); ?>" title="<?php echo ($rest['rest_Name']); ?>" style="vertical-align:top;outline:none;border:none"/>
                                </a>
                            </td>
                            <td align="" style="padding:10px 20px 10px 0px;background: #FFFFFF;border-top: 1px solid #EAE9E9;border-right: 1px solid #B2B1B1;" valign="top">

                                <table cellpadding="0" cellspacing="0" border="0" width="100%" >
                                    <tr>
                                        <td colspan="3">
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%" >
                                                <tr>
                                                    <td style=" font-size: 17px; font-weight: normal; font-family: Arial, Helvetica, sans-serif; ">Brought you by</td>
                                                    <td>
                                                        <a href="<?php echo base_url(); ?>" title="<?php echo $sitename; ?>">
                                                            <img src="<?php echo $this->config->item('sa_url'); ?>/images/smallheaderlogo.png" height="50" alt="<?php echo ($rest['rest_Name']); ?>" title="<?php echo ($rest['rest_Name']); ?>" style="vertical-align:top;outline:none;border:none"/>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td >
                                            <a style="display: inline-block;margin-bottom: 4px;" href="https://itunes.apple.com/us/app/sufrati-lite/id709229893" title="Sufrati Lite" target="_blank"> 
                                                <img src="http://uploads.azooma.co/newsletter/badge_app_store.png" width="120" alt="Sufrati Lite" style="outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;border:none;"/> 
                                            </a>
                                        </td>
                                        <td> 
                                            <a href="https://play.google.com/store/apps/details?id=com.LetsEat.SufratiLite" title="Sufrati Lite" target="_blank"> 
                                                <img src="http://uploads.azooma.co/newsletter/badge_google_play.png" width="120" alt="Sufrati Lite" style="outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;border:none;"/> 
                                            </a>
                                        </td>
                                        <td width="15" height="20"></td>
                                    </tr>

                                </table>

                            </td>

                        </tr>
                        <tr>
                            <td colspan="2" align="left" style="background:#e60683;border-right: 1px solid #D4D2D3;border-left: 1px solid #D4D2D3;height:28px;">
                                <table cellpadding="0" cellspacing="0" border="0" width="698" style="padding:8px 0px;">
                                    <tr>
                                        <td width="23"></td>
                                        <td style="color:#fff;font-size:14px;line-height:16px;height:20px;"><span style="font-weight:bold;font-size: 17px;line-height: 19px;">
                                                <?php
                                                echo ($event['subject']);
                                                ?>
                                            </span></td>
                                        <td width="30"></td>
                                    </tr>
                                </table></td>
                        </tr>
                        <tr>
                            <td colspan="2" >&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" height="5">
                                <table cellpadding="3" cellspacing="0" border="0" width="690" align="center">
                                    <tr>
                                        <td colspan="2"style="padding:0px 20px;" >
                                            <div style="font-size:13px;line-height:20px;color:#646464;padding-bottom: 10px;">
                                                <?php
                                                echo nl2br(($event['message']));
                                                ?>
                                            </div>
                                            <?php if (isset($event['image']) && !empty($event['image'])) { ?>
                                                <div>
                                                    <img src="<?php echo base_url('images/' . $event['image']); ?>" width="640" alt="500"/>
                                                </div>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" >&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-size:13px;line-height:20px;color:#646464;padding:0px 20px;line-height:21px;"> Feel free to contact us for any information at <a href="mailto:info@azooma.co" style="color:#00A2B1;">info@azooma.co</a> or call us on <span style="color:#e60683;font-size:18px;"><?php echo $settings['tel']; ?></span>.<br />
                                            If you would like to advertise with us please contact <a href="mailto:sales@sufrati.com" style="color:#00A2B1;">sales@sufrati.com</a>
                                            <td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" >&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="font-size:13px;line-height:20px;color:#646464;padding:0px 20px;"> Thank you
                                                        <td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="font-size:13px;line-height:20px;color:#646464;padding:0px 20px;"> Best regards
                                                                    <td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2" style="font-size:13px;line-height:20px;color:#646464;padding:0px 20px;"> Sufrati Team
                                                                                <td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="2" ></td>
                                                                                    </tr>
                                                                                    </table></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2" height="5" style="background-color:#00a2b1;min-height:5px;"></td>
                                                                        </tr>



                                                                        <tr height="100px"  style="color:#646464; background-color:whitesmoke;">
                                                                            <td width="410" align="left" valign="bottom" style=" padding:20px 30px 5px;font-size:12px; ">

                                                                                <strong><?php echo $sitename; ?></strong><br />
                                                                                <?php echo $settings['address']; ?>
                                                                                <br /><br/>
                                                                                Telephone: <?php echo $settings['tel']; ?><br />
                                                                                Mobile: <?php echo $settings['mobile']; ?><br />
                                                                                Fax: <?php echo $settings['fax']; ?><br />
                                                                                Email:<a href="mailto:<?php echo $settings['email']; ?>" style="color:#000;"><?php echo $settings['email']; ?></a>
                                                                                <p>

                                                                                    <a href="<?php echo base_url('contact'); ?>" target="_blank">
                                                                                        Contact Us
                                                                                    </a>

                                                                                    &nbsp;&nbsp;|&nbsp;&nbsp; <a href="<?php echo base_url('newsletter/unsubscribe/[id]#gone'); ?>" title="Unsubscribe" target="_blank"> Unsubscribe </a>

                                                                                </p>
                                                                            </td>
                                                                            <td width="290" align="right" valign="bottom" style=" padding:20px 30px 5px;">
                                                                                <table>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <h4 style="font-size:15px;margin:0 0 10px;">Connect With Us</h4>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td align="right">
                                                                                            <?php if ($settings['facebook'] != "") { ?>
                                                                                                <a style="text-decoration:none;" href="<?php echo $settings['facebook']; ?>" target="_blank"> <img src="http://uploads.azooma.co/newsletter/facebook-icon.jpg" width="30" border="0" height="30" alt="Sufrati Facebook Page"/> </a>&nbsp;
                                                                                            <?php } ?>
                                                                                            <?php if ($settings['twitter'] != "") { ?>
                                                                                                <a style="text-decoration:none;" href="<?php echo $settings['twitter']; ?>" target="_blank"> <img src="http://uploads.azooma.co/newsletter/twitter-icon.jpg" width="30" border="0" height="30" alt="Sufrati Twitter Profile"/> </a>&nbsp;
                                                                                            <?php } ?>
                                                                                            <?php if ($settings['linkedin'] != "") { ?>
                                                                                                <a style="text-decoration:none;" href="<?php echo $settings['linkedin']; ?>" target="_blank"> <img src="http://uploads.azooma.co/newsletter/linkin-icon.jpg" width="30" height="30" border="0" alt="Sufrati Linkedin Profile"/> </a>&nbsp;
                                                                                            <?php } ?>
                                                                                            <?php if ($settings['youtube'] != "") { ?>
                                                                                                <a href="<?php echo $settings['youtube']; ?>" style="text-decoration:none;" target="_blank"> <img src="http://uploads.azooma.co/newsletter/youtube-icon.jpg" width="30" height="30" border="0" alt="Sufrati Youtube Channel"/> </a>&nbsp;
                                                                                            <?php } ?>
                                                                                            <?php if ($settings['instagram'] != "") { ?>
                                                                                                <a href="<?php echo $settings['instagram']; ?>" style="text-decoration:none;" target="_blank"> <img src="http://uploads.azooma.co/newsletter/instagram-icon.png" width="32" height="32" border="0" alt="Instagram Profile"/> </a>&nbsp;
                                                                                            <?php } ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td colspan="2" style="min-height:20px !important;background-color:whitesmoke;"> 
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="whitesmoke" style="background-color:whitesmoke; margin:0; padding:0; width:100% !important; line-height: 100% !important;">
                                                                                    <tr>
                                                                                        <td width="30" style="width:30px;"></td>
                                                                                        <td style="color:#646464;font-size:11px;">
                                                                                            <p>
                                                                                                Please do not reply directly to this email. This email was sent from a notification-only address that cannot accept incoming email
                                                                                            </p>
                                                                                            <p>
                                                                                                To the best of our knowledge, all information and offers contained in this email are correct at the time of distribution.
                                                                                                However, for the most up-to-date information we recommend you check <a href="<?php echo base_url(); ?>">sufrati.com</a>
                                                                                            </p>
                                                                                            <p>
                                                                                                &copy; <?php echo date('Y'); ?> Sufrati.com. All rights reserved. Sufrati , the Sufrati logo, the Chef and the Waiter images are either registered trademarks or trademarks of Sufrati.com in Saudi Arabia and/or other countries.
                                                                                            </p>
                                                                                        </td>
                                                                                        <td width="30" style="width:30px;"></td>
                                                                                    </tr>
                                                                                </table>

                                                                            </td>
                                                                        </tr>



                                                                        <tr>
                                                                            <td height="20" colspan="2" style="min-height:20px !important;background-color:whitesmoke;"></td>
                                                                        </tr>
                                                                        </table></td>
                                                            </tr>
                                                            </table></td>
                                                </tr>
                                                <tr>
                                                    <td height="50"></td>
                                                </tr>
                                                </table>
                                                </body>
                                                </html>