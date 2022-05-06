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
<body style="margin:0;padding:0;-webkit-text-size-adjust:none;width:100% !important;font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#646464 !important;">
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
                <td align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding-left:20px; padding-right:10px; padding-top:12px;" colspan="2"><h1 style="color:#000;text-align:right" dir="rtl">أخبار رائعة!</h1></td>
              </tr>
              <tr align="left"  valign="top">
                <td colspan="2" style="padding:20px 20px"><h1 style="font-family:Arial, Helvetica, sans-serif;font-size:25px;color:#000;text-align:right;" dir="rtl"> أعزائي أعضاء الفريق </h1></td>
              </tr>
              <tr>
                <td colspan="2" height="5"><table cellpadding="3" cellspacing="0" border="0" width="600" align="center">
                    <tr>
                      <td height="18" colspan="2" style="font-family:Arial, Helvetica, sans-serif;text-align:right;" dir="rtl" ><?php echo $restnameAr; ?> بدء للتو إدارة ملف تعريف المطعم الخاص به بإستخدام لوحة التحكم  </td>
                    </tr>
                    <tr>
                      <td colspan="2" height="10px"><table cellpadding="3" cellspacing="0" border="0" width="600" align="left">
                          <tr>
                            
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;text-align:right;" dir="rtl" width="70%"><a href="<?php echo $this->config->item('sa_url').'rest/'.$restaurant['seo_url'];?>" > <?php echo $restnameAr;?></a></td>
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;text-align:right;" dir="rtl" width="30%"><strong>إسم المطعم: </strong></td>
                          </tr>
                          <tr>
                            <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                          </tr>
                          <tr>
                            
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;text-align:right;" dir="rtl" width="70%"><?php echo stripslashes($rows['full_name']); ?> </td>
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;text-align:right;" dir="rtl" width="30%"><strong>الاتصال بـ: </strong></td>
                          </tr>
                          <tr>
                            <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                          </tr>
                          <tr>
                            
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;text-align:right;" dir="rtl" width="70%"><?php echo str_replace(",","<br>", $rows['email']); ?></td>
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;text-align:right;" dir="rtl" width="30%"><strong>البريد الإلكتروني: </strong></td>
                          </tr>
                          <tr>
                            <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                          </tr>
                          <tr>
                            
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;text-align:right;" dir="rtl" width="70%"><?php echo $rows['phone'];?></td>
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;text-align:right;" dir="rtl" width="30%"><strong>جوال: </strong></td>
                          </tr>
                          <tr>
                            <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                          </tr>
                          <tr>
                            
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;text-align:right;" dir="rtl" width="70%"><?php echo stripslashes($rows['your_Position']); ?></td>
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;text-align:right;" dir="rtl" width="30%"><strong>Designation: </strong></td>
                          </tr> 
                          <tr>
                            <td colspan="2" style="border-bottom:1px solid #cccccc;" ></td>
                          </tr>
                          <tr>
                            
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;text-align:right;" dir="rtl" width="70%"><?php echo stripslashes($restaurant['city']); ?></td>
                            <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;text-align:right;" dir="rtl" width="30%"><strong>الموقع: </strong></td>
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
                      <td style="font-family:Arial, Helvetica, sans-serif;padding-top:10px;font-weight:bold;color:#000;text-align:right;" colspan="2" height="20px" dir="rtl">فضلا تأكد من الإتصال بهم للسؤال عن تجربة المستخدم, إذا كانوا يريدون المساعدة وإطلاعهم على الخدمات الأخرى لدينا </td>
                    </tr>
                    <tr>
                      <td colspan="2"><ul style="font-family:Arial, Helvetica, sans-serif;font-size:14px; text-align:right;" dir="rtl">
                          <li>خدمة إلتقاط  صور الوجبات بإحترافية</li>
                          <li>خدمة الفيديو عالي الجودة على يد محترفين</li>
                          <li>خدمة تصميم المواقع  </li>
                          <li>خدمات التصميم الجرافيكي (القائمة، والشعار، والكتيباتونشرات إعلانية وما إلى ذلك ..)</li>
                          <li>منتجات الطباعه & تصنيع اللافتات</li>
                        </ul></td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" style="font-family:Arial, Helvetica, sans-serif;font-size:14px;text-align:right;" dir="rtl"> إستمر في الإبداع.</td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                     <tr>
                      <td colspan="2" style="font-size:12px;padding-bottom:10px;text-align:right;" dir="rtl"> شكراً لك </td>
                    </tr>
                     <tr>
                      <td colspan="2" style="font-size:12px;padding-bottom:10px;text-align:right;" dir="rtl"> مع اطيب الأمنيات </td>
                    </tr>
                    <tr>
                      <td colspan="2" height="10" style="padding-bottom:10px;" ></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td colspan="2" height="5" style="background-color:#00a2b1;min-height:5px;"></td>
              </tr>
              <tr height="100px"  style="color:#000; background-color:whitesmoke;">
                <td width="330" align="left" valign="top" style=" padding:20px 20px;font-size:12px; "><?php echo str_replace("<br>",' ', str_replace("<br />",' ', $settings['addressAr']));?> رقم الهاتف 1: <?php echo $settings['tel'];?> رقم الهاتف 2: <?php echo $settings['mobile'];?> بالفاكس: <?php echo $settings['fax'];?> بريدكالإلكتروني:<a href="mailto:<?php echo $settings['email'];?>" style="color:#000;"><?php echo $settings['email'];?></a></td>
                <td align="right" style=" padding:20px 30px;" valign="top"><table>
                    <tr>
                      <td><h4 style="font-size:15px;margin:0 0 0px;text-align:right" dir="rtl">تواصل معنا</h4></td>
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