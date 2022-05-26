<?php

class Sponsors extends AdminController
{

    protected $MAdmins;
    protected $MSponsor;

    public function __construct()
    {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MSponsor = new MSponsor();
    }

    public function index()
    {
        $status = "";
        $sort = "";
        if (isset($_GET['status'])) {
            $status = stripslashes($_GET['status']);
        }
        if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            $sort = stripslashes($_GET['sort']);
        }
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }

        $MSponsor = DB::table('sponsor');
        $MSponsor->select('*', 'sponsor.active AS status');
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $MSponsor->where('name', 'LIKE', stripslashes($_GET['name']) . '%');
        }
        if (!empty($sort)) {
            switch ($sort) {
                case "latest":
                    $MSponsor->orderBy('publish_date', 'DESC');
                    break;
                case "name":
                    $MSponsor->orderBy('name', 'ASC');
                    break;
            }
        }
        if ($status != "") {
            $MSponsor->where('active', '=', $status);
        }

        $MSponsor->where('country', '=', $country);


        $lists = $MSponsor->paginate(2000);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Name', 'Name Arabic', 'Description', 'Last Update on', 'Actions'),
            'resultheads' => array('name', 'name_ar', 'detail', 'publish_date/publish_date'),
            'actions' => array('edit', 'status', 'delete'),
            'pagetitle' => 'List of All Sponsors',
            'title' => 'Sponsor',
            'action' => 'adminsponsors',
            'statuslink' => 'adminsponsors/status',
            'deletelink' => 'adminsponsors/delete',
            'addlink' => 'adminsponsors/form',
            'lists' => $lists,
            'side_menu' => array('Corporate Pages', 'Sponsors'),
        );
        return view('admin.partials.restTeam', $data);
    }

    public function form($id = 0)
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }

        if ($id != 0) {
            $page = MSponsor::find($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->name,
                'title' => $page->name,
                'page' => $page,
                'side_menu' => array('Corporate Pages', 'Sponsors'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Sponsor',
                'title' => 'New Sponsor',
                'side_menu' => array('Corporate Pages', 'Sponsors'),
            );
        }
        return view('admin.forms.sponsor', $data);
    }

    public function save()
    {
        $filename = "";
        $filename_big = "";
        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $temp_name = $_FILES['image']['tmp_name'];
            $filename = $file->getClientOriginalName();
            $filename = $save_name = uniqid(Config::get('settings.sitename')) . $filename;
            $conserveProportion = true;
            $positionX = 0; // px
            $positionY = 0; // px
            $position = 'MM';
            $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath($temp_name);
            $largeLayer->save(Config::get('settings.uploadpath') . "/images/sponsor/", $save_name, true, null, 95);

            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/sponsor/" . $save_name);
            $changelayer = clone $layer;
            $changelayer->resizeInPixel(150, 150);
            $changelayer->save(Config::get('settings.uploadpath') . "/images/sponsor/", $save_name, true, null, 95);
        } elseif (isset($_POST['image_old'])) {
            $filename = Input::get('image_old');
        }

        if (Input::hasFile('image_big')) {
            $file = Input::file('image_big');
            $temp_name = $_FILES['image_big']['tmp_name'];
            $filename_big = $file->getClientOriginalName();
            $filename_big = $save_name = uniqid(Config::get('settings.sitename')) . $filename_big;
            $conserveProportion = true;
            $positionX = 0; // px
            $positionY = 0; // px
            $position = 'MM';
            $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath($temp_name);
            $largeLayer->save(Config::get('settings.uploadpath') . "/images/sponsor/", $save_name, true, null, 95);

            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/sponsor/" . $save_name);
            $changelayer = clone $layer;
            $changelayer->resizeInPixel(400, 266);
            $changelayer->save(Config::get('settings.uploadpath') . "/images/sponsor/", $save_name, true, null, 95);
        } elseif (isset($_POST['image_big_old'])) {
            $filename_big = Input::get('image_big_old');
        }

        if (Input::get('id')) {
            $id = Input::get('id');
            $this->MSponsor->updateSponsor($filename, $filename_big);
            $obj = MSponsor::find($id);
            $this->MAdmins->addActivity('Sponsor updated Succesfully ' . $obj->name);

            return returnMsg('success', 'adminsponsors', 'Sponsor updated Succesfully.');
        } else {
            $id = $this->MSponsor->addSponsor($filename, $filename_big);
            $obj = MSponsor::find($id);
            $this->MAdmins->addActivity('Sponsor added Succesfully ' . $obj->name);

            return returnMsg('success', 'adminsponsors', 'Sponsor added Succesfully.');
        }

        return returnMsg('error', 'adminsponsors', 'something went wrong, Please try again.');
    }

    public function status($id = 0)
    {
        $status = 0;
        $obj = MSponsor::find($id);
        if (count($obj) > 0) {
            if ($obj->active == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'active' => $status
            );

            DB::table('sponsor')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Sponsor status Changed Succesfully ' . $obj->name);

            return returnMsg('success', 'adminsponsors', 'Your data has been save successfully.');
        }

        return returnMsg('error', 'adminsponsors', 'something went wrong, Please try again.');
    }

    public function delete($id = 0)
    {
        $status = 0;
        $obj = MSponsor::find($id);
        if (count($obj) > 0) {
            MSponsor::destroy($id);
            $this->MAdmins->addActivity('Sponsor deleted Succesfully ' . $obj->name);

            return returnMsg('success', 'adminsponsors', 'Sponsor deleted succesfully.');
        }

        return returnMsg('error', 'adminsponsors', 'something went wrong, Please try again.');
    }
}
