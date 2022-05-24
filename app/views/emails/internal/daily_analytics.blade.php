<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
            Azooma Daily Report
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
                                                <img src="<?php echo Azooma::CDN('sufratilogo/'.$logoimage);?>" height="60" alt="Azooma" style="outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;border:none;"/>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" height="1px" style="border-bottom:1px dashed #ccc;">
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" valign="top" style="padding:22px 30px 10px;">
                                            <table cellpadding="0" cellspacing="0" border="0" width="640">
                                                <tr>
                                                    <td width="400" style="font-size:20px;color:#000000;line-height:23px;">
                                                        <strong>
                                                        <?php echo date('dS F Y',strtotime($date));?>,</strong> Report 
                                                    </td>
                                                    <td width="240" style="font-size:12px;color:#4c4c4c;text-align:right;">
                                                        <?php echo date('dS F Y',strtotime($date));?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="20" colspan="2">
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="font-size:20px;color:#000000;line-height:23px;">
                                                       <strong> Yesterday's </strong> Page Traffic 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="20" colspan="2">
                                                        
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" valign="top" style="padding:0px 30px 20px;">
                                            <table cellpadding="0" cellspacing="0" border="0" width="640">
                                            <tr>
                                                <td width="210">
                                                    <table width="210" cellpadding="0" cellspacing="0" border="0" >
                                                        <tr>
                                                            <td width="54">
                                                                <img src="http://uploads.azooma.co/stat/fa-users.png" width="45" height="45" alt="hits">
                                                            </td>
                                                            <td width="10" style="border-left:1px solid #ccc;"></td>
                                                            <td>
                                                                <strong>
                                                                    <?php echo number_format($dailyvisits);?>
                                                                </strong>&nbsp;Visits
                                                                <br/>
                                                                <strong>
                                                                    <?php echo number_format($dailyapphits);?>
                                                                </strong>&nbsp;App Hits
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="210">
                                                    <table width="210" cellpadding="0" cellspacing="0" border="0" >
                                                        <tr>
                                                            <td width="54">
                                                                <img src="http://uploads.azooma.co/stat/fa-bar-charts.png" width="45" height="45" alt="hits">
                                                            </td>
                                                            <td width="10" style="border-left:1px solid #ccc;"></td>
                                                            <td>
                                                                <strong>
                                                                    <?php echo number_format($totalvisits);?>
                                                                </strong>&nbsp;Total Visits
                                                                <br/>
                                                                <strong>
                                                                    <?php echo number_format($totalapphits);?>
                                                                </strong>&nbsp;Total App Hits
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width="210">
                                                    <table width="210" cellpadding="0" cellspacing="0" border="0" >
                                                        <tr>
                                                            <td width="54">
                                                                <img src="http://uploads.azooma.co/stat/fa-search.png" width="45" height="45" alt="hits">
                                                            </td>
                                                            <td width="10" style="border-left:1px solid #ccc;"></td>
                                                            <td>
                                                                <strong>
                                                                    <?php echo (100-$trafficdetails).'%';?>
                                                                </strong>&nbsp;Search traffic
                                                                <br/>
                                                                <strong>
                                                                    <?php echo $trafficdetails.'%';?>
                                                                </strong>&nbsp;Direct Traffic
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" height="10" style="height:10px;"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" height="1px" style="border-bottom:1px dashed #ccc;">
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" height="20" style="height:20px;"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" valign="top" style="padding:0px 30px 20px;font-size:20px;line-height:21px;">
                                        <strong>Yesterday's</strong> Activity
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" valign="top" style="padding:0px 30px 20px;">
                                        <table cellspacing="0" border="0" width="640">
                                            <tr>
                                                <td width="200">
                                                    <table width="100%" style="background:#f5f5f5;border:1px solid #ddd;" border="0" align="center" cellpadding="0" cellspacing="0">
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                        <tr>
                                                            <td width="10"></td>
                                                            <td>
                                                                <?php echo $newusers;?> New Users    
                                                            </td>
                                                            <td width="10"></td>
                                                        </tr>
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                    </table>
                                                </td>
                                                <td width="20">
                                                    
                                                </td>
                                                <td width="200">
                                                    <table width="100%" style="background:#f5f5f5;border:1px solid #ddd;" border="0" align="center" cellpadding="0" cellspacing="0">
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                        <tr>
                                                            <td width="10"></td>
                                                            <td>
                                                                <?php echo $comments;?> New Comments 
                                                            </td>
                                                            <td width="10"></td>
                                                        </tr>
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                    </table>
                                                </td>
                                                <td width="20">
                                                    
                                                </td>
                                                <td width="200">
                                                    <table width="100%" style="background:#f5f5f5;border:1px solid #ddd;" border="0" align="center" cellpadding="0" cellspacing="0">
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                        <tr>
                                                            <td width="10"></td>
                                                            <td>
                                                                <?php echo $ratings;?> New Ratings  
                                                            </td>
                                                            <td width="10"></td>
                                                        </tr>
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" height="20"></td>
                                            </tr>
                                            <tr>
                                                <td width="200">
                                                    <table width="100%" style="background:#f5f5f5;border:1px solid #ddd;" border="0" align="center" cellpadding="0" cellspacing="0">
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                        <tr>
                                                            <td width="10"></td>
                                                            <td>
                                                                <?php echo $menudownloads;?> Menu Downloads
                                                            </td>
                                                            <td width="10"></td>
                                                        </tr>
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                    </table>
                                                </td>
                                                <td width="20"></td>
                                                <td width="200">
                                                    <table width="100%" style="background:#f5f5f5;border:1px solid #ddd;" border="0" align="center" cellpadding="0" cellspacing="0">
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                        <tr>
                                                            <td width="10"></td>
                                                            <td>
                                                                <?php echo $websiteclicks;?> Website Referrals
                                                            </td>
                                                            <td width="10"></td>
                                                        </tr>
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                    </table>
                                                </td>
                                                <td width="20"></td>
                                                <td width="200">
                                                    <table width="100%" style="background:#f5f5f5;border:1px solid #ddd;" border="0" align="center" cellpadding="0" cellspacing="0">
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                        <tr>
                                                            <td width="10"></td>
                                                            <td>
                                                                <?php echo $menurequests;?> Menu Requests
                                                            </td>
                                                            <td width="10"></td>
                                                        </tr>
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" height="20"></td>
                                            </tr>
                                            <tr>
                                                <td width="200">
                                                    <table width="100%" style="background:#f5f5f5;border:1px solid #ddd;" border="0" align="center" cellpadding="0" cellspacing="0">
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                        <tr>
                                                            <td width="10"></td>
                                                            <td>
                                                                <?php echo $dailyappdownloads;?> App Downloads
                                                            </td>
                                                            <td width="10"></td>
                                                        </tr>
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                    </table>
                                                </td>
                                                <td width="20"></td>
                                                <td width="200">
                                                    <table width="100%" style="background:#f5f5f5;border:1px solid #ddd;" border="0" align="center" cellpadding="0" cellspacing="0">
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                        <tr>
                                                            <td width="10"></td>
                                                            <td>
                                                                <?php echo $dailyiosdownloads;?> iOS
                                                            </td>
                                                            <td width="10"></td>
                                                        </tr>
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                    </table>
                                                </td>
                                                <td width="20"></td>
                                                <td width="200">
                                                    <table width="100%" style="background:#f5f5f5;border:1px solid #ddd;" border="0" align="center" cellpadding="0" cellspacing="0">
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                        <tr>
                                                            <td width="10"></td>
                                                            <td>
                                                                <?php echo $dailyandroiddownloads;?> Android
                                                            </td>
                                                            <td width="10"></td>
                                                        </tr>
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" height="20"></td>
                                            </tr>
                                            <tr>
                                                <td width="200">
                                                    <table width="100%" style="background:#f5f5f5;border:1px solid #ddd;" border="0" align="center" cellpadding="0" cellspacing="0">
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                        <tr>
                                                            <td width="10"></td>
                                                            <td>
                                                                <?php echo $newrestaruants;?> New Restaurants
                                                            </td>
                                                            <td width="10"></td>
                                                        </tr>
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                    </table>
                                                </td>
                                                <td width="20"></td>
                                                <td width="200">
                                                    <table width="100%" style="background:#f5f5f5;border:1px solid #ddd;" border="0" align="center" cellpadding="0" cellspacing="0">
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                        <tr>
                                                            <td width="10"></td>
                                                            <td>
                                                                <?php echo $photos;?> New Photos
                                                            </td>
                                                            <td width="10"></td>
                                                        </tr>
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                    </table>
                                                </td>
                                                <td width="20"></td>
                                                <td width="200">
                                                    <table width="100%" style="background:#f5f5f5;border:1px solid #ddd;" border="0" align="center" cellpadding="0" cellspacing="0">
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                        <tr>
                                                            <td width="10"></td>
                                                            <td>
                                                                <?php echo $dailyevents;?> Catering Orders
                                                            </td>
                                                            <td width="10"></td>
                                                        </tr>
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" height="10" style="height:10px;"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" height="1px" style="border-bottom:1px dashed #ccc;">
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" height="20" style="height:20px;"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" valign="top" style="padding:0px 30px 20px;font-size:20px;line-height:21px;">
                                        <strong>Azooma Member</strong> Status
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" valign="top" style="padding:0px 30px 20px;">
                                            <table cellspacing="0" border="0" width="640">
                                            <tr>
                                                <td width="200">
                                                    <table width="100%" style="background:#f5f5f5;border:1px solid #ddd;" border="0" align="center" cellpadding="0" cellspacing="0">
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                        <tr>
                                                            <td width="10"></td>
                                                            <td>
                                                                <?php echo $newbronze;?> New Bronze Member
                                                            </td>
                                                            <td width="10"></td>
                                                        </tr>
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                    </table>
                                                </td>
                                                <td width="20">
                                                    
                                                </td>
                                                <td width="200">
                                                    <table width="100%" style="background:#f5f5f5;border:1px solid #ddd;" border="0" align="center" cellpadding="0" cellspacing="0">
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                        <tr>
                                                            <td width="10"></td>
                                                            <td>
                                                                <?php echo $newsilver;?> New Silver Member
                                                            </td>
                                                            <td width="10"></td>
                                                        </tr>
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                    </table>
                                                </td>
                                                <td width="20">
                                                    
                                                </td>
                                                <td width="200">
                                                    <table width="100%" style="background:#f5f5f5;border:1px solid #ddd;" border="0" align="center" cellpadding="0" cellspacing="0">
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                        <tr>
                                                            <td width="10"></td>
                                                            <td>
                                                                <?php echo $newgold;?> New Gold Member
                                                            </td>
                                                            <td width="10"></td>
                                                        </tr>
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" height="20"></td>
                                            </tr>
                                            <tr>
                                                <td width="200">
                                                    <table width="100%" style="background:#f5f5f5;border:1px solid #ddd;" border="0" align="center" cellpadding="0" cellspacing="0">
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                        <tr>
                                                            <td width="10"></td>
                                                            <td>
                                                                <?php echo $totalbronze;?> Total Bronze Member
                                                            </td>
                                                            <td width="10"></td>
                                                        </tr>
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                    </table>
                                                </td>
                                                <td width="20">
                                                    
                                                </td>
                                                <td width="200">
                                                    <table width="100%" style="background:#f5f5f5;border:1px solid #ddd;" border="0" align="center" cellpadding="0" cellspacing="0">
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                        <tr>
                                                            <td width="10"></td>
                                                            <td>
                                                                <?php echo $totalsilver;?> Total Silver Member
                                                            </td>
                                                            <td width="10"></td>
                                                        </tr>
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                    </table>
                                                </td>
                                                <td width="20">
                                                    
                                                </td>
                                                <td width="200">
                                                    <table width="100%" style="background:#f5f5f5;border:1px solid #ddd;" border="0" align="center" cellpadding="0" cellspacing="0">
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                        <tr>
                                                            <td width="10"></td>
                                                            <td>
                                                                <?php echo $totalgold;?> Total Gold Members
                                                            </td>
                                                            <td width="10"></td>
                                                        </tr>
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" height="10" style="height:10px;"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" height="1px" style="border-bottom:1px dashed #ccc;">
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" height="20" style="height:20px;"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" valign="top" style="padding:0px 30px 20px;font-size:20px;line-height:21px;">
                                        <strong>Popular</strong> Cities
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" valign="top" style="padding:0px 30px 20px;">
                                            <?php if(count($popularcities)>0){
                                                ?>
                                                <table cellspacing="0" border="0" width="640">
                                                <tr>
                                                <?php
                                                $i=0;
                                                foreach ($popularcities as $city) {
                                                    $i++;
                                                    ?>
                                                    <td width="200">
                                                    <table width="100%" style="background:#f5f5f5;border:1px solid #ddd;" border="0" align="center" cellpadding="0" cellspacing="0">
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                        <tr>
                                                            <td width="10"></td>
                                                            <td>
                                                                <?php echo $city->city_Name.' - '.$city->visits;?>
                                                            </td>
                                                            <td width="10"></td>
                                                        </tr>
                                                        <tr><td colspan="3" height="10"></td></tr>
                                                    </table>
                                                </td>
                                                <?php if($i!=3){ ?>
                                                <td width="20">
                                                    
                                                </td>
                                                    <?php
                                                }
                                                }
                                                ?>
                                                </tr>
                                                </table>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php if(count($keywords)>0){ ?>
                                    <tr>
                                        <td colspan="2" height="10" style="height:10px;"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" height="1px" style="border-bottom:1px dashed #ccc;">
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" height="20" style="height:20px;"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" valign="top" style="padding:0px 30px 20px;font-size:20px;line-height:21px;">
                                        <strong>Popular Search</strong> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" valign="top">
                                            <?php $i=0; foreach ($keywords as $keyword) { $i++;
                                                echo $keyword->search_term;
                                                if($i>=count($keywords)){
                                                    echo ', ';
                                                }
                                            } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
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