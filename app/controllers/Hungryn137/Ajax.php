<?php

class Ajax extends AdminController {

    protected $MAdmins;
    protected $MGeneral;
    protected $mSearch;

    public function __construct() {
        parent::__construct();
        $this->MAdmins = new Admin();
        $this->MGeneral = new MGeneral();
        $this->mSearch = new mSearch();
    }

    public function index() {
        
    }
	public function adminsearch()	{
		$lang=Config::get('app.locale');
		$search= "";
        $city="";
        $data=array();
     
		if(Input::has('search')){
			$search=Input::get('search');
		}
		// echo $query2[1];
   
        $restresults =  $this->mSearch->getRestaurantsAll($search);

        $data['restaurants']=$restresults;
        $data['search']=$search;
        $data['lang']=$lang;
        return Response::json($data);
		
	}
    public function getCitiesList($countryID) {
        if (!empty($countryID)) {
            $this->MLocation = new MLocation();
            $iselected = "";
            $name = "cities[]";
            if (isset($_GET['iselected']) && !empty($_GET['iselected'])) {
                $iselected = $_GET['iselected'];
            }
            if (isset($_GET['name']) && !empty($_GET['name'])) {
                $name = $_GET['name'];
            }
            $cats = $this->MLocation->getAllCities(1, '', '',$countryID);            
            $html = $this->MGeneral->generateSelect($cats, $name, 'required chzn-select', $iselected,'','city_Name','city_ID','multiple');
            $data['html'] = $html;
            $data['total'] = count($cats);
            return Response::json($data);
        } else {
            return '';
        }
    }

    public function missingMethod($parameters = array()) {
        return Redirect::route('adminaccess')->with('message', "something went wrong, Please try again.");
    }

}