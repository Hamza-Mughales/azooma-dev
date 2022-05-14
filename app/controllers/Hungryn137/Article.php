<?php

use Yajra\DataTables\Facades\DataTables;

class Article extends AdminController {

    protected $MAdmins;
    protected $MGeneral;
    protected $MBlog;

    public function __construct() {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MGeneral = new MGeneral();
        $this->MBlog = new MBlog();
    }

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

        $name = "";
        $status = "";
        $sort = "";
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $name = stripslashes($_GET['name']);
        }
        if (isset($_GET['status'])) {
            $status = stripslashes($_GET['status']);
        }
        if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            $sort = stripslashes($_GET['sort']);
        }

        $lists = $this->MBlog->getAllCategoriesAdmin($country, $status, 0, $name, $sort);

        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Title', 'Title Arabic', 'Total Articles', 'Last Update on', 'Actions'),
            'resultheads' => array('name', 'nameAr', 'totalarticles', 'sortposition', 'createdAt/lastupdatedArticle'),
            'actions' => array('sub', 'edit', 'status', 'delete'),
            'pagetitle' => 'List of All Categories  ',
            'title' => 'All Categories',
            'action' => 'adminarticles',
            'statuslink' => 'adminarticles/status',
            'deletelink' => 'adminarticles/delete',
            'addlink' => 'adminarticles/form',
            'sublink' => 'adminarticles/articles',
            'lists' => $lists,
            'side_menu' => array('Blog','Articles'),
        );

        return view('admin.partials.maincommonpage', $data);
    }

    public function data_table()
    {
        $query = DB::table('categories')->select('*', DB::Raw('(SELECT count(*) FROM article WHERE article.category=categories.id AND article.status=1) as totalarticles'));
        if (!in_array(0, adminCountry())) {
            $query->whereIn("country",  adminCountry());
        }
        if (Input::has('status')) {
            $query->where("status", '=', intval(get('status')));
        }
        return  DataTables::of($query)
            ->addColumn('action', function ($list) {
                $addURL = "";
                $btns = '';
                    $btns = '<a class="btn btn-xs btn-info mytooltip m-1" href="' . route('adminarticles/articles/',$list->id). '" title="View Sub Articles"><i class="fa fa-eye"></i></a>';
                    $btns .= '<a class="btn btn-xs btn-info mytooltip m-1" href="' . route('adminarticles/form/', $list->id) . '" title="Edit Content"><i class="fa fa-edit"></i></a>';

                if ($list->status == 0) {

                    $btns .= '<a class="btn btn-xs btn-info mytooltip m-1" href="' . route("adminarticles/status/",  $list->id) . '" title="Activate "><i  class="fa fa-minus"></i></a>';
                } else {
                    $btns .= '<a class="btn btn-xs btn-info mytooltip m-1" href="' . route("adminarticles/status/", $list->id) . '" title="Deactivate"><i  class="fa fa-plus"></i></a>';
                }

                $btns .= '<a onclick="return confirm(Do You Want to Delete?)" class="btn btn-xs btn-danger mytooltip m-1" href="' . route('adminarticles/delete/', $list->id) . '" title="Delete"><i  class="fa fa-trash"></i></a>';
                return $btns;
            })
            ->editColumn('name', function ($list) {
                return  stripslashes($list->name);
            })
            ->editColumn('nameAr', function ($list) {
                return  stripslashes($list->nameAr);
            })
            ->editColumn('totalarticles', function ($list) {
                return  stripslashes($list->totalarticles);
            })
            ->editColumn('lastupdatedArticle', function ($list) {
                if ($list->lastupdatedArticle == "" || $list->lastupdatedArticle == "0000-00-00 00:00:00") {
                    return date('d/m/Y', strtotime($list->createdAt));
                } else {
                    return date('d/m/Y', strtotime($list->lastupdatedArticle));
                }
            })
            
            ->make(true);
    }

    public function form($id = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }

        if ($id != 0) {
            $page = $this->MBlog->getCategory($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->name,
                'title' => $page->name,
                'page' => $page,
                'side_menu' => array('Blog','Articles'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Category',
                'title' => 'New Category',
                'side_menu' => array('Blog','Articles'),
            );
        }
        return view('admin.forms.category', $data);
    }

    public function save() {
        if (Input::get('id')) {
            $id = Input::get('id');
            $this->MBlog->updateCategory();
            $obj = $this->MBlog->getCategory($id);
            $this->MAdmins->addActivity('Category updated Succesfully - ' . $obj->name);
            
            return returnMsg('success','adminarticles',"Category updated Succesfully.");
        } else {
            $id = $this->MBlog->addCategory();
            $obj = $this->MBlog->getCategory($id);
            $this->MAdmins->addActivity('Article Added Succesfully - ' . $obj->name);
            
            return returnMsg('success','adminarticles',"Category Added Succesfully.");
        }
        
        return returnMsg('error','adminarticles',"Something went wrong, Please try again.");
    }

    public function status($id = 0) {
        $status = 0;
        $page = $this->MBlog->getCategory($id);
        if (count($page) > 0) {
            if ($page->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'status' => $status,
                'lastupdatedArticle' => date('Y-m-d H:i:s')
            );
            DB::table('categories')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Category Status changed successfully.' . $page->name);
            
            return returnMsg('success','adminarticles',"Category Status changed successfully.");
        }
        
        return returnMsg('error','adminarticles',"Something went wrong, Please try again.");
    }

    public function delete($id = 0) {
        $status = 0;
        $page = $this->MBlog->getCategory($id);
        if (count($page) > 0) {
            DB::table('categories')->where('id', $id)->delete();
            $this->MAdmins->addActivity('Category Deleted successfully.' . $page->name);
            
            return returnMsg('success','adminarticles',"Category Deleted successfully.");
        }
        
        return returnMsg('error','adminarticles',"something went wrong, Please try again.");
    }

    public function articles($pid = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $limit = 20;
        $name = "";
        $status = "";
        $sort = "";
        $views = "";
        $comments = "";
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $name = stripslashes($_GET['name']);
        }
        if (isset($_GET['status'])) {
            $status = stripslashes($_GET['status']);
        }
        if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            $sort = stripslashes($_GET['sort']);
        }
        if (isset($_GET['views']) && !empty($_GET['views'])) {
            $views = stripslashes($_GET['views']);
        }
        if (isset($_GET['comment']) && !empty($_GET['comment'])) {
            $comments = stripslashes($_GET['comment']);
        }

        $lists = $this->MBlog->getAllArticle($country, $pid, $status, $limit, $name, $sort, $views, $comments);
        $bcat = $this->MBlog->getCategory($pid);

        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Title', 'Title Arabic', 'Total Comments', 'Views', 'Last Update', 'Actions'),
            'resultheads' => array('name', 'nameAr', 'totalcomment', 'views', 'createdAt/updatedAt'),
            'actions' => array('edit', 'status', 'delete'),
            'pagetitle' => 'All Articles for ' . $bcat->name,
            'title' => $bcat->name . ' Articles',
            'action' => 'adminarticles/articles/' . $pid,
            'statuslink' => 'adminarticles/articlestatus',
            'deletelink' => 'adminarticles/articledelete',
            'addlink' => 'adminarticles/articleform',
            'articlesflag' => TRUE,
            'pid' => $pid,
            'lists' => $lists,
            'side_menu' => array('Miscellaneous','All Menu Request'),
        );

        return view('admin.partials.maincommonpage_sub', $data);
    }

    public function articleform($id = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }

        $pid = 0;
        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $pid = $_GET['category'];
        } else {
            return Redirect::route('adminarticles')->with('error', "something went wrong, Please try again.");
        }
        $cat = $this->MBlog->getCategory($pid);
        $restaurants = $this->MGeneral->getAllRests(1);
        if ($id != 0) {
            $page = $this->MBlog->getArticle($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->name,
                'title' => $page->name,
                'cat' => $cat,
                'restaurants' => $restaurants,
                'pid' => $pid,
                'page' => $page,
                'css' => 'admin/jquery-ui,chosen',
                'js' => 'admin/jquery-ui,chosen.jquery,admin/charCount',
                'side_menu' => array('Blog','Articles'),
            );
        } else {
            $data = array(
                'cat' => $cat,
                'restaurants' => $restaurants,
                'pid' => $pid,
                'sitename' => $settings['name'],
                'pagetitle' => 'New  Article',
                'title' => 'New Article',
                'css' => 'admin/jquery-ui,chosen',
                'js' => 'admin/jquery-ui,chosen.jquery,admin/charCount',
                'side_menu' => array('Blog','Articles'),
            );
        }
        return view('admin.forms.article', $data);
    }

    public function articlesave() {
        $pid = Input::get('category');
        $filename = "";
        $broughtbyImage = "";
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
            //get Size of the Image and reSize
            $actualWidth = $largeLayer->getWidth();
            $actualHeight = $largeLayer->getHeight();
            $ratio = $actualWidth / $actualHeight;
            if ($actualWidth < 200 && $actualHeight < 200) {
                
                return returnMsg('error','adminrestaurants',"Image is very small. Please upload image which must be bigger than 200*200 width and height.");
            }
            $text_font = Input::get('name') . ' - azooma.co';
            $textLayer = PHPImageWorkshop\ImageWorkshop::initTextLayer($text_font, public_path() . '/fonts/text.ttf', 13, 'ffffff', 0);
            $textLayer->opacity(75);
            $largeLayer->addLayerOnTop($textLayer, 20, 40, "RB");
            $largeLayer->save(Config::get('settings.uploadpath') . "/images/blog", $save_name, true, null, 95);

            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/blog/" . $save_name);
            $changelayer = clone $layer;
            $changelayer->resizeInPixel(800, 500);
            $changelayer->save(Config::get('settings.uploadpath') . "/images/blog/", $save_name, true, null, 95);

            $changelayer = clone $layer;
            $changelayer->resizeInPixel(210, 210);
            $changelayer->save(Config::get('settings.uploadpath') . "/images/blog/210x210/", $save_name, true, null, 95);

            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/blog/" . $save_name);
            $layer->cropMaximumInPixel(0, 0, "MM");
            $changelayer = clone $layer;
            $changelayer->resizeInPixel(100, 100);
            $changelayer->save(Config::get('settings.uploadpath') . "/images/blog/thumb/", $save_name, true, null, 95);
        } elseif (isset($_POST['image_old'])) {
            $filename = Input::get('image_old');
        }

        if (Input::hasFile('broughtbyImage')) {
            $temp_name = $_FILES['broughtbyImage']['tmp_name'];
            $broughtbyImage = $file->getClientOriginalName();
            $broughtbyImage = $save_name = uniqid(Config::get('settings.sitename')) . $broughtbyImage;
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
            $largeLayer->save(Config::get('settings.uploadpath') . "/images/blog/", $save_name, true, null, 95);

            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/blog/" . $save_name);
            $changelayer = clone $layer;
            $changelayer->resizeInPixel(200, 60);
            $changelayer->save(Config::get('settings.uploadpath') . "/images/blog/", $save_name, true, null, 95);
        } elseif (isset($_POST['image_old'])) {
            $broughtbyImage = Input::get('broughtbyImage_old');
        }
        if (Input::get('id')) {
            $id = Input::get('id');
            $this->MBlog->updateArticle($filename, $broughtbyImage);
            $obj = $this->MBlog->getArticle($id);
            $this->MAdmins->addActivity('Article updated Succesfully ' . $obj->name);
            
            return returnMsg('success','adminarticles/articles/',"Article updated Succesfully.", $pid);
        } else {
            // dd($filename, $broughtbyImage, $this->MBlog->addArticle($filename, $broughtbyImage));
            $id = $this->MBlog->addArticle($filename, $broughtbyImage);
            $obj = $this->MBlog->getArticle($id);
            $this->MAdmins->addActivity('Article added Succesfully ' . $obj->name);
            
            return returnMsg('success','adminarticles/articles/',"Article added Succesfully.", $pid);
        }
        
        return returnMsg('error','adminarticles/articles/',"something went wrong, Please try again.", $pid);
    }

    public function articlestatus($id = 0) {
        $status = 0;
        $pid = 0;
        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $pid = $_GET['category'];
        } else {
            
            return returnMsg('error','adminarticles',"something went wrong, Please try again.");
        }
        $page = $this->MBlog->getArticle($id);
        if (count($page) > 0) {
            if ($page->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'status' => $status
            );
            DB::table('article')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Article Status changed successfully.' . $page->name);
            
            return returnMsg('success','adminarticles/articles/',"Article Status changed successfully.", $pid);
        }
        
        return returnMsg('error','adminarticles/articles/',"something went wrong, Please try again.", $pid);
    }

    public function articledelete($id = 0) {
        $status = 0;
        $pid = 0;
        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $pid = $_GET['category'];
        } else {
            
            return returnMsg('error','adminarticles',"Something went wrong, Please try again.");
        }
        $page = $this->MBlog->getArticle($id);
        if (count($page) > 0) {
            $this->MBlog->deleteArticle($id);
            $this->MAdmins->addActivity('Article deleted successfully.' . $page->name);
            
            return returnMsg('success','adminarticles/articles/',"Article deleted successfully.", $pid);
        }
        
        return returnMsg('error','adminarticles/articles/',"something went wrong, Please try again.", $pid);
    }

    public function updateposition() {
        if (isset($_POST['position'])) {
            $articles = explode('-', $_POST['position']);
            if (is_array($articles)) {
                foreach ($articles as $article) {
                    if (!empty($article)) {
                        $k = explode(':', $article);
                        if (is_array($k) && !empty($k)) {
                            $data = array(
                                'position' => $k[1]
                            );
                            DB::table('categories')->where('id', $k[0])->update($data);
                        }
                    }
                }
            }
        }
    }

    function slideform($id = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }

        $pid = 0;
        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $pid = $_GET['category'];
        } else {
            return Redirect::route('adminarticles')->with('error', "something went wrong, Please try again.");
        }

        $cat = $this->MBlog->getCategory($pid);
        $restaurants = $this->MGeneral->getAllRests(1);
        if ($id != 0) {
            $page = $this->MBlog->getArticle($id);
            $slideArticles = $this->MBlog->getSlidesByArticleID($id);
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => $page->name,
                'title' => $page->name,
                'cat' => $cat,
                'restaurants' => $restaurants,
                'pid' => $pid,
                'page' => $page,
                'slideArticles' => $slideArticles,
                'css' => 'admin/jquery-ui,chosen',
                'js' => 'admin/jquery-ui,chosen.jquery,admin/charCount'
            );
        } else {
            $data = array(
                'cat' => $cat,
                'restaurants' => $restaurants,
                'pid' => $pid,
                'sitename' => $settings['name'],
                'pagetitle' => 'New ' . $cat->name . ' Article',
                'title' => 'New ' . $cat->name . ' Article',
                'css' => 'admin/jquery-ui,chosen',
                'js' => 'admin/jquery-ui,chosen.jquery,admin/charCount'
            );
        }
        return View::make('admin.index', $data)->nest('content', 'admin.forms.slidearticle', $data);
    }

    function saveslide() {
        if (Input::get('name')) {
            $category = Input::get('category');
            $counter = Input::get('counter');
            $articleID = 0;
            $image = "";
            $broughtbyImage = "";
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
                //get Size of the Image and reSize
                $actualWidth = $largeLayer->getWidth();
                $actualHeight = $largeLayer->getHeight();
                $ratio = $actualWidth / $actualHeight;
//                if ($actualWidth < 200 && $actualHeight < 200) {
//                    return Redirect::route('adminrestaurants')->with('message', 'Image is very small. Please upload image which must be bigger than 200*200 width and height.');
//                }
                //$text_font = Input::get('name') . ' - azooma.co';
                //$textLayer = PHPImageWorkshop\ImageWorkshop::initTextLayer($text_font, public_path() . '/fonts/text.ttf', 13, 'ffffff', 0);
                //$textLayer->opacity(75);
                //$largeLayer->addLayerOnTop($textLayer, 20, 40, "RB");
                
                $largeLayer->save(Config::get('settings.uploadpath') . "/images/blog/", $save_name, true, null, 95);
                
                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/blog/" . $save_name);
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(800, 500);
                $changelayer->save(Config::get('settings.uploadpath') . "/images/blog/", $save_name, true, null, 95);

                $changelayer = clone $layer;
                $changelayer->resizeInPixel(210, 210);
                $changelayer->save(Config::get('settings.uploadpath') . "/images/blog/210x210/", $save_name, true, null, 95);

                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/blog/" . $save_name);
                $layer->cropMaximumInPixel(0, 0, "MM");
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(100, 100);
                $changelayer->save(Config::get('settings.uploadpath') . "/images/blog/thumb/", $save_name, true, null, 95);
            } elseif (isset($_POST['image_old'])) {
                $filename = Input::get('image_old');
            }

            if (Input::hasFile('broughtbyImage')) {
                $temp_name = $_FILES['broughtbyImage']['tmp_name'];
                $broughtbyImage = $file->getClientOriginalName();
                $broughtbyImage = $save_name = uniqid(Config::get('settings.sitename')) . $broughtbyImage;
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
                $largeLayer->save(Config::get('settings.uploadpath') . "/images/blog/", $save_name, true, null, 95);

                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/blog/" . $save_name);
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(200, 60);
                $changelayer->save(Config::get('settings.uploadpath') . "/images/blog/", $save_name, true, null, 95);
            } elseif (isset($_POST['image_old'])) {
                $broughtbyImage = Input::get('broughtbyImage_old');
            }

            if (Input::get('articleID')) {
                $this->MBlog->updateTopSlideArticle(Input::get('articleID'), $filename, $broughtbyImage);
                $articleID = Input::get('articleID');
            } else {
                $articleID = $this->MBlog->addTopSlideArticle($filename, $broughtbyImage);
            }

            for ($i = 0; $i <= $counter; $i++) {
                if (isset($_POST['slidename-' . $i])) {
                    $image = "";
                    $logo = "";
                    $largeLayer = "";
                    $thumbLayer = "";
                    $temp_name = "";
                    if (Input::hasFile('image-' . $i)) {
                        $file = Input::file('image-' . $i);
                        $temp_name = $_FILES['image-' . $i]['tmp_name'];
                        $image = $file->getClientOriginalName();
                        $image = $save_name = uniqid(Config::get('settings.sitename')) . $image;
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
                        $largeLayer->save(Config::get('settings.uploadpath') . "/images/blog/", $save_name, true, null, 95);
                        
                        $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/blog/" . $save_name);
                        $changelayer = clone $layer;
                        $changelayer->resizeInPixel(490, 250);
                        $changelayer->save(Config::get('settings.uploadpath') . "/images/blog/", $save_name, true, null, 95);

                        $changelayer = clone $layer;
                        $changelayer->resizeInPixel(210, 210);
                        $changelayer->save(Config::get('settings.uploadpath') . "/images/blog/210x210/", $save_name, true, null, 95);

                        $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/blog/" . $save_name);
                        $layer->cropMaximumInPixel(0, 0, "MM");
                        $changelayer = clone $layer;
                        $changelayer->resizeInPixel(100, 100);
                        $changelayer->save(Config::get('settings.uploadpath') . "/images/blog/thumb/", $save_name, true, null, 95);
                    } elseif (isset($_POST['image_old-' . $i])) {
                        $image = Input::get('image_old-' . $i);
                    }
                    $largeLayer = "";
                    $thumbLayer = "";
                    $temp_name = "";
                    if (Input::hasFile('logo-' . $i)) {
                        $filebroughtbyImage = Input::file('logo-' . $i);
                        $temp_name = $_FILES['logo-' . $i]['tmp_name'];
                        $logo = $filebroughtbyImage->getClientOriginalName();
                        $logo = $save_name = uniqid(Config::get('settings.sitename')) . $logo;
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
                        $largeLayer->save(Config::get('settings.uploadpath') . "/images/blog/", $save_name, true, null, 95);
                        
                        $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/blog/" . $save_name);
                        $layer->cropMaximumInPixel(0, 0, "MM");
                        $changelayer = clone $layer;
                        $changelayer->resizeInPixel(100, 100);
                        $changelayer->save(Config::get('settings.uploadpath') . "/images/blog/thumb/", $save_name, true, null, 95);
                    } elseif (isset($_POST['logo_old-' . $i])) {
                        $logo = Input::get('logo_old-' . $i);
                    }

                    if (Input::get('id-' . $i)) {
                        $this->MBlog->updateSlideArticle($image, $i, $articleID, $logo);
                    } else {
                        $this->MBlog->addSlideArticle($image, $i, $articleID, $logo);
                    }
                }
            }
            $this->MAdmins->addActivity('Added/updated Slide Article ' . stripslashes((Input::get('name'))));
            
            return returnMsg('success','adminarticles/articles/',"Added/updated Slide Article.", Input::get('category'));
        } else {
            show_404();
        }
    }

    function slidedelete($id = 0) {
        $this->MBlog->deleteSlide($id);
        $this->MAdmins->addActivity('Deleted Slide Article ');
        $result['html'] = 'yes';
        return $output = json_encode($result);
    }

    function slideformtab() {
        $data['restaurants'] = $this->MGeneral->getAllRests(1);
        if (isset($_GET['counter'])) {
            $data['counter'] = $_GET['counter'];
        }
        $html = "";
        $html = View::make("admin.ajax.articleslideformtab", $data);
        return $html;
    }

    function makefeature() {
        if ((isset($_GET['article']) && !empty($_GET['article']) ) && (isset($_GET['category']) && !empty($_GET['category']) )) {
            $articleID = ($_GET['article']);
            $categoryID = ($_GET['category']);
            $article = $this->MBlog->getArticle($articleID);
            $this->MBlog->makeFeatureArticle($articleID, $categoryID);
            $this->MAdmins->addActivity('Article Added in Feature ' . stripslashes(($article->name)));
            
            return returnMsg('success','adminarticles/articles/',"Article Added in Featured succesfully", $categoryID);
        }
        
        return returnMsg('error','adminarticles',"something went wrong, Please try again.");
    }

    function removefeature() {
        if ((isset($_GET['article']) && !empty($_GET['article']) ) && (isset($_GET['category']) && !empty($_GET['category']) )) {
            $articleID = ($_GET['article']);
            $categoryID = ($_GET['category']);
            $article = $this->MBlog->getArticle($articleID);
            $this->MBlog->removeFeatureArticle($articleID, $categoryID);
            $this->MAdmins->addActivity('Article Removed From Feature ' . stripslashes(($article->name)));
            
            return returnMsg('success','adminarticles/articles/',"Article Removed From Featured succesfully", $categoryID);
        }
        $this->session->set_flashdata('message', 'something went wrong, please try again.');
        redirect('hungryn137/article');
    }

    public function missingMethod($parameters) {
        //return Redirect::route('adminarticles')->with('error', "something went wrong, Please try again.");
    }

}
