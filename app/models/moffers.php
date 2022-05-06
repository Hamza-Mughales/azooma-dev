<?php

class MOffers extends Eloquent
{

    protected $table = 'offer_category';

    function getOfferBranch($id)
    {
        $list = DB::table('offer_branch')->where('offerID', '=', $id)->get();
        if (count($list) > 0) {
            return $list;
        }
        return [];
    }

    function getOffer($id)
    {
        $list = DB::table('rest_offer')->where('id', '=', $id)->first();
        if (count($list) > 0) {
            return $list;
        }
    }

    function getAllOffersAdmin($country = 0, $rest = 0, $status = 0, $limit = 5000)
    {
        $this->table = "rest_offer";
        $m_offers = MOffers::select('*');
        if (!empty($country)) {
            $m_offers->where('rest_offer.country', '=', $country);
        }
        if ($rest != 0) {
            $m_offers->where('rest_ID', '=', $rest);
        } else {
            $m_offers->join('restaurant_info', 'rest_offer.rest_ID', '=', 'restaurant_info.rest_ID');
        }
        if ($status != 0) {
            $m_offers->where('status', '=', 1);
        }
        $m_offers->orderBy('createdAt', 'DESC');
        if ($limit != "") {
            $lists = $m_offers->paginate($limit);
        } else {
            $lists = $m_offers->paginate();
        }
        if (count($lists) > 0) {
            return $lists;
        }
    }

    function getOfferCategory($id)
    {
        return $offers = DB::table('offer_category')
        ->join("rest_offer_category","offer_category.id",'=',"rest_offer_category.categoryID")
        ->where("rest_offer_category.offerID","=",$id)
        ->get();
    }

    function getAllOfferCategories($country = 0, $status = "", $city = 0, $limit = "", $name = "", $sort = "")
    {
        $this->table = "offer_category";
        $mOffers = MOffers::select('*');
        if ($country != 0) {
            $mOffers->where('offer_category.country', $country);
        }
        if ($status != "") {
            $mOffers->where('offer_category.status', '=', $status);
        }
        if ($city != 0) {
            $mOffers->join('rest_offer_category', 'rest_offer_category.categoryID', '=', 'offer_category.id');
            $mOffers->join('offer_branch', 'offer_branch.offerID', '=', 'rest_offer_category.offerID');
            $mOffers->join('rest_branches', 'rest_branches.br_id', '=', 'offer_branch.branchID')->where('rest_branches.city_ID', '=', $city);
            $mOffers->join('rest_offer', 'rest_offer.id', '=', 'rest_offer_category.offerID')->where('rest_offer.status', '=', '1');
            $mOffers->where('rest_offer.endDate', '>=', 'CURDATE()');
        }
        if ($name != "") {
            $mOffers->where('offer_category.categoryName', 'LIKE', $name . '%');
        }

        if (!empty($sort)) {
            switch ($sort) {
                case 'name':
                    $mOffers->orderBy('categoryName', 'ASC');
                    break;
                case 'latest':
                    $mOffers->orderBy('createdAt', 'DESC');
                    break;
            }
        }

        if ($limit != "") {
            $lists = $mOffers->paginate($limit);
        } else {
            $lists = $mOffers->paginate();
        }
        if (count($lists) > 0) {
            return $lists;
        }
        return null;
    }

    function addCategory()
    {
        if (isset($_POST['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'categoryName' => ($_POST['categoryName']),
            'categoryNameAr' => ($_POST['categoryNameAr']),
            'country' => $country,
            'status' => $status,
            'url' => Str::slug(($_POST['categoryName']), '-')
        );
        return $id = DB::table('offer_category')->insertGetId($data);
    }

    function updateCategory()
    {
        if (isset($_POST['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }
        $country = Session::get('admincountry');
        if (empty($country)) {
            $country = 1;
        }
        $data = array(
            'categoryName' => ($_POST['categoryName']),
            'categoryNameAr' => ($_POST['categoryNameAr']),
            'country' => $country,
            'status' => $status,
            'url' => Str::slug(($_POST['categoryName']), '-')
        );
        DB::table('offer_category')->where('id', $_POST['categoryID'])->update($data);
    }

    function deleteOfferCategory($id = 0)
    {
        DB::table('offer_category')->where('id', $id)->delete();
    }

    function addOfferCategory($ofrid, $catid)
    {
        $data = array(
            'offerID' => $ofrid,
            'categoryID' => $catid
        );
        return DB::table('rest_offer_category')->insertGetId($data);
    }

    function addOfferBranch($ofrid, $brid, $restID)
    {
        $data = array(
            'offerID' => $ofrid,
            'branchID' => $brid,
            'restID' => $restID
        );
        DB::table('offer_branch')->insertGetId($data);
    }

    function deleteOfferBranch($ofrid)
    {
        DB::table('offer_branch')->where('offerID', '=', $ofrid)->delete();
    }

    function addOffer($image, $imageAr)
    {
        if (isset($_POST['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }
        $data = array(
            'rest_ID' => (Input::get('rest_ID')),
            'offerName' => (Input::get('offerName')),
            'offerNameAr' => (Input::get('offerNameAr')),
            'shortDesc' => Input::get('shortDesc'),
            'shortDescAr' => Input::get('shortDescAr'),
            'longDesc' => htmlentities(Input::get('longDesc')),
            'longDescAr' => Input::get('longDescAr'),
            'image' => $image,
            'imageAr' => $imageAr,
            'startDate' => (Input::get('startDate')),
            'endDate' => (Input::get('endDate')),
            'startTime' => (Input::get('startTime')),
            'endTime' => (Input::get('endTime')),
            'terms' => htmlentities(Input::get('terms')),
            'termsAr' => (Input::get('termsAr')),
            'contactEmail' => (Input::get('contactEmail')),
            'contactPhone' => (Input::get('contactPhone')),
            'redeemurl' => (Input::get('redeemurl')),
            'status' => $status,
            'updatedAt' => date('Y-m-d H:i:s')
        );
        $ofrid = DB::table('rest_offer')->insertGetId($data);
        $cat = array();
        $br = array();
        if (isset($_POST['offerCategory'])) {
            $cat = $_POST['offerCategory'];
            for ($i = 0; $i < count($cat); $i++) {
                $this->addOfferCategory($ofrid, $cat[$i]);
            }
        }
        if (isset($_POST['restBranches'])) {
            $br = $_POST['restBranches'];
            $restid = Input::get('rest_ID');
            if ((count($br) == 1) && ($br[0] == 'all')) {
                $branchq = DB::table('rest_branches')->where('rest_fk_id', '=', $restid)->get();
                if (count($branchq) > 0) {
                    foreach ($branchq as $br) {
                        $this->addOfferBranch($ofrid, $br->br_id, $restid);
                    }
                
            } else {
                for ($i = 0; $i < count($br); $i++) {
                    $this->addOfferBranch($ofrid, $br[$i], $restid);
                }
            }
        }
    }
        return $ofrid;
    }

    ##Updated Haroon

   public function updateOffer($image, $imageAr)
    {
        if (isset($_POST['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }
        $data = array(
            'rest_ID' => (Input::get('rest_ID')),
            'offerName' => (Input::get('offerName')),
            'offerNameAr' => (Input::get('offerNameAr')),
            'shortDesc' => (Input::get('shortDesc')),
            'shortDescAr' => (Input::get('shortDescAr')),
            'longDesc' => htmlentities(Input::get('longDesc')),
            'longDescAr' => (Input::get('longDescAr')),
            'image' => $image,
            'imageAr' => $imageAr,
            'startDate' => (Input::get('startDate')),
            'endDate' => (Input::get('endDate')),
            'startTime' => (Input::get('startTime')),
            'endTime' => (Input::get('endTime')),
            'terms' => htmlentities(Input::get('terms')),
            'termsAr' => (Input::get('termsAr')),
            'contactEmail' => (Input::get('contactEmail')),
            'contactPhone' => (Input::get('contactPhone')),
            'redeemurl' => (Input::get('redeemurl')),
            'status' => $status,
            'updatedAt' => date('Y-m-d H:i:s')
        );
       
        DB::table('rest_offer')->where('id', '=', post('id'))->update($data);
        $ofrid = intval(post('id'));
        DB::table("rest_offer_category")->where("offerID","=",$ofrid )->delete();
        $this->deleteOfferBranch($ofrid);
        $cat = array();
        $restid = Input::get('rest_ID');
        $br = array();
        if (isset($_POST['offerCategory'])) {
            $cat = $_POST['offerCategory'];
            for ($i = 0; $i < count($cat); $i++) {
                $this->addOfferCategory($ofrid, $cat[$i]);
            }
        }
    
        if (isset($_POST['restBranches'])) {
            $br = $_POST['restBranches'];
            if ((count($br) == 1) && ($br[0] == 'all')) {
                $branchq = DB::table("rest_branches")->where('rest_fk_id', "=", $restid)->get();
                if (count($branchq) > 0) {
                    foreach ($branchq as $br) {
                        $this->addOfferBranch($ofrid, $br->br_id, Input::get('rest_ID'));
                    }
                }
            } else {
                for ($i = 0; $i < count($br); $i++) {
                    $this->addOfferBranch($ofrid, $br[$i], Input::get('rest_ID'));
                }
            }
        }
    
}

    function deleteOffer($rest = 0)
    {
        DB::table('rest_offer')->where('id', '=', $rest)->delete();
    }

  

    public static function getAllOffers($city = 0, $category = 0, $sort = "", $limit = 20, $offset = 0, $count = false)
    {
        $selectq = 'ro.id, oc.categoryName,oc.categoryNameAr,ri.rest_Name,ri.rest_Name_Ar,ri.rest_Logo,ri.seo_url,ri.rest_ID,ro.offerName,ro.offerNameAr,ro.image,ro.imageAr,ro.endDate,ro.endTime, getRestaurantTel(ro.rest_ID) as telephone,ro.shortDesc,ro.shortDescAr,ro.contactPhone ';
        $whereq = " WHERE ro.endDate >= CURDATE() ";
        if ($category != 0) {
            $whereq .= ' AND roc.categoryID=' . $category;
        }
        $joinq = " JOIN rest_branches rb ON rb.rest_fk_id=ro.rest_ID AND rb.city_ID=" . $city;
        $joinq .= " JOIN rest_offer_category roc ON roc.offerID=ro.id ";
        $joinq .= " JOIN offer_category oc ON oc.id=roc.categoryID AND oc.status=1";
        $joinq .= " JOIN restaurant_info ri ON ri.rest_ID=ro.rest_ID AND ri.rest_Status=1";
        $joinq .= ' JOIN offer_branch ob ON ob.offerID=ro.id AND ob.branchID=rb.br_id';
        $orderbyq = ' ';
        switch ($sort) {
            case "latest":
                $orderbyq .= 'ro.createdAt DESC';
                break;
            case "name":
                $orderbyq .= 'ro.offerName ASC';
                break;
            case "popular":
                $orderbyq .= 'ro.views DESC';
                break;
        }
        if ($count) {
            return DB::select(DB::raw(" SELECT COUNT(DISTINCT ro.id) as total  FROM rest_offer ro " . $joinq . " " . $whereq));
        } else {
            $query = "SELECT DISTINCT " . $selectq . ' FROM rest_offer ro ' . $joinq . ' ' . $whereq . ' ' . $orderbyq . ' LIMIT ' . $offset . ', ' . $limit;
            return DB::select($query);
        }
    }

    public static function getOfferCategories($offer = 0)
    {
        $q = "SELECT oc.categoryName,oc.categoryNameAr,oc.url,oc.id FROm offer_category oc JOIN rest_offer_category roc ON roc.offerID=:offer";
        return DB::select(DB::raw($q), array('offer' => $offer));
    }

    public static function getOfferBranches($offer = 0, $cityid = 0)
    {
        $q = "SELECT rb.br_id, rb.br_loc,rb.br_loc_ar,rb.br_number,rb.br_mobile,rb.br_toll_free,rb.br_Delivery, dl.district_Name,dl.district_Name_Ar FROM rest_branches rb JOIN offer_branch ob ON ob.branchID= rb.br_id AND ob.offerID = :offer JOIN district_list dl ON dl.district_ID=rb.district_ID AND dl.district_Status=1 WHERE rb.status=1 AND rb.city_ID=:cityid";
        return DB::select(DB::raw($q), array('offer' => $offer, 'cityid' => $cityid));
    }

    public static function getOtherOffers($city = 0, $offer = 0)
    {
        $selectq = 'ro.id, ri.rest_Name,ri.rest_Name_Ar,ro.offerName,ro.offerNameAr,ro.image,ro.imageAr ';
        $whereq = " WHERE ro.endDate >= CURDATE() AND ro.id!=" . $offer;
        $joinq = " JOIN rest_branches rb ON rb.rest_fk_id=ro.rest_ID AND rb.city_ID=" . $city;
        $joinq .= " JOIN restaurant_info ri ON ri.rest_ID=ro.rest_ID AND ri.rest_Status=1";
        $joinq .= ' JOIN offer_branch ob ON ob.offerID=ro.id AND ob.branchID=rb.br_id';
        $orderbyq = 'ORDER BY ro.createdAt DESC';
        $query = "SELECT DISTINCT " . $selectq . ' FROM rest_offer ro ' . $joinq . ' ' . $whereq . ' ' . $orderbyq . ' LIMIT 0,5';
        return DB::select($query);
    }

    public static function getPossibleOffer()
    {
    }
}
