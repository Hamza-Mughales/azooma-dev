<!doctype html>
<html lang="<?php echo $lang;?>">
<head>
    @include('inc.metaheader',$meta)
    <?php
    if(isset($metastring)){
        echo $metastring;
    }
    ?>
</head>
<body itemscope itemtype="http://schema.org/WebPage" class="<?php if($lang == 'ar'){ echo 'rtl'; } ?>">
    @include('inc.header')
      {{-- Breadcrumb Section Start --}}
      <section class="Breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <ul class="breadcrumb-nav">
                        <li>
                            <i class="fa fa-home"></i> <a href="<?php echo Azooma::URL('');?>" title="<?php echo Lang::get('messages.azooma');?>">
                            <?php echo Lang::get('messages.azooma'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo Azooma::URL($city->seo_url);?>" title="<?php echo Lang::choice('messages.restaurants',2).' '.Lang::get('messages.inplace',array('name'=>$cityname));?>">
                                <?php echo ($lang=="en")?$cityname=stripcslashes($city->city_Name):$cityname=stripcslashes($city->city_Name_ar); ?>
                            </a>
                        </li>
                        <li class="active">
                            <?php echo Lang::get('messages.add_restaurant');?>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="breadcrumb-social">
                        <div class="social">
                            <a href="https://twitter.com/share"><i class="fa fa-twitter"></i> Tweet</a>
                        </div>
                        <div class="social">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo Request::url();?>"><i
                                    class="fa fa-facebook"></i> Share</a>
                            {{-- <div class="fb-share-button" data-layout="button_count" data-href="<?php echo Request::url();?>"></div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Breadcrumb Section End --}}
    <section class="register-res-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 reg-con">
                    <h2>  <?php echo Lang::get('messages.add_restaurant');?></h2>
                    {{-- Register Form --}}
                    <?php if(Session::has('success')){ ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo Session::get('success');?>
                        </div>
                        <?php } ?>
                        <p class="lead d-block mt-4 mb-4"><?php echo Lang::get('messages.add_restaurant_helper');?></p>
                        <form class="row register-res-form" role="form" action="<?php echo Azooma::URL($city->seo_url.'/add-restaurant/submit');?>" method="post" id="addrestaurant-form" enctype="multipart/form-data">
                            <div class="col-md-6">
                                <h4>
                                    <?php echo Lang::get('messages.restaurant_info');?>
                                </h4>
                                <div class="form-group row">
                                    <input type="text" class="form-control input-lg required" id="restaurantName" name="name" placeholder="<?php echo Lang::get('messages.restaurant_name_en');?>"> 
                                </div>
                                <div class="form-group row">
                                    <input type="text" class="form-control input-lg" id="restaurantNameAr" name="nameAr" placeholder="<?php echo Lang::get('messages.restaurant_name_ar');?>" dir="rtl"> 
                                </div>
                                <div class="form-group row">
                                    <input type="text" class="form-control input-lg required" id="location" name="location" placeholder="<?php echo Lang::get('messages.location');?>"> 
                                </div>
                                <div class="form-group row">
                                    <?php if(count($cuisines)>0){ ?>
                                    <select name="cuisines[]" id="cuisines" class="form-control input-lg" multiple style="height: 250px;">
                                        <?php foreach ($cuisines as $cuisine) {
                                            ?>
                                            <option value="<?php echo $cuisine->cuisine_ID;?>"><?php echo ($lang=="en")?stripcslashes($cuisine->cuisine_Name):stripcslashes($cuisine->cuisine_Name_ar);?></option>
                                            <?php  
                                        }
                                        ?>
                                    </select>
                                    <?php } ?>
                                </div>
                                <div class="form-group row">
                                    <input type="text" class="form-control input-lg" id="restaurantWebsite" name="restaurantWebsite" placeholder="<?php echo Lang::get('messages.restaurant_website');?>"> 
                                </div>
                                <div class="form-group input-lg">
                                    <div class="mb-2" style="text-align: left"><?php echo Lang::get('messages.choose_menu');?></div>
                                    <div class="align-left" style="text-align: left"><input type="file" name="menu" id="file"/> </div>
                                </div>
                            </div>
                            <div class="col-md-6" id="add-restaurant-contact">
                                <h4>
                                    <?php echo Lang::get('messages.contact_info');?>
                                </h4>
                                <div class="form-group row">
                                    <input type="email" class="form-control input-lg" id="restaurantEmail" name="restaurantEmail" placeholder="<?php echo Lang::get('messages.restaurant_email');?>"> 
                                </div>
                                <div class="form-group row">
                                    <input type="tel" class="form-control input-lg required" id="restaurantNumber" name="restaurantNumber" placeholder="<?php echo Lang::get('messages.restaurant_number');?>"> 
                                </div>
                                <?php if(Session::has('userid')){
                                    $user=User::checkUser(Session::get('userid'),true);
                                    $username=($user->user_NickName=="")?stripcslashes($user->user_FullName):stripcslashes($user->user_NickName);
                                } ?>
                                <div class="form-group row">
                                    <input type="text" class="form-control input-lg required" id="yourName" name="yourName" placeholder="<?php echo Lang::get('messages.your_name');?>" <?php if(Session::has('userid')){?> value="<?php echo $username;?>" <?php } ?>> 
                                </div>
                                <div class="form-group row">
                                    <select name="position" id="position" class="form-control input-lg">
                                        <option value=""><?php echo Lang::get('messages.your_position');?> </option>
                                        <option value="Owner"><?php echo Lang::get('messages.owner');?> </option>
                                        <option value="Manager"><?php echo Lang::get('messages.manager');?> </option>
                                        <option value="Employee"><?php echo Lang::get('messages.employee');?> </option>
                                        <option value="Other"><?php echo Lang::get('messages.other');?> </option>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <input type="email" class="form-control input-lg required" id="yourEmail" name="yourEmail" placeholder="<?php echo Lang::get('messages.your_email');?>" <?php if(Session::has('userid')){?> value="<?php echo $user->user_Email;?>" disabled="disabled"<?php } ?>> 
                                </div>
                                <div class="form-group row">
                                    <input type="text" class="form-control input-lg required" id="yourContact" name="yourContact" placeholder="<?php echo Lang::get('messages.your_contact');?>"> 
                                </div>
                                <div class="form-group row">
                                    <button type="submit" class="btn btn-lg btn-camera btn-block big-main-btn"><?php echo Lang::get('messages.submit');?></button>
                                </div>
                            </div>
                        </form>
                </div>
          
            </div>
        </div>
    </section>

    

    @include('inc.footer')
    <script type="text/javascript">
        require(['bootstrap-multiselect','add-restaurant'],function(){});
    </script>
</body>
</html>