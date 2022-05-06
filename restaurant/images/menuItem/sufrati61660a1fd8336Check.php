<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Check extends CI_Controller
{
    private $maxList = false;
    public function __construct()
    {
        parent::__construct();
    }
    public function hr_login()
    {
        $token = decrypt_url(get("t"));

        if (!$token) {
            admin_redirect("login");

        }
        $code = $token["token"];

        $code = substr($code, 4, strlen($code));

        $user_id = $token["user_id"];
        $code = substr($code, 2, strlen($code));
        $code = base64_decode($code);
        if (json_decode($code, true) === false) {
            admin_redirect("login");
        }
        $data = json_decode($code);

        $cookie_name = base64_encode("hr_login");

        if (isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] === $data->c) {
            admin_redirect("welcome");
        }
        if (isset($data->c)) {
            $company = $data->c;
            $token = $data->h;
            setcookie($cookie_name, $company, time() + 50000000, '/');

            setcookie("smartChatUser", 0, time() + 50000000, '/');

            Database::setDatabase($company);

            $this->db = $this->site->connectDB($company);
            $sys_config = $this->db->select("hr_token,hr_active")->get("sma_system_config")->row();
            if (!isset($sys_config->hr_token) || isset($sys_config->hr_token) && substr($sys_config->hr_token, 0, 10) !== $token || intval($sys_config->hr_active) === 0) {
                admin_redirect("login");
            }
            $where = intval($user_id) > 0 ? " AND id='$user_id' " : "  AND `group_id` = 1 ";
            $user = $this->db->query("SELECT *,CONCAT(first_name,' ',last_name) as name  FROM `sma_users` WHERE `active` = 1 $where")->row();
            if ($user_id != "1" && intval($user->hr_id) < 1) {
                admin_redirect("login");
            }
            $_data = array(
                "date_of_payment" => "2020-05-01",
                "number_of_payment" => 1,
                "client_status" => 1,
                "client_name" => $company,
                "company" => $company,
                'identity' => $user->username,
                'username' => $user->username,
                'email' => $user->email,
                'user_id' => $user->id, //everyone likes to overwrite id so we'll use user_id
                'old_last_login' => $user->last_login,
                'last_ip' => $this->input->ip_address(),
                'avatar' => $user->avatar,
                'gender' => $user->gender,
                'group_id' => $user->group_id,
                'warehouse_id' => $user->warehouse_id,
                'view_right' => $user->view_right,
                'edit_right' => $user->edit_right,
                'allow_discount' => $user->allow_discount,
                'biller_id' => $user->biller_id,
                'company_id' => $user->company_id,
                'show_cost' => $user->show_cost,
                'show_price' => $user->show_price,
                'allow_percent_discount' => $user->allow_percent_discount,
            );

            $set = $this->session->set_userdata($_data);
            $this->session->set_flashdata('isLogedIN', true);

            Smart::startUpdate();
            if (get("_rf")) {
                admin_redirect('welecome');

            }
            admin_redirect("h?_rf=1&t=" . get("t") . "&user_id=" . get("user_id"));
        }

        admin_redirect("login");
    }

    public function style($new = true)
    {
        $style = get("t") === "new" ? "new" : "default";
        setcookie("th_me", $style, time() + 50000000, '/');

        //get_instance()->db->update("sma_settings",array("theme"=>$style),array("setting_id>"=>"0"));
        define('newTheme', $style);
        admin_redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'welcome');

    }
    public function index()
    {
        header("Content-Type: application/json;charset=utf-8");

        $company = isset($_POST["company"]) ? $_POST["company"] : false;
        if (!$company) {
            header('Location: ' . base_url());
        }
        if ($company) {

            $database = Database::getDatabase($company);
            // $this->session->sess_destroy();

        }

        echo json_encode(array("error" => true));
        exit();
    }

    public function tr_login($lang = "turkish")
    {
        if ($lang === "indonesian") {
            define("countryCode", "ID");
        } else {
            define("countryCode", "TR");
        }
        $this->language($lang, true);
        $this->config->set_item('language', $lang);
        $this->lang->admin_load('plugins', $lang);
        $this->lang->admin_load('sma', $lang);
        $this->lang->admin_load('auth', $lang);
        $this->data['lang'] = $lang;
        $this->data['title'] = lang('login');
        $block = "login_tr";
        if (countryCode === "ID") {
            $this->SysLogo = "buyr";
            $this->SysIcon = "buyr_icon";
            $block = "login_buyr";

        } else {
            $this->SysLogo = "logo";
            $this->SysIcon = "icon";
        }
        $this->loggedIn = $this->sma->logged_in();
        if ($this->loggedIn) {
            admin_redirect('admin');
        }
        $this->data['assets'] = base_url() . 'themes/default/admin/assets/';
        $this->load->view('default/admin/views/auth/' . $block, $this->data);
    }

    public function language($lang = false, $no_red = false)
    {
        if ($this->input->get('lang')) {
            $lang = $this->input->get('lang');
        }
        //$this->load->helper('cookie');
        $folder = 'app/language/';
        $languagefiles = scandir($folder);
        if (in_array($lang, $languagefiles)) {
            $cookie = array(
                'name' => 'language',
                'value' => $lang,
                'expire' => '31536000',
                'prefix' => 'sma_',
                'secure' => false,
            );
            $this->input->set_cookie($cookie, 100000000);
        }

        if ($lang === "indonesian") {
            get_instance()->input->set_cookie("_location", "ID", 500000);
        }
        if ($lang === "turkish") {
            get_instance()->input->set_cookie("_location", "TR", 500000);
        }
        if (!$no_red) {
            redirect(base_url() . "/" . $url);
        }
    }

}
