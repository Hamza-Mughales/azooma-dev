<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Smart
{
    /**
     * SmartLife Smart Class
     *
     * @package    CodeIgniter
     * @subpackage    Tools for all
     * @category    Class
     * @author     Ehab Al.Rubaiee
     * @email     ehab.alrubaiee@gmail.com
     */

    public function __construct()
    {

        $this->_CI = &get_instance();

    }


    public static function startUpdate()
    {
        get_instance()->load->library('start_update');
        return get_instance()->start_update->initialize();

    }
    
    // ------------------------------------------------------------------------
    /**
     *
     * Chcek and get var value from array or object
     *
     * @access    public
     * @params
    [var =>  String]
    [parent =>  array() OR Object ]
     * @return    String | Array | Object | bool ...
     */
    public static function returnVar($var, $parent = false)
    {
        $CI = get_instance();
        if (!$parent) {
            $parent = $CI->output->_sm_cached_vars;

        }
        if (is_array($parent)) {
            if (isset($parent[$var])) {

                return $parent[$var];
            }
        }
        if (is_object($parent)) {
            if (isset($parent->$var)) {

                return $parent->$var;
            }
        }
        return false;
    }
    //-----------------------------------------------
    /**
     *
     * get result info  from table table
     *  @author     Arafat Thabet
     *  @access    public
     *  @params
     *        [table => table name]
     *  [select => string select of data to get ]
     *  [
     *    [ params => parameter of sql
    forexample >>>>  array("name"=>$name, "id"=>$id)
    if you want to use the PRIMARY KEY only you can set parameter to object  and it will be get data by the Primary key of table  ]]

     *
     *    [all => true get all record]
     *  @return    mix array
     */
    public static function get_table_info($table, $select = null, $params = array(), $all = true)
    {
        if (empty($params)):
            return get_instance()->db->select($select ? $select : "*")->from($table)->get()->result();
        else:
            if ($all) {
                return get_instance()->db->select($select ? $select : "*")->from($table)->where($params)->get()->result();
            } else {
                return get_instance()->db->select($select ? $select : "*")->from($table)->where($params)->get()->row();
            }

        endif;
    }
    // ------------------------------------------------------------------------

    public static function getInfoEmployee($id, $select = null, $employment_id = false)
    {
        return get_instance()->db->select($select ? $select : "*")->where($employment_id ? "employment_id" : "employee_id", $id)->get('tbl_employee')->row();
    }

    public static function get_all_employees($select = null)
    {
        return get_instance()->db->select($select ? $select : "*")->where("status", 1)->get('tbl_employee')->result();
    }
    // ------------------------------------------------------------------------

    /**
     *
     * Return value from settings
     *
     * @access    public
     * @params  [key => key of the settings]
     * @return    String
     */
    public static function setting($key)
    {
        get_instance()->load->database('default',true);
        if(!empty($key)){
        $val = get_instance()->db->select($key)->get("tbl_gsettings")->row();
        return isset($val->$key) ? $val->$key : null;
        }
        else{
            return null;
        }
    }

    // ------------------------------------------------------------------------

    /**
     *
     * Insert  OR Update Values to table
     *
     * @access    public
     * @params
    [table => table name]
    [data => array of data to insert OR updae]
    [
    id => if id ? record will be update table : insert values to table
    if id is integer ? id will be a primary Key of table OR Array ( "id"=> value ,"name"=>value,etc)

    ]
     * @return    bool
     */
    public static function record($table, $data = array(), $id = false)
    {
        if ($id) {
            return Smart::update($table, $data, $id);
        } else {
            return Smart::insert($table, $data);
        }

        return Smart::insert($table, $data);
    }
    // ------------------------------------------------------------------------

    /**
     *
     * Insert Values to DataBase
     *
     * @access    public
     * @params
    [table => table name]
    [data => array of data to insert]
     * @return    bool
     */
    public static function insert($table, $data = array())
    {
        $CI = get_instance();
        if (!is_array($data) or (!$table)) {
            return false;
        }
        $items = array();

        $fields = $CI->db->list_fields($table);
        // Check if table contain data item
        foreach ($fields as $field) {
            if (isset($data[$field])) {
                if (is_array($data[$field])) {

                    continue;
                }
                $items[$field] = $data[$field];
            }

        }

        if ($CI->db->insert($table, $items)) {

            return $CI->db->insert_id();
        }
        return false;
    }
    // ------------------------------------------------------------------------
    /**
     *
     * update table in DataBase
     *
     * @access    public
     * @params
    [table => table name]
    [data => array of data to insert]
    [ params => parameter of sql
    forexample >>>>  array("name"=>$name, "id"=>$id)
    if you want to use the PRIMARY KEY only you can set parameter to object  and it will be update by the Primary key of table  ]
     * @return    bool
     */
    public static function update($table, $data = array(), $params = array())
    {
        if (!is_array($params)) {
            $key = Smart::PrimaryKey($table);
            if ($key) {
                $params = array(
                    $key => $params,
                );
            }
        }
        if (!is_array($data) or !is_array($params) or (!$table)) {
            return false;
        }
        return    get_instance()->db->update($table, $data, $params);
         return true;
    }
    // ------------------------------------------------------------------------
    /**
     *
     * Delete row from DataBase
     *
     * @access    public
     * @params
    [table => table name]
    params => parameter of sql
    forexample
    array("name"=>$name, "id"=>$id)
    if you want to use the PRIMARY KEY only you can set parameter to object  and it will be delete by the Primary key of table
     * @return    bool
     */
    public static function delete($table, $params = array())
    {
        if (!is_array($params)) {
            $key = Smart::primaryKey($table);
            if ($key) {
                $params = array(
                    $key => $params,
                );
            }
        }
        if (!is_array($params) or (!$table)) {
            return false;
        }
        return get_instance()->db->delete($table, $params);
    }
    // ------------------------------------------------------------------------
    /**
     *
     * Get Primary Key of table
     *
     * @access    public
     * @params   [table => table name]
     * @return    bool
     */
    public static function primaryKey($table)
    {
        $table = get_instance()->db->query("SHOW KEYS FROM `" . $table . "` WHERE Key_name = 'PRIMARY' ")->row();
        return $table ? $table->Column_name : false;
    }
    // ------------------------------------------------------------------------

    // ------------------------------------------------------------------------
    /**
     * edit by Arafat Thabet
     * Upload file/files to dir
     *
     * @access    public
     * @params
    [ file/files => name of $_FILES
    dir => Dir to upload
    config => Options upload ]
     * @return    Array
     */

    public static function upload($file, $dir, $config = array())
    {
        get_instance()->load->library('upload');
        $Upload = get_instance()->upload;
        if (isset($_FILES[$file]['error']) && $_FILES[$file]['error'] == 0) {
            $options = array();
            $options['max_size'] = 5000;
            $options['allowed_types'] = 'gif|jpg|jpeg|png';
            $options['encrypt_name'] = false;
            $options['overwrite'] = false;
            foreach ($config as $key => $val) {
                $options[$key] = $val;
            }
            $tmp_name = $_FILES[$file]['tmp_name'];
            /*if (!is_valid_mime_content_type($tmp_name,$options['allowed_types'] )) {
                return array('error' => 1, 'msg' =>lang('invalid_file_type'));
    
             }*/
            $options['upload_path'] = $dir;
            $Upload->initialize($options);

            if (!$Upload->do_upload($file)) {
                return array('error' => 1, 'msg' => $Upload->display_errors());
                return false;
            }

            $data = $Upload->data();

            if (!count($data)) {
                return array('error' => 1, 'msg' => $Upload->display_errors());
                return false;

            }
            return array('error' => 0, 'upload' => true, 'file' => $data['file_name'], 'name' => $data['raw_name'], 'file_ext' => $data['file_ext'], 'file_size' => $data['file_size']);
            return true;
        }
        return array('error' => 1, 'upload' => false, 'file' => false);
    }

    // ------------------------------------------------------------------------
    /**
     *
     * Redirct with msg flash data
     *
     * @access    public
     * @params
    [uri => redirect url with/without full uri]
    [msgToShow => text to show after redirect ]
    [typeMsg => Type of msg ( message| error | info | warning ]
     * @return    Bool
     */

    public static function msg($msgToShow, $uri = false, $typeMsg = 'error')
    {
        if (!is_null($typeMsg) && !empty($msgToShow)) {

            get_instance()->session->set_flashdata($typeMsg, $msgToShow);
        }
        if (!$uri) {
            $uri = get_instance()->config->site_url(get_instance()->uri->uri_string());

        }
        if (!empty($uri)) {
            redirect($uri);
            return true;
        }
        return false;
    }
    /**
     *
     * Load model from <<models>>
     *
     * @access    public
     * @params
    [model => name of the file]
    [object_name => the name you want use for this model]
    for example  SMART::model("information_mode","info");   you will be able to use model like: $this->info->example;
     * @return    Class
     */

    public static function model($model, $object_name = null)
    {
        get_instance()->load->model($model, $object_name);
    }
}
