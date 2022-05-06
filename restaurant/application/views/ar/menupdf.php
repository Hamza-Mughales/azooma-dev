<section id="top-banner">
  <ul class="breadcrumb">
<li>
    <a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
</li>
<li class="active">Pdf القائمة  </li>

</ul>
    <div class="right-float">
        <span class="btn-left-margin right-float">
            <a href="<?php echo site_url('ar/menus/formpdf?rest='.$rest['rest_ID']);?>" title="" class="btn btn-primary ">PDFإضافة القائمة</a>
    </div>
  <div class="row-fluid spacer">
    <article class="left span12 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#results">
          <a class="accordion-toggle" href="javascript:void(0);">
             مجموعة PDF القوائم (<?php echo $this->MGeneral->convertToArabic($total);?>) <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i>
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
    if($total>0){
        ?>
             
                    <table class="table table-bordered table-striped sufrati-backend-table" id="rest-results-table">
            <thead>
            <th class="span4">
                العنوان
            </th>
            <th class="span4">
                Menu
            </th>
            <th>
                تحديث / تعديل
            </th>
            </thead>
            <tbody>
                <?php 
                foreach($menus as $menu){
                    ?>
                <tr> 
                    <td>
                       <?php echo $menu['title'].' - '.$menu['title_ar'];?>
                    </td>
                    <td>
                        <a target="_blank" href="http://uploads.azooma.co/images/menuItem/<?php echo $menu['menu'];?>">  View English PDF </a> <br/>
                        <a target="_blank" href="http://uploads.azooma.co/images/menuItem/<?php echo $menu['menu_ar'];?>">View Arabic PDF</a>
                    </td>
                    <td>
                       
                        <a class="sufrati-backend-actions" href="<?php echo site_url('ar/menus/formpdf/'.$menu['id'].'?rest='.$rest['rest_ID']);?>" rel="tooltip" title="تحرير">
                        <i class="icon icon-edit"></i> تحرير
                    </a><br/>
                    <a class="sufrati-backend-actions" href="<?php echo site_url('ar/menus/deletepdf/'.$menu['id']);?>" rel="tooltip" title="حذف" onclick="return confirm('Do You Want to Delete?')">
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