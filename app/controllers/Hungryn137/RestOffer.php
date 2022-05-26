<?php

class RestOffer extends AdminController
{

    protected $MAdmins;
    protected $MGeneral;
    protected $MOffers;

    public function __construct()
    {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MGeneral = new MGeneral();
        $this->MRestActions = new MRestActions();
        $this->MOffers = new MOffers();
    }

    public function index($restID = 0)
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        $limit = 20;
        if (isset($_GET['limit']) && ($_GET['limit'] != "")) {
            $limit = ($_GET['limit']);
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $country = 1;
        $rest = $this->MRestActions->getRest($restID);
        $lists = $this->MOffers->getAllOffersAdmin($country, $restID, 0, 5000);

        $data = array(
            'sitename' => $settings['name'],
            'MGeneral' => $this->MGeneral,
            'headings' => array('Title', 'Description', 'Start Date', 'End Date', 'Last Updated', 'Actions'),
            'pagetitle' => 'List of All Offers for ' . $rest->rest_Name,
            'title' => 'All Offers for ' . $rest->rest_Name,
            'action' => 'adminrestoffer',
            'lists' => $lists,
            'rest_ID' => $restID,
            'rest' => $rest,
            'side_menu' => ['adminrestaurants', 'Add Restaurants'],
        );

        return view('admin.partials.restaurantoffer', $data);
    }

    public function form($offer_ID = 0)
    {
        if (Session::get('admincountryName') != "") {
            $settings = Config::get('settings.' . Session::get('admincountryName'));
        } else {
            $settings = Config::get('settings.default');
        }
        if (Input::has('rest_ID')) {
            $rest_ID = Input::get('rest_ID');
        } else {
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $rest = $this->MRestActions->getRest($rest_ID);
        $offercategories = $this->MOffers->getAllOfferCategories(1);
        $restbranches = $this->MRestActions->getAllBranches($rest_ID);
        if ($offer_ID == 0) {
            $data = array(
                'pagetitle' => 'New Offer for ' . stripslashes($rest->rest_Name),
                'title' => 'New Offer for ' . stripslashes($rest->rest_Name),
                'MRestActions' => $this->MRestActions,
                'MGeneral' => $this->MGeneral,
                'sitename' => $settings['name'],
                'rest' => $rest,
                'offercategories' => $offercategories,
                'restbranches' => $restbranches,
                "restoffercategory" => [],
                "restofferbranches" => [],
                'rest_ID' => $rest_ID,
                'js' => 'admin/jquery-ui,chosen.jquery',
                'css' => 'chosen,admin/jquery-ui',
                'side_menu' => ['adminrestaurants', 'Add Restaurants'],
            );
        } else {
            $offer = $this->MOffers->getOffer($offer_ID);
            $restoffercategory = $this->MOffers->getOfferCategory($offer_ID);
            $restofferbranches = $this->MOffers->getOfferBranch($offer_ID);
            $data = array(
                'pagetitle' => 'Updating Offer ' . stripslashes($offer->offerName),
                'title' => 'Updating Offer ' . stripslashes($offer->offerName),
                'MRestActions' => $this->MRestActions,
                'MGeneral' => $this->MGeneral,
                'sitename' => $settings['name'],
                'rest' => $rest,
                'offercategories' => $offercategories,
                'restbranches' => $restbranches,
                "restoffercategory" => $restoffercategory,
                "restofferbranches" => $restofferbranches,
                'offer' => $offer,
                'rest_ID' => $rest_ID,
                'js' => 'admin/jquery-ui,chosen.jquery',
                'css' => 'chosen,admin/jquery-ui',
                'side_menu' => ['adminrestaurants', 'Add Restaurants'],
            );
        }
        return view('admin.forms.restoffer', $data);
    }

    public function save()
    {
        $rest = Input::get('rest_ID');
        $restaurant = $this->MRestActions->getRest($rest);
        $restname = stripslashes($restaurant->rest_Name);
        if (Input::get('offerName')) {
            $image = "";
            $imageAr = "";
            $actualWidth = "";
            $ratio = "0";
            $thumbHeight = null;
            $conserveProportion = true;
            $positionX = 0; // px
            $positionY = 0; // px
            $position = 'MM';
            //IMAGE FOR ENGLISH 
            if (Input::hasFile('image')) {
                $file = Input::file('image');
                $temp_name = $_FILES['image']['tmp_name'];
                $image = $save_name = uniqid(Config::get('settings.sitename')) . $file->getClientOriginalName();
                $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath($temp_name);
                $thumbLayer = clone $largeLayer;
                //get Size of the Image and reSize
                $actualWidth = $largeLayer->getWidth();
                $actualHeight = $largeLayer->getHeight();
                $ratio = $actualWidth / $actualHeight;
                if ($actualWidth < 200 && $actualHeight < 200) {
                    return returnMsg('error', 'adminrestoffer/form/', 'Image is very small. Please upload image which must be bigger than 200*200 width and height.', array('id' => intval(get('id')), 'rest_ID' => $rest));
                }
                //WaterMark on the Image
                $text_font = $restaurant->rest_Name . '-' . Input::get('offerName') . '- azooma.co';
                $textLayer = PHPImageWorkshop\ImageWorkshop::initTextLayer($text_font, public_path() . '/fonts/text.ttf', 13, 'ffffff', 0);
                $textLayer->opacity(75);
                $largeLayer->addLayerOnTop($textLayer, 20, 40, "RB");
                //reSize image
                if (($actualWidth > 800) || ($actualHeight > 500)) {
                    $largeLayer->resizeInPixel(800, $thumbHeight, $conserveProportion, $positionX, $positionY, $position);
                }
                //Saving image
                $largeLayer->save(Config::get('settings.uploadpath') . "/images/offers", $save_name, true, null, 95);

                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/offers/" . $save_name);
                $layer->cropMaximumInPixel(0, 0, "MM");
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(100, 100);
                $changelayer->save(Config::get('settings.uploadpath') . "/images/offers/thumb/", $save_name, true, null, 95);
            } else {
                if (Input::has('image_old')) {
                    $image = Input::get('image_old');
                }
            }
            //IMAGE FOR ARABIC
            if (Input::hasFile('imageAr')) {
                $file = Input::file('imageAr');
                $temp_name = $_FILES['imageAr']['tmp_name'];
                $imageAr = $save_name = uniqid(Config::get('settings.sitename')) . $file->getClientOriginalName();
                $largeLayer = PHPImageWorkshop\ImageWorkshop::initFromPath($temp_name);
                $thumbLayer = clone $largeLayer;
                //get Size of the Image and reSize
                $actualWidth = $largeLayer->getWidth();
                $actualHeight = $largeLayer->getHeight();
                $ratio = $actualWidth / $actualHeight;
                if ($actualWidth < 200 && $actualHeight < 200) {
                    return returnMsg('error', 'adminrestoffer/form/', 'Image is very small. Please upload image which must be bigger than 200*200 width and height.', array('id' => intval(get('id')), 'rest_ID' => $rest));
                }
                //WaterMark on the Image
                $text_font = $restaurant->rest_Name . '-' . Input::get('offerName') . '- azooma.co';
                $textLayer = PHPImageWorkshop\ImageWorkshop::initTextLayer($text_font, public_path() . '/fonts/text.ttf', 13, 'ffffff', 0);
                $textLayer->opacity(75);
                $largeLayer->addLayerOnTop($textLayer, 20, 40, "RB");
                //reSize image
                if (($actualWidth > 800) || ($actualHeight > 500)) {
                    $largeLayer->resizeInPixel(800, $thumbHeight, $conserveProportion, $positionX, $positionY, $position);
                }
                //Saving image
                $largeLayer->save(Config::get('settings.uploadpath') . "/images/offers/", $save_name, true, null, 95);

                $layer = PHPImageWorkshop\ImageWorkshop::initFromPath(Config::get('settings.uploadpath') . "/images/offers/" . $save_name);
                $layer->cropMaximumInPixel(0, 0, "MM");
                $changelayer = clone $layer;
                $changelayer->resizeInPixel(100, 100);
                $changelayer->save(Config::get('settings.uploadpath') . "/images/offers/thumb/", $save_name, true, null, 95);
            } else {
                if (Input::has('image_old')) {
                    $imageAr = Input::get('imageAr_old');
                }
            }
            //IF OFFER ALREADY EXISTS
            if (Input::get('id')) {
                $this->MOffers->updateOffer($image, $imageAr);
                $this->MRestActions->updateRestLastUpdatedOn($rest);
                $this->MAdmins->addActivity('Updated Offer ' . Input::get('offerName') . ' ' . $restname);
                $this->MAdmins->addRestActivity('Updated his offer.', $restaurant->rest_ID, Input::get('id'));
                return returnMsg('success', 'adminrestoffer/', 'Offer updated Successfully.', array($rest));
            } else {
                $last_inserted_id = $this->MOffers->addOffer($image, $imageAr);
                $this->MRestActions->updateRestLastUpdatedOn($rest);
                $this->MAdmins->addActivity('Added Offer ' . stripslashes(htmlspecialchars(Input::get('offerName'))) . ' ' . stripslashes(htmlspecialchars($restname)));
                $this->MAdmins->addRestActivity('Added a New offer.', $restaurant->rest_ID, $last_inserted_id);
                return returnMsg('success', 'adminrestoffer/', 'Offer added Successfully.', array($rest));
            }
        } else {
            return returnMsg('error', 'adminrestoffer/', 'something went wrong, Please try again.', array($rest));
        }
    }

    public function delete($id = 0)
    {
        if (isset($_REQUEST['rest_ID']) && !empty($_REQUEST['rest_ID'])) {
            $rest = $_REQUEST['rest_ID'];
            $rest_data = $this->MRestActions->getRest($rest);
        } else {
            return returnMsg('error', 'adminrestaurants', "something went wrong, Please try again.");
        }
        $this->MOffers->deleteOffer($id);
        $this->MRestActions->updateRestLastUpdatedOn($rest);
        $this->MAdmins->addActivity('Image deleted ' . stripslashes(($rest_data->rest_Name)));
        return returnMsg('success', 'adminrestoffer/',  "Image deleted succesfully", [$rest]);
    }
}
