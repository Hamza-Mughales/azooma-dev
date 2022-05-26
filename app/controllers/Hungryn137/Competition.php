<?php

use Yajra\DataTables\Facades\DataTables;

class Competition extends AdminController
{

    protected $MAdmins;
    protected $MGeneral;

    public function __construct()
    {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MGeneral = new MGeneral();
        $this->MRestActions = new MRestActions();
    }

    public function index()
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $sort = "latest";
        $searchname = "";
        $limit = 20;
        $status = 0;
        if (isset($_GET['sort']) && ($_GET['sort'] != "")) {
            $sort = ($_GET['sort']);
        }
        if (isset($_GET['status']) && ($_GET['status'] != "")) {
            $status = ($_GET['status']);
        }
        if (isset($_GET['limit']) && ($_GET['limit'] != "")) {
            $limit = ($_GET['limit']);
        }
        if (isset($_GET['restaurant']) && ($_GET['restaurant'] != "")) {
            $searchname = ($_GET['restaurant']);
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }

        // $lists = MCompetition::getAllCompetition($country, $status, $limit, $searchname);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Title', 'Title Arabic', 'Participants', 'Last Updated', 'Actions'),
            'pagetitle' => 'List of All Competition',
            'title' => 'All Competition',
            'action' => 'admincompetitions',
            // 'lists' => $lists,
            'side_menu' => array('Competitions', 'Events & Competitions'),
        );
        return view('admin.partials.competition', $data);
    }

    public function data_table()
    {
        $query = DB::table('competition');
        if (!in_array(0, adminCountry())) {
            $query->whereIn("country",  adminCountry());
        }

        return  DataTables::of($query)
            ->addColumn('action', function ($list) {
                $btns = '';
                $btns = '<a class="btn btn-xs btn-primary mytooltip m-1" href="' . route('admincompetitions/participants/', $list->id) . '" title="View All Participants"><i class="fa fa-info"></i></a>';
                $btns .= '<a class="btn btn-xs btn-info mytooltip m-1" href="' . route('admincompetitions/form/', $list->id) . '" title="Edit Content"><i class="fa fa-edit"></i></a>';

                if ($list->status == 0) {
                    $btns .= '<a class="btn btn-xs btn-info mytooltip m-1" href="' . route('admincompetitions/status/', $list->id) . '" title="Activate "><i class="fa fa-minus"></i></a>';
                } else {
                    $btns .= '<a class="btn btn-xs btn-info mytooltip m-1" href="' . route('admincompetitions/status/', $list->id) . '" title="Deactivate"><i class="fa fa-plus"></i></a>';
                }

                $btns .= '<a class="btn btn-xs btn-danger mytooltip m-1 cofirm-delete-button" href="#" link="' . route('admincompetitions/delete/', $list->id) . '" title="Delete"><i class="fa fa-trash"></i></a>';
                return $btns;
            })
            ->editColumn('title', function ($list) {
                return  stripslashes($list->title);
            })
            ->editColumn('titleAr', function ($list) {
                return  stripslashes($list->titleAr);
            })
            ->editColumn('participants', function ($list) {
                $btn = "Pend: " . MCompetition::getTotalParticipants($list->id, 0);
                $btn .= '<br>';
                $btn .= "Atten: " . MCompetition::getTotalParticipants($list->id, 1);
                $btn .= '<br>';
                $btn .= "Canc: " . MCompetition::getTotalParticipants($list->id, 2);
                $btn .= '<br>';
                $btn .= "Total: " . $list->participants;
                return $btn;
            })

            ->editColumn('createdAt', function ($list) {
                if (!empty($list->updatedAt)) {
                    return date('d/m/Y', strtotime($list->updatedAt));
                } else {
                    return date('d/m/Y', strtotime($list->last_Time));
                }
            })
            ->make(true);
    }

    public function form($id = 0)
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $cities = $this->MGeneral->getAllCities($country);
        if ($id != 0) {
            $page = MCompetition::getCompetition($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->title,
                'title' => $page->title,
                'competition' => $page,
                'cities' => $cities,
                'css' => 'admin/jquery-ui,chosen',
                'js' => 'admin/jquery-ui,chosen.jquery',
                'side_menu' => array('Competitions', 'Events & Competitions'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Competition',
                'title' => 'New Competition',
                'css' => 'admin/jquery-ui,chosen',
                'cities' => $cities,
                'js' => 'admin/jquery-ui,chosen.jquery',
                'side_menu' => array('Competitions', 'Events & Competitions'),
            );
        }
        return view('admin.forms.competition', $data);
    }

    public function save()
    {
        if (Input::get('title')) {
            $image = "";
            $actualWidth = "";
            $ratio = "0";
            if (Input::hasFile('logo')) {
                $file = Input::file('logo');
                $temp_name = $_FILES['logo']['tmp_name'];
                $filename = $file->getClientOriginalName();
                $logo = $save_name = uniqid(Config::get('settings.sitename')) . $filename;
                $thumbHeight = null;
                $conserveProportion = true;
                $positionX = 0; // px
                $positionY = 0; // px
                $position = 'MM';
                $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath($temp_name);
                $thumbLayer = clone $largeLayer;
                //get Size of the Image and reSize
                $actualWidth = $largeLayer->getWidth();
                $actualHeight = $largeLayer->getHeight();
                $ratio = $actualWidth / $actualHeight;
                if ($actualWidth < 200 && $actualHeight < 200) {
                    return returnMsg('error', 'admincompetitions', "Image is very small. Please upload image which must be bigger than 200*200 width and height.");
                }
                $largeLayer->save(Config::get('settings.uploadpath') . "/images/competition/", $save_name, true, null, 95);
                if (($actualWidth > 800) || ($actualHeight > 500)) {
                    $largeLayer->resizeInPixel(800, $thumbHeight, $conserveProportion, $positionX, $positionY, $position);
                }
                $largeLayer->save(Config::get('settings.uploadpath') . "/images/competition/", $save_name, true, null, 95);

                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/competition/" . $save_name);
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(270, 230);
                $changelayer->save(Config::get('settings.uploadpath') . "/images/competition/300/", $save_name, true, null, 95);
            } else {
                if (Input::has('logo_old')) {
                    $logo = Input::get('logo_old');
                } else {
                    $logo = '';
                }
            }

            if (Input::hasFile('image')) {
                $file = Input::file('image');
                $temp_name = $_FILES['image']['tmp_name'];
                $filename = $file->getClientOriginalName();
                $image = $save_name = uniqid(Config::get('settings.sitename')) . $filename;
                $thumbHeight = null;
                $conserveProportion = true;
                $positionX = 0; // px
                $positionY = 0; // px
                $position = 'MM';
                $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath($temp_name);
                $thumbLayer = clone $largeLayer;
                //get Size of the Image and reSize
                $actualWidth = $largeLayer->getWidth();
                $actualHeight = $largeLayer->getHeight();
                $ratio = $actualWidth / $actualHeight;
                if ($actualWidth < 200 && $actualHeight < 200) {

                    return returnMsg('error', 'adminrestaurants', "Image is very small. Please upload image which must be bigger than 200*200 width and height.");
                }

                $largeLayer->save(Config::get('settings.uploadpath') . "/images/competition", $save_name, true, null, 95);

                if (($actualWidth > 800) || ($actualHeight > 500)) {
                    $largeLayer->resizeInPixel(800, $thumbHeight, $conserveProportion, $positionX, $positionY, $position);
                }
                $largeLayer->save(Config::get('settings.uploadpath') . "/images/competition/", $save_name, true, null, 95);

                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/competition/" . $save_name);
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(450, 335);
                $changelayer->save(Config::get('settings.uploadpath') . "/images/competition/300/", $save_name, true, null, 95);

                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/competition/" . $save_name);
                $layer->cropMaximumInPixel(0, 0, "MM");
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(100, 100);
                $changelayer->save(Config::get('settings.uploadpath') . "/images/competition/thumb/", $save_name, true, null, 95);
            } else {
                if (Input::has('image_old')) {
                    $image = Input::get('image_old');
                } else {
                    $image = '';
                }
            }

            if (Input::get('id')) {
                $rest = $_POST['id'];
                MCompetition::updateCompetition($image, $logo);
                $this->MAdmins->addActivity('Competition Updated ' . Input::get('title'));

                return returnMsg('success', 'admincompetitions', "Competition Updated succesfully");
            } else {
                $rest = MCompetition::addCompetition($image, $logo);
                $this->MAdmins->addActivity('Competition Added ' . Input::get('title'));

                return returnMsg('success', 'admincompetitions', "Competition Added succesfully");
            }
        } else {

            return returnMsg('error', 'admincompetitions', "something went wrong, Please try again.");
        }
    }

    public function status($id = 0)
    {
        $status = 0;
        $page = MCompetition::getCompetition($id);
        if (count($page) > 0) {
            if ($page->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'status' => $status
            );
            DB::table('competition')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Competition Status changed successfully.' . $page->title);

            return returnMsg('success', 'admincompetitions', "Competition Status changed successfully.");
        }

        return returnMsg('error', 'admincompetitions', "something went wrong, Please try again.");
    }

    public function delete($id = 0)
    {
        $status = 0;
        $page = MCompetition::getCompetition($id);
        if (count($page) > 0) {
            MCompetition::deleteCompetition($id);
            $this->MAdmins->addActivity($page->title . ' deleted successfully.');

            return returnMsg('success', 'admincompetitions', $page->title . ' deleted successfully.');
        }

        return returnMsg('success', 'admincompetitions', "Something went wrong, Please try again.");
    }

    public function participants($id)
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $page = MCompetition::getCompetition($id);
        $lists = MCompetition::getAllCompetitionParticipants($id);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Name', 'Birthday', 'Number/email', 'Status', 'Added on', 'Actions'),
            'pagetitle' => 'All Participants ' . $page->title,
            'title' => 'All Participants ' . $page->title,
            'action' => 'admincompetitions',
            'page' => $page,
            'lists' => $lists,
            'id' => $id,
            'side_menu' => array('Competitions', 'Events & Competitions'),
        );
        return view('admin.partials.participants', $data);
    }

    public function parti_data_table($id)
    {
        $query = DB::table('participants')->where('event_id', '=', $id);;
        if (!in_array(0, adminCountry())) {
            $query->whereIn("country",  adminCountry());
        }

        return  DataTables::of($query)
            ->addColumn('action', function ($list) {
                $btns = '';
                $btns = '<a class="btn btn-xs btn-primary mytooltip m-1" href="' . route('admincompetitions/participantstatus/', $list->id) . '?type=1&event_id=' . $list->event_id . '" title="Attending"><i class="fa fa-plus"></i></a>';
                $btns .= '<a class="btn btn-xs btn-info mytooltip m-1" href="' . route('admincompetitions/participantstatus/', $list->id) . '?type=2&event_id=' . $list->event_id . '" title="Canceled"><i class="fa fa-minus"></i></a>';
                return $btns;
            })
            ->editColumn('name', function ($list) {
                return  stripslashes($list->name) . ' ' .  stripslashes($list->parent_name);
            })
            ->editColumn('birthday', function ($list) {
                return  stripslashes($list->birthday);
            })
            ->editColumn('number', function ($list) {
                return  stripslashes($list->number) . '<br>' . $list->email;
            })
            ->editColumn('status', function ($list) {
                if ($list->status == 0) {
                    return 'pending';
                } elseif ($list->status == 1) {
                    return 'Attending';
                } elseif ($list->status == 2) {
                    return 'Canceled';
                }
            })
            ->editColumn('updatedAt', function ($list) {
                if (!empty($list->updatedAt)) {
                    return date('d/m/Y', strtotime($list->updatedAt));
                } else {
                    return date('d/m/Y', strtotime($list->createdAt));
                }
            })
            ->make(true);
    }

    public function participantstatus($id = 0)
    {
        $event_id = 0;
        $status = 0;
        if (isset($_GET['event_id']) && ($_GET['event_id'] != "")) {
            $event_id = ($_GET['event_id']);
        }
        if (isset($_GET['type']) && ($_GET['type'] != "")) {
            $status = ($_GET['type']);
        }

        if ($event_id === 0 || $id === 0 || $status === 0) {

            return returnMsg('error', 'admincompetitions', "something went wrong, Please try again.");
        }
        $participants = MCompetition::getParticipants($id, $event_id);
        if ($status == 0) {
            MCompetition::participantsStatus($id, $event_id, $status);
            $this->MAdmins->addActivity('Participants Pending ' . $participants->name);

            return returnMsg('success', 'admincompetitions', "Participant Pending succesfully");
        } elseif ($status == 1) {

            MCompetition::participantsStatus($id, $event_id, $status);
            $data['event'] = $event = MCompetition::getCompetition($event_id);

            //send email
            $data['name'] = $participants->name;
            $data['birthday'] = $participants->birthday;
            $data['email'] = $participants->email;
            $data['number'] = $participants->number;
            $data['participants'] = $participants;
            ##EMAIL FUNCTION

            $this->MAdmins->addActivity('Participants Attending ' . $participants->name);

            return returnMsg('success', 'admincompetitions', "Participant Attending succesfully");
        } elseif ($status == 2) {
            MCompetition::participantsStatus($id, $event_id, $status);
            $this->MAdmins->addActivity('Participants Canceled ' . $participants->name);

            return returnMsg('success', 'admincompetitions', "Participant Canceled succesfully");
        }

        return returnMsg('error', 'admincompetitions', "something went wrong, Please try again.");
    }
}
