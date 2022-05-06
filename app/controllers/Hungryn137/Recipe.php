<?php

class Recipe extends AdminController {

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
        $limit = 0;
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

        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $lists = $this->MBlog->getAllRecipe($country, $status, $sort, $limit, 0, $name, $views);

        $data = array(
            'sitename' => $settings['name'],
            'headings' => array('Title', 'Title Arabic', 'Total Views', 'Last Update on', 'Actions'),
            'resultheads' => array('name', 'nameAr', 'views', 'createdAt/updatedAt'),
            'actions' => array('edit', 'status', 'delete'),
            'pagetitle' => 'List of All Recipes ',
            'title' => 'All Recipes',
            'action' => 'adminrecipe',
            'statuslink' => 'adminrecipe/status',
            'deletelink' => 'adminrecipe/delete',
            'addlink' => 'adminrecipe/form',
            'lists' => $lists,
            'side_menu' => array('Blog','Recipes'),
        );

        return view('admin.partials.maincommonpage', $data);
    }

    public function form($id = 0) {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }

        if ($id != 0) {
            $page = $this->MBlog->getRecipe($id);
            $ingredients = $this->MBlog->getIngredients($id);
            $data = array(
                'ingredients' => $ingredients,
                'sitename' => $settings['name'],
                'pagetitle' => $page->name,
                'title' => $page->name,
                'page' => $page,
                'side_menu' => array('Blog','Recipes'),
            );
        } else {
            $data = array(
                'sitename' => $settings['name'],
                'pagetitle' => 'New Recipe',
                'title' => 'New Recipe',
                'side_menu' => array('Blog','Recipes'),
            );
        }
        return view('admin.forms.recipe', $data);
    }

    public function save() {
        $filename = "";
        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $temp_name = $_FILES['image']['tmp_name'];
            $filename = $file->getClientOriginalName();
            $filename = $save_name = uniqid(Config::get('settings.sitename')) . $filename;
            $conserveProportion = true;
            $thumbHeight = null;
            $positionX = 0; // px
            $positionY = 0; // px
            $position = 'MM';
            $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath($temp_name);
            $thumbLayer = clone $largeLayer;
            $largeLayer->save(Config::get('settings.uploadpath') . "/images/recipe", $save_name, true, null, 95);

            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/recipe/" . $save_name);
            $changelayer = clone $layer;
            $changelayer->resizeInPixel(490, 250);
            $changelayer->save(Config::get('settings.uploadpath') . "/images/recipe/thumb/", $save_name, true, null, 95);

            $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/recipe/" . $save_name);
            $layer->cropMaximumInPixel(0, 0, "MM");
            $changelayer = clone $layer;
            $changelayer->resizeInPixel(100, 100);
            $changelayer->save(Config::get('settings.uploadpath') . "/images/recipe/thumb/", $save_name, true, null, 95);
        } elseif (isset($_POST['image_old'])) {
            $filename = Input::get('image_old');
        }
        if (Input::get('id')) {
            $id = Input::get('id');
            $this->MBlog->updateRecipe($filename);
            $this->MBlog->deleteIngredients($id);
            if (isset($_POST['ingredient'])) {
                $totingredient = $_POST['ingredient'];
                $totingredientAr = $_POST['ingredientAr'];
                $totquantity = $_POST['quantity'];
                $totquantityAr = $_POST['quantityAr'];
                for ($i = 0; $i < count($totingredient); $i++) {
                    if ($totingredient[$i] != "") {
                        $ingredient = $totingredient[$i];
                        $ingredientAr = $totingredientAr[$i];
                        $quantity = $totquantity[$i];
                        $quantityAr = $totquantityAr[$i];
                        $this->MBlog->addIngredient($id, $quantity, $ingredient, $quantityAr, $ingredientAr);
                    }
                }
            }
            $obj = $this->MBlog->getRecipe($id);
            $this->MAdmins->addActivity('Recipe updated Succesfully - ' . $obj->name);
            return Redirect::route('adminrecipe')->with('message', "Recipe updated Succesfully.");
        } else {
            $id = $this->MBlog->addRecipe($filename);
            $this->MBlog->deleteIngredients($id);
            if (isset($_POST['ingredient'])) {
                $totingredient = $_POST['ingredient'];
                $totingredientAr = $_POST['ingredientAr'];
                $totquantity = $_POST['quantity'];
                $totquantityAr = $_POST['quantityAr'];
                for ($i = 0; $i < count($totingredient); $i++) {
                    if ($totingredient[$i] != "") {
                        $ingredient = $totingredient[$i];
                        $ingredientAr = $totingredientAr[$i];
                        $quantity = $totquantity[$i];
                        $quantityAr = $totquantityAr[$i];
                        $this->MBlog->addIngredient($id, $quantity, $ingredient, $quantityAr, $ingredientAr);
                    }
                }
            }
            $obj = $this->MBlog->getRecipe($id);
            $this->MAdmins->addActivity('Article Added Succesfully - ' . $obj->name);
            return Redirect::route('adminrecipe')->with('message', "Recipe Added Succesfully.");
        }
        return Redirect::route('adminrecipe')->with('error', "something went wrong, Please try again.");
    }

    public function status($id = 0) {
        $status = 0;
        $page = $this->MBlog->getRecipe($id);
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
            DB::table('recipe')->where('id', $id)->update($data);
            $this->MAdmins->addActivity('Recipe Status changed successfully.' . $page->name);
            return Redirect::route('adminrecipe')->with('message', "Recipe Status changed successfully.");
        }
        return Redirect::route('adminrecipe')->with('error', "something went wrong, Please try again.");
    }

    public function delete($id = 0) {
        $status = 0;
        $page = $this->MBlog->getRecipe($id);
        if (count($page) > 0) {
            DB::table('recipe')->where('id', $id)->delete();
            $this->MAdmins->addActivity('Recipe Deleted successfully.' . $page->name);
            return Redirect::route('adminrecipe')->with('message', "Recipe Deleted successfully.");
        }
        return Redirect::route('adminrecipe')->with('error', "something went wrong, Please try again.");
    }

    public function missingMethod($parameters) {
        //return Redirect::route('adminrecipe')->with('error', "something went wrong, Please try again.");
    }

}
