
<?php 
  if(Session::has('sfcity')){
    $city=DB::table('city_list')->select('city_Name','city_Name_ar','seo_url','city_thumbnail')->where('city_ID',Session::get('sfcity'))->where('city_status',1)->first();
    $countryID=DB::table('city_list')->select('country')->where('seo_url',$city->seo_url)->first();
    $country=DB::table('aaa_country')->select('id','flag','name','nameAr')->where('id',$countryID->country)->get();
    $mycities=DB::table('city_list')->select('city_Name','city_Name_ar','seo_url','city_thumbnail')->where('city_status',1)->where('country',$countryID->country)->orderBy('city_Name','asc')->get();
    $city=$city=MGeneral::getCityURL($city->seo_url);
}else{
    $ip = $_SERVER['REMOTE_ADDR'];
    $details = "";
    if($ip == 0){
        $details = json_decode(file_get_contents("http://ip-api.com/json/"));
    }else{
        $details = json_decode(file_get_contents("http://ip-api.com/json/".$ip));
    }
    $currentCountryIP = $details->country;
    $Getcityname = $details->city;
   
    $country=DB::table('aaa_country')->select('id','flag','name','nameAr')->where('name',$currentCountryIP)->first();
    $mycities=DB::table('city_list')->select('city_Name','city_Name_ar','seo_url','city_thumbnail')->where('city_status',1)->where('country',$country->id)->orderBy('city_Name','asc')->get();
    $city=DB::table('city_list')->select('city_ID','city_Name','city_Name_ar','seo_url','city_thumbnail')->where('city_Name',$Getcityname)->where('city_status',1)->first();
    if(count($city) > 0){
    }else{
        $city=DB::table('city_list')->select('city_ID','city_Name','city_Name_ar','seo_url','city_thumbnail')->where('country',$country->id)->where('city_status',1)->first();
    }
   
    Config::set('session.lifetime',365*12*3600);
    Session::put('sfcity',$city->city_ID);
}
$city=$city=MGeneral::getCityURL($city->seo_url);
if(isset($city)){
    // Get Country
    // $CurrentCountry=DB::table('city_list')->select('country')->where('seo_url',$city->seo_url)->first();
    // $mycities=DB::table('city_list')->select('city_Name','city_Name_ar','seo_url','city_thumbnail')->where('city_status',1)->where('country',$CurrentCountry->country)->orderBy('city_Name','asc')->get();
?>
<script src="<?php echo URL::asset('js/jquery-ui.js');?>"></script>

<section class="header-search-top">
    <div class="container">
        <div class="row">
            <div class="col-12">       
                    <form class="search-from form-inline" method="get" action="">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group row">           
                                    <select id="chooseCity" class="form-select">
                                        <option selected><?php echo Lang::get('messages.SelectCity'); ?></option>
                                        <?php if(isset($mycities) > 0){  foreach ($mycities as $newcity ) {
                                            $cityname=($lang=="en")?stripcslashes($newcity->city_Name):stripcslashes($newcity->city_Name_ar);
                                        ?>
                                        <option <?php if($city->city_Name == $newcity->city_Name) echo "selected" ?> value="<?php echo strtolower($newcity->city_Name) ?>"><?php echo $cityname ?></option>
                                        <?php } } ?>
                                    </select> 
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group row" id="main-search-container">
                                    <input name="query" type="search" autocomplete="off" class="form-control" id="rest_search" placeholder="<?php echo Lang::get('messages.Searchplaces&restaurant'); ?>"/>
                                </div>
                            </div>
                            
                        </div>
                        <div class="search-tabs">
                            <li class="active" data-bs-target="restaurantstitle"><?php echo Lang::get('messages.restaurantstitle'); ?></li>
                            <li data-bs-target="cuisinestitle"><?php echo Lang::get('messages.cuisinestitle'); ?></li>
                            <li data-bs-target="menutitle"><?php echo Lang::get('messages.menutitle'); ?></li>
                            <li data-bs-target="dishestitle"><?php echo Lang::get('messages.dishestitle'); ?></li>
                            <li data-bs-target="locationstitle"><?php echo Lang::get('messages.locationstitle'); ?></li>
                        </div>
                    </form>
             
            </div>
        </div>
    </div>
    <ul id="searchResult"></ul>

</section>
<?php } ?>