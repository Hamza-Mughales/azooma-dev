<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title.' - '.$sitename;?></title>
<style media="all" type="text/css">
table td {
	border-collapse: collapse;
}
td {
	font-family:Arial, Helvetica, sans-serif;
}
</style>
</head>
<body style="margin:0;padding:0;-webkit-text-size-adjust:none;width:100% !important;font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000 !important;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#00a2b1" style="background-color:#00a2b1; margin:0; padding:0; width:100% !important; line-height: 100% !important;">
  <tr>
    <td align="center"><table cellpadding="0" cellspacing="0" border="0" width="640" bgcolor="#ffffff">
        <tr>
          <td><table cellpadding="0" cellspacing="0" border="0" width="640">
              <tr>
                <td colspan="2" style="background:#00a2b1" height="20"></td>
              </tr>
              <tr>
                <td colspan="2" align="left" style="padding:20px 20px;" valign="top"><a href="<?php echo $this->config->item('sa_url');?>" title="<?php echo $settings['name'];?>"> <img src="<?php echo $this->config->item('sa_url');?>images/<?php echo $logo['image'];?>" height="75" alt="<?php echo $settings['name'];?>" style="outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;border:none;"/> </a></td>
              </tr>
              <tr>
                <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
              </tr>
              <tr>
                <td align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding-left:20px; padding-right:10px; padding-top:12px;" colspan="2"><h1 style="color:#000;">Great News!</h1></td>
              </tr>
              <tr align="left"  valign="top">
                <td colspan="2" style="padding:20px 20px"><h1 style="font-family:Arial, Helvetica, sans-serif;font-size:25px;color:#000;"> Dear Sufrati.com </h1></td>
              </tr>
              <tr>
                <td colspan="2" height="5"><table cellpadding="3" cellspacing="0" border="0" width="600" align="center">
                    <tr>
                      <td height="18" colspan="2" style="font-family:Arial, Helvetica, sans-serif;" ><?php echo $restname; ?> has just started managing his restaurant profile using the restaurant control panel.  </td>
                    </tr>
                    <tr>
                      <td colspan="2" height="10px"><table cellpadding="3" cellspacing="0" border="0" width="600" align="left">
                          <tr>
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;" width="30%"><strong>Restaurant Name: </strong></td>
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;" width="70%"><a href="<?php echo $this->config->item('sa_url').'rest/'.$restaurant['seo_url'];?>" > <?php echo $restname;?></a></td>
                          </tr>
                          <tr>
                            <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                          </tr>
                          <tr>
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;" width="30%"><strong>Name: </strong></td>
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;" width="70%"><?php echo stripslashes($rows['full_name']); ?> </td>
                          </tr>
                          <tr>
                            <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                          </tr>
                          <tr>
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;" width="30%"><strong>Email: </strong></td>
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;" width="70%"><?php echo str_replace(",","<br>", $rows['email']); ?></td>
                          </tr>
                          <tr>
                            <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                          </tr>
                          <tr>
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;" width="30%"><strong>Phone: </strong></td>
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;" width="70%"><?php echo $rows['phone'];?></td>
                          </tr>
                          <tr>
                            <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                          </tr>
                          <tr>
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;" width="30%"><strong>Designation: </strong></td>
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;" width="70%"><?php echo stripslashes($rows['your_Position']); ?></td>
                          </tr> 
                          <tr>
                            <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                          </tr>
                          <tr>
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;" width="30%"><strong>Location: </strong></td>
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;" width="70%"><?php echo stripslashes($restaurant['city']); ?></td>
                          </tr>                          
                          <tr>
                            <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td colspan="2" ></td>
                    </tr>
                    <tr>
                      <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;font-weight:bold;color:#000;" colspan="2" height="20px">Please make sure that you call them to ask about the user experience, if they would like assistance and inform them of our other services. </td>
                    </tr>
                    <tr>
                      <td colspan="2"><ul style="font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:21px;">
                          <li>Professional Food Photography Services </li>
                          <li>Professional HD VIDEO Services</li>
                          <li>Web design Services </li>
                          <li>Graphic Design Services (menu, logo, brochures, flyers etc...)</li>
                          <li>Printing production & Signage fabrication</li>
                        </ul></td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;"> Keep up the great work.</td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;"> Thank you, </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;"> Best regards </td>
                    </tr>
                    <tr>
                      <td colspan="2" height="10" style="padding-bottom:10px;" ></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td colspan="2" height="5" style="background-color:#00a2b1;min-height:5px;"></td>
              </tr>
              <tr height="100px"  style="color:#646464; background-color:whitesmoke;">
                <td width="330" align="left" valign="bottom" style=" padding:20px 20px; "><strong><?php echo $settings['name'];?></strong><br />
                  <?php echo $settings['address'];?> <br />
                  <br/>
                  Telephone: <?php echo $settings['tel'];?><br />
                  Telephone 2: <?php echo $settings['mobile'];?><br />
                  Email:<a href="mailto:<?php echo $settings['email'];?>" style="color:#000;"><?php echo $settings['email'];?></a></td>
                <td align="right" style=" padding:20px 30px;" valign="bottom"><table>
                    <tr>
                      <td><h4 style="font-size:15px;margin:0 0 10px;">Connect With Us</h4></td>
                    </tr>
                    <tr>
                      <td align="right"><?php if($settings['facebook']!=""){ ?>
                        <a style="text-decoration:none;" href="<?php echo $settings['facebook'];?>" target="_blank"> <img src="http://uploads.azooma.co/stat/facebook-trans-32.png" width="32" border="0" height="32" alt="Sufrati Facebook Page"/> </a>
                        <?php } ?>
                        <?php if($settings['twitter']!=""){ ?>
                        <a style="text-decoration:none;" href="<?php echo $settings['twitter'];?>" target="_blank"> <img src="http://uploads.azooma.co/stat/twitter-trans-32.png" width="32" border="0" height="32" alt="Sufrati Twitter Profile"/> </a>
                        <?php } ?>
                        <?php if($settings['linkedin']!=""){ ?>
                        <a style="text-decoration:none;" href="<?php echo $settings['linkedin'];?>" target="_blank"> <img src="http://uploads.azooma.co/stat/linkedin--trans-32.png" width="32" height="32" border="0" alt="Sufrati Linkedin Profile"/> </a>
                        <?php } ?>
                        <?php if($settings['youtube']!=""){ ?>
                        <a href="<?php echo $settings['youtube'];?>" style="text-decoration:none;" target="_blank"> <img src="http://uploads.azooma.co/stat/youtube-trans-32.png" width="32" height="32" border="0" alt="Sufrati Youtube Channel"/> </a>
                        <?php } ?></td>
                    </tr>
                  </table></td>
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