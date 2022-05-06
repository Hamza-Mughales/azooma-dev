<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
            Sufrati
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
                                            <a href="<?php echo Azooma::URL();?>" title="Sufrati">
                                                <img src="<?php echo Azooma::CDN('sufratilogo/'.$logoimage);?>" height="60" alt="Sufrati" style="outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;border:none;"/>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr align="left"  valign="top">
                                        <td colspan="2" style="padding:20px 30px">
                                            <h1 style="color: #333;font-size:25px;line-height:28px;margin:15px 0;">
                                                Hi <?php echo $followedusername;?>
                                            </h1>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" height="100px" valign="top" style="padding:0 30px 20px;">
                                            <table cellpadding="0" cellspacing="0" border="0" width="640">
                                                <tr>
                                                    <td style="font-size:16px;">
                                                        <?php echo Lang::get('email.new_follower_on',array(),$lang); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="15">
                                                    </td>
                                                </tr>
                                                <?php
                                                $place="";
                                                if(is_numeric($currentuser->user_City)){
                                                    $city=DB::table('city_list')->select('city_Name','city_Name_Ar','city_ID')->first();
                                                    if($lang=="en"){
                                                        $place=$city->city_Name.', '.$country->name;    
                                                    }else{
                                                        $place=$city->city_Name_Ar.', '.$country->nameAr;
                                                    }
                                                    
                                                }else{
                                                    if($currentuser->user_City!=""){
                                                        $place=$currentuser->user_City;
                                                    }
                                                }
                                                $currentuserimage=($currentuser->image!="")?stripcslashes($currentuser->image):'user-default.svg';
                                                $totalfollowers=User::getTotalFollowers($currentuser->user_ID);
                                                $totalfollowing=User::getTotalFollowing($currentuser->user_ID);
                                                $totalcomments=User::getTotalComments($currentuser->user_ID);
                                                $totalratings=User::getTotalRatings($currentuser->user_ID);
                                                ?>
                                                <tr>
                                                    <td>
                                                        <table cellpadding="0" cellspacing="0" border="0" width="640">
                                                            <tr>
                                                                <td width="90">
                                                                    <a href="<?php echo Azooma::URL('user/'.$currentuser->user_ID);?>" title="<?php echo $currentusername;?>">
                                                                        <img src="<?php echo Azooma::CDN('images/100/'.$currentuserimage);?>" alt="<?php echo $currentusername;?>" width="80" height="80" style="width:80px;height:80px;border:1px solid #ccc;padding:3px;"/>
                                                                    </a>
                                                                </td>
                                                                <td width="15"></td>
                                                                <td valign="top">
                                                                    <table cellpadding="2" cellspacing="2" border="0" valign="top">
                                                                        <tr>
                                                                            <td style="font-size:15px;">
                                                                                <a href="<?php echo Azooma::URL('user/'.$currentuser->user_ID);?>" title="<?php echo $currentusername;?>"><b><?php echo $currentusername;?></b></a>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <?php if($place!=""){ echo $place; }?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <?php echo $totalfollowers.' '.Lang::get('messages.followers',array(),$lang);?> | <?php echo $totalfollowing.' '.Lang::get('messages.following',array(),$lang);?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <?php echo $totalcomments.' '.Lang::get('messages.reviews',array(),$lang);?> | <?php echo $totalratings.' '.Lang::get('messages.ratings',array(),$lang);?>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
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
                                                <a href="<?php echo Azooma::URL('contact');?>" target="_blank">
                                                    Contact Us
                                                </a> | 
                                                <a href="<?php echo $country->facebook;?>" title="Sufrati Facebook">Facebook</a> | 
                                                <a href="<?php echo $country->twitter;?>" title="Sufrati Twitter">Twitter</a>
                                            </p>
                                        </td>
                                        <td align="right" style=" padding:20px 30px;" valign="bottom">            
                                            <table>
                                                <tr>
                                                    <td>
                                                        <a href="https://itunes.apple.com/us/app/sufrati-lite/id709229893?ls=1&mt=8" title="Download Sufrati for iOS">
                                                            <img src="<?php echo Azooma::CDN('stat/appstore-135.jpg');?>" alt="Sufrati for iOS" height="40" width="135"/>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="https://play.google.com/store/apps/details?id=com.LetsEat.SufratiLite" title="Download Sufrati for Android">
                                                            <img src="<?php echo Azooma::CDN('stat/googleplay-135.jpg');?>" alt="Sufrati for Android" height="40" width="135"/>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="background-color:whitesmoke;padding:5px 30px;text-align:center;color:#666;line-height:18px;">
                                            &copy; <?php echo date('Y');?> Sufrati<br/>
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