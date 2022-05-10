<?php

class Pages extends AdminController {

    public function index() {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $status = "";
        $sort = "";
        if (isset($_GET['status'])) {
            $status = stripslashes($_GET['status']);
        }
        if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            $sort = stripslashes($_GET['sort']);
        }

        $MContents = DB::table('contents');
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $MContents->where('title', 'LIKE', "%" . stripslashes($_GET['name']) . '%');
        }
        $MContents->where('country', '=', $country);

        if (!empty($sort)) {
            switch ($sort) {
                case "latest":
                    $MContents->orderBy('last_Time', 'DESC');
                    break;
                case "name":
                    $MContents->orderBy('title', 'ASC');
                    break;
            }
        } else {
            $MContents->orderBy('last_Time', 'DESC');
        }
        if ($status != "") {
            $MContents->where('status', '=', $status);
        }

        $lists = $MContents->paginate(2000);

        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Page Name', 'Page Name Arabic', 'Description', 'Last Update on', 'Actions'),
            'resultheads' => array('title', 'title_ar', 'details', 'last_Time/updatedAt'),
            'actions' => array('edit', 'status', 'delete'),
            'pagetitle' => 'List of All Pages',
            'title' => 'Pages',
            'action' => 'adminpages',
            'statuslink' => 'adminpages/status',
            'deletelink' => 'adminpages/delete',
            'addlink' => 'adminpages/form',
            'lists' => $lists,
            'side_menu' => array('Corporate Pages','Information Pages'),
        );

        return view('admin.partials.restTeam', $data);
    }

    public function form($id = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }

        if ($id != 0) {
            $page = Contents::find($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->title,
                'title' => $page->title,
                'page' => $page,
                'side_menu' => array('Corporate Pages','Information Pages'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Static Page',
                'title' => 'New Static Page',
                'side_menu' => array('Corporate Pages','Information Pages'),
            );
        }


        return view('admin.forms.page', $data);
    }

    public function save() {
        $status = 0;
        $url = "";
        $url = Str::slug(Input::get('title'));
        if (Input::get('status') != "") {
            $status = Input::get('status');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'country' => $country,
            'title' => (Input::get('title')),
            'title_ar' => (Input::get('titlear')),
            'details' => htmlentities(Input::get('details')),
            'details_ar' => Input::get('details_ar'),
            'keywords' => (Input::get('keywords')),
            'keywords_ar' => (Input::get('keywords_ar')),
            'seo_url' => $url,
            'status' => $status,
            'updatedAt' => date('Y-m-d H:i:s'),
        );

        if (Input::get('id')) {
            DB::table('contents')->where('id', Input::get('id'))->update($data);
        } else {
            DB::table('contents')->insert($data);
        }
        
        return returnMsg('success','adminpages',"Your data has been save successfully.");
    }

    public function status($id = 0) {
        $status = 0;
        $page = Contents::find($id);
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

            DB::table('contents')->where('id', $id)->update($data);
            
            return returnMsg('success','adminpages',"Your data has been save successfully.");
        }
        
        return returnMsg('error','adminpages',"something went wrong, Please try again.");
    }

    public function delete($id = 0) {
        $status = 0;
        $page = Contents::find($id);
        if (count($page) > 0) {
            Contents::destroy($id);
            
            return returnMsg('success','adminpages',"Your data has been save successfully.");
        }
        
        return returnMsg('success','adminpages',"something went wrong, Please try again.");
    }

}
