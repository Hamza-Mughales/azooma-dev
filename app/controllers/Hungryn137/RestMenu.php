<?php

class RestMenu extends AdminController {

    protected $MAdmins;
    protected $MGeneral;

    public function __construct() {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MGeneral = new MGeneral();
        $this->MRestActions = new MRestActions();
    }

    public function index($restID = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $limit = 500;
        if (isset($_GET['limit']) && ($_GET['limit'] != "")) {
            $limit = ($_GET['limit']);
        }
        if (isset($_GET['menu_id']) && ($_GET['menu_id'] != "")) {
            $menu_id = $_GET['menu_id'];
        } else {
            $menu_id = 0;
        }
        if (isset($_GET['item']) && ($_GET['item'] != "")) {
            $item = $_GET['item'];
        } else {
            $item = 0;
        }
        $rest = $this->MRestActions->getRest($restID);
        if ($item != 0) {
            $lists = $this->MRestActions->getAllMenuItems($restID, $item);
            $cat = $this->MRestActions->getMenuCat($item);
            $data = array(
                'sitename' => $settings['name'],
                'headings' => array('Item Name', 'Item Name Arabic', 'Last Updated', 'Actions'),
                'pagetitle' => 'List of All Interactive Menu for ' . $rest->rest_Name,
                'title' => 'All Interactive Menu for ' . $rest->rest_Name,
                'action' => 'adminrestaurants',
                'menuAction' => 'item',
                'lists' => $lists,
                'cat' => $cat,
                'rest' => $rest
            );
        } elseif ($menu_id != 0) {
            $lists = $this->MRestActions->getAllMenuCats($restID, 0, $menu_id);
            $data = array(
                'sitename' => $settings['name'],
                'headings' => array('Category Name', 'Category Name Arabic', 'Last Updated', 'Actions'),
                'pagetitle' => 'List of All Interactive Menu for ' . $rest->rest_Name,
                'title' => 'All Interactive Menu for ' . $rest->rest_Name,
                'action' => 'adminrestaurants',
                'menuAction' => 'category',
                'lists' => $lists,
                'menu_id' => $menu_id,
                'rest' => $rest,
                'side_menu' => ['adminrestaurants','Add Restaurants'],
            );
        } else {
            $lists = $this->MRestActions->getAllMenu($restID, $limit);
            $data = array(
                'sitename' => $settings['name'],
                'headings' => array('Menu Name', 'Menu Name Arabic', 'Last Updated', 'Actions'),
                'pagetitle' => 'List of All Interactive Menu for ' . $rest->rest_Name,
                'title' => 'All Interactive Menu for ' . $rest->rest_Name,
                'action' => 'adminrestaurants',
                'menuAction' => 'menu',
                'lists' => $lists,
                'rest' => $rest,
                'side_menu' => ['adminrestaurants','Add Restaurants'],
            );
        }
        return view('admin.partials.restaurantmenu', $data);
    }

    public function form($rest_ID = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        if (isset($_GET['menu_id']) && ($_GET['menu_id'] != "")) {
            $menu_id = $_GET['menu_id'];
        } else {
            $menu_id = 0;
        }
        if (isset($_GET['cat_id']) && ($_GET['cat_id'] != "")) {
            $cat_id = $_GET['cat_id'];
        } else {
            $cat_id = 0;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $rest = $this->MRestActions->getRest($rest_ID);
        $data = array(
            'MRestActions' => $this->MRestActions,
            'MGeneral' => $this->MGeneral,
            'sitename' => $settings['name'],
            'rest' => $rest,
            'js' => 'chosen.jquery,admin/branchform',
            'side_menu' => ['adminrestaurants','Add Restaurants']
        );

        if (isset($_GET['cat']) && ($_GET['cat'] != "")) {
            $data['item'] = 1;
            $data['cat'] = $cat = $this->MRestActions->getMenuCat($_GET['cat']);
            if (isset($_GET['item']) && ($_GET['item'] != "")) {
                $data['menuitem'] = $menuitem = $this->MRestActions->getMenuItem($_GET['item']);
                $data['pagetitle'] = 'Updating Menu item ' . stripslashes($menuitem->menu_item);
                $data['title'] = 'Updating Menu item ' . stripslashes($menuitem->menu_item);
            } else {
                $data['pagetitle'] = 'New - ' . stripslashes($cat->cat_name);
                $data['title'] = 'New - ' . stripslashes($cat->cat_name);
            }
        } elseif (isset($_GET['menu_id']) && ($_GET['menu_id'] != "") && ( isset($_GET['cat_id']) && ( $_GET['cat_id'] != "" || $_GET['cat_id'] == "0" ) )) {
            $data['category'] = 1;
            $data['menuList'] = $this->MRestActions->getAllMenu($rest_ID);
            if (isset($_GET['cat_id']) && (empty($_GET['cat_id']))) {
                $data['pagetitle'] = 'New Menu Category for ' . stripslashes($rest->rest_Name);
                $data['title'] = 'New Menu Category for ' . stripslashes($rest->rest_Name);
            } else {
                $data['menucat'] = $menucat = $this->MRestActions->getMenuCat($cat_id, $menu_id);
                $data['pagetitle'] = 'Updating Menu Category ' . stripslashes($menucat->cat_name);
                $data['title'] = 'Updating Menu Category ' . stripslashes($menucat->cat_name);
            }
        } else {
            $data['menu'] = 1;
            if ($menu_id == 0) {
                $data['pagetitle'] = 'New Menu Type for ' . stripslashes($rest->rest_Name);
                $data['title'] = 'New Menu Type for ' . stripslashes($rest->rest_Name);
            } else {
                $data['menucat'] = $menucat = $this->MRestActions->getMenu($menu_id);
                $data['pagetitle'] = 'Updating Menu Type ' . stripslashes($menucat->menu_name);
                $data['title'] = 'Updating Menu Type ' . stripslashes($menucat->menu_name);
            }
        }
        return view('admin.forms.menu', $data);
    }

    public function save() {
        $option = Input::get('menuActionSave');
        if ($option == "menu") {
            $rest = Input::get('rest_ID');
            $rest_data = $this->MRestActions->getRest($rest);
            if (Input::get('menu_name')) {
                if (Input::get('menu_id')) {
                    $this->MRestActions->updateMenu();
                    $this->MRestActions->updateRestLastUpdatedOn($rest);
                    $this->MAdmins->addActivity('Menu Type updated for ' . stripslashes(($rest_data->rest_Name)));
                    return returnMsg('success','adminrestmenu/', 'Menu Type updated successfully',[ $rest]);
                } else {
                    $last_insert_id = $this->MRestActions->addMenu();
                    $this->MRestActions->updateRestLastUpdatedOn($rest);
                    $this->MRestActions->updateMenuCats($rest, $last_insert_id);
                    $this->MAdmins->addActivity('Menu Type added for ' . stripslashes(($rest_data->rest_Name)));
                    $this->MAdmins->addRestActivity('A New Menu Type is added.', $rest_data->rest_ID, $last_insert_id);
                    return returnMsg('success','adminrestmenu/', 'Menu Type added successfully',[ $rest]);

                }
            } else {
                show_404();
            }
        }
        if ($option == "menucategory") {
            $rest = Input::get('rest_ID');
            $rest_data = $this->MRestActions->getRest($rest);
            if (Input::get('cat_name')) {
                if (Input::get('cat_id')) {
                    $this->MRestActions->updateMenuCat();
                    $this->MRestActions->updateRestLastUpdatedOn($rest);
                    $this->MAdmins->addActivity('Menu Category updated for ' . stripslashes(($rest_data->rest_Name)));
                    return returnMsg('success','adminrestmenu/', 'Menu Category updated successfully',array('id' => $rest, 'cat_id' => post('cat_id'), 'menu_id' => post('menu_id')));

                } else {
                    $last_inserted_id = $this->MRestActions->addMenuCat();
                    $this->MRestActions->updateRestLastUpdatedOn($rest);
                    $this->MAdmins->addActivity('Menu Category added for ' . stripslashes(($rest_data->rest_Name)));
                    $this->MAdmins->addRestActivity('A New Menu Category is added', $rest_data->rest_ID, $last_inserted_id);
                    return returnMsg('success','adminrestmenu/', 'Menu Category added successfully',array('id' => $rest, 'cat_id' => $last_inserted_id, 'menu_id' => post('menu_id')));

                }
            } else {
                return returnMsg('error','adminrestmenu/',  "something went wrong, Please try again.",array( $rest));

            }
        }
        if ($option == "menuitem") {
            $rest = Input::get('rest_ID');
            $rest_data = $restaurant = $this->MRestActions->getRest($rest);
            $image = "";
            if (Input::get('menu_item')) {
                $cat = Input::get('cat_id');
                $menu_id = Input::get('menu_id');
                if (Input::hasFile('menuItem_image')) {
                    $file = Input::file('menuItem_image');
                    $temp_name = $_FILES['menuItem_image']['tmp_name'];
                    $image = $save_name = uniqid(Config::get('settings.sitename')) . $file->getClientOriginalName();
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
                    if ($actualWidth < 200 && $actualHeight < 200) {
                        return returnMsg('error','adminrestmenu/', 'Image is very small. Please upload image which must be bigger than 200*200 width and height.',array('id' => $rest, 'cat_id' => $cat,'menu_id' => $menu_id, 'item' => $cat));

                    }
                    
                    
                    
                    $text_font = $rest_data->rest_Name . '-' . Input::get('menu_item') . '- azooma.co';
                    $textLayer = PHPImageWorkshop\ImageWorkshop::initTextLayer($text_font, public_path() . '/fonts/text.ttf', 13, 'ffffff', 0);
                    $textLayer->opacity(75);
                    $largeLayer->addLayerOnTop($textLayer, 20, 40, "RB");
                    $largeLayer->save(Config::get('settings.uploadpath') . "/images/menuItem/", $save_name, true, null, 80);
                    
                    $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/menuItem/" . $save_name);
                    $changelayer = clone $layer;
                    $changelayer->resizeInPixel(500, null);
                    $changelayer->save(Config::get('settings.uploadpath') . "/images/menuItem/", $save_name, true, null, 95);
                    
                    $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/menuItem/" . $save_name);
                    $layer->cropMaximumInPixel(0, 0, "MM");
                    $changelayer = clone $layer;
                    $changelayer->resizeInPixel(100, 100);
                    $changelayer->save(Config::get('settings.uploadpath') . "/images/menuItem/thumb/", $save_name, true, null, 95);

                } else {
                    $image = (Input::get('menuItem_image_old'));
                }

                if (Input::get('id')) {
                    $this->MRestActions->updateMenuItem($image);
                    $this->MRestActions->updateRestLastUpdatedOn($rest);
                    $this->MAdmins->addActivity('Menu updated for ' . stripslashes(($rest_data->rest_Name)));
                    return returnMsg('success','adminrestmenu/', 'Menu Item Updated successfully',array('id' => $rest, 'cat_id' => $cat,'menu_id' => $menu_id, 'item' => $cat));

                } else {
                    $last_inserted_id = $this->MRestActions->addMenuItem($image);
                    $this->MRestActions->updateRestLastUpdatedOn($rest);
                    $this->MAdmins->addActivity('Menu added for ' . stripslashes(($rest_data->rest_Name)));
                    $this->MAdmins->addRestActivity('A New Menu Item is added.', $rest_data->rest_ID, $last_inserted_id);
                    return returnMsg('success','adminrestmenu/', 'Menu Item Added successfully',array('id' => $rest, 'cat_id' => $cat,'menu_id' => $menu_id, 'item' => $cat));

                }
            } else {
                return returnMsg('error','adminrestmenu/',  "something went wrong, Please try again.",array( $rest));
            }
        }
    }

    public function status($id = 0) {
        $status = 0;
        $rest = 0;
        if (isset($_REQUEST['rest_ID'])) {
            $rest = $_REQUEST['rest_ID'];
        }
        $page = $this->MRestActions->getRestBranch($id);
        if (count($page) > 0) {
            if ($page->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'status' => $status,
                'lastUpdated' => date('Y-m-d H:i:s')
            );
            DB::table('rest_branches')->where('br_id', $id)->update($data);
            $this->MAdmins->addActivity('Branch Status changed successfully.' . $page->br_loc);
            return returnMsg('success','adminrestmenu/',  "Branch Status changed successfully.",array( $rest));

        }
        return returnMsg('error','adminrestmenu/',  "something went wrong, Please try again.",array( $rest));

    }

    public function delete($rest = 0) {
        if (!empty($rest)) {
            $rest_data = $this->MRestActions->getRest($rest);
        } else {
            return returnMsg('error','adminrestmenu/',  "something went wrong, Please try again.",array( $rest));
        }

        if (isset($_GET['menu_id']) && !isset($_GET['cat_id']) && !isset($_GET['item'])) {
            $this->MRestActions->deleteMenu(($_GET['menu_id']), $rest);
            $this->MRestActions->updateRestLastUpdatedOn($rest);
            $this->MAdmins->addActivity('Menu deleted for ' . stripslashes(($rest_data->rest_Name)));
            return returnMsg('success','adminrestmenu/',  "Menu deleted successfully",array( $rest));

        } elseif (isset($_GET['menu_id']) && isset($_GET['cat_id'])) {
            $cat_id = ($_GET['cat_id']);
            $menu_id = ($_GET['menu_id']);
            $this->MRestActions->deleteMenuCat($cat_id, $menu_id, $rest);
            $this->MRestActions->updateRestLastUpdatedOn($rest);
            $this->MAdmins->addActivity('Menu deleted for ' . stripslashes(($rest_data->rest_Name)));
            return returnMsg('success','adminrestmenu/', "Menu Category deleted successfully",array('id' => $rest, 'cat_id' => $cat_id, 'menu_id' => $menu_id));

        } elseif (isset($_GET['cat'])) {
            $this->MRestActions->deleteMenuItem(($_GET['item']));
            $this->MRestActions->updateRestLastUpdatedOn($rest);
            $this->MAdmins->addActivity('Menu item deleted for ' . stripslashes(($rest_data->rest_Name)));
            return returnMsg('success','adminrestmenu/', "Menu item deleted successfully",array('id' => $rest, 'item' => get('cat'), 'cat_id' =>get('cat'), 'menu_id' => get('menu_id')));

        } else {
            redirect('hungryn137/menu?rest=' . $rest);
        }
    }

    public function pdf($rest_ID = 0) {
        if (empty($rest_ID)) {
            return returnMsg('success','adminrestaurants',"something went wrong, Please try again.");
        }
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $rest = $this->MRestActions->getRest($rest_ID);
        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Menu Name', 'Menu Name Arabic', 'Last Updated', 'Actions'),
            'pagetitle' => 'List of All PDF Menu for ' . $rest->rest_Name,
            'title' => 'All PDF Menu for ' . $rest->rest_Name,
            'action' => 'adminrestaurants',
            'lists' => $this->MRestActions->getAllMenuPDF($rest_ID),
            'menuRequest' => $this->MRestActions->getNewMenuRequest($rest_ID, 1),
            'rest_ID' => $rest_ID,
            'rest' => $rest,
            'side_menu' => ['adminrestaurants','Add Restaurants']
        );

        return view('admin.partials.menupdf', $data);
    }

    public function formpdf($pdf = 0) {
        if (isset($_GET['rest']) && ($_GET['rest'] != "")) {
            $rest_ID = ($_GET['rest']);
        } else {
            return returnMsg('error','adminrestaurants',"something went wrong, Please try again.");
        }
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $rest = $this->MRestActions->getRest($rest_ID);
        if ($pdf == 0) {
            $data = array(
                'MRestActions' => $this->MRestActions,
                'MGeneral' => $this->MGeneral,
                'pagetitle' => 'Updating PDF Menu ' . $rest->rest_Name,
                'title' => 'Updating PDF Menu ' . $rest->rest_Name,
                'sitename' => $settings['name'],
                'rest_ID' => $rest_ID,
                'rest' => $rest,
                'js' => 'chosen.jquery,admin/branchform',
                'side_menu' => ['adminrestaurants','Add Restaurants'],
            );
        } else {
            $data = array(
                'MRestActions' => $this->MRestActions,
                'MGeneral' => $this->MGeneral,
                'pagetitle' => 'New PDF Menu',
                'title' => 'New PDF Menu',
                'sitename' => $settings['name'],
                'rest' => $rest,
                'rest_ID' => $rest_ID,
                'menupdf' => $this->MRestActions->getPDFMenu($pdf),
                'js' => 'chosen.jquery,admin/branchform',
                'side_menu' => ['adminrestaurants','Add Restaurants'],
            );
        }
        return view('admin.forms.menupdf', $data);
    }

    public function savepdf() {
        if (Input::get('rest_ID')) {
            $rest = Input::get('rest_ID');
            if (Input::get('title')) {
                ini_set("memory_limit", "-1");
                set_time_limit(0);
                $menu = $menuar = "";
                $numPages = $numPagesAr = 0;
                if (Input::get('id')) {
                    if (is_uploaded_file($_FILES['menu']['tmp_name'])) {
                        $menu = $this->upload_pdf('menu', menu_pdf_path());
                        $numPages = 0; //$this->savePdfAsImage($menu, 'images/', 'images/pdf/');
                    } else {
                        $menu = $_POST['menu_old'];
                        $numPages = $_POST['pagenumber'];
                    }
                    if (is_uploaded_file($_FILES['menu_ar']['tmp_name'])) {
                        $menuar = $this->upload_pdf('menu_ar', menu_pdf_path());
                        $numPagesAr = 0; //$this->savePdfAsImage($menuar, 'images/', 'images/pdf_ar/');
                    } else {
                        $menuar = $_POST['menu_ar_old'];
                        $numPagesAr = $_POST['pagenumberAr'];
                    }
                    $this->MRestActions->updatePDFMenu($menu, $menuar, $numPages, $numPagesAr);
                    $this->MRestActions->updateRestLastUpdatedOn($rest);
                    $this->MAdmins->addActivity('Menu updated for ' . stripslashes((Input::get('rest_Name'))));
                    $this->MAdmins->addRestActivity('A New PDF Menu is Added.', $rest, Input::get('id'));
                    return returnMsg('success','adminrestmenu/pdf/',"Menu updated successfully",[$rest]);

                } else {
                    if (is_uploaded_file($_FILES['menu']['tmp_name'])) {
                        $menu = $this->upload_pdf('menu', menu_pdf_path());
                        $numPages = 0; //$this->savePdfAsImage($menu, 'images/', 'images/pdf/');
                    }
                    if (is_uploaded_file($_FILES['menu_ar']['tmp_name'])) {
                        $menuar = $this->upload_pdf('menu_ar', menu_pdf_path());
                        $numPagesAr = 0; //$this->savePdfAsImage($menuar, 'images/', 'images/pdf_ar/');
                    }

                    $last_inserted_id = $this->MRestActions->addPDFMenu($menu, $menuar, $numPages, $numPagesAr);
                    $this->MRestActions->updateRestLastUpdatedOn($rest);
                    $this->MAdmins->addActivity('Menu Added for ' . stripslashes((Input::get('rest_Name'))));
                    $this->MAdmins->addRestActivity('A New PDF Menu is added.', $rest, $last_inserted_id);
                    return returnMsg('success','adminrestmenu/pdf/',"Menu Added successfully",[$rest]);

                }
            }
        } else {
            return returnMsg('success','adminrestaurants',"something went wrong, Please try again.");

        }
    }

    public function notified() {
        if (isset($_GET['rest']) && ($_GET['rest'] != "")) {
            $rest = ($_GET['rest']);
            $is_pdf = 0;
            if (isset($_GET['is_pdf']) && !empty($_GET['is_pdf'])) {
                $is_pdf = 1;
            }
            $menuRequest = $this->MRestActions->getNewMenuRequest($rest, $is_pdf);
            $rest_data = $this->MRestActions->getRest($rest);
            if (!empty($menuRequest) && is_array($menuRequest)) {
                $this->load->library('email');
                $config['charset'] = 'utf-8';
                $config['mailtype'] = 'html';
                $config['wordwrap'] = TRUE;
                $this->email->initialize($config);
                $data = array();
                $data['logo'] = $this->MGeneral->getLogo();
                $data['settings'] = $settings = $this->MGeneral->getSettings();
                $data['rest'] = $rest_data;
                $data['title'] = "Menu Notification for " . stripslashes($rest_data['rest_Name']);
                $data['sitename'] = $settings['name'];

                $this->email->from($this->config->item("mainemail"), "Sufrati.com");

                foreach ($menuRequest as $request) {
                    $data['user'] = $request;
                    $msgtoUsers = "";
                    $msgtoUsers = $this->load->view('mails/menunotification', $data, true);
                    $this->email->message($msgtoUsers);
                    $this->email->to($request['email']);
                    $this->email->bcc($this->config->item("teamemails"));
                    $this->email->bcc("nr@azooma.co");
                    $this->email->subject(stripslashes($rest_data['rest_Name']) . ' Menu is uploaded Now. - azooma.co');
                    $this->email->send();
                    $userdb = $this->load->database('user', TRUE);
                    $checkuserexists = $userdb->query('SELECT user_ID FROM user WHERE user_Email="' . $request['email'] . '" AND user_Status=1');
                    $userrequests = $checkuserexists->result_Array();
                    foreach ($userrequests as $usr) {
                        $msg = stripcslashes($rest_data['rest_Name']) . ' Menu is online now';
                        $msgar = stripcslashes($rest_data['rest_Name_ar']) . " القائمة غير متواجد حاليا";
                        $message = array('message' => $msg, 'url' => 'rest/' . $rest_data['rest_ID'], 'scenario' => 'url');
                        $this->MUser->pushNotify($usr['user_ID'], $message, $msg, $msgar);
                    }
                }
                $this->MRestActions->updateNewMenuRequest($rest);
                $this->session->set_flashdata('message', 'Notification send successfully');
                redirect('hungryn137/menu?rest=' . $rest);

            } else {
                $this->session->set_flashdata('message', 'Some error happen please try again');
                redirect('hungryn137/menu?rest=' . $rest);
            }
        } else {
            $this->session->set_flashdata('message', 'Some error happen please try again');
            redirect('hungryn137/menu?rest=' . $rest);
        }
    }

    public function deletepdf($pdf = 0) {
        if (isset($_GET['rest']) && ($_GET['rest'] != "")) {
            $rest = ($_GET['rest']);
        } else {
            return returnMsg('success','adminrestaurants',"something went wrong, Please try again.");

        }
        $this->MRestActions->deleteMenuPDF($pdf);
        $rest_data = $this->MRestActions->getRest($rest);
        $this->MAdmins->addActivity('Menu deleted for ' . stripslashes(($rest_data->rest_Name)));
        return returnMsg('success','adminrestmenu/pdf/',"PDF Menu deleted successfully",[$rest]);

        
    }

    function upload_pdf($name, $directory) {
        $uploadDir = $directory;
        // ======================= upload 1 ===========================
        if ($_FILES[$name]['name'] != '' && $_FILES[$name]['name'] != 'none') {
            $uploadFile_1 = uniqid('sufrati') . "_menu".time().rand(1,99).'.'.pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);
            $uploadFile1 = $uploadDir . $uploadFile_1;
            if (move_uploaded_file($_FILES[$name]['tmp_name'], $uploadFile1)) {
                //print "File is valid, and was successfully uploaded. \n\n ";
            } else {
                return null;
            }
            return $uploadFile_1;
        } else
            return null;
    }

    public function savePdfAsImage($fname, $directory, $savedir) {
        $filename = $directory . $fname;
        if ($fname != "" && file_exists($filename)) {
            $pdf = $filename;
            $pages = $this->getNumPagesPdf($pdf);
            $name = explode('.', $fname);
            if (mkdir($savedir . $name[0], 0755)) {
                for ($i = 0; $i < $pages; $i++) {
                    $j = $i + 1;
                    $im = new imagick();
                    $im->readimage($pdf . '[' . $i . ']');
                    $im->setImageFormat('jpg');
                    file_put_contents($savedir . $name[0] . '/' . $j . '.jpg', $im);
                }
            }
            return $pages;
        }
    }

    public function getNumPagesPdf($filepath) {

        $fp = @fopen(preg_replace("/\[(.*?)\]/i", "", $filepath), "r");
        if ($fp) {
            $max = 0;
            while (!feof($fp)) {
                $line = fgets($fp, 255);
                if (preg_match('/\/Count [0-9]+/', $line, $matches)) {
                    preg_match('/[0-9]+/', $matches[0], $matches2);
                    if ($max < $matches2[0])
                        $max = $matches2[0];
                }
            }
            fclose($fp);
        }else {
            // return 2;
        }
        if ($max == 0) {
            $im = new imagick($filepath);
            $max = $im->getNumberImages();
        }

        return $max;
    }

}
