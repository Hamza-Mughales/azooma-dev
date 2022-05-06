<section id="top-banner">
  <ul class="breadcrumb">
<li>
    <a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
</li>
<?php
if(isset($menu)){
?>
<li class="active"> أنواع القائمة </li>
<?php }
if(isset($category)){
?>
<li class="active"> القائمة المصنفه  </li>
<?php }
if(isset($item)){
?>
<li class="active"> قائمة الأنواع </li>
<?php } ?>
</ul>
  <div class="row-fluid spacer">
    <article class="left span12 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#results">
          <a class="accordion-toggle" href="javascript:void(0);">
           <?php echo $pagetitle;?> <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i>
          </a>
      </h2>
      <div id="results" class="collapse in accordion-inner">
          <?php
if($this->session->flashdata('error')){
      echo '<br /><div class="alert alert-error"><a class="close" data-dismiss="alert">x</a><strong>'.$this->session->flashdata('error').'</strong></div>';
}
if($this->session->flashdata('message')){
  echo '<br /><div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong>'.$this->session->flashdata('message').'</strong></div>';
}
?>
    <?php
if(isset($menu)){
?>
<form id="menuForm" class="form-horizontal restaurant-form" method="post" action="<?php echo site_url('ar/menus/save/menu');?>">
    <fieldset>
        
        <div class="control-group">
            <label class="control-label" for="cat_name"> أنواع القائمة بأسم </label>
            <div class="controls">
                <input type="text" name="menu_name" class="required" id="menu_name" placeholder="أنواع القائمة بأسم" <?php echo isset($menucat)?'value="'.$menucat['menu_name'].'"':""; ?> />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="cat_name_ar"> أنواع القائمة بأسم العربي</label>
            <div class="controls">
                <input type="text" name="menu_name_ar" id="menu_name_ar" class="required" placeholder="أنواع القائمة بأسم العربي" <?php echo isset($menucat)?'value="'.$menucat['menu_name_ar'].'"':""; ?> />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <input type="hidden" name="rest_ID" value="<?php echo $rest['rest_ID'];?>"/>
                <?php if(isset($menucat)){
                  ?>
                <input type="hidden" name="menu_id" value="<?php echo $menucat['menu_id'];?>"/>
                <?php
                }
                ?>
                <input type="submit" name="submit" value=" حفظ " class="btn btn-primary"/>
                <a href="<?php if(isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER']; else echo site_url('ar/menus');?>" class="btn" title="إلغاء">إلغاء</a>
            </div>
        </div>
    </fieldset>
</form>
<?php
}
if(isset($category)){
  ?>
<form id="menuForm" class="form-horizontal restaurant-form" method="post" action="<?php echo site_url('ar/menus/save/menucategory');?>">
    <fieldset>
        <div class="control-group">
            <label class="control-label" for="cat_name_ar">أنواع القائمة بأسم</label>
            <div class="controls">
               <select id="menu_id" name="menu_id" class="required">
                    <option value="">Please select</option>
                    <?php
                    $i=0;
                    foreach($menuList as $list){
                    $i++;
					?>
                    <option value="<?php echo $list['menu_id']; ?>" <?php if(isset($menucat)){ if($list['menu_id']==$menucat['menu_id']){ echo "selected"; } }elseif( isset($_GET['menu_id']) ){ if($_GET['menu_id']==$list['menu_id']){ echo "selected"; } } ?>><?php echo $list['menu_name_ar']; ?></option>
					<?php 
					}
					?>
               </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="cat_name">اسم القسم - اللغة الإنجليزية</label>
            <div class="controls">
                <input type="text" name="cat_name" class="required" id="cat_name" placeholder="اسم القسم - اللغة الإنجليزية" <?php echo isset($menucat)?'value="'.(htmlspecialchars($menucat['cat_name'])).'"':""; ?> />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="cat_name_ar">اسم القسم - اللغة العربية</label>
            <div class="controls">
                <input type="text" name="cat_name_ar" id="cat_name_ar" class="required" placeholder="اسم القسم - اللغة العربية" <?php echo isset($menucat)?'value="'.(htmlspecialchars($menucat['cat_name_ar'])).'"':""; ?> />
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <input type="hidden" name="rest_ID" value="<?php echo $rest['rest_ID'];?>"/>
                <?php if(isset($menucat)){
                  ?>
                <input type="hidden" name="cat_id" value="<?php echo $menucat['cat_id'];?>"/>
                <?php
                }
                ?>
                <input type="submit" name="submit" value=" حفظ " class="btn btn-primary"/>
                <a href="<?php if(isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER']; else echo site_url('ar/menus');?>" class="btn" title="إلغاء">إلغاء</a>
            </div>
        </div>
    </fieldset>
</form>
<?php
}
if(isset($item)){
    ?>
<form id="menuForm" class="form-horizontal restaurant-form" method="post" action="<?php echo site_url('ar/menus/save/menuitem');?>" enctype="multipart/form-data">
    <fieldset>
        <div class="control-group">
            <label class="control-label" for="menu_item"> اسم الأكلة - اللغة بالانكليزية</label>
            <div class="controls">
                <input type="text" name="menu_item" id="menu_item" class="required" placeholder=" اسم الأكلة - اللغة بالانكليزية" <?php echo isset($menuitem)?'value="'.(htmlspecialchars($menuitem['menu_item'])).'"':""; ?> />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="menu_item_ar"> اسم الأكلة - اللغة العربية</label>
            <div class="controls">
                <input type="text" name="menu_item_ar" dir="rtl" id="menu_item_ar" class="required" placeholder=" اسم الأكلة - اللغة العربية" <?php echo isset($menuitem)?'value="'.(htmlspecialchars($menuitem['menu_item_ar'])).'"':""; ?> />
            </div>
        </div>
        
        
        
        <div class="control-group">
            <label for="rest_Description" class="control-label"> أنواع الصنف بالشرح - اللغة بالانكليزية </label>
            <div class="controls">
                <textarea placeholder="أنواع الصنف بالشرح" rows="5" id="menuItemDescription" name="menuItem_Description"><?php if(isset($menuitem)&&($menuitem['description']!="")) echo stripcslashes($menuitem['description']);?></textarea>
            </div>
        </div>
        
        <div class="control-group">
            <label for="rest_Description_Ar" class="control-label"> قائمة الأنواع بالشرح - اللغة العربية </label>
            <div class="controls">
                <textarea placeholder="أنواع الصنف بالشرح  - اللغة العربية" dir="rtl" rows="5" id="menuItem_Description_Ar" name="menuItem_Description_Ar"><?php if(isset($menuitem)&&($menuitem['descriptionAr']!="")) echo stripcslashes($menuitem['descriptionAr']);?></textarea>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" for="price">السعر</label>
            <div class="controls">
                <input type="text" name="price" id="price" placeholder="السعر" <?php echo isset($menuitem)?'value="'.$menuitem['price'].'"':""; ?> />
            </div>
        </div>
        <?php if($permissions['accountType']!=0){ ?>
        <div class="control-group">
            <label for="rest_Logo" class="control-label">صورة <br/><span class="small-font">حجم الصورة: (200*200)</span> </label>
            <div class="controls">
                <input type="file" id="menuItem_image" name="menuItem_image">
                <?php 
					if(isset($menuitem)){
						if(!empty( $menuitem['image'] )){
							?>
					<img src="<?php echo $this->config->item('sa_url').'images/menuItem/thumb/'.$menuitem['image']; ?>">
		   	             	<input type="hidden" value="<?php echo $menuitem['image']; ?>" name="rest_Logo_old">
							<?php
						}
					}
				?>
                
            </div>
        </div>
        <?php } ?>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <input type="hidden" name="rest_ID" value="<?php echo $rest['rest_ID'];?>"/>
                <input type="hidden" name="cat_id" value="<?php echo $cat['cat_id'];?>"/>
                <input type="hidden" name="menu_id" value="<?php echo $cat['menu_id'];?>"/>
                <?php if(isset($menuitem)){
                  ?>
                <input type="hidden" name="id" value="<?php echo $menuitem['id'];?>"/>
                <?php
                }
                ?>
                <input type="submit" name="submit" value=" حفظ " class="btn btn-primary"/>
                <a href="<?php if(isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER']; else echo site_url('ar/menus');?>" class="btn" title="إلغاء">إلغاء</a>
            </div>
        </div>
    </fieldset>
</form>
<?php
}
?>
<script type="text/javascript">
    $("#menuForm").validate();
</script>

</div>
    </article>

  </div>
</section>
