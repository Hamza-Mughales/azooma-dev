<?php foreach ($userfoods as $food) {
  $city=MGeneral::getPossibleCity($food->rest_ID);
  ?>
    <div class="col-md-4 col-sm-6">
  <div class="user-like-box dish"  id="food-item-<?php echo $food->id;?>">
  <a href="<?php echo Azooma::URL($city->seo_url.'/'.$food->seo_url.'#menu-item-'.$food->id);?>" class="normal-text rest-logo" title="<?php echo ($lang=="en")?stripcslashes($food->menu_item).' - '.stripcslashes($food->cat_name):stripcslashes($food->menu_item_ar).' - '.stripcslashes($food->cat_name_ar);?>">
      <strong><?php echo ($lang=="en")?stripcslashes($food->menu_item).' - '.stripcslashes($food->cat_name):stripcslashes($food->menu_item_ar).' - '.stripcslashes($food->cat_name_ar);?></strong>
    </a>
    <a href="<?php echo Azooma::URL($city->seo_url.'/'.$food->seo_url.'#menu-item-'.$food->id);?>" class="normal-text" title="<?php echo ($lang=="en")?stripcslashes($food->rest_Name):stripcslashes($food->rest_Name_Ar);?>">
      <?php echo ($lang=="en")?stripcslashes($food->rest_Name):stripcslashes($food->rest_Name_Ar);?>
    </a>
      <?php if(Session::has('userid')&&(Session::get('userid')==$user->user_ID)){ ?>
        <a data-id="<?php echo $food->id;?>" data-city="<?php echo $city->seo_url;?>" href="javascript:void(0);" class="normal-text hidden remove-recommend btn" title="<?php echo Lang::get('messages.remove');?>">
      <i class="fa fa-times"></i>
    </a>
      <?php } ?>
  </div>
</div>


  <?php
}
?>