<section id="top-banner">
  
    <ul class="breadcrumb">
<li>
<a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
</li>
<?php
if( isset($_GET['menu_id']) && !isset($_GET['cat_id']) ){
?>
<li class="active">
القائمة المصنفه 
</li>
<?php 
}elseif( isset($_GET['cat_id']) && isset($_GET['cat_id']) ){
?>
<li>
<a href="<?php echo site_url('ar/menus?rest='.$_GET['rest'].'&menu_id='.$_GET['menu_id']);?>">القائمة المصنفه  </a> <span class="divider">/</span>
</li>
<li class="active">
 قائمة الأصناف
</li>
<?php }else{ ?>

<li class="active">القائمة </li>
<?php 
}
?>
</ul>
    <div class="right-float">
        <span class="btn-left-margin right-float">
            <a href="<?php echo site_url('ar/menus/form?rest='.$rest['rest_ID']);?><?php if(isset($_GET['menu_id'])&&($_GET['menu_id']!="")){ echo '&cat_id=0&menu_id='.$_GET['menu_id'];} ?><?php if(isset($cat)&&($cat['cat_id']!="")){ echo '&cat='.$cat['cat_id'];} ?>" title="" class="btn btn-primary "><?php echo $pagetitlelink; ?></a>
    </div>
  <div class="row-fluid spacer">
    <article class="left span12 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#results">
          <a class="accordion-toggle" href="javascript:void(0);">
             <?php echo ($topName); ?> (<?php echo $this->MGeneral->convertToArabic($total); ?>) <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i>
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
    if(count($menus)>0){
        ?>
             
                    <table class="table table-bordered table-striped sufrati-backend-table" id="rest-results-table">
            <thead>
            <th class="span4">
               <?php echo $tableheading; ?>
            </th>
            <th class="span4">
               <?php echo $tableheadingAr; ?>
            </th>
            <th>
                تحديث / تعديل
            </th>
            </thead>
            <tbody>
            
			    <?php 
                foreach($menus as $menu){
                    ?>
                    <?php
					$tmp_link='?rest='.$rest['rest_ID'];
					if(isset($menu['menu_id']) && !isset($menu['cat_id'])){ 
						$tmp_link.='&menu_id='.$menu['menu_id'];
					}elseif(isset($menu['cat_id']) && isset($menu['menu_id'])){ 
						$tmp_link.='&cat_id='.$menu['cat_id'].'&menu_id='.$menu['menu_id'];
					}
                    
					?>
                    
                <tr> 
                    <td>
                        <?php
                        if(isset($menu['menu_name'])){
                            echo ($menu['menu_name']);
                        }elseif(isset($menu['cat_name'])){
                            echo ($menu['cat_name']);
                        }else{
                            echo ($menu['menu_item']);
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if(isset($menu['menu_name_ar'])){
                            echo ($menu['menu_name_ar']);
                        }elseif(isset($menu['cat_name_ar'])){
                            echo ($menu['cat_name_ar']);
                        }else{
                            echo ($menu['menu_item_ar']);
                        }
                        ?>
                    </td>
                    <td>
                    
                        <?php if(!isset($cat)){ ?>
                        <a class="sufrati-backend-actions" href="<?php echo site_url('ar/menus'.$tmp_link);?><?php if(!isset($cat) && ( isset($menu['cat_id']) && isset($menu['menu_id']) ) ){ echo '&item='.$menu['cat_id'];} ?>" rel="tooltip" title="<?php echo $pageview; ?>">
                        <i class="icon icon-list-alt"></i> <?php echo $pageview; ?>
                    </a><br/>
                    <?php }?>
                        <a class="sufrati-backend-actions" href="<?php echo site_url('ar/menus/form'.$tmp_link);?><?php if(isset($cat)){ echo '&cat='.$cat['cat_id'].'&item='.$menu['id'].'&menu_id='.$_GET['menu_id'];} ?>" rel="tooltip" title="تحرير">
                        <i class="icon icon-edit"></i> تحرير
                    </a><br/>
                    <a class="sufrati-backend-actions" href="<?php echo site_url('ar/menus/delete'.$tmp_link);?><?php if(isset($cat)){ echo '&cat='.$cat['cat_id'].'&item='.$menu['id'].'&menu_id='.$_GET['menu_id'];} ?>" rel="tooltip" title="حذف" onclick="return confirm('Do You Want to Delete?')">
                        <i class="icon icon-remove"></i>
                        حذف 
                    </a>
                    </td>
                </tr>
                
                <?php
                }
                ?>
            </tbody>
                    </table>
    <?php
    }
    ?>
</div>
    </article>

  </div>
</section>