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
        <body style="margin:0;padding:0;-webkit-text-size-adjust:none;width:100% !important;font-family:Arial, Helvetica, sans-serif;font-size:12px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#00a2b1" style="background-color:#00a2b1; margin:0; padding:0; width:100% !important; line-height: 100% !important;">
          <tr>
            <td align="center"><table cellpadding="0" cellspacing="0" border="0" width="640" bgcolor="#ffffff">
                <tr>
                <td><table cellpadding="0" cellspacing="0" border="0" width="640">
                    <tr>
                    <td colspan="2" style="background:#00a2b1" height="20"></td>
                  </tr>
                    <tr>
                    <td colspan="2" align="left" style="padding:20px 30px;" valign="top"><a href="<?php echo $this->config->item('sa_url');?>" title="<?php echo $settings['name'];?>"> <img src="<?php echo $this->config->item('sa_url');?>images/<?php echo $logo['image'];?>" height="75" alt="<?php echo $settings['name'];?>" style="outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;border:none;"/> </a></td>
                  </tr>
                    <tr align="left"  valign="top">
                    <td colspan="2" style="padding:20px 30px"><h1 style="color: black !important;font-size:25px;"> Hi <?php echo $rest['rest_Name']; ?>, </h1></td>
                  </tr>
                    <tr>
                    <td colspan="2" height="100px" valign="top" style="padding:0 30px 20px;"><?php if($user['user_NickName']!=""){ echo $user['user_NickName']; }else{ echo $user['user_FullName']; } ?>
                        Commented on <a href="<?php echo $this->config->item('sa_url').'rest/'.$rest['seo_url']; ?>"><?php echo $rest['rest_Name']; ?></a> on Sufrati.com <br />
                        <br />
                        <span style="font-size:17px;font-style:italic;line-height:20px;"><?php echo substr($review_Msg,0,25); ?></span>... <a href="<?php echo $this->config->item('sa_url').'rest/'.$rest['seo_url'].'/comments#comment-'.$user_activity_id;?>" style="color:#00A2B1;font-size:12px;" >Read More</a></td>
                  </tr>
                    <tr>
                    <td colspan="2" height="5" style="background-color:#00a2b1;min-height:5px;"></td>
                  </tr>
                    <tr height="100px"  style="color:#646464; background-color:whitesmoke;">
                    <td width="330" align="left" valign="bottom" style=" padding:20px 30px; "><strong><?php echo $settings['name'];?></strong><br />
                        <?php echo $settings['address'];?> <br />
                        <br/>
                        Telephone: <?php echo $settings['tel'];?><br />
                        Mobile: <?php echo $settings['mobile'];?><br />
                        Fax: <?php echo $settings['fax'];?><br />
                        Email:<a href="mailto:<?php echo $settings['email'];?>" style="color:#000;"><?php echo $settings['email'];?></a>
                        </td>
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