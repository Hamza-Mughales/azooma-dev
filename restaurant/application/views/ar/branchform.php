<section id="top-banner">
  <ul class="breadcrumb">
<li>
    <a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
</li>
<li>
<a href="<?php echo site_url('branches');?>">الفروع</a> <span class="divider">/</span>
</li>
<li class="active"><?php echo $title; ?> </li>
</ul>
    <?php if(isset($branch)){ ?>
    <div class="right-float">
        <span class="btn-left-margin">
            <a class="btn btn-primary" href="<?=base_url('ar/branches/photofrom')?>" title="إضافة صورة جديدة">إضافة صورة جديدة</a>
        </span>
    </div>
    <?php } ?>
  <div class="row-fluid spacer">
    <article class="span12 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#restinfo"> <a class="accordion-toggle" href="javascript:void(0);"> حدث معلومات الفرع  <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i> </a>

      </h2>

      <div id="restinfo" class="collapse in accordion-inner">
          <?php
if($this->session->flashdata('error')){
      echo '<br /><div class="alert alert-error"><a class="close" data-dismiss="alert">x</a><strong>'.$this->session->flashdata('error').'</strong></div>';
}
if($this->session->flashdata('message')){
  echo '<br /><div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong>'.$this->session->flashdata('message').'</strong></div>';
}
?>

<?php 
if((isset($branch))&&($branch['br_number']!="")){
     list($cityCode,$phone) = explode('-',$branch['br_number']);
}
$cityoptions=$citycodes=$cityCode="";
foreach($cities as $city){
    $cityoptions.='<option value="'.$city['city_ID'].'"';
    $citycodes.='<option data-city="'.$city['city_ID'].'" value="'.$city['city_Code'].'"';
    if(isset($branch)){ if($branch['city_ID']==$city['city_ID']) {
        $cityoptions.=' selected="selected"';
    }}
    if((isset($branch))&&($cityCode!="")&&($cityCode==$city['city_Code'])){
        $citycodes.=' selected="selected"';
    }
    $cityoptions.='>'.$city['city_Name_ar'].'</option>';
    $citycodes.='>'.$city['city_Code'].'</option>';
}
?>

<form id="restMainForm" class="form-horizontal restaurant-form" method="post" action="<?php echo site_url('ar/branches/save');?>">
    <fieldset>
        <legend>عنوان الفرع</legend>
        <div class="control-group">
            <label class="control-label" for="city_ID">حدد المدينة</label>
            <div class="controls">
                <select class="required" name="city_ID" id="city_ID" onchange="selectcity();">
                    <option value=""> حدد المدينة</option>
                    <?php echo $cityoptions;?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="city_ID">حدد الحي</label>
            <div class="controls">
                    <?php
                    $i=0;
                    foreach($cities as $city){
                    $i++;
                        $districts=$this->MGeneral->getCityDistricts($city['city_ID']);
                    if(count($districts)>0){
                        
                        ?>
                <select <?php if((!isset($branch))||($branch['latitude']=="")){ ?> onchange="getDistrictMap('district_<?php echo $city['city_ID'];?>');" <?php }?> name="district_<?php echo $city['city_ID'];?>" id="district_<?php echo $city['city_ID'];?>" class="district <?php if(isset($branch)){ if($branch['city_ID']!=$city['city_ID']) echo 'invisible'; }else{ if($i!=1) echo 'invisible';} ?>">
                <?php
                        foreach($districts as $district){
                         ?>
                    <option <?php if(isset($branch)){ echo $branch['district_ID']==$district['district_ID']?'selected="selected"':"";} ?> value="<?php echo $district['district_ID'];?>">
                        <?php echo $district['district_Name_ar'];?>
                    </option>
                    <?php
                        }
                        ?>
                </select>
                    <?php
                    }
                    }
                    ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="br_loc">أين عنوان الفرع - اللغة الانكليزية</label>
            <div class="controls">
                <input class="required" type="text" name="br_loc" id="br_loc" placeholder="أين عنوان الفرع - اللغة الانكليزية" <?php echo isset($branch)?'value="'.(htmlspecialchars($branch['br_loc'])).'"':''; ?>/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="br_loc_ar">أين عنوان الفرع - اللغة عربي</label>
            <div class="controls">
                <input class="required" type="text" name="br_loc_ar" id="br_loc_ar" placeholder="أين عنوان الفرع - اللغة عربي" <?php echo isset($branch)?'value="'.(htmlspecialchars($branch['br_loc_ar'])).'"':''; ?>/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="cityCode">رقم الهاتف</label>
            <div class="controls">
                <select class="auto-width" name="cityCode" id="cityCode">
                    <?php echo $citycodes;?>
                </select>
                <input class="auto-width" name="br_number" id="br_number" <?php if((isset($branch))&&($branch['br_number']!="")&&($phone!="")) echo 'value="'.$phone.'"'; ?> placeholder="رقم الهاتف"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="br_mobile">رقم الجوال</label>
            <div class="controls">
                <input name="br_mobile" id="br_mobile" <?php if((isset($branch))&&($branch['br_mobile']!="")) echo 'value="'.$branch['br_mobile'].'"'; ?> placeholder="رقم الجوال"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="br_mobile">Map
             <a href="javascript:void(0)" onClick="showMarker()" id="addMap" title="Click to Add Google Map Location for your Branch" style="display:none;">
                                      <b> Click to  Add Map Location</b>
                                  </a>
                                  <a href="javascript:void(0)" onClick="hideMarker()" id="removeMap" title="Click to Remove Google Map" >
                                      <b>X Hide Map</b>
                                  </a>
            </label>
            <div class="controls">
                 <input type="hidden" name="latitude" id="latitude" value="<?php if(isset($branch)){ echo $branch['latitude']; }?>"/>
                            <input type="hidden" name="longitude" id="longitude" value="<?php if(isset($branch)){ echo $branch['longitude']; }?>"/>
                            <input type="hidden" name="zoom" id="zoom" value="14"/>
                     <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
		<?php 
                if((isset($branch))&&($branch['latitude']!="")&&($branch['longitude']!="")){
		?>
                <script type="text/javascript">
                    var geocoder = new google.maps.Geocoder();
                    function geocodePosition(pos) {
                      geocoder.geocode({
                            latLng: pos
                      }, function(responses) {

                      });
                    }

                    function updateMarkerPosition(latLng) {
                        document.getElementById("latitude").value = latLng.lat();
                        document.getElementById("longitude").value = latLng.lng();
                    }

                    function initialize() {
                        var latLng = new google.maps.LatLng('<?php echo $branch['latitude'];?>','<?php echo $branch['longitude'];?>');
                        var map = new google.maps.Map(document.getElementById('map'), {
                                zoom: 8,
                                center: latLng,
                                mapTypeId: google.maps.MapTypeId.ROADMAP
                        });
                        var marker = new google.maps.Marker({
                                draggable: true,
                                position: latLng, 
                                title:'drag to select postion',
                                map: map
                        });

                        updateMarkerPosition(latLng);
                        geocodePosition(latLng);

                        google.maps.event.addListener(marker, 'drag', function() {  
                                updateMarkerPosition(marker.getPosition());
                        });	
                    }
             </script>
		<?php
          }else{
        ?>
        <script type="text/javascript">				
                var geocoder = new google.maps.Geocoder();                                
                function geocodePosition(pos) {
                  geocoder.geocode({
                        latLng: pos
                  }, function(responses) {

                  });
                }

                function updateMarkerPosition(latLng) {
                    document.getElementById("latitude").value = latLng.lat();
                    document.getElementById("longitude").value = latLng.lng();
                }
                                
                function initialize() {
                    var latt=''; //23.885942
                    var lngg=''; //45.079162
                    var address='Saudi Arabia';                                    
                    geocoder.geocode({ 'address': address }, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {                                            
                            latt = results[0].geometry.location.lat().toString().substr(0, 12);
                            lngg = results[0].geometry.location.lng().toString().substr(0, 12);
                           loadmap(latt, lngg)
                        }else{
                            alert('error: '+ status);
                        }
                    });
                }
                                
                function loadmap(latt,lngg){
                    var latLng = new google.maps.LatLng(latt,lngg);                                    
                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 8,
                        center: latLng,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });
                    var marker = new google.maps.Marker({
                        draggable: true,
                        position: latLng, 
                        title:'drag to select postion',
                        map: map
                    });

                    updateMarkerPosition(latLng);
                    geocodePosition(latLng);

                    google.maps.event.addListener(marker, 'drag', function() {  
                        updateMarkerPosition(marker.getPosition());
                    });	
                }

                function getDistrictMap(id){
                    var district=$('#'+id + ' option:selected').text();
                    var city=$("#city_ID option:selected").text();
                    var address=city+" "+district;
                    geocoder.geocode({ 'address': address }, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {                                            
                            latt = results[0].geometry.location.lat().toString().substr(0, 12);
                            lngg = results[0].geometry.location.lng().toString().substr(0, 12);
                           loadmap(latt, lngg)
                        }else{
                            alert('error: '+ status);
                        }
                    });
                }
				
                function selectcity(){
                    var city=$("#city_ID").val();
                    $(".district").addClass('invisible');
                    $("#district_"+city).removeClass('invisible');
                    $("#cityCode option[data-city='"+city+"']").attr('selected', true);
                    var cityname=$("#city_ID option:selected").text();

                    geocoder.geocode({ 'address': cityname }, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {                                            
                            latt = results[0].geometry.location.lat().toString().substr(0, 12);
                            lngg = results[0].geometry.location.lng().toString().substr(0, 12);
                           loadmap(latt, lngg)
                        }else{
                           console.log('error: '+ status);
                        }
                    });
                }    
            </script>
		<?php }?>
                         
                          <div id="map" style="width: 550px; height: 350px"></div>
                </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="branch_type">نوع الفرع</label>
            <div class="controls">
                <select class="auto-width" name="branch_type" id="branch_type" onchange="selecthotel();">
                    <option value=""> حدد </option>
                    <option <?php if(isset($branch)){ echo $branch['branch_type']=="Classic Restaurant"?'selected="selected"':"";} ?> value="Classic Restaurant">مطعم عادي</option>
                    <option <?php if(isset($branch)){ echo $branch['branch_type']=="Hotel Restaurant"?'selected="selected"':"";} ?> value="Hotel Restaurant">مطعم داخل الفندق</option>
                    <option <?php if(isset($branch)){ echo $branch['branch_type']=="Food Court"?'selected="selected"':"";} ?> value="Food Court">فرع في المول</option>
                    <option <?php if(isset($branch)){ echo $branch['branch_type']=="Home Made"?'selected="selected"':"";} ?> value="Home Made">مطبخ منزلي</option>
                    <option <?php if(isset($branch)){ echo $branch['branch_type']=="Delivery Service"?'selected="selected"':"";} ?> value="Delivery Service">خدمة توصيل</option>
                    <option <?php if(isset($branch)){ echo $branch['branch_type']=="Catering Service"?'selected="selected"':"";} ?> value="Catering Service">تموين حفلات</option>
                    <option <?php if(isset($branch)){ echo $branch['branch_type']=="Quick Service"?'selected="selected"':"";} ?> value="Quick Service">خدمة سريعة</option>
                    <option <?php if(isset($branch)){ echo $branch['branch_type']=="Stall"?'selected="selected"':"";} ?> value="Stall">كوشك</option>
                </select>
                <select name='hotel_value' id='hotel_value' <?php if(!isset($branch)||($branch['branch_type']!="Hotel Restaurant")) echo 'class="invisible"';?>>
                 <?php
            if(count($hotels)>0)
            {
                $hotel_list="";
                foreach($hotels as $hotel){
                    if(isset($branch))
                        {
                        $hotel_id=$hotel['id'];
                        $query2="SELECT * FROM hotel_rest WHERE hotel_id=$hotel_id AND rest_id={$branch['br_id']}";
                        $hotel_rest_q=mysql_query($query2);
                        if(mysql_num_rows($hotel_rest_q)>0)
                        {
                            $hotel_rest=mysql_fetch_array($hotel_rest_q);
                            if($hotel_rest['hotel_id']==$hotel['id'])
							$hotel_list .= "<option value='".$hotel['id']."' selected='selected'> " . $hotel['hotel_name'] . "</option>";
                        }
						else
							$hotel_list .= "<option value='" .$hotel['id']."'> " . $hotel['hotel_name'] . "</option>";
                        }
					else
						$hotel_list .= "<option value='".$hotel['id']."'>".$hotel['hotel_name']."</option>";
                
            }
            echo $hotel_list;
        }
                ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="tot_seats">كم عدد الاشخاص التي تسلع مطعمك</label>
            <div class="controls">
                <input name="tot_seats" id="tot_seats" <?php if((isset($branch))&&($branch['tot_seats']!="")) echo 'value="'.$branch['tot_seats'].'"'; ?> placeholder="كم عدد الاشخاص التي تسلع مطعمك"/>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>مميزات الفرع</legend>
        <div class="control-group label-heading">
            <label class="control-label" for="seatings">انواع الغرف والجلسات</label>
            <div class="controls input-spacer"></div>
        </div>
    <div class="control-group">
            <div class="input-spacer">
                <div class="left">
                <select class="auto-width" name="seatings" id="seatings">
                    <option value="">
                        حدد
                    </option>
                    <option value="Seating capacity:Small(5-8)" <?php if(isset($branch)){ echo $branch['seatings']=="Seating capacity:Small(5-8)"?'selected="selected"':"";} ?>>صغيرة ( <?php echo $this->MGeneral->convertToArabic(5).' - '.$this->MGeneral->convertToArabic(8); ?>) </option>
                    <option value="Seating capacity:Medium(10-50)" <?php if(isset($branch)){ echo $branch['seatings']=="Seating capacity:Medium(10-50)"?'selected="selected"':"";} ?>>متوسطة (<?php echo $this->MGeneral->convertToArabic(10).' - '.$this->MGeneral->convertToArabic(50); ?>)</option>
                    <option value="Seating capacity:Large(60-200)" <?php if(isset($branch)){ echo $branch['seatings']=="Seating capacity:Large(60-200)"?'selected="selected"':"";} ?>>كبيرة (<?php echo $this->MGeneral->convertToArabic(60).' - '.$this->MGeneral->convertToArabic(200); ?>)</option>
                    <option value="Seating capacity:Banquet(200+)" <?php if(isset($branch)){ echo $branch['seatings']=="Seating capacity:Banquet(200+)"?'selected="selected"':"";} ?>>الولائم (<?php echo $this->MGeneral->convertToArabic(200).'+ '; ?>)</option>
                </select>
                </div>
                <div class="left">
                <?php
                if(isset($branch)){
                    $seatingrooms=explode(',',$branch['seating_rooms']);
                }?>
                        <input name="seating_rooms[]" type="checkbox" value="Indoor" <?php if(isset($branch)){ if(in_array("Indoor",$seatingrooms)){?>checked="checked"<?php }} ?> /> جلسات داخلية
                        <input name="seating_rooms[]" type="checkbox" value="Outdoor" <?php if(isset($branch)){ if(in_array("Outdoor",$seatingrooms)){?>checked="checked"<?php }} ?> /> جلسات خارجية
                        <input name="seating_rooms[]" type="checkbox" value="Child Friendly" <?php if(isset($branch)){ if(in_array("Child Friendly",$seatingrooms)){?>checked="checked"<?php }} ?> />نستقبل الأطفال
                        <input name="seating_rooms[]" type="checkbox" value="Single Section" <?php if(isset($branch)){ if(in_array("Single Section",$seatingrooms)){?>checked="checked"<?php }} ?> />قسم الرجال
                        <input name="seating_rooms[]" type="checkbox" value="Family Section" <?php if(isset($branch)){ if(in_array("Family Section",$seatingrooms)){?>checked="checked"<?php }} ?> /قسم العوائل
                        <input name="seating_rooms[]" type="checkbox" value="Private room" <?php if(isset($branch)){ if(in_array("Private room",$seatingrooms)){?>checked="checked"<?php }} ?> />غرفة خاصة
                        </div>
            </div>
        </div>
        <div class="control-group label-heading">
            <label class="control-label" for="features_services">الميزات والخدمات</label>
            <div class="controls input-spacer"></div>
        </div>
        <div class="control-group">
            
            <div class="input-spacer">
                <?php
                if(isset($branch)){
                    $feat_ser=explode(',',$branch['features_services']);
                }    ?>
                <div>    <input name="features_services[]" type="checkbox" <?php if(isset($branch)){ if(in_array("Wifi",$feat_ser)){?> checked="checked"<?php }} ?>  value="Wifi" />انترنت
                          <input name="features_services[]" type="checkbox" <?php if(isset($branch)){ if(in_array("TV Screens",$feat_ser)){?> checked="checked"<?php }} ?> value="TV Screens" />شاشات تلفزيون
                          <input name="features_services[]" type="checkbox" <?php if(isset($branch)){ if(in_array("Sheesha",$feat_ser)){?> checked="checked"<?php }} ?> value="Sheesha" />جلسات الشيشة
                          <input name="features_services[]" type="checkbox" <?php if(isset($branch)){ if(in_array("Wheel Chair Accessibility",$feat_ser)){?> checked="checked"<?php }} ?> value="Wheel Chair Accessibility" />مصاعد للكراسي المتحرك                          
                          <input name="features_services[]" type="checkbox" <?php if(isset($branch)){ if(in_array("Smoking",$feat_ser)){?> checked="checked"<?php }} ?> value="Smoking" /> مسموح التدخين
                          <input name="features_services[]" type="checkbox" <?php if(isset($branch)){ if(in_array("Non Smoking",$feat_ser)){?> checked="checked"<?php }} ?> value="Non Smoking" /> ممنوع التدخين
                          <input name="features_services[]" type="checkbox" <?php if(isset($branch)){ if(in_array("Valet Parking",$feat_ser)){?> checked="checked"<?php }} ?> value="Valet Parking" />مواقف فالي  <br>
                </div><div class="top">  
                          <input name="features_services[]" type="checkbox" <?php if(isset($branch)){ if(in_array("Drive Through",$feat_ser)){?> checked="checked"<?php }} ?> value="Drive Through" /> طلبات السيارة
                          <input name="features_services[]" type="checkbox" <?php if(isset($branch)){ if(in_array("Buffet",$feat_ser)){?> checked="checked"<?php }} ?> value="Buffet" /> بوفي مفتوح
                          <input name="features_services[]" type="checkbox" <?php if(isset($branch)){ if(in_array("Takeaway",$feat_ser)){?> checked="checked"<?php }} ?> value="Takeaway" /> طلبات لتسليم
                          <input name="features_services[]" type="checkbox" <?php if(isset($branch)){ if(in_array("Delivery",$feat_ser)){?> checked="checked"<?php }} ?> value="Delivery" />خدمة التوصيل
                          <input name="features_services[]" type="checkbox" <?php if(isset($branch)){ if(in_array("Business Facilities",$feat_ser)){?> checked="checked"<?php }} ?> value="Business Facilities" />  خدمات رجال الأعمال
                          <input name="features_services[]" type="checkbox" <?php if(isset($branch)){ if(in_array("Catering services",$feat_ser)){?> checked="checked"<?php }} ?> value="Catering services" /> تموين حفلات
                </div>
            </div>
        </div>
        <div class="control-group label-heading">
            <label class="control-label" for="tot_seats">المزاج والجو</label>
            <div class="controls input-spacer"></div>
        </div>
        <div class="control-group">            
            <div class="input-spacer">
                <?php
                if(isset($branch)){
                    $mood=explode(',',$branch['mood_atmosphere']);
                }?>
                          <input name="mood_atmosphere[]" type="checkbox" <?php if(isset($branch)){ if(in_array("Busy",$mood)){?> checked="checked"<?php }} ?>value="Busy" />مشغول
                          <input name="mood_atmosphere[]" type="checkbox" <?php if(isset($branch)){ if(in_array("Quiet",$mood)){?> checked="checked"<?php }} ?> value="Quiet" />هادئ
                          <input name="mood_atmosphere[]" type="checkbox" <?php if(isset($branch)){ if(in_array("Romantic",$mood)){?> checked="checked"<?php }} ?> value="Romantic" />رومانسي
                          <input name="mood_atmosphere[]" type="checkbox" <?php if(isset($branch)){ if(in_array("Young Crowd",$mood)){?> checked="checked"<?php }} ?> value="Young Crowd" /> للشباب
                          <input name="mood_atmosphere[]" type="checkbox" <?php if(isset($branch)){ if(in_array("Trendy",$mood)){?> checked="checked"<?php }} ?> value="Trendy" />عصري
	                  <?php 
                          if(isset($branch)){
                          ?>
                          <input type="hidden" name="br_id" id="br_id" value="<?php echo $branch['br_id'];?>">
                         <?php }?>
                         <input type="hidden" name="rest_fk_id" id="rest_fk_id" value="<?php echo $rest['rest_ID'];?>">
                         <input type="hidden" name="rest_Name" id="rest_Name" value="<?php echo $rest['rest_Name'];?>">
            </div>
        </div>  
        <div class="control-group label-heading">
            <label class="control-label" for="status">نشر</label>
            <div class="controls">
                <input type="checkbox" <?php if (!isset($branch['status']) || $branch['status'] == 1) echo 'checked="checked"'; ?> name="status" value="1"/>
            </div>
        </div>
        <div class="control-group">
            <div class="controls input-spacer">                
            <label class="control-label" for=""></label>
                <div class="controls right-float">
                    <input type="submit" name="submit" value="اضافة فرع اخر" class="btn btn-primary"/>
                    <a href="<?php if(isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER']; else echo site_url('ar');?>" class="btn" title="إلغاء">إلغاء</a>
                </div>
            </div>
        </div>
    </fieldset>
</form>

<script>
google.maps.event.addDomListener(window, 'load', initialize);    
$("#restMainForm").validate();
if($("#city_ID").val()!=""){
    selectcity();
}


</script>

      </div>
    </article>
  </div>
</section>
