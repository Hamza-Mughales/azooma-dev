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
                <td colspan="2" align="left" style="padding:20px 20px;" valign="top"><a href="<?php echo $this->config->item('sa_url');?>" title="<?php echo $settings['name'];?>"> <img src="<?php echo $this->config->item('sa_url'); ?>images/<?php echo $logo['image'];?>" height="75" alt="<?php echo $settings['name'];?>" style="outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;border:none;"/> </a></td>
              </tr>
              <tr>
                <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
              </tr>
              <tr>
                <td align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding-left:20px; padding-right:10px; padding-top:12px;" colspan="2"><h1>Dear <?php echo ucwords($name); ?>,</h1></td>
              </tr>
              <tr>
                <td colspan="2" height="5"><table cellpadding="3" cellspacing="0" border="0" width="600" align="center">
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:14px;" >
                      		<b><?php echo stripslashes($rest['rest_Name']); ?></b> replied to your <?php echo $link; ?> on azooma.co.
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="18" colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:14px;" ><?php 
					  	$msg=strip_tags($msg);
						$msg=(htmlspecialchars($msg));
						echo $msg;
					  ?></td>
                    </tr>
                    <tr>
                      <td colspan="2" >&nbsp;</td>
                    </tr>                    
                    <tr>
                      <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:14px;"> 
                      <a href="http://www.azooma.co/sa/login" style="display:inline-block;">
                      <img src="http://uploads.azooma.co/newsletter/see-more-btn.png" alt="See more comments" style="outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;border:none;"/>
                      </a> 

                      
                      <td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:14px;"> Thank you, </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:14px;"> Best regards </td>
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
                        <a style="text-decoration:none;" href="<?php echo $settings['facebook'];?>" target="_blank"> <img src="http://uploads.azooma.co/stat/facebook-trans-32.png" width="32" border="0" height="32" alt="Azooma Facebook Page"/> </a>
                        <?php } ?>
                        <?php if($settings['twitter']!=""){ ?>
                        <a style="text-decoration:none;" href="<?php echo $settings['twitter'];?>" target="_blank"> <img src="http://uploads.azooma.co/stat/twitter-trans-32.png" width="32" border="0" height="32" alt="Azooma Twitter Profile"/> </a>
                        <?php } ?>
                        <?php if($settings['linkedin']!=""){ ?>
                        <a style="text-decoration:none;" href="<?php echo $settings['linkedin'];?>" target="_blank"> <img src="http://uploads.azooma.co/stat/linkedin--trans-32.png" width="32" height="32" border="0" alt="Azooma Linkedin Profile"/> </a>
                        <?php } ?>
                        <?php if($settings['youtube']!=""){ ?>
                        <a href="<?php echo $settings['youtube'];?>" style="text-decoration:none;" target="_blank"> <img src="http://uploads.azooma.co/stat/youtube-trans-32.png" width="32" height="32" border="0" alt="Azooma Youtube Channel"/> </a>
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