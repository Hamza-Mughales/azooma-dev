<?php

use Yajra\DataTables\Facades\DataTables;

class NewsletterController extends AdminController
{

    protected $MAdmins;
    protected $MGeneral;
    protected $MNewsLetter;
    protected $MCuisine;

    public function __construct()
    {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MGeneral = new MGeneral();
        $this->MNewsLetter = new NewsLetter();
        $this->MCuisine = new MCuisine();
    }

    public function index()
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

        $emailListingReceivers = $this->MGeneral->getEmailListingReceivers();
        $cuisines = $this->MCuisine->getAllCuisines(0, 1);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Name', 'Description', 'Total Receivers', 'Result', "Status", 'Last Update on', 'Actions'),
            'pagetitle' => 'List of All The Newsletters',
            'title' => 'Newsletters',
            'action' => 'adminnewsletter',
            'cuisines' => $cuisines,
            'emailListingReceivers' => $emailListingReceivers,
            'side_menu' => array('Emailing List', 'News Letter'),
        );

        return view('admin.partials.newsletter', $data);
    }
    public function getNewsLetterData()
    {
        $query = DB::table('newsletter')
            ->select(['newsletter.*']);


        if (!in_array(0, adminCountry())) {
            $query->whereIn("newsletter.country",  adminCountry());
        }

        return  DataTables::of($query)
            ->addColumn('action', function ($row) {
                $btns =
                    $btns = '<a class="btn btn-xs btn-info m-1 mytooltip" href="' . route('adminnewsletter/form/', $row->id) . '" title="Edit Content"><i class="fa fa-edit"></i></a>';


                if ($row->status == 0) {

                    $btns .= '<a class="btn btn-xs btn-info m-1 mytooltip" href="' . route('adminnewsletter/status/', $row->id) . '" title="Activate "><i class="fa fa-check"></i></a>';
                } else {
                    $btns .= '<a class="btn btn-xs btn-danger m-1 mytooltip" href="' . route('adminnewsletter/status/', $row->id) . '" title="Deactivate"><i class="fa fa-ban"></i></a>';
                }
                $btns .= '<a  class="btn btn-xs btn-danger m-1 mytooltip cofirm-delete-button" href="#" link="' . route('adminnewsletter/delete/', $row->id)  . '" title="Delete"><i class="fa fa-trash"></i></a>';

                return $btns;
            })
            ->editColumn('message', function ($letter) {
                return Str::limit(stripslashes(strip_tags(html_entity_decode($letter->message))), 100);
            })
            ->editColumn('receiver', function ($letter) {
                return stripslashes($letter->receiver);
            })
            ->addColumn('result', function ($letter) {
                return stripslashes($letter->receiver);
            })


            ->addColumn('status_html', function ($letter) {
                return  $letter->status == 1 ? '<span class="label label-success p-1">' . __('Active') . '</span>' : '<span class="label p-1 label-danger">' . __("Inactive") . '</span>';
            })

            ->editColumn('updatedAt', function ($letter) {
                if ($letter->updatedAt == "" || $letter->updatedAt == "0000-00-00 00:00:00") {
                    return date('d/m/Y', strtotime($letter->createdAt));
                } else {
                    return date('d/m/Y', strtotime($letter->updatedAt));
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
        $emailListingReceivers = $this->MGeneral->getEmailListingReceivers();
        $cuisines = $this->MCuisine->getAllCuisines(0, 1);

        if ($id != 0) {
            $page = $this->MNewsLetter->getNewsLetter($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->name,
                'title' => $page->name,
                'page' => $page,
                'cities' => $cities,
                'cuisines' => $cuisines,
                'emailListingReceivers' => $emailListingReceivers,
                'css' => 'datepicker,chosen',
                'js' => 'datepicker,chosen.jquery',
                'side_menu' => array('Emailing List', 'News Letter'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'cuisines' => $cuisines,
                'cities' => $cities,
                'emailListingReceivers' => $emailListingReceivers,
                'pagetitle' => 'New Newsletter',
                'title' => 'New Newsletter',
                'css' => 'admin/datepicker,chosen',
                'js' => 'admin/datepicker,chosen.jquery',
                'side_menu' => array('Emailing List', 'News Letter'),
            );
        }
        return view('admin.forms.newsletter', $data);
    }

    public function save()
    {
        $filename = "";
        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $temp_name = $_FILES['image']['tmp_name'];
            $filename = $file->getClientOriginalName();
            $filename = $save_name = uniqid(Config::get('settings.sitename')) . $filename;
            $thumbHeight = null;
            $conserveProportion = true;
            $positionX = 0; // px
            $positionY = 0; // px
            $position = 'MM';
            $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath($temp_name);
            $thumbLayer = clone $largeLayer;
            $actualWidth = $largeLayer->getWidth();
            $actualHeight = $largeLayer->getHeight();
            $ratio = $actualWidth / $actualHeight;
            $largeLayer->save(Config::get('settings.uploadpath') . "/images/newsletter", $save_name, true, null, 95);

            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/newsletter/" . $save_name);
            $changelayer = clone $layer;
            $changelayer->resizeInPixel(640, null);
            $changelayer->save(Config::get('settings.uploadpath') . "/images/newsletter/", $save_name, true, null, 95);

            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/newsletter/" . $save_name);
            $layer->cropMaximumInPixel(0, 0, "MM");
            $changelayer = clone $layer;
            $changelayer->resizeInPixel(100, 100);
            $changelayer->save(Config::get('settings.uploadpath') . "/images/newsletter/thumb/", $save_name, true, null, 95);
        } elseif (isset($_POST['image_old'])) {
            $filename = Input::get('image_old');
        }
        if (Input::get('id')) {
            $id = Input::get('id');
            $this->MNewsLetter->updateNewsLetter($filename);
            $obj = $this->MNewsLetter->getNewsLetter($id);
            $this->MAdmins->addActivity('Newsletter updated Succesfully - ' . $obj->name);
            return returnMsg('success', 'adminnewsletter', "Newsletter updated Succesfully.");
        } else {
            $id = $this->MNewsLetter->addNewsLetter($filename);
            // dd($id);
            $obj = $this->MNewsLetter->getNewsLetter($id);
            $this->MAdmins->addActivity('Newsletter Added Succesfully - ' . $obj->name);
            return returnMsg('success', 'adminnewsletter', "Newsletter Added Succesfully.");
        }
        return returnMsg('error', 'adminnewsletter', "something went wrong, Please try again.");
    }

    public function status($id = 0)
    {
        $status = 0;
        $page = $this->MNewsLetter->getNewsLetter($id);
        if (count($page) > 0) {
            if ($page->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'status' => $status,
                'updatedAt' => date('Y-m-d H:i:s')
            );

            DB::table('newsletter')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Newsletter Status changed successfully.' . $page->name);
            return returnMsg('success', 'adminnewsletter', "Newsletter Status changed successfully.");
        }
        return returnMsg('error', 'adminnewsletter', "something went wrong, Please try again.");
    }

    public function delete($id = 0)
    {
        $status = 0;
        $page = $this->MNewsLetter->getNewsLetter($id);
        if (count($page) > 0) {
            DB::table('newsletter')->where('id', $id)->delete();
            $this->MAdmins->addActivity('Newsletter Deleted successfully.' . $page->name);
            return returnMsg('success', 'adminnewsletter', "Newsletter Deleted successfully.");
        }
        return returnMsg('error', 'adminnewsletter', "something went wrong, Please try again.");
    }

    public function getAjaxCount()
    {
        $type = "";
        $city = "";
        if (isset($_REQUEST['type']) && !empty($_REQUEST['type'])) {
            $type = $_REQUEST['type'];
        }

        $total = NewsLetter::getReceivers($type);
        $data['total'] = $total;
        return Response::json($data);
    }
}
