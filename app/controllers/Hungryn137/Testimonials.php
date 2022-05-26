<?php

class Testimonials extends AdminController
{

    protected $MAdmins;
    protected $MTestimonials;

    public function __construct()
    {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MTestimonials = new MTestimonials();
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
        $MTestimonials = DB::table('testimonials');
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $MTestimonials->where('name', 'LIKE', "%" . stripslashes($_GET['name']) . '%');
        }
        if (!empty($sort)) {
            switch ($sort) {
                case "latest":
                    $MTestimonials->orderBy('createdAt', 'DESC');
                    break;
                case "name":
                    $MTestimonials->orderBy('name', 'ASC');
                    break;
            }
        }
        if ($status != "") {
            $MTestimonials->where('status', '=', $status);
        }

        $MTestimonials->where('country', '=', $country);

        $lists = $MTestimonials->paginate(2000);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Name', 'Country', 'Description', 'Last Update on', 'Actions'),
            'resultheads' => array('name', 'nameAr', 'description', 'createdAt/updatedAt'),
            'actions' => array('edit', 'status', 'delete'),
            'pagetitle' => 'List of All Testimonials',
            'title' => 'Testimonials',
            'action' => 'admintestimonials',
            'statuslink' => 'admintestimonials/status',
            'deletelink' => 'admintestimonials/delete',
            'addlink' => 'admintestimonials/form',
            'lists' => $lists,
            'side_menu' => array('Corporate Pages', 'Testimonials'),
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
            $page = MTestimonials::find($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->name,
                'title' => $page->name,
                'page' => $page,
                'side_menu' => array('Corporate Pages', 'Testimonials'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Static Testimonial',
                'title' => 'New Static Testimonial',
                'side_menu' => array('Corporate Pages', 'Testimonials'),
            );
        }
        return view('admin.forms.testimonial', $data);
    }

    public function save()
    {
        if (Input::get('id')) {
            $id = Input::get('id');
            $this->MTestimonials->updateTestimonial();
            $obj = MTestimonials::find($id);
            $this->MAdmins->addActivity('Testimonial updated Succesfully ' . $obj->name);

            return returnMsg('success', 'admintestimonials', "Testimonial updated Succesfully.");
        } else {
            $id = $this->MTestimonials->addTestimonial();
            $obj = MTestimonials::find($id);
            $this->MAdmins->addActivity('Testimonial added Succesfully ' . $obj->name);

            return returnMsg('success', 'admintestimonials', "Testimonial added Succesfully.");
        }

        return returnMsg('success', 'admintestimonials', "something went wrong, Please try again.");
    }

    public function status($id = 0)
    {
        $status = 0;
        $obj = MTestimonials::find($id);
        if (count($obj) > 0) {
            if ($obj->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'status' => $status,
                'updatedAt' => date('Y-m-d H:i:s')
            );

            DB::table('testimonials')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Testimonial status Changed Succesfully ' . $obj->name);

            return returnMsg('success', 'admintestimonials', "Your data has been save successfully.");
        }

        return returnMsg('error', 'admintestimonials', "something went wrong, Please try again.");
    }

    public function delete($id = 0)
    {
        $status = 0;
        $obj = MTestimonials::find($id);
        if (count($obj) > 0) {
            MTestimonials::destroy($id);
            $this->MAdmins->addActivity('Testimonial deleted Succesfully ' . $obj->name);

            return returnMsg('success', 'admintestimonials', "Testimonial deleted succesfully.");
        }

        return returnMsg('success', 'admintestimonials', "something went wrong, Please try again.");
    }
}
