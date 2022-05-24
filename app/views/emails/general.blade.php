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
                                            <a href="<?php echo Azooma::URL();?>" title="Azooma">
                                                <?php    $logo=DB::table('art_work')->select('image','image_ar')->where('active',1)->where('art_work_name','Azooma Logo')->first();
                                                if(count($logo)>0){
                                                $logoimage= $logo->image?>
                                                <img src="<?php echo Azooma::CDN('sufratilogo/'.$logoimage);?>" height="60" alt="Azooma" style="outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;border:none;"/>
                                                    <?php } ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr align="left"  valign="top">
                                        <td colspan="2" style="padding:20px 30px">
                                            <h1 style="color: #333;font-size:25px;line-height:28px;margin:15px 0;">
                                                <?php echo (isset($heading))?$heading:Lang::get('email.hi');?>
                                            </h1>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" height="100px" valign="top" style="padding:0 30px 20px;">
                                            <table cellpadding="0" cellspacing="0" border="0" width="640">
                                                <?php if(isset($helper)){ ?>
                                                <tr>
                                                    <td style="font-size:16px;">
                                                        <?php echo $helper;?>
                                                    </td>
                                                </tr>
                                                <?php }
                                                if(isset($action)){ ?>
                                                <tr>
                                                    <td align="center" style="padding:20px 0;">
                                                        <table border="0" cellspacing="0" cellpadding="0" style="background:#00a2b1;color: #ffffff;border:1px solid #0993A0;border-radius:3px;">
                                                            <tr>
                                                                <td width="208" height="47" align="center" valign="middle">
                                                                    <a href="<?php echo $actionlink;?>" style="color:#ffffff;font-size:18px;font-weight:bold;text-decoration:none;display:block;line-height:47px;" target="_blank">
                                                                        <span style="color:#ffffff">
                                                                        <?php echo $action;?>
                                                                        </span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td>
                                                        <?php echo (isset($action_helper))?$action_helper:'';?>
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
                                                <a href="<?php echo Azooma::URL('contact');?>" target="_blank">
                                                    Contact Us
                                                </a> | 
                                                <a href="<?php echo $country->facebook;?>" title="Azooma Facebook">Facebook</a> | 
                                                <a href="<?php echo $country->twitter;?>" title="Azooma Twitter">Twitter</a>
                                            </p>
                                        </td>
                                        <td align="right" style=" padding:20px 30px;" valign="bottom">            
                                            <table>
                                                <tr>
                                                    <td>
                                                        <a href="https://itunes.apple.com/us/app/Azooma-lite/id709229893?ls=1&mt=8" title="Download Azooma for iOS">
                                                            <img src="<?php echo Azooma::CDN('stat/appstore-135.jpg');?>" alt="Azooma for iOS" height="40" width="135"/>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="https://play.google.com/store/apps/details?id=com.LetsEat.AzoomaLite" title="Download Azooma for Android">
                                                            <img src="<?php echo Azooma::CDN('stat/googleplay-135.jpg');?>" alt="Azooma for Android" height="40" width="135"/>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="background-color:whitesmoke;padding:5px 30px;text-align:center;color:#666;line-height:18px;">
                                            &copy; <?php echo date('Y');?> Azooma<br/>
                                            Tel:- <?php echo $country->telephone;?><br/>
                                            <?php echo $country->address;?>
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