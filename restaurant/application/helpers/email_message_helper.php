<?php


if (!function_exists("smiple_message")) {
    function smiple_message($title = '', $content = '', $company_name = 'Smart HR')
    {
        $html = '<div  style="min-height: 250px;"> <table style="direction:ltr;" width="100%" cellspacing="0" cellpadding="0" border="0">
    <tbody>
      <tr>
        <td  style="font-size:0px;vertical-align: top;background-color: #242b3d;padding-left: 16px;padding-right: 5px;padding-bottom: 10px;" align="center">

          <div  style="display: inline-block;vertical-align: top;width: 100%;max-width: 60%;">
            <div style="font-size: 24px; line-height: 24px; height:10px;">&nbsp; </div>
            <div  style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;text-align: left;padding-left: 8px;padding-right: 8px;">
              <p style="margin-top: 0px;margin-bottom: 0px;">
              <a  href="' . base_url() . '" style="text-decoration: none;outline: none;color: #ffffff;">
              <img src="' . base_url()  . '" alt="Smart HR" style="max-width: 136px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height:110px;outline: none;text-decoration: none;" width="136" height="36"></a></p>
            </div>
          </div>
        

          <div  style="display: inline-block;vertical-align: top;width: 100%;max-width: 40%;">
            <div style="font-size: 24px; line-height: 24px; height: 8px;">&nbsp; </div>
            <div  style="font-size: 18px;padding-left: 8px;padding-right: 8px;">
              <table   style="text-align: center;margin-left: auto;margin-right: 0;" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                  <tr>
                    <td   style="font-family:Arial, sans-serif;font-weight: bold;margin-top: 10px;margin-bottom: 0px;font-size: 1.3em;line-height: 21px;" align="center">
                      <h3  style="outline:none;color:#ffffff;display:block;padding: 7px 16px;padding-top:30px;">' . $company_name . '</h3>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
      
          
        </td>
      </tr>
    </tbody>
  </table><div class="parentOfBg"><table  width="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody>
        <tr>
          <td  align="center" style="background-color: #126de5;padding-left: 24px;padding-right: 24px;padding-top: 64px;padding-bottom: 64px;" >
            <!--[if mso]><table width="584" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td align="center"><![endif]-->
            <div  style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #ffffff;text-align: center;">
              <table  cellspacing="0" cellpadding="0" border="0"  style="text-align: center;margin-left: auto;margin-right: auto;">
                <tbody>
                  <tr>
                    <td align="center" " style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;border-radius: 96px;padding-left: 16px;padding-right: 16px;padding-top: 16px;padding-bottom: 16px;">
                      <img src="http://www.stampready.net/dashboard/editor/user_uploads/zip_uploads/2018/11/19/FGr4uysEPTw12DdXkW5CHApa/service_upgrade/images/flag-48-primary.png" width="48" height="48" alt="" style="max-width: 48px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;" data-crop="false">
                    </td>
                  </tr>
                  <tr>
                    <td style="font-size: 24px; line-height: 24px; height: 24px;">&nbsp; </td>
                  </tr>
                </tbody>
              </table>
              <h2  style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 4px;font-size: 30px;line-height: 39px;">' . $title . '</h2>
             ' . $content . '
            </div>
            <!--[if mso]></td></tr></table><![endif]-->
          </td>
        </tr>
      </tbody>
    </table></div><table  width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" class="">
      <tbody>
        <tr>
          <td  style="font-size: 24px;line-height: 24px;height: 24px;background-color: #ffffff;" data-bgcolor="Bg White">&nbsp; </td>
        </tr>
      </tbody>
    </table></div>';
        $html .= ' 
    <table align="center" cellspacing="0" cellpadding="0" border="0" role="presentation">
    <tbody>
      <tr>
        <td width="300"  align="center"  style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #242b3d;border-radius: 4px;">
          <a  href="' . base_url() . '" style="text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;"> ' . lang('login_email_text') . '</a>
        </td>
      </tr>
    </tbody>
  </table>
  <br>
    <table align="center" style="direction:ltr;" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" >
    <tbody>
      <tr>
        <td  align="center"  style="background-color: #dbe5ea;padding-left: 16px;padding-right: 16px;padding-bottom: 32px;" contenteditable="false">


          <div style="display: inline-block;vertical-align: top;width: 100%;max-width: 400px;">
            <div style="font-size: 32px; line-height: 32px; height: 32px;">&nbsp; </div>
            <div   style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;color: #82899a;text-align: left;padding-left: 8px;padding-right: 8px;">
              <p style="margin-top: 0px;margin-bottom: 8px;">©2020 smart life Inc. All rights reserved.</p>
              <p  style="margin-top: 0px;margin-bottom: 8px;"> KSA</p>
              <p style="margin-top: 0px;margin-bottom: 0px;">
                <a  href="http://smart-hr.top"  style="text-decoration: underline;outline: none;color: #82899a;">Help Center</a> <span class="o_hide-xs">&nbsp; • &nbsp;</span><br class="o_hide-lg" style="display: none;font-size: 0;max-height: 0;width: 0;line-height: 0;overflow: hidden;mso-hide: all;visibility: hidden;">
                <a  href="' . base_url() . '"  style="text-decoration: underline;outline: none;color: #82899a;">login</a> <span class="o_hide-xs">&nbsp; • &nbsp;</span><br class="o_hide-lg" style="display: none;font-size: 0;max-height: 0;width: 0;line-height: 0;overflow: hidden;mso-hide: all;visibility: hidden;">
 
              </p>
            </div>
          </div>


         
          <div  style="font-size: 64px; line-height: 64px; height: 64px;">&nbsp; </div>
        </td>
      </tr>
    </tbody>
  </table>';
        return $html;
    }
}
/**
 * send mail
 * 
 * @param string $to
 * @param string $subject
 * @param string $message
 * @param array $optoins
 * @return true/false
 */
if (!function_exists('sendSysMail')) {

    function sendSysMail($to, $message, $subject, $optoins = array())
    {
        $email_config = array(
            'charset' => 'utf-8',
            'mailtype' => 'html'
        );

        //check mail sending method from settings
        /*if (get_custom_setting("email_protocol") === "smtp") {
          $email_config["protocol"] = "smtp";
          $email_config["smtp_host"] = get_custom_setting("email_smtp_host");
          $email_config["smtp_port"] = get_custom_setting("email_smtp_port");
          $email_config["smtp_user"] = get_custom_setting("email_smtp_user");
          $email_config["smtp_pass"] = get_custom_setting("email_smtp_pass");
          $email_config["smtp_crypto"] = get_custom_setting("email_smtp_security_type");

          if (!$email_config["smtp_crypto"]) {
              $email_config["smtp_crypto"] = "tls"; //for old clients, we have to set this by defaultsssssssss
          }

          if ($email_config["smtp_crypto"] === "none") {
              $email_config["smtp_crypto"] = "";
          }
      }*/
      $sys_email = site_email();
      //  $email_config["protocol"] = "smtp";
        //$email_config["smtp_host"] = "ssl://mail.smart-hr.top";
        //$email_config["smtp_port"] = 465;
        //$email_config["smtp_user"] = "system@smart-hr.top";
        //$email_config["smtp_pass"] = 'aa;Cx1$a9g0y';
        //$email_config['_smtp_auth']   = TRUE;
        //$email_config['smtp_crypto']   = 'ssl';
        $ci = get_instance();
        $ci->load->library('email', $email_config);
        // $ci->email->initialize($email_config);
        $ci->email->set_mailtype("html");
        //$ci->email->clear();
        //  $ci->email->set_newline("\r\n");
        $user = $ci->db->where("id_user", this_user())->get('booking_management')->row();
        $company_name = ''; //Smart::setting('name');
     
        $email = $user->email;
        $full_name = $user->full_name;
        $ci->email->from($sys_email, "$full_name");
        $ci->email->reply_to($email);
        if (is_array($to)) {
            /*
             * Email Configuaration
             */
            //--------------------- start none employee recevers add info ------------------
            foreach ($to as $v) :
                $to_email = $v['email'];
                $to_name = $v['name'];
                if (check_valid_email($to_email) && !empty($to_email)) :

                    $ci->email->to($to_email, "$to_name");

                endif;
            endforeach;
        } else {
            $ci->email->to($to);
        }


        $ci->email->set_mailtype("html");
        $ci->email->subject($subject);
        $ci->email->message($message);

        if (isset($optoins['attachment']) && is_array($optoins['attachment'])) {
            foreach ($optoins['attachment'] as $attach) {
                $ci->email->attach($attach);
            }
        }
        //send email
        try {
            if ($ci->email->send()) {
                return true;
            } else {
                //show error message in none production version
                /* if (ENVIRONMENT !== 'production') {
            //  show_error($ci->email->print_debugger());
          }*/
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}

/**
 *
 *  check email ois valid
 * @params $email

 * @return   bool
 */


if (!function_exists("check_valid_email")) {
    function check_valid_email($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
}
