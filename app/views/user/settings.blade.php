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
<body>
    <?php
    $header=array('nonav'=>false);
    ?>
    @include('inc.header',$header)

    {{-- Setting Section Start --}}
    <section class="user-setting">
        <div class="container">
            <div class="row setting-top-border">
                <div class="col-md-6 col-sm-12">
                    <a class="btn-back" title="<?php echo Lang::get('messages.back_to_profile');?>" href="<?php echo Azooma::URL('user/'.$user->user_ID.'#n');?>"><i class="fas fa-arrow-left"></i> <?php echo Lang::get('messages.back_to_profile');?></a>
                </div>
                <div class="col-md-6 col-sm-12">
                    <ul class="setting-nav">
                        <li class="active" data-bs-target="profile"><?php echo Lang::get('messages.profile');?></li>
                        <li data-bs-target="notification"><?php echo Lang::choice('messages.notification',1);?></li>
                        <li data-bs-target="phototab"><?php echo ucfirst(Lang::get('messages.photo'));?></li>
                        <li data-bs-target="passwordtab"><?php echo Lang::get('messages.password');?></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <div class="setting-tabs">
                        <div class="tab-setting show" id="profile">
                            <?php
                             if(Session::get('profilemessage')){
                            ?>
                                <div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong><?php echo Session::get('profilemessage');?></strong></div>
                            <?php } ?>
                            {{-- Profile Form --}}
                             <form class="row" action="<?php echo Azooma::URL('settings/profile');?>" method="post" id="user-general-form"> 
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group row">
                                        <label for="user_FullName" class="control-label"><?php echo Lang::get('messages.full_name');?></label>
                                        <input type="text" class="form-control" id="user_FullName" name="user_FullName" value="<?php echo stripcslashes($user->user_FullName);?>"> 
                                    </div>
                                    <div class="form-group row">
                                        <label for="user_NickName" class="control-label"><?php echo Lang::get('messages.nick_name');?></label>
                                            <input type="text" class="form-control" id="user_NickName" name="user_NickName" placeholder="<?php echo Lang::get('messages.nick_name');?>" value="<?php echo stripcslashes($user->user_NickName);?>"> 
                                    </div>
                                    <div class="form-group birth-group">
                                        <?php
                                        $birthday=date('d',  strtotime($user->user_BirthDate));
                                        $birthmonth=date('m',  strtotime($user->user_BirthDate));
                                        $birthyear=date('Y',  strtotime($user->user_BirthDate));
                                        ?>
                                        <label for="birthday" class="control-label"><?php echo Lang::get('messages.date_of_birth');?></label>
                                        <div class="d-md-flex p-0">
                                            <select class="birthday-select form-select" name="birthday" id="birthday">
                                                <option value=""><?php echo Lang::get('messages.day');?></option>
                                                <?php echo Azooma::Generate(1,31,false,$birthday); ?>
                                            </select>
                                            <select class="birthday-select form-select mr-2" name="month" id="month">
                                                <option value=""><?php echo Lang::get('messages.month');?></option>
                                                <?php echo Azooma::Generate(1,12,'month',$birthmonth); ?>
                                            </select>
                                            <select class="birthday-select form-select mr-2" name="year" id="year">
                                                <option value=""><?php echo Lang::get('messages.year');?></option>
                                                <?php echo Azooma::Generate(date('Y'),1950,false,$birthyear);?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="country" class="control-label"><?php echo Lang::get('messages.country');?></label>
                                            <select class="form-select" id="country" name="country">
                                                <option value=""><?php echo Lang::get('messages.country');?></option> 
                                                <?php $countries=Azooma::getCountries(); 
                                                if(count($countries)>0){
                                                    foreach ($countries as $country) {
                                                        ?>
                                                        <option value="<?php echo $country->country;?>" <?php echo ($country->country==$user->user_Country)?'selected':''; ?>><?php echo stripcslashes($country->name);?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                    </div>
                                    <div class="form-group row">
                                        <label for="city" class="control-label"><?php echo Lang::get('messages.city');?></label>
                                            <select class="form-select" id="city" name="city">
                                                <option value=""><?php echo Lang::get('messages.city');?></option> 
                                                <?php 
                                                $usercity=0;
                                                $country=$user->Azooma;
                                                if($country==0){
                                                    $country=1;
                                                }
                                                $cities=DB::select(DB::raw("SELECT city_ID,city_Name,city_Name_Ar FROM city_list  WHERE city_Status=1 AND country=:country"),array('country'=>$country));
                                                if($user->user_City!=NULL){
                                                    if(is_numeric($user->user_City)){
                                                        $usercity=$user->user_City;
                                                    }
                                                }
                                                if(count($cities)>0){
                                                    foreach ($cities as $city) {
                                                        ?>
                                                        <option <?php if($city->city_ID==$usercity){ echo 'selected'; } ?> value="<?php echo $city->city_ID;?>"><?php echo ($lang=="en")?$city->city_Name:$city->city_Name_Ar;?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nationality" class="control-label"><?php echo Lang::get('messages.nationality');?></label>
                                            <select class="form-select" id="nationality" name="nationality">
                                                <option value=""><?php echo Lang::get('messages.nationality');?></option> 
                                                <?php $nationalities=Azooma::getNationalities(); 
                                                if(count($nationalities)>0){
                                                    foreach ($nationalities as $nationality) {
                                                        ?>
                                                        <option value="<?php echo $nationality->nationality;?>" <?php echo ($nationality->nationality==$user->user_nationality)?'selected':''; ?>><?php echo stripcslashes($nationality->name);?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group row">
                                        <label for="gender" class="control-label"><?php echo Lang::get('messages.gender');?></label>
                                            <select class="form-select" id="gender" name="gender">
                                                <?php
                                                $genders=array(
                                                    (object)array('name'=>'Male','nameAr'=>'ذكر'),
                                                    (object)array('name'=>'Female','nameAr'=>'أنثى'),
                                                );
                                                ?>
                                                <option value=""><?php echo Lang::get('messages.gender');?></option> 
                                                <?php foreach ($genders as $gender) {
                                                    ?>
                                                    <option value="<?php echo $gender->name;?>" <?php echo ($user->user_Sex==$gender->name)?'selected':'';?>><?php echo ($lang=="en")?$gender->name:$gender->nameAr;?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                    </div>
                                    <div class="form-group row">
                                        <label for="occupation" class="control-label"><?php echo Lang::get('messages.occupation');?></label>
                                            <select class="form-select" id="occupation" name="occupation">
                                                <option value=""><?php echo Lang::get('messages.occupation');?></option> 
                                                <?php $occupations=Azooma::getOccupations(); 
                                                if(count($occupations)>0){
                                                    foreach ($occupations as $occupation) {
                                                        ?>
                                                        <option value="<?php echo $occupation->name;?>" <?php echo ($occupation->name==$user->user_occupation)?'selected':''; ?>><?php echo stripcslashes($occupation->name);?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                    </div>
                                    <div class="form-group row">
                                        <label for="telephone" class="control-label"><?php echo Lang::get('messages.telephone');?></label>
                                        <input type="text" class="form-control" id="telephone" name="telephone" placeholder="<?php echo Lang::get('messages.telephone');?>"> 
                                    </div>
                                    <div class="form-group row">
                                        <label for="mobile" class="control-label"><?php echo Lang::get('messages.mobile');?></label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="<?php echo Lang::get('messages.mobile');?>"> 
                                    </div>
                                    <div class="form-group row">
                                        <label for="marital_status" class="control-label"><?php echo Lang::get('messages.marital_status');?></label>
                                            <select class="form-select" id="marital_status" name="marital_status">
                                                <option value=""><?php echo Lang::get('messages.marital_status');?></option> 
                                                <option value="single" <?php if($user->user_maritial=="single"){ echo 'selected'; } ?>><?php echo Lang::get('messages.single');?></option> 
                                                <option value="married" <?php if($user->user_maritial=="married"){ echo 'selected'; } ?>><?php echo Lang::get('messages.married');?></option> 
                                            </select>
                                    </div>                                  
                                </div>
                                <button class="big-main-btn rest-like-btn btn-block"><?php echo Lang::get('messages.save');?></button>
                            </form>
                        </div>
                        <div class="tab-setting" id="notification">
                            <?php
                            if(Session::get('notifymessage')){
                            ?>
                            <div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong><?php echo Session::get('notifymessage');?></strong></div>
                            <?php } ?>
                            {{-- Notification Form --}}
                            <form class="row form-horizontal" action="<?php echo Azooma::URL('settings/notifications');?>" method="post" id="user-notification-form">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group group-check">
                                        <input class="form-check-input" type="checkbox" name="notification_emails" id="notification_emails" <?php echo ($notifystatus->status==1)?'checked':'';?>/>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo Lang::get('messages.notification_emails');?>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group group-check">
                                        <input class="form-check-input" type="checkbox" name="weekly" id="weekly" <?php echo ($weeklynotify->status==1)?'checked':'';?>/>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo Lang::get('messages.monthly_emails');?>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group group-check">
                                        <input class="form-check-input" type="checkbox" name="monthly" id="monthly" <?php echo ($monthlynotify->status==1)?'checked':'';?>/>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?php echo Lang::get('messages.weekly_emails');?>
                                        </label>
                                    </div>
                                </div>
                                <button class="big-main-btn btn-block"><?php echo Lang::get('messages.save');?></button>
                            </form>
                        </div>
                        <div class="tab-setting" id="phototab">
                            <?php
                            if(Session::get('photoerror')){
                            ?>
                            <div class="alert alert-danger"><a class="close" data-dismiss="alert">x</a><strong><?php echo Session::get('photoerror');?></strong></div>
                                <?php } ?>
                                <?php
                            if(Session::get('photomessage')){
                            ?>
                            <div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong><?php echo Session::get('photomessage');?></strong></div>
                            <?php } ?>
                            {{-- Photo Form --}}
                            <form class="row form-horizontal" action="<?php echo Azooma::URL('settings/photo');?>" method="post" id="user-photo-form" enctype="multipart/form-data"> 
                                <div class="col-md-12 d-flex">
                                    <div class="user-img">
                                        <?php $userimage=($user->image=="")?'user-default.svg':$user->image; ?>
                                        <img id="user-photo-preview" class="cropper" src="<?php echo Azooma::CDN('images/'.$userimage);?>" alt="<?php echo $username;?>">
                                    </div>
                                    <div class="upload-btn">   
                                        <a href="javascript:void(0);" class="big-trans-btn"><?php echo Lang::get('messages.upload_new_photo');?> <input type="file" name="image" accept="image/*" id="user-photo-btn" onchange="loadFile(event)"/></a>
                                    </div>   
                                </div>
                                <div class="right-btns">
                                    <button type="button" class="big-trans-btn mr-2" id="cancel-photo"><?php echo Lang::get('messages.cancel');?></button>
                                    <button type="submit" class="big-main-btn" id="save-photo"><?php echo Lang::get('messages.save');?></button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-setting" id="passwordtab">
                            <?php
                            if(Session::get('passworderror')){
                            ?>
                            <div class="alert alert-danger"><a class="close" data-dismiss="alert">x</a><strong><?php echo Session::get('passworderror');?></strong></div>
                                <?php } ?>
                                <?php
                            if(Session::get('passwordmessage')){
                            ?>
                            <div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong><?php echo Session::get('passwordmessage');?></strong></div>
                            <?php } ?>
                            {{-- Password Form --}}
                            <form class="row form-horizontal" action="<?php echo Azooma::URL('settings/password');?>" method="post" id="user-password-form"> 
                                    <?php
                                    if($user->user_Pass==""){
                                        //Facebook connect users
                                     ?>
                                <div class="inner-padding"><div class="alert alert-info"><?php echo Lang::get('messages.new_password_helper');?></div></div>
                                <div class="col-md-6">
                                    <div class="form-group row">    
                                        <label for="password" class="col-sm-5 control-label"><?php echo Lang::get('messages.your').' '.Lang::get('messages.password');?></label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="<?php echo Lang::get('messages.password');?>"> 
                                    </div>
                                    <button class="big-main-btn"><?php echo Lang::get('messages.save');?></button>
                                </div>
                                    <?php }else{
                                        ?>
                                <div class="col-md-6">
                                    <div class="form-group row">    
                                        <label for="old_password" class="col-sm-5 control-label"><?php echo Lang::get('messages.old_password');?></label>
                                        <input type="password" class="form-control" name="old_password" id="old_password" placeholder="<?php echo Lang::get('messages.old_password');?>"> 
                                    </div>
                                    <div class="form-group row">    
                                        <label for="new_password" class="col-sm-5 control-label"><?php echo Lang::get('messages.new_password');?></label>
                                         <input type="password" class="form-control" name="new_password" id="new_password" placeholder="<?php echo Lang::get('messages.your').' '.Lang::get('messages.new_password');?>"> 
                                    </div>
                                    <button class="big-main-btn"><?php echo Lang::get('messages.save');?></button>
                                </div>
                                        <?php
                                    }?>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="register-banner">
                        <img src="<?php echo asset('img/register-banner.svg') ?>" alt="register banner">
                        <div class="content">
                            <h2> <?php echo Lang::get('messages.WelcometoAzooma');?></h2>
                            <p> <?php echo Lang::get('messages.registerwelcome');?> </p>
                                <a class="big-white-btn" href="#"><?php echo Lang::get('messages.learnmore');?> </a>
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Setting Section End --}}
 

    @include('inc.footer')
    <script type="text/javascript">
    require(['usersettings'],function(){});
    </script>
    <script>
        if(window.location.hash) {
            var myhash = window.location.hash.substring(1);
            $('.setting-nav .active').removeClass('active');
            $('.setting-nav [data-bs-target="'+myhash+'"]').addClass('active');
            $('.setting-tabs .show').removeClass('show');
            $('.setting-tabs #' + myhash).addClass('show');
        }
    </script>
    <script>
        var loadFile = function(event) {
          var output = document.getElementById('user-photo-preview');
          output.src = URL.createObjectURL(event.target.files[0]);
          output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
          }
        };
      </script>
</body>
</html>