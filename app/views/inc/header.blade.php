{{-- Check If Home --}}
<?php 
$countries=DB::table('aaa_country')->select('id','flag','name','nameAr')->get();
$countriesname="";
$i=0;
$tcountries=array();
foreach ($countries as $country) {
$i++;
$countriesname.=($lang=="en")?stripcslashes($country->name):stripcslashes($country->nameAr);
if($i<count($countries)){
$countriesname.=', ';
}
$cities=DB::table('city_list')->select('city_Name','city_Name_ar','seo_url','city_thumbnail')->where('city_status',1)->where('country',$country->id)->orderBy('city_Name','asc')->get();
$tcountries[$i]=$country;
$tcountries[$i]->cities=$cities;
}
$countries = $tcountries;
$checklanding=FALSE;
// $lang=Config::get('app.locale');
// if(((Config::get('app.locale')=="en")&&(Request::segment(1)==""))||((Config::get('app.locale')=="ar")&&Request::segment(2)=="")){
// $checklanding=TRUE;
// }
if(isset($nonav)&&$nonav){
$checklanding=TRUE;
}
?>
<body>
<div id="azooma-loader">
  <img src="<?php echo asset('img/loader.gif'); ?>">
</div>
<!-- Top Header Start -->
<header class="azooma-top-header">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-sm-12 mobile-hide align-items-center">
        <ul class="social-media-header">
          <?php 
              if(isset($city) && $city != null){
                  $country=MGeneral::getCountry($city->country);
              }else{
                  $country=MGeneral::getCountry(1);
              } 
            ?>
          <li>
            <a href="<?php echo $country->facebook;?>">
              <ion-icon name="logo-facebook"></ion-icon>
            </a>
          </li>
          <li>
            <a href="<?php echo $country->instagram;?>">
              <ion-icon name="logo-instagram"></ion-icon>
            </a>
          </li>
          <li>
            <a href="<?php echo $country->youtube;?>">
              <ion-icon name="logo-youtube"></ion-icon>
            </a>
          </li>
          <li>
            <a href="<?php echo $country->twitter;?>">
              <ion-icon name="logo-twitter"></ion-icon>
            </a>
          </li>
        </ul>
      </div>
      <div class="col-md-6 col-sm-12">
          <ul class="right-top-header">
              <li>
                <?php if(isset($city)){ ?>
                <a href="<?php echo Azooma::URL($city->seo_url.'/add-restaurant/');?>"><?php echo Lang::get('messages.add_restaurant');?></a>
                <?php } ?>
              </li>
              <li>
                <div class="dropdown">
                  <a class="dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo ($lang=="en")? 'English' : "عربي" ;?>
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li>
                       <a href="<?php echo Azooma::LanguageSwitch_new(Request::path('','ar'));?>">  <?php echo ($lang=="en")? 'English' : "عربي" ;?></a>
                    </li>
                    <li>
                       <a href="<?php echo Azooma::LanguageSwitch(Request::path('/'));?>"> <?php echo ($lang=="en")? 'عربي' : "English" ;?></a>
                    </li>
                  </ul>
                </div>
              </li>
          </ul>
      </div>
    </div>
  </div>
</header>
<!-- Top Header End -->

{{-- Check Header If Home or not --}}
<?php   if($checklanding) {?>
<nav class="navbar navbar-expand-lg mb-8">
  <?php } else { ?>
  <nav class="navbar navbar-expand-lg mb-8">
    <?php } ?>
    <div class="container">
      {{-- Logo --}}
      <?php 
        $cityurl=$cityname='';
        if(Session::get('sfcity')!=null){
          $cityid=Session::get('sfcity');
          $city=DB::select('SELECT city_Name,city_Name_ar,seo_url,country FROM city_list WHERE city_Status=1 AND city_ID='.$cityid.' LIMIT 1');
            if(count($city)>0){
              $cityurl=$city[0]->seo_url;
              $cityname=(Config::get('app.locale')=="en")?stripcslashes($city[0]->city_Name):stripcslashes($city[0]->city_Name_ar);
              
          }
        }
        
        $logo=DB::table('art_work')->select('image','image_ar')->where('active',1)->where('art_work_name','Azooma Logo')->first();
        if(count($logo)>0){
        $logoimage=($lang=="en")?$logo->image:$logo->image_ar;
        
        ?>
      <a class="navbar-brand" href="<?php echo Azooma::URL($cityurl);?>">
        <img src="<?php echo Azooma::CDN('sufratilogo/'.$logoimage);?>" height="50"
          alt="<?php echo Lang::get('messages.azooma');?>" />
      </a>
      <?php } ?>
      <div class="location-choose-header">
     <div class="d-flex align-items-center">
       
      <button type="button" id="locationdropDown" aria-expanded="false">
        {{-- SVG Icon --}}
    <ion-icon name="location-outline"></ion-icon> 
        <i class="fa fa-angle-down"></i> 
      </button>
      <?php if($checklanding == true) { ?>
      <a href="<?php echo Azooma::URL($cityurl);?>"><?php echo $cityname; ?></a>
      <?php } else { ?>
        <a class="d-flex" href="<?php echo Azooma::URL('');?>"><ion-icon style="font-size: 20px;height: 23px; margin:0 10px" name="earth-outline"></ion-icon></a>
      <?php } ?>
     </div>
        <div class="world-map">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 col-sm-12">
                <h3>  <?php echo Lang::get('messages.Countries'); ?>
                </h3>
                <ul class="countries">
                  <?php
                  $selectedCountry = "";
                  if(isset($country)) {
                    $selectedCountry = $country->name;
                  }
                  if(count($countries)>0){
                  foreach ($countries as $country) {
                  $tcities= $country->cities;
                  ?>
                  <li data-bs-target="<?php echo stripcslashes($country->name); ?>"
                    class="<?php if($selectedCountry == $country->name) echo "active"; ?>">
                    <?php echo ($lang=="en")?stripcslashes($country->name):stripcslashes($country->nameAr); ?>
                    <i class="fa fa-angle-<?php if($lang=="en"){ echo "right"; }else{ echo "left"; } ?>">
                    </i>
                  </li>
                  <?php } }?>
                </ul>
              </div>
              <div class="col-md-6 col-sm-12 region">
                <h3><?php echo Lang::get('messages.regions'); ?>
                </h3>
                <ul>
                  <?php
                      $selectedCity = "";
                      if((Session::get('sfcity')!=null)){
                        $cityid=Session::get('sfcity');
                        $city=DB::select('SELECT city_Name,city_Name_ar,seo_url,country FROM city_list WHERE city_Status=1 AND city_ID='.$cityid.' LIMIT 1');
                        if(count($city)>0){
                          $selectedCity = $city[0]->city_Name;
                        }
                     }
                  if(count($countries)>0){
                    foreach ($countries as $country) {
                    $tcities=$country->cities;
                    if(count($tcities) > 0){
                    $total=count($tcities);
                    $splitter=round($total/6);
                    $citysplitted=array_chunk($tcities,6);
                    foreach ($citysplitted as $cities) {
                    foreach ($cities as $city) {
                    $cityname=($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);
                    
                    ?>
                  <li data-bs-target="<?php echo stripcslashes($country->name); ?>"   class="<?php if($selectedCity == $city->city_Name) echo "active"; ?>"
                    style="<?php if($selectedCountry == $country->name) echo "display: list-item;"; ?>">
                    <a href="<?php echo Azooma::URL($city->seo_url);?>"
                      title="<?php echo Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
                      <?php
                        echo ($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);
                        ?>
                    </a>
                  </li>
                  <?php } } } } } ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      {{-- Mobile Menu Button --}}
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="navbarSupportedContent">
        <span class="mobile-nav-bar"></span>
        <span class="mobile-nav-bar"></span>
      </button>
      <?php 
              $loggedin=false;
              if(Session::has('userid')){
              $userid=Session::get('userid');
              $user=User::checkUser($userid);
              if(count($user)>0){
              $loggedin=TRUE;
              $username=($user[0]->user_NickName=="")?stripcslashes($user[0]->user_FullName):stripcslashes($user[0]->user_NickName);
              $userimage=($user[0]->image!="")?$user[0]->image:'user-default.svg';
              $usermininame=explode(' ',trim($username))[0];
            
              }
              } ?>
      <?php    if(($checklanding)&&(Session::get('sfcity')==null)) {?>
      {{-- Start Menu --}}
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav m-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="#Features">
              <?php echo Lang::get('messages.features'); ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo Azooma::URL($cityurl.'gallery');?>"
              title="<?php echo Lang::get('messages.photos').' '.Lang::get('messages.and').' '.Lang::get('messages.videos').' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
              <?php echo Lang::get('messages.food').' '.Lang::get('messages.gallery');?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo Azooma::URL('blog');?>"
              title="<?php echo Lang::get('messages.blog');?>">
              <?php echo Lang::get('messages.blog');?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo Azooma::URL('recipes');?>"
              title="<?php echo Lang::get('messages.recipes');?>">
              <?php echo Lang::get('messages.recipes');?>
            </a>
          </li>
        </ul>
        <div class="d-flex header-account-end">
        <button class="search-icon  mobile-hide" id="search-icon">
            <ion-icon name="search"></ion-icon>
          </button>
          <div class="dropdown header-account-dropdown">
            <button class="dropdown-toggle" id="account_dropdown" data-bs-toggle="dropdown" aria-expanded="false">
             <ion-icon name="person-circle-outline"></ion-icon> <i class="fa fa-angle-down"></i>
              </button>
              <ul class="dropdown-menu" aria-labelledby="account_dropdown">
                <li>
                    <a class="login-link" href="javascript:void(0)">  <?php echo Lang::get('messages.login'); ?></a>
                </li>
                <li>
                <a class="register-link" href="javascript:void(0)">  <?php echo Lang::get('messages.register'); ?></a>
                </li>
              </ul>
            </div>
        </div>
      </div>
      <?php } else { ?>
      {{-- Start Menu --}}
      <?php 
        $cityurl=$cityname='';
        if((Session::get('sfcity')!=null)){
        $cityid=Session::get('sfcity');
        $city=DB::select('SELECT city_Name,city_Name_ar,seo_url,country FROM city_list WHERE city_Status=1 AND city_ID='.$cityid.' LIMIT 1');
        if(count($city)>0){
        $cityurl=$city[0]->seo_url;
        $cityname=(Config::get('app.locale')=="en")?stripcslashes($city[0]->city_Name):stripcslashes($city[0]->city_Name_ar);
        
         ?>
      <style>
        .dropdown-submenu {
          position: relative;
        }

        .dropdown-submenu .dropdown-menu {
          top: 0;
          left: 100%;
          margin-top: -1px;
        }
      </style>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav m-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              <?php echo Lang::get('messages.explore'); ?>   <?php if(!$checklanding) { echo $cityname; }?>  <i class="fa fa-angle-down"></i>
               
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li> <a class="dropdown-item" href="<?php echo Azooma::URL($cityurl.'/near-me');?>"
                  title="<?php echo Lang::choice('messages.restaurants',2).' '.Lang::get('messages.near_you') ;?>">
                  <?php echo Lang::choice('messages.restaurants',2).' '.Lang::get('messages.near_you') ;?>
                </a></li>
              <li> <a class="dropdown-item" href="<?php echo Azooma::URL($cityurl.'/latest');?>"
                  title="<?php echo Lang::get('messages.latest').' '.Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname)) ;?>">
                  <?php echo Lang::get('messages.latest').' '.Lang::choice('messages.restaurants',2) ;?>
                </a></li>
              <li> <a class="dropdown-item" href="<?php echo Azooma::URL($cityurl.'/home-delivery');?>"
                  title="<?php echo Lang::get('messages.home-delivery').' '.Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname)) ;?>">
                  <?php echo Lang::get('messages.home-delivery');?>
                </a></li>
              <li> <a class="dropdown-item" href="<?php echo Azooma::URL($cityurl.'/fine-dining');?>"
                  title="<?php echo Lang::get('messages.fine-dining').' '.Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname)) ;?>">
                  <?php echo Lang::get('messages.fine-dining');?>
                </a></li>
              <li> <a class="dropdown-item" href="<?php echo Azooma::URL($cityurl.'/popular');?>"
                  title="<?php echo Lang::get('messages.popular').' '.Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname)) ;?>">
                  <?php echo Lang::get('messages.popular').' '.Lang::choice('messages.restaurants',2) ;?>
                </a></li>
              <li> <a class="dropdown-item" href="<?php echo Azooma::URL($cityurl.'/offers');?>"
                  title="<?php echo Lang::get('messages.special_offers').' '.Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname)) ;?>">
                  <?php echo Lang::get('messages.special_offers');?>
                </a></li>
              <li> <a class="dropdown-item" href="<?php echo Azooma::URL($cityurl.'/catering');?>"
                  title="<?php echo Lang::get('messages.catering').' '.Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname)) ;?>">
                  <?php echo Lang::get('messages.catering');?>
                </a></li>
              <li> <a class="dropdown-item" href="<?php echo Azooma::URL($cityurl.'/sheesha');?>"
                  title="<?php echo Lang::get('messages.sheesha').' '.Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname)) ;?>">
                  <?php echo Lang::get('messages.sheesha');?>
                </a></li>
     
            </ul>
          </li>
          {{-- Cuisine Menu --}}
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="<?php echo Azooma::URL($cityurl.'/cuisines');?>"
              id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo Lang::get('messages.cuisines'); ?>  <i class="fa fa-angle-down"></i>
            </a>
            {{-- Sub Menu --}}
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li>
                <a class="dropdown-item" href="<?php echo Azooma::URL($cityurl.'/cuisines');?>"> <span
                    class="icon"><?php echo Lang::get('messages.AllCuisines'); ?> </span></a>
              </li>
              <?php
                  // Get All Cuisines
                  $mastercuisines=DB::connection('new-sufrati')->select('SELECT DISTINCT mc.id,mc.name,mc.name_ar FROM master_cuisine mc JOIN cuisine_list cl ON cl.master_id=mc.id JOIN rest_branches rb ON rb.city_ID='.$cityid.' AND rb.status=1 JOIN restaurant_cuisine rc  ON rc.cuisine_ID =cl.cuisine_ID AND rc.rest_ID=rb.rest_fk_id WHERE mc.status=1 AND cl.cuisine_Status=1 ORDER BY name ASC');
                  foreach ($mastercuisines as $mc) {
                  $mastercuisine=(Config::get('app.locale')=="en")?stripcslashes($mc->name):stripcslashes($mc->name_ar);
                ?>
              <li class="dropdown-submenu">
                <a class="dropdown-item sub d-flex align-items-center justify-content-between"
                  href="<?php echo Azooma::URL($cityurl.'/cuisines'.'/'.$mc->name);?>"><span
                    class="icon"><?php echo $mastercuisine;?> </span> <i style="color:#717171"
                    class="fas fa-angle-<?php if($lang=="en"){ echo "right"; }else{ echo "left"; } ?>"></i> </a>
                <?php
                    $cuisines=DB::connection('new-sufrati')->select('SELECT DISTINCT cu.seo_url,cu.cuisine_Name,cu.cuisine_Name_ar,COUNT(DISTINCT ri.rest_ID) as total FROM cuisine_list cu JOIN rest_branches rb ON rb.city_ID='.$cityid.' AND rb.status=1 JOIN restaurant_info ri ON ri.rest_ID=rb.rest_fk_id AND ri.rest_Status=1 JOIN restaurant_cuisine rc ON rc.cuisine_ID=cu.cuisine_ID AND rc.rest_ID=rb.rest_fk_id WHERE cu.cuisine_Status=1 AND cu.master_id='.$mc->id.' GROUP BY cu.cuisine_ID ORDER BY cu.cuisine_Name ASC');
                    if(count($cuisines)>0){
                      ?>
                <ul class="dropdown-menu level">
                  <?php
                        $i=0;
                        foreach ($cuisines as $cuisine) {
                          $i++;
                          $cuisinename=(Config::get('app.locale')=="en")?stripcslashes($cuisine->cuisine_Name):stripcslashes($cuisine->cuisine_Name_ar);
                          ?>
                  <li>
                    <a class="dropdown-item"
                      href="<?php echo Azooma::URL($cityurl.'/'.$cuisine->seo_url.'/restaurants');?>"
                      title="<?php echo $cuisinename.' '.Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname)) ;?>">
                      <?php echo $cuisinename.'  ( <span>'.$cuisine->total.'</span> ) ' ;?>
                    </a>
                  </li>
                  <?php
                          if(($i%10)==0){
                            echo '</ul><ul class="pull-left">';
                          }
                        }
                        ?>
                </ul>
                <?php
                    }
                    ?>

              </li>
              <?php } ?>


            </ul>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?php echo Azooma::URL($cityurl.'/gallery');?>"
              title="<?php echo Lang::get('messages.photos').' '.Lang::get('messages.and').' '.Lang::get('messages.videos').' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
              <?php echo Lang::get('messages.gallery').' '.Lang::get('messages.food');?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo Azooma::URL('blog');?>"
              title="<?php echo Lang::get('messages.blog');?>">
              <?php echo Lang::get('messages.blog');?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo Azooma::URL('recipes');?>"
              title="<?php echo Lang::get('messages.recipes');?>">
              <?php echo Lang::get('messages.recipes');?>
            </a>
          </li>
        </ul>
        <?php if(!Session::has('userid')&&!$loggedin){?>
        <div class="d-flex header-account-end">
          <button class="search-icon  mobile-hide" id="search-icon">
            <ion-icon name="search-outline"></ion-icon>
          </button>
          <div class="dropdown header-account-dropdown">
            <button class="dropdown-toggle" id="account_dropdown" data-bs-toggle="dropdown" aria-expanded="false">
             <ion-icon name="person-circle-outline"></ion-icon> <i class="fa fa-angle-down"></i>
              </button>
              <ul class="dropdown-menu" aria-labelledby="account_dropdown">
                <li>
                    <a class="login-link" href="javascript:void(0)">  <?php echo Lang::get('messages.login'); ?></a>
                </li>
                <li>
                <a class="register-link" href="javascript:void(0)">  <?php echo Lang::get('messages.register'); ?></a>
                </li>
              </ul>
            </div>
        </div>
        <?php } else {?>
    
        <div class="d-flex header-account-end">
          <button class="search-icon  mobile-hide" id="search-icon">
            <ion-icon name="search"></ion-icon>
          </button>
          <div class="dropdown header-account-dropdown">
            <button class="dropdown-toggle" id="account_dropdown" data-bs-toggle="dropdown" aria-expanded="false">
             <ion-icon name="person-circle-outline"></ion-icon>
             <i class="fa fa-angle-down"></i>
              </button>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="<?php echo Azooma::URL('user/'.$user[0]->user_ID);?>"
                    title="<?php echo Lang::get('messages.my').' '.Lang::get('messages.profile');?>">
                    <?php echo Lang::get('messages.my').' '.Lang::get('messages.profile');?>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="<?php echo Azooma::URL('user/'.$user[0]->user_ID.'#news-feed');?>"
                    title="<?php echo Lang::get('messages.news_feed');?>">
                    <?php echo Lang::get('messages.news_feed');?>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="<?php echo Azooma::URL('user/'.$user[0]->user_ID.'#user-activity');?>"
                    title="<?php echo Lang::get('messages.activity');?>">
                    <?php echo Lang::get('messages.activity');?>
                  </a>
                </li>

                <li>
                  <a class="dropdown-item" href="<?php echo Azooma::URL('user/'.$user[0]->user_ID.'#lists');?>"
                    title="<?php echo Lang::get('messages.my_lists');?>">
                    <?php echo Lang::get('messages.my_lists');?>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="<?php echo Azooma::URL('settings');?>"
                    title="<?php echo Lang::get('messages.settings');?>">
                    <?php echo Lang::get('messages.settings');?>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="<?php echo Azooma::URL('logout');?>"
                    title="<?php echo Lang::get('messages.logout');?>">
                    <?php echo Lang::get('messages.logout');?>
                  </a>
                </li>
              </ul>
            </div>

   
        </div>
        <?php } ?>
      </div>
      <?php } } } ?>
      <button class="search-icon pc-hide" id="search-icon">
        <ion-icon name="search"></ion-icon>
      </button>
    </div>
    @include('main.search')
  </nav>