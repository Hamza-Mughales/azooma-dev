<?php
foreach ($restlikes as $rest) {
  $restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar);
  $restlogo=($rest->rest_Logo=="")?"default_logo.gif":$rest->rest_Logo;
  $restname=(strlen($restname)>18)?mb_substr($restname, 0,16,'utf-8').'..':$restname;
  if(isset($rest->rest_ID)){
    $city=MGeneral::getPossibleCity($rest->rest_ID);
  }else{
    continue;
  }
  
  ?>
      <div class="col-md-4 col-sm-6">
  <div class="user-like-box" <?php if((isset($list))){ ?>id="rest-list-<?php echo $rest->rest_ID;?>"<?php }else{ ?>id="rest-recommend-<?php echo $rest->rest_ID;?>"<?php } ?>>
  <a href="<?php echo Azooma::url($city->seo_url.'/'.$rest->seo_url);?>" class="rest-logo" title="<?php echo $restname;?>">
        <img src="<?php echo Azooma::CDN('logos/'.$restlogo);?>" alt="<?php echo $restname;?>">
      </a>


    <a href="<?php echo Azooma::url($city->seo_url.'/'.$rest->seo_url);?>" class="normal-text rest-title" title="<?php echo $restname;?>">
        <?php echo $restname;?>
      </a>
      <?php if(Session::has('userid')&&(Session::get('userid')==$user->user_ID)){ ?>
      <a data-rest="<?php echo $rest->rest_ID;?>" class="remove-recommend btn <?php echo (isset($list))?'remove-from-list':'unlike-btn';?> hidden" <?php if(isset($list)){ echo 'data-list="'.$list.'"'; } ?> href="javascript:void(0);">
        <i class="fa fa-times"></i>
      </a>

      <?php } ?>
  </div>
</div>


  <?php
}
?>