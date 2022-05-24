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
                                        <td colspan="2" align="left" valign="top">
                                            <a href="<?php echo Azooma::URL();?>" title="Azooma">
                                                <img src="<?php echo Azooma::CDN('stat/sufrati_occasions.jpg');?>" width="730" alt="Azooma" style="outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;border:none;"/>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" height="100px" valign="top" style="padding:0 30px 20px;">
                                            <table cellpadding="0" cellspacing="0" border="0" width="640">
                                                <tr>
                                                    <td style="font-size:16px;">
                                                        <?php if(isset($tosufrati)){ ?>
                                                            <h1 style="color: black !important;font-size:25px;line-height:30px;">
                                                                <a href="<?php echo Azooma::URL('user/'.$user->user_ID); ?>"><?php echo stripcslashes($user->user_FullName);?></a> has made a catering order on Azooma <?php echo $user->user_Mobile;?>
                                                            </h1>
                                                        <?php }else{ ?>
                                                            <h1 style="color: black !important;font-size:25px;line-height:30px;">
                                                                Hi <?php echo stripcslashes($user->user_FullName);?>
                                                            </h1>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="15">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <?php if(isset($tosufrati)){ ?>
                                                        Please carry out the necessary steps
                                                        <ol>
                                                            <li>
                                                                Confirm the Event details.
                                                            </li>
                                                            <li>
                                                                Confirm the Addditional requirements.
                                                            </li>
                                                        </ol>
                                                        <?php }else{ ?>
                                                        You've ordered for an event through azooma.co, here is the summary of what you've ordered.
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="25">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table width="670" cellpadding="8" cellspacing="0" style="font-size:14px;line-height:17px;">
                                                            <tr style="font-weight:bold;">
                                                                <td width="180" style="border:1px solid #ccc;border-right-width:0px;border-bottom-width:0px;">
                                                                    Reference ID:- 
                                                                </td>
                                                                <td style="border:1px solid #ccc;border-bottom-width:0px;">
                                                                    <?php echo 'SUF000' . $event->id; ?>
                                                                </td>
                                                            </tr>
                                                            <?php if (isset($tosufrati)) { ?>
                                                                <tr>
                                                                    <td style="border:1px solid #ccc;border-right-width:0px;border-bottom-width:0px;">
                                                                        User
                                                                    </td>
                                                                    <td style="border:1px solid #ccc;border-bottom-width:0px;">
                                                                        <a href="<?php echo Azooma::URL('user/' . $user->user_ID); ?>"><?php echo $user->user_FullName; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $user->user_Mobile;?> - <?php echo $user->user_Email;?>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                            <tr>
                                                                <td style="border:1px solid #ccc;border-right-width:0px;border-bottom-width:0px;">
                                                                    Event Title
                                                                </td>
                                                                <td style="border:1px solid #ccc;border-bottom-width:0px;">
                                                                    <?php echo $event->name; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border:1px solid #ccc;border-right-width:0px;border-bottom-width:0px;">
                                                                    Event Type
                                                                </td>
                                                                <td style="border:1px solid #ccc;border-bottom-width:0px;">
                                                                    <?php echo $event->type; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border:1px solid #ccc;border-right-width:0px;border-bottom-width:0px;">
                                                                    Total number of Guests
                                                                </td>
                                                                <td style="border:1px solid #ccc;border-bottom-width:0px;">
                                                                    <?php echo $event->guests; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border:1px solid #ccc;border-right-width:0px;border-bottom-width:0px;">
                                                                    Budget per person
                                                                </td>
                                                                <td style="border:1px solid #ccc;border-bottom-width:0px;">
                                                                    <?php echo $event->budget; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border:1px solid #ccc;border-right-width:0px;border-bottom-width:0px;">
                                                                    Event Date
                                                                </td>
                                                                <td style="border:1px solid #ccc;border-bottom-width:0px;">
                                                                    <?php echo date('d/m/Y',strtotime($event->date)); ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border:1px solid #ccc;border-right-width:0px;border-bottom-width:0px;">
                                                                    Event Venue
                                                                </td>
                                                                <td style="border:1px solid #ccc;border-bottom-width:0px;">
                                                                    <?php echo $event->eventVenue; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border:1px solid #ccc;border-right-width:0px;border-bottom-width:0px;">
                                                                    Location
                                                                </td>
                                                                <td style="border:1px solid #ccc;border-bottom-width:0px;">
                                                                    <?php echo $event->location; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border:1px solid #ccc;border-right-width:0px;border-bottom-width:0px;">
                                                                    Event Meal Time
                                                                </td>
                                                                <td style="border:1px solid #ccc;border-bottom-width:0px;">
                                                                    <?php echo $event->mealType; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border:1px solid #ccc;border-right-width:0px;border-bottom-width:0px;">
                                                                    Cuisines
                                                                </td>
                                                                <td style="border:1px solid #ccc;border-bottom-width:0px;">
                                                                    <?php
                                                                    $cuisines = explode(',', $event->cuisines);
                                                                    $k = 0;
                                                                    foreach ($cuisines as $csn) {
                                                                        $k++;
                                                                        $cuisine = DB::table('cuisine_list')->select('cuisine_Name')->where('cuisine_ID',$csn)->first();
                                                                        echo $cuisine->cuisine_Name;
                                                                        if ($k != count($cuisines)) {
                                                                            echo ', ';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border:1px solid #ccc;border-right-width:0px;border-bottom-width:0px;">
                                                                    Meal Courses
                                                                </td>
                                                                <td style="border:1px solid #ccc;border-bottom-width:0px;">
                                                                    <?php echo $event->meals; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border:1px solid #ccc;border-right-width:0px;border-bottom-width:0px;">
                                                                    Beverage
                                                                </td>
                                                                <td style="border:1px solid #ccc;border-bottom-width:0px;">
                                                                    <?php echo $event->beverage; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border:1px solid #ccc;border-right-width:0px;border-bottom-width:0px;">
                                                                    Serving Style
                                                                </td>
                                                                <td style="border:1px solid #ccc;border-bottom-width:0px;">
                                                                    <?php echo $event->servingStyle; ?>
                                                                </td>
                                                            </tr>
                                                            <?php if ($event->eventVenue == "On Site") { ?>
                                                                <tr>
                                                                    <td style="border:1px solid #ccc;border-right-width:0px;border-bottom-width:0px;">
                                                                        Dining SetUp
                                                                    </td>
                                                                    <td style="border:1px solid #ccc;border-bottom-width:0px;">
                                                                        <?php echo $event->diningSetup; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border:1px solid #ccc;border-right-width:0px;border-bottom-width:0px;">
                                                                        Staff Requirements
                                                                    </td>
                                                                    <td style="border:1px solid #ccc;border-bottom-width:0px;">
                                                                        <?php echo $event->staffReq; ?>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                            <tr>
                                                                <td style="border:1px solid #ccc;border-right-width:0px;">
                                                                    Additional Notes
                                                                </td>
                                                                <td style="border:1px solid #ccc;">
                                                                    <?php echo $event->notes; ?>
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