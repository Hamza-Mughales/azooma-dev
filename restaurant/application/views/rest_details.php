<section id="top-banner">
<ul class="breadcrumb">
<li>
<a href="<?php echo site_url('home');?>">Home</a> <span class="divider">/</span>
</li>
<li class="active">Restaurant Information </li>
</ul>
  <div class="row-fluid spacer">
    <article class="span12 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#restinfo"> <a class="accordion-toggle" href="javascript:void(0);"> Update Your Restaurant Information  <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i> </a>

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
          <form id="restMainForm" class="form-horizontal restaurant-form" method="post" action="<?php echo site_url('profile/save/');?>" enctype="multipart/form-data">
  <fieldset>
      <legend>General Info</legend>
     
      <div class="control-group">
          <label class="control-label" for="cuisine">Select Cuisines</label>
          <div class="controls">
              <?php 
              if(isset($rest)){
              $cuisineList=array();
              $bestList=array();
			  if(is_array($restcuisines)){  
				  foreach($restcuisines as $val){
					  $cuisineList[]=$val['cuisine_ID'];
				  }
			  }
			  if(is_array($restbestfors)){  
				  foreach($restbestfors as $val){
					  $bestList[]=$val['bestfor_ID'];
				  }
			  }
              }
              $maxcuisine=2;
              $maxbest=1;
              $msgcuisine="Maximum <strong>2 Cuisines</strong> can be selected";
              $msgbest="Maximum <strong>1 Best</strong> for can be selected";
              if(isset($rest)){
                  switch($rest['rest_Subscription']){
                      case 1:
                          $maxcuisine=3;
                          $maxbest=1;
                          $msgcuisine="Maximum <strong>3 Cuisines</strong> can be selected";
                          $msgbest="Maximum <strong>1 Best</strong> for can be selected";
                          break;
                      case 2:
                          $maxcuisine=3;
                          $maxbest=2;
                          $msgcuisine="Maximum <strong>3 Cuisines</strong> can be selected";
                          $msgbest="Maximum <strong>2 Best</strong> for can be selected";
                          break;
                      case 3:
                          $maxcuisine=4;
                          $maxbest=4;
                          $msgcuisine="Maximum <strong>4 Cuisines</strong> can be selected";
                          $msgbest="Maximum <strong>4 Best</strong> for can be selected";
                          break;
                  }
              }
              ?>

              <select multiple class="chzn-select required" data-maxpersons="<?php echo $maxcuisine;?>" tabindex="7" style="width: 350px;" data-placeholder="Select Cuisines" name="cuisine[]" id="cuisine">
                  <?php
                  if(isset($rest)){
					if(is_array($cuisines)){  
						  foreach($cuisines as $cuisine){
							  ?>
						  <option <?php if(in_array($cuisine['cuisine_ID'], $cuisineList)) echo 'selected="selected"'; ?> value="<?php echo $cuisine['cuisine_ID'];?>">
							  <?php echo stripslashes($cuisine['cuisine_Name']); ?>
						  </option>
						  <?php
						  }
					}
                  }else{
					  if(is_array($cuisines)){ 
							foreach($cuisines as $cuisine){
							  ?>
						  <option value="<?php echo $cuisine['cuisine_ID'];?>">
							  <?php echo stripslashes($cuisine['cuisine_Name']);?>
						  </option>
						  <?php  
						  }
					  }
                  }
                  ?>
              </select>
              <p style="font-size:12px;">(<?php echo $msgcuisine;?>)</p>
          </div>
      </div>
   
      <div class="control-group">
          <label class="control-label" for="rest_Name">Restaurant Name</label>
          <div class="controls">
              <input type="hidden" name="rest_Name" id="rest_Name" <?php echo isset($rest)?'value="'.(($rest['rest_Name'])).'"':""; ?>/>
              <?php echo isset($rest)? (($rest['rest_Name'])):""; ?>
              
          </div>
      </div>
      <div class="control-group">
          <label class="control-label" for="rest_Name_Ar">Restaurant Name Arabic</label>
          <div class="controls">
              <input type="hidden" name="rest_Name_Ar" id="rest_Name_Ar" <?php echo isset($rest)?'value="'.(($rest['rest_Name_Ar'])).'"':""; ?>/>
              <?php echo isset($rest)? (($rest['rest_Name_Ar'])):""; ?>
          </div>
      </div>
      <div class="control-group">
          <label class="control-label" for="opening">Year of Opening</label>
          <div class="controls">
              <select name="opening" class="required">
                        <?php
                        for($i=date('Y'); $i>1950; $i--)
                          echo "<option value='$i'>$i</option>";
                        ?>
             </select>
          </div>
      </div>
  </fieldset>
  <fieldset>
      <legend>
          Business / Restaurant Contact Info
      </legend>
      <div class="control-group">
        <label class="control-label" for="rest_Email">Business / Restaurant Email</label>
        <div class="controls sufrati-backend-input-seperator" id="memberemails">
            <?php if(isset($rest)){                        
            $rest_Emails=explode(',', $rest['rest_Email']);
            $count_members_details=count($rest_Emails);
            echo "<script type='text/javascript'> var counter='".$count_members_details."' </script> ";
            for($i=0;$i<count($rest_Emails);$i++){
                ?>
            <div id="input-<?php echo $i;?>" class="input-<?php echo $i;?>">
                <input  type="text" name="rest_Email[]"  placeholder="Contact Email" <?php echo isset($rest_Emails)?'value="'.$rest_Emails[$i].'"':""; ?> />
                <a class="close sufrati-close" href="javascript:void(0);" data-dismiss="input-<?php echo $i;?>">&times;</a>
            </div>
            <?php
                }
            }else{
            ?>
            <div id="input-0">
                <input type="text" name="rest_Email[]"  placeholder="Restaurant Email, Managers Email, Owner`s Email" />
            </div>                
            <?php } ?>
        </div>
    </div>
      <div class="control-group">
            <div class="controls">
                 <a href="javascript:void(0)" class="btn btn-inverse" onclick="addmore();"><i class="icon-plus-sign icon-white"></i> Add another email</a>
            </div>
        </div>
      <div class="control-group">
          <label class="control-label" for="rest_WebSite">Website</label>
          <div class="controls">
              <input type="text" name="rest_WebSite" id="rest_WebSite" placeholder="Website" <?php echo isset($rest)?'value="'.$rest['rest_WebSite'].'"':""; ?>/>
          </div>
      </div>
      <div class="control-group">
          <label class="control-label" for="facebook_fan">Facebook Page</label>
          <div class="controls">
              <input type="text" name="facebook_fan" id="facebook_fan" placeholder="Facebook Page" <?php echo isset($rest)?'value="'.$rest['facebook_fan'].'"':""; ?>/>
          </div>
      </div>
      <div class="control-group">
          <label class="control-label" for="head_office">Head Office Contact Number</label>
          <div class="controls">
              <input type="text" name="head_office" id="head_office" placeholder="Head office Number" <?php echo isset($rest)?'value="'.$rest['head_office'].'"':""; ?>/>
          </div>
      </div>
      <div class="control-group">
          <label class="control-label" for="rest_TollFree">Toll Free Number</label>
          <div class="controls">
              <input type="text" name="rest_TollFree" id="rest_TollFree" placeholder="Toll Free Number" <?php echo isset($rest)?'value="'.$rest['rest_TollFree'].'"':""; ?>/>
          </div>
      </div>
      <div class="control-group">
          <label class="control-label" for="rest_Telephone">Restaurant Telephone</label>
          <div class="controls">
              <input type="text" name="rest_Telephone" id="rest_Telephone" placeholder="Restaurant Telephone" <?php echo isset($rest)?'value="'.$rest['rest_Telephone'].'"':""; ?>/>
          </div>
      </div>
      <div class="control-group">
          <label class="control-label" for="rest_Mobile">Delivery Number</label>
          <div class="controls">
              <input type="text" name="rest_Mobile" id="rest_Mobile" placeholder="Delivery Number" <?php echo isset($rest)?'value="'.$rest['rest_Mobile'].'"':""; ?>/>
          </div>
      </div>
      <div class="control-group">
          <label class="control-label" for="rest_pbox">P.O: Box</label>
          <div class="controls">
              <input type="text" name="rest_pbox" id="rest_pbox" placeholder="P.O.Box" <?php echo isset($rest)?'value="'.$rest['rest_pbox'].'"':""; ?>/>
          </div>
      </div>
  </fieldset>
  <fieldset>
      <legend>
          Open Hours &amp; Days
      </legend>
      <div class="control-group">
          <label class="control-label" for="week_days_start">Week Days</label>
          <div class="controls">
              <select class="auto-width" name="week_days_start">
                    <option value="">Opening Time</option>
                     <?php
                     for($i=0; $i<=24; $i++){
                          if($i<=9) $i="0".$i;
                          for($j=0;$j<=1;$j++){
                          if($j==0)$min='00';else $min=30;
                          $tim=$i.":".$min;
                          if($tim=="00:00") continue;
                          if($tim!="24:30"){
                          if($i >=12 and $i!=24) $mer=" pm"; else $mer=" am";
                          $act_time=$tim;
                          if(isset($openHours['week_days_start']) and $openHours['week_days_start']==$act_time){
                                  echo "<option selected='selected' value='$act_time'>$act_time</option>";
                          }
                          else{
                                  echo "<option value='$act_time'>$act_time</option>";
                          }
                          }
                      }
                  }
              ?>
              </select>
              <select class="auto-width" name="week_days_close">
                    <option value="">Closing Time</option>
                     <?php
                     for($i=0; $i<=24; $i++){
                          if($i<=9) $i="0".$i;
                          for($j=0;$j<=1;$j++){
                          if($j==0)$min='00';else $min=30;
                          $tim=$i.":".$min;
                          if($tim=="00:00") continue;
                          if($tim!="24:30"){
                          if($i >=12 and $i!=24) $mer=" pm"; else $mer=" am";
                          $act_time=$tim;
                          if(isset($openHours['week_days_close']) and $openHours['week_days_close']==$act_time){
                                  echo "<option selected='selected' value='$act_time'>$act_time</option>";
                          }
                          else{
                                  echo "<option value='$act_time'>$act_time</option>";
                          }
                          }
                      }
                  }
              ?>
              </select>
              <?php
              if(isset($rest)){
                  $weekdays=$weekends=$brunch=$breakfast="";
                  if(!empty($restdays['weekdays'])){
                      $weekdays=explode(',',$restdays['weekdays']);
                  }
                  if(!empty($restdays['weekends'])){
                      $weekends=explode(',',$restdays['weekends']);
                  }
                  if(!empty($restdays['breakfast'])){
                      $breakfast=explode(',',$restdays['breakfast']);
                  }
                  if(!empty($restdays['brunch'])){
                      $brunch=explode(',',$restdays['brunch']);
                  }
                  if(!empty($restdays['lunch'])){
                    $lunch=explode(',',$restdays['lunch']);
                    }
                    if(!empty($restdays['dinner'])){
                        $dinner=explode(',',$restdays['dinner']);
                    }
              }
              ?>
              <select name="weekdays[]" class="chzn-select sufrati-select" data-placeholder="Select Days" multiple style="width:350px;" tabindex="4">
                  <option value="">
                      Select Days
                  </option>
                  <option value="1" <?php if(isset($weekdays) and !empty($weekdays) and in_array(1,$weekdays)) echo 'selected="selected"';?>>Sunday</option>
                  <option value="2" <?php if(isset($weekdays) and !empty($weekdays) and in_array(2,$weekdays)) echo 'selected="selected"';?>>Monday</option>
                  <option value="3" <?php if(isset($weekdays) and !empty($weekdays) and in_array(3,$weekdays)) echo 'selected="selected"';?>>Tuesday</option>
                  <option value="4" <?php if(isset($weekdays) and !empty($weekdays) and in_array(4,$weekdays)) echo 'selected="selected"';?>>Wednesday</option>
                  <option value="5" <?php if(isset($weekdays) and !empty($weekdays) and in_array(5,$weekdays)) echo 'selected="selected"';?>>Thursday</option>
                  <option value="6" <?php if(isset($weekdays) and !empty($weekdays) and in_array(6,$weekdays)) echo 'selected="selected"';?>>Friday</option>
                  <option value="7" <?php if(isset($weekdays) and !empty($weekdays) and in_array(7,$weekdays)) echo 'selected="selected"';?>>Saturday</option>
              </select>
          </div>
      </div>
      <div class="control-group">
          <label class="control-label" for="week_ends_start">Week Ends</label>
          <div class="controls">
              <select class="auto-width" name="week_ends_start">
                    <option value="">Opening Time</option>
                     <?php
                     for($i=0; $i<=24; $i++){
                          if($i<=9) $i="0".$i;
                          for($j=0;$j<=1;$j++){
                          if($j==0)$min='00';else $min=30;
                          $tim=$i.":".$min;
                          if($tim=="00:00") continue;
                          if($tim!="24:30"){
                          if($i >=12 and $i!=24) $mer=" pm"; else $mer=" am";
                          $act_time=$tim;
                          if(isset($openHours['week_ends_start']) and $openHours['week_ends_start']==$act_time){
                                  echo "<option selected='selected' value='$act_time'>$act_time</option>";
                          }
                          else{
                                  echo "<option value='$act_time'>$act_time</option>";
                          }
                          }
                      }
                  }
              ?>
              </select>
              <select class="auto-width" name="week_ends_close">
                    <option value="">Closing Time</option>
                     <?php
                     for($i=0; $i<=24; $i++){
                          if($i<=9) $i="0".$i;
                          for($j=0;$j<=1;$j++){
                          if($j==0)$min='00';else $min=30;
                          $tim=$i.":".$min;
                          if($tim=="00:00") continue;
                          if($tim!="24:30"){
                          if($i >=12 and $i!=24) $mer=" pm"; else $mer=" am";
                          $act_time=$tim;
                          if(isset($openHours['week_ends_close']) and $openHours['week_ends_close']==$act_time){
                                  echo "<option selected='selected' value='$act_time'>$act_time</option>";
                          }
                          else{
                                  echo "<option value='$act_time'>$act_time</option>";
                          }
                          }
                      }
                  }
              ?>
              </select>
              <select name="weekends[]" class="chzn-select sufrati-select" data-placeholder="Select Days" multiple style="width:350px;" tabindex="4">
                  <option value="">
                      Select Days
                  </option>
                  <option value="1" <?php if(isset($weekends) and !empty($weekends) and in_array(1,$weekends)) echo 'selected="selected"';?>>Sunday</option>
                  <option value="2" <?php if(isset($weekends) and !empty($weekends) and in_array(2,$weekends)) echo 'selected="selected"';?>>Monday</option>
                  <option value="3" <?php if(isset($weekends) and !empty($weekends) and in_array(3,$weekends)) echo 'selected="selected"';?>>Tuesday</option>
                  <option value="4" <?php if(isset($weekends) and !empty($weekends) and in_array(4,$weekends)) echo 'selected="selected"';?>>Wednesday</option>
                  <option value="5" <?php if(isset($weekends) and !empty($weekends) and in_array(5,$weekends)) echo 'selected="selected"';?>>Thursday</option>
                  <option value="6" <?php if(isset($weekends) and !empty($weekends) and in_array(6,$weekends)) echo 'selected="selected"';?>>Friday</option>
                  <option value="7" <?php if(isset($weekends) and !empty($weekends) and in_array(7,$weekends)) echo 'selected="selected"';?>>Saturday</option>
              </select>
          </div>
      </div>
      <div class="control-group">
          <label class="control-label" for="breakfast">Breakfast</label>
          <div class="controls">
              <select class="auto-width" name="breakfast_start">
                    <option value="">Opening Time</option>
                     <?php
                     for($i=0; $i<=24; $i++){
                          if($i<=9) $i="0".$i;
                          for($j=0;$j<=1;$j++){
                          if($j==0)$min='00';else $min=30;
                          $tim=$i.":".$min;
                          if($tim=="00:00") continue;
                          if($tim!="24:30"){
                          if($i >=12 and $i!=24) $mer=" pm"; else $mer=" am";
                          $act_time=$tim;
                          if(isset($openHours['breakfast_start']) and $openHours['breakfast_start']==$act_time){
                                  echo "<option selected='selected' value='$act_time'>$act_time </option>";
                          }
                          else{
                                  echo "<option value='$act_time'>$act_time</option>";
                          }
                          }
                      }
                  }
              ?>
              </select>
              <select class="auto-width" name="breakfast_close">
                    <option value="">Closing Time</option>
                     <?php
                     for($i=0; $i<=24; $i++){
                          if($i<=9) $i="0".$i;
                          for($j=0;$j<=1;$j++){
                          if($j==0)$min='00';else $min=30;
                          $tim=$i.":".$min;
                          if($tim=="00:00") continue;
                          if($tim!="24:30"){
                          if($i >=12 and $i!=24) $mer=" pm"; else $mer=" am";
                          $act_time=$tim;
                          if(isset($openHours['breakfast_close']) and $openHours['breakfast_close']==$act_time){
                                  echo "<option selected='selected' value='$act_time'>$act_time</option>";
                          }
                          else{
                                  echo "<option value='$act_time'>$act_time</option>";
                          }
                          }
                      }
                  }
              ?>
              </select>
              <select name="breakfast[]" class="chzn-select sufrati-select" data-placeholder="Select Days" multiple style="width:350px;" tabindex="4">
                  <option value="">
                      Select Days
                  </option>
                  <option value="0" <?php if(isset($breakfast) and !empty($breakfast) and in_array(0,$breakfast)) echo 'selected="selected"';?> >Every Day</option>
                  <option value="1" <?php if(isset($breakfast) and !empty($breakfast) and in_array(1,$breakfast)) echo 'selected="selected"';?> >Sunday</option>
                  <option value="2" <?php if(isset($breakfast) and !empty($breakfast) and in_array(2,$breakfast)) echo 'selected="selected"';?> >Monday</option>
                  <option value="3" <?php if(isset($breakfast) and !empty($breakfast) and in_array(3,$breakfast)) echo 'selected="selected"';?> >Tuesday</option>
                  <option value="4" <?php if(isset($breakfast) and !empty($breakfast) and in_array(4,$breakfast)) echo 'selected="selected"';?> >Wednesday</option>
                  <option value="5" <?php if(isset($breakfast) and !empty($breakfast) and in_array(5,$breakfast)) echo 'selected="selected"';?> >Thursday</option>
                  <option value="6" <?php if(isset($breakfast) and !empty($breakfast) and in_array(6,$breakfast)) echo 'selected="selected"';?> >Friday</option>
                  <option value="7" <?php if(isset($breakfast) and !empty($breakfast) and in_array(7,$breakfast)) echo 'selected="selected"';?> >Saturday</option>
              </select>
          </div>
      </div>
      <div class="control-group">
          <label class="control-label" for="brunch">Brunch</label>
          <div class="controls">
              <select class="auto-width" name="brunch_start">
                    <option value="">Opening Time</option>
                     <?php
                     for($i=0; $i<=24; $i++){
                          if($i<=9) $i="0".$i;
                          for($j=0;$j<=1;$j++){
                          if($j==0)$min='00';else $min=30;
                          $tim=$i.":".$min;
                          if($tim=="00:00") continue;
                          if($tim!="24:30"){
                          if($i >=12 and $i!=24) $mer=" pm"; else $mer=" am";
                          $act_time=$tim;
                          if(isset($openHours['brunch_start']) and $openHours['brunch_start']==$act_time){
                                  echo "<option selected='selected' value='$act_time'>$act_time</option>";
                          }
                          else{
                                  echo "<option value='$act_time'>$act_time</option>";
                          }
                          }
                      }
                  }
              ?>
              </select>
              <select class="auto-width" name="brunch_close">
                    <option value="">Closing Time</option>
                     <?php
                     for($i=0; $i<=24; $i++){
                          if($i<=9) $i="0".$i;
                          for($j=0;$j<=1;$j++){
                          if($j==0)$min='00';else $min=30;
                          $tim=$i.":".$min;
                          if($tim=="00:00") continue;
                          if($tim!="24:30"){
                          if($i >=12 and $i!=24) $mer=" pm"; else $mer=" am";
                          $act_time=$tim;
                          if(isset($openHours['brunch_close']) and $openHours['brunch_close']==$act_time){
                                  echo "<option selected='selected' value='$act_time'>$act_time</option>";
                          }
                          else{
                                  echo "<option value='$act_time'>$act_time</option>";
                          }
                          }
                      }
                  }
              ?>
              </select>
              <select name="brunch[]" class="chzn-select sufrati-select" data-placeholder="Select Days" multiple style="width:350px;" tabindex="4">
                  <option value="">
                      Select Days
                  </option>
                  <option value="0" <?php if(isset($breakfast) and !empty($brunch)  and in_array(0,$brunch)) echo 'selected="selected"';?>>Every Day</option>
                  <option value="1" <?php if(isset($breakfast) and !empty($brunch)  and in_array(1,$brunch)) echo 'selected="selected"';?>>Sunday</option>
                  <option value="2" <?php if(isset($breakfast) and !empty($brunch)  and in_array(2,$brunch)) echo 'selected="selected"';?>>Monday</option>
                  <option value="3" <?php if(isset($breakfast) and !empty($brunch)  and in_array(3,$brunch)) echo 'selected="selected"';?>>Tuesday</option>
                  <option value="4" <?php if(isset($breakfast) and !empty($brunch)  and in_array(4,$brunch)) echo 'selected="selected"';?>>Wednesday</option>
                  <option value="5" <?php if(isset($breakfast) and !empty($brunch)  and in_array(5,$brunch)) echo 'selected="selected"';?>>Thursday</option>
                  <option value="6" <?php if(isset($breakfast) and !empty($brunch)  and in_array(6,$brunch)) echo 'selected="selected"';?>>Friday</option>
                  <option value="7" <?php if(isset($breakfast) and !empty($brunch)  and in_array(7,$brunch)) echo 'selected="selected"';?>>Saturday</option>
              </select>
          </div>
      </div>
       <div class="control-group">
          <label class="control-label" for="lunch">Lunch</label>
          <div class="controls">
              <select class="auto-width" name="lunch_start">
                    <option value="">Opening Time</option>
                     <?php
                     for($i=0; $i<=24; $i++){
                          if($i<=9) $i="0".$i;
                          for($j=0;$j<=1;$j++){
                          if($j==0)$min='00';else $min=30;
                          $tim=$i.":".$min;
                          if($tim=="00:00") continue;
                          if($tim!="24:30"){
                          if($i >=12 and $i!=24) $mer=" pm"; else $mer=" am";
                          $act_time=$tim;
                          if(isset($openHours['lunch_start']) and $openHours['lunch_start']==$act_time){
                                  echo "<option selected='selected' value='$act_time'>$act_time</option>";
                          }
                          else{
                                  echo "<option value='$act_time'>$act_time</option>";
                          }
                          }
                      }
                  }
              ?>
              </select>
              <select class="auto-width" name="lunch_close">
                    <option value="">Closing Time</option>
                     <?php
                     for($i=0; $i<=24; $i++){
                          if($i<=9) $i="0".$i;
                          for($j=0;$j<=1;$j++){
                          if($j==0)$min='00';else $min=30;
                          $tim=$i.":".$min;
                          if($tim=="00:00") continue;
                          if($tim!="24:30"){
                          if($i >=12 and $i!=24) $mer=" pm"; else $mer=" am";
                          $act_time=$tim;
                          if(isset($openHours['lunch_close']) and $openHours['lunch_close']==$act_time){
                                  echo "<option selected='selected' value='$act_time'>$act_time</option>";
                          }
                          else{
                                  echo "<option value='$act_time'>$act_time</option>";
                          }
                          }
                      }
                  }
              ?>
              </select>
              
              <select name="lunch[]" class="chzn-select sufrati-select" data-placeholder="Select Days" multiple style="width:350px;" tabindex="4">
                    <option value="">
                        Select Days
                    </option>
                    <option value="0" <?php if(isset($lunch) and !empty($lunch) and in_array(0,$lunch)) echo 'selected="selected"';?> >Every Day</option>
                    <option value="1" <?php if(isset($lunch) and !empty($lunch) and in_array(1,$lunch)) echo 'selected="selected"';?> >Sunday</option>
                    <option value="2" <?php if(isset($lunch) and !empty($lunch) and in_array(2,$lunch)) echo 'selected="selected"';?> >Monday</option>
                    <option value="3" <?php if(isset($lunch) and !empty($lunch) and in_array(3,$lunch)) echo 'selected="selected"';?> >Tuesday</option>
                    <option value="4" <?php if(isset($lunch) and !empty($lunch) and in_array(4,$lunch)) echo 'selected="selected"';?> >Wednesday</option>
                    <option value="5" <?php if(isset($lunch) and !empty($lunch) and in_array(5,$lunch)) echo 'selected="selected"';?> >Thursday</option>
                    <option value="6" <?php if(isset($lunch) and !empty($lunch) and in_array(6,$lunch)) echo 'selected="selected"';?> >Friday</option>
                    <option value="7" <?php if(isset($lunch) and !empty($lunch) and in_array(7,$lunch)) echo 'selected="selected"';?> >Saturday</option>
                </select>
              
          </div>
      </div>
      <div class="control-group">
          <label class="control-label" for="dinner">Dinner</label>
          <div class="controls">
              <select class="auto-width" name="dinner_start">
                    <option value="">Opening Time</option>
                     <?php
                     for($i=0; $i<=24; $i++){
                          if($i<=9) $i="0".$i;
                          for($j=0;$j<=1;$j++){
                          if($j==0)$min='00';else $min=30;
                          $tim=$i.":".$min;
                          if($tim=="00:00") continue;
                          if($tim!="24:30"){
                          if($i >=12 and $i!=24) $mer=" pm"; else $mer=" am";
                          $act_time=$tim;
                          if(isset($openHours['dinner_start']) and $openHours['dinner_start']==$act_time){
                                  echo "<option selected='selected' value='$act_time'>$act_time</option>";
                          }
                          else{
                                  echo "<option value='$act_time'>$act_time</option>";
                          }
                          }
                      }
                  }
              ?>
              </select>
              <select class="auto-width" name="dinner_close">
                    <option value="">Closing Time</option>
                     <?php
                     for($i=0; $i<=24; $i++){
                          if($i<=9) $i="0".$i;
                          for($j=0;$j<=1;$j++){
                          if($j==0)$min='00';else $min=30;
                          $tim=$i.":".$min;
                          if($tim=="00:00") continue;
                          if($tim!="24:30"){
                          if($i >=12 and $i!=24) $mer=" pm"; else $mer=" am";
                          $act_time=$tim;
                          if(isset($openHours['dinner_close']) and $openHours['dinner_close']==$act_time){
                                  echo "<option selected='selected' value='$act_time'>$act_time</option>";
                          }
                          else{
                                  echo "<option value='$act_time'>$act_time</option>";
                          }
                          }
                      }
                  }
              ?>
              </select>
              
              <select name="dinner[]" class="chzn-select sufrati-select" data-placeholder="Select Days" multiple style="width:350px;" tabindex="4">
                    <option value="">
                        Select Days
                    </option>
                    <option value="0" <?php if(isset($dinner) and !empty($dinner) and in_array(0,$dinner)) echo 'selected="selected"';?> >Every Day</option>
                    <option value="1" <?php if(isset($dinner) and !empty($dinner) and in_array(1,$dinner)) echo 'selected="selected"';?> >Sunday</option>
                    <option value="2" <?php if(isset($dinner) and !empty($dinner) and in_array(2,$dinner)) echo 'selected="selected"';?> >Monday</option>
                    <option value="3" <?php if(isset($dinner) and !empty($dinner) and in_array(3,$dinner)) echo 'selected="selected"';?> >Tuesday</option>
                    <option value="4" <?php if(isset($dinner) and !empty($dinner) and in_array(4,$dinner)) echo 'selected="selected"';?> >Wednesday</option>
                    <option value="5" <?php if(isset($dinner) and !empty($dinner) and in_array(5,$dinner)) echo 'selected="selected"';?> >Thursday</option>
                    <option value="6" <?php if(isset($dinner) and !empty($dinner) and in_array(6,$dinner)) echo 'selected="selected"';?> >Friday</option>
                    <option value="7" <?php if(isset($dinner) and !empty($dinner) and in_array(7,$dinner)) echo 'selected="selected"';?> >Saturday</option>
                </select>

          </div>
      </div>
  </fieldset>
  <fieldset>
      <legend>About the Restaurant</legend>
      <div class="control-group">
          <label class="control-label" for="rest_Logo">Logo</label>
          <div class="controls">
              <input type="file" name="rest_Logo" id="rest_Logo" />
              <?php 
              if(isset($rest)&&($rest['rest_Logo']!="")){
                  ?>
              <img src="http://uploads.azooma.co/logos/<?php echo $rest['rest_Logo'];?>"/>
              <input type="hidden" name="rest_Logo_old" value="<?php echo $rest['rest_Logo'];?>"/>
              <?php
              }
              ?>
          </div>
      </div>
      <div class="control-group">
          <label class="control-label" for="rest_Description">Restaurant Description</label>
          <div class="controls">
              <textarea onkeyup="countChar(this);" name="rest_Description" id="restDescription" rows="5" placeholder="Restaurant Description"><?php if(isset($rest)&&($rest['rest_Description']!="")) echo stripcslashes($rest['rest_Description']);?></textarea>
              <span class="badge badge-info" id="charNum"><?php echo $allowed_chars; ?></span>
                <div id="count-message" class="hidden error">Maximum <?php echo $allowed_chars; ?> Characters </div>
          </div>
      </div>
      <div class="control-group">
          <label class="control-label" for="rest_Description_Ar">Restaurant Description Arabic</label>
          <div class="controls">
              <textarea onkeyup="countCharAr(this);" name="rest_Description_Ar" id="rest_Description_Ar" rows="5" dir="rtl" placeholder="Restaurant Description Arabic"><?php if(isset($rest)&&($rest['rest_Description']!="")) echo stripcslashes($rest['rest_Description_Ar']);?></textarea>
              <span class="badge badge-info" id="charNumAr"><?php echo $allowed_chars; ?></span>
                <div id="count-message-ar" class="hidden error">Maximum <?php echo $allowed_chars; ?> Characters </div>
          </div>
      </div>
      <div class="control-group">
          <label class="control-label" for="rest_tags">Restaruant Tags</label>
          <div class="controls">
              <input type="text" name="rest_tags" id="rest_tags" placeholder="Restaruant Tags" <?php echo isset($rest)?'value="'.($rest['rest_tags']).'"':""; ?>/>
          </div>
      </div>
      <div class="control-group">
          <label class="control-label" for="rest_tags_ar">Restaruant Tags Arabic</label>
          <div class="controls">
              <input type="text" name="rest_tags_ar" id="rest_tags_ar" placeholder="Restaruant Tags Arabic" <?php echo isset($rest)?'value="'.($rest['rest_tags_ar']).'"':""; ?>/>
          </div>
      </div>
  </fieldset>
  
  <div class="control-group">
          <div class="controls">
              <input type="submit" name="submit" value="Save" class="btn btn-primary-gradien"/>
              <a href="<?php if(isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER']; else echo site_url();?>" class="btn" title="Cancel Changes">Cancel</a>
          </div>
       <?php 
              if(isset($rest)){
                  ?>
              <input type="hidden" name="rest_ID" value="<?php echo $rest['rest_ID'];?>"/>              
              <?php
              }
              ?>
      </div>
</form>
      </div>
    </article>
  </div>
</section>
<script type="text/javascript" src="<?php echo base_url();?>js/restform.js"></script> 
<script>
    
    var allowed_chars='<?php echo $allowed_chars; ?>';
    function countChar(val){
        var len = val.value.length;
        if (len > allowed_chars) {
            $('#count-message').removeClass('hidden');
            val.value = val.value.substring(0, allowed_chars);
        } else {
            $('#count-message').addClass('hidden');
            $('#charNum').text(allowed_chars - len);
        }
    };
    function countCharAr(val){
        var len = val.value.length;
        if (len > allowed_chars) {
            $('#count-message-ar').removeClass('hidden');
            val.value = val.value.substring(0, allowed_chars);
        } else {
            $('#count-message-ar').addClass('hidden');
            $('#charNumAr').text(allowed_chars - len);
        }
    };
</script>