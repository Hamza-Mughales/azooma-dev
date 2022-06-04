<?php


class Admin extends Eloquent
{

    protected $table = 'admin';

    public static function addActivity($activity)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $data = array(
            'user' => Session::get('fullname'),
            'message' => $activity,
            'my_ip' => $ip
        );
        DB::table('activity_info')->insert($data);
    }

    public function updateAdmin()
    {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $country=post('admin')==1 ? 0 : post('country');
   
        $data = array(
            'country' => $country,
            'fullname' => (Input::get('fullname')),
            'status' => $status,
            'email' => (Input::get('email')),
            'user' => (Input::get('user')),
            'admin' => (Input::get('admin'))
        );
        DB::table('admin')->where('id', Input::get('id'))->update($data);
    }

    public function addAdmin()
    {
        $status = 0;
        if (isset($_POST['status'])) {
            $status = 1;
        }
        $country=post('admin')==1 ? 0 : post('country');
   

        $data = array(
            'fullname' => (Input::get('fullname')),
            'country' => $country,
            'status' => $status,
            'email' => (Input::get('email')),
            'user' => (Input::get('user')),
            'admin' => (Input::get('admin')),
            'pass' => md5(Input::get('pass'))
        );
        return $insertID = DB::table('admin')->insertGetId($data);
    }

    function changePassword()
    {
        $data = array(
            'pass' => md5(post('pass'))
        );
        DB::table('admin')->where('id', Input::get('id'))->update($data);
    }

    function getAllPermissions()
    {
        $return = DB::table('permission_section')->get();
        if (count($return) > 0) {
            return $return;
        }
    }

    function getPermissionSectionInfo($section = 0)
    {
        $return = DB::table('permission_info')->where('section', $section)->get();
        if (count($return) > 0) {
            return $return;
        }
    }

    function updatePermissions()
    {
        if (isset($_POST['permissions'])) {
            $permissions = implode(",", $_POST['permissions']);
            $data = array(
                'permissions' => $permissions
            );
            DB::table('admin')->where('id', Input::get('id'))->update($data);
        }
    }

    function getAdminActivity($user, $limit = 15)
    {
        $return = DB::table('activity_info')->where('user', $user)->orderBy('date_time', 'DESC')->paginate($limit);
        if (count($return) > 0) {
            return $return;
        }
    }

    function upload_image($name, $dir, $default = 'no_image.jpg')
    {
        $uploadDir = $dir;
        if ($_FILES[$name]['name'] != '' && $_FILES[$name]['name'] != 'none') {
            $filename = $_FILES[$name]['name'];
            $filename = str_replace(' ', '_', $filename);
            $uploadFile_1 = uniqid('sufrati') . $filename;
            $uploadFile1 = $uploadDir . $uploadFile_1;
            $fileName = $_FILES[$name]['name'];
            if (move_uploaded_file($_FILES[$name]['tmp_name'], $uploadFile1))
                $image_name = $uploadFile_1;
            else
                $image_name = $default;
        } else
            $image_name = $default;

        return $image_name;
    }

    function addRestActivity($activity, $rest_ID = 0, $activity_id = 0)
    {
        $data = array(
            'id_user' => '0',
            'rest_ID' => $rest_ID,
            'langid' => '0',
            'activity' => $activity,
            'activity_ID' => $activity_id

        );
        DB::table('rest_activity')->insert($data);
    }
}
