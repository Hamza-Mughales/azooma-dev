<section id="top-banner">
  
    <ul class="breadcrumb">
<li>
    <a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
</li>
<li>
  <a href="<?php echo site_url('ar/offers');?>">العروض</a> <span class="divider">/</span>
</li>
<li class="active">
 إضافة عرض جديد 
</li>
</ul>
    <div class="right-float">
        
    </div>
    
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
          
<form id="offerForm" class="form-horizontal restaurant-form" method="post" action="<?php echo site_url('ar/offers/save');?>" enctype="multipart/form-data">
    <fieldset>
        <div class="control-group">
            <label class="control-label" for="offerName">اسم العرض - اللغة الانجليزية</label>
            <div class="controls">
                <input type="text" name="offerName" class="required" id="offerName" placeholder="اسم العرض - اللغة الانجليزية" <?php echo isset($offer)?'value="'.(htmlspecialchars($offer['offerName'])).'"':""; ?> />
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" for="offerNameAr">اسم العرض- اللغة العربية</label>
            <div class="controls">
                <input type="text" name="offerNameAr" dir="rtl" class="required" id="offerNameAr" placeholder="اسم العرض- اللغة العربية" <?php echo isset($offer)?'value="'.(htmlspecialchars($offer['offerNameAr'])).'"':""; ?> />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="offerCategory">عنوان العرض</label>
            <div class="controls">
                <select  multiple class="chzn-select required" tabindex="7" style="width: 350px;" data-placeholder="عنوان العرض"  name="offerCategory[]" id="offerCategory">
                    <?php
                    if(isset($restoffercategory))
                    $cat=array();
                    foreach($restoffercategory as $val){
                        $cat[]=$val['categoryID'];
                    }
                    if(count($offercategories)>0){
                        foreach($offercategories as $category){
                            ?>
                    <option value="<?php echo $category['id'];?>" <?php if(isset($cat)){ if(in_array($category['id'],$cat)) echo "selected='selected'"; };?>>
                        <?php echo $category['categoryNameAr'];?>
                    </option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="restBranches">الفروع مع العرض</label>
            <div class="controls">
                <select multiple class="chzn-select required" tabindex="7" style="width: 350px;" data-placeholder="الفروع مع العرض"  name="restBranches[]" id="restBranches">
                    <?php
                    if(isset($restofferbranches)){
                    $br=array();
                    if(count($restofferbranches)>0){
                        foreach($restofferbranches as $val){
                            $br[]=$val['branchID'];
                        }
                    }
                    }else{
						$br=0;
					}
                    ?>
                    <option value="all" <?php if((count($br)==1)&&($br[0]==0)) echo "selected='selected'";?>> جميع الفروع </option>
                    <?php
                    if(count($restbranches)>0){
                        foreach($restbranches as $branch){
                            ?>
                    <option value="<?php echo $branch['br_id'];?>" <?php if(isset($restofferbranches)){ if(in_array($branch['br_id'],$br)) echo "selected='selected'"; } ?>><?php echo $branch['br_loc'];?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="startDate">تاريخ</label>
            <div class="controls">
                <input class="auto-width required"  type="text" name="startDate" id="startDate" placeholder="نهاية" <?php echo isset($offer)?'value="'.$offer['startDate'].'"':""; ?> />
                <input class="auto-width required" type="text" name="endDate" id="endDate" placeholder="بداية " <?php echo isset($offer)?'value="'.$offer['endDate'].'"':""; ?> />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="startTime">الوقت</label>
            <div class="controls">
                
                <select class="auto-width" name="startTime" id="startTime">
                        <option value="">حدد وقت البدء</option>
                   <?php for($i=0; $i<=24; $i++){
                        if($i<=9) $i="0".$i;
                            for($j=0;$j<=1;$j++){
                                if($j==0)$min='00';else $min=30;
                                $tim=$i.":".$min;
                                if($tim=="00:00") continue;
                                if($tim!="24:30"){
                                    if($i >=12 and $i!=24) $mer=" pm"; else $mer=" am";
                                    $act_time=$tim;
                                    if(isset($offer['startTime']) and $offer['startTime']==$act_time)
                                    {
                                    echo "<option selected='selected' value='$act_time'>$act_time</option>";
                                    }
                                else{
                            echo "<option value='$act_time'>".$this->MGeneral->convertToArabic($act_time)."</option>";
                                  }
                                 }
                            }
                    }?>
                </select>
                <select name="endTime" class="auto-width">
                        <option value="">حدد وقت إنهاء</option>
                   <?php for($i=0; $i<=24; $i++){
                        if($i<=9) $i="0".$i;
                            for($j=0;$j<=1;$j++){
                                if($j==0)$min='00';else $min=30;
                                $tim=$i.":".$min;
                                if($tim=="00:00") continue;
                                if($tim!="24:30"){
                                if($i >=12 and $i!=24) $mer=" pm"; else $mer=" am";
                                $act_time=$tim;
                                if(isset($offer['endTime']) and $offer['endTime']==$act_time)
                                {
                                echo "<option selected='selected' value='$act_time'>$act_time</option>";
                                }
                                else{
                            echo "<option value='$act_time'>".$this->MGeneral->convertToArabic($act_time)."</option>";
                                        }
                                 }
                        }
                    }?>
                </select> </div>
        </div>
        
        
        <div class="control-group">
            <label class="control-label" for="shortDesc"> وصف قصير - اللغة الانجليزية <br/>
            (ماكس 100 حرفا)</label>
            <div class="controls">
                <textarea name="shortDesc" id="shortDesc" rows="5" placeholder="وصف قصير - اللغة الانجليزية"><?php echo isset($offer)?str_replace(array("\\r\\n","\r\n", "\r", "\\r", "\\n", "\n"), "\n", $offer['shortDesc']):""; ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="shortDescAr">وصف قصير - اللغة العربية <br /> (ماكس 100 حرفا)</label>
            <div class="controls">
                <textarea dir="rtl" name="shortDescAr" id="shortDescAr" rows="5" placeholder="وصف قصير - اللغة العربية"><?php echo isset($offer)?str_replace(array("\\r\\n","\r\n", "\r", "\\r", "\\n", "\n"), "\n", $offer['shortDescAr']):""; ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="image">صورة العرض - اللغة العربية
            <br />
            <span class="small-font">حجم الصورة: (200*200)</span>
            </label>
            <div class="controls">
                <input type="file" name="image" id="image" />
                <?php 
                if(isset($offer)){
                    ?>
                <input type="hidden" name="image_old" value="<?php echo $offer['image'];?>"/>
                <img src="<?php echo $this->config->item('sa_url');?>images/offers/thumb/<?php echo $offer['image'];?>"/>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="imageAr">صورة العرض - اللغة الانجليزية
            <br />
            <span class="small-font">حجم الصورة: (200*200)</span>
            </label>
            <div class="controls">
                <input type="file" name="imageAr" id="imageAr" />
                <?php 
                if(isset($offer)){
                    ?>
                <input type="hidden" name="imageAr_old" value="<?php echo $offer['imageAr'];?>"/>
                <img src="<?php echo $this->config->item('sa_url');?>images/offers/thumb/<?php echo $offer['imageAr'];?>"/>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="longDesc">وصف كامل - اللغة الانجليزية</label>
            <div class="controls">
                <textarea name="longDesc" id="longDesc" rows="5" placeholder="وصف كامل - اللغة الانجليزية"><?php echo isset($offer)?$offer['longDesc']:""; ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="longDescAr">وصف كامل - اللغة العربية</label>
            <div class="controls">
                <textarea dir="rtl" name="longDescAr" id="longDescAr" rows="5" placeholder="وصف كامل - اللغة العربية"><?php echo isset($offer)?$offer['longDescAr']:""; ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="terms">الشروط والتفاصيل  - اللغة الانجليزية</label>
            <div class="controls">
                <textarea name="terms" id="terms" rows="5" placeholder="الشروط والتفاصيل  - اللغةالانجليزية"><?php echo isset($offer)?$offer['terms']:""; ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="terms">الشروط والتفاصيل - اللغة العربية </label>
            <div class="controls">
                <textarea name="termsAr" id="termsAr" rows="5" placeholder="الشروط والتفاصيل - اللغة العربية"><?php echo isset($offer)?$offer['termsAr']:""; ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="contactEmail">البريد الإلكتروني</label>
            <div class="controls">
                <input type="text" name="contactEmail" id="contactEmail" placeholder="Contact Email" <?php echo isset($offer)?'value="'.$offer['contactEmail'].'"':""; ?> />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="contactPhone">رقم الهاتف</label>
            <div class="controls">
                <input type="text" name="contactPhone" id="contactPhone" placeholder="Contact Number" <?php echo isset($offer)?'value="'.$offer['contactPhone'].'"':""; ?> />
            </div>
        </div>
        <div class="control-group">
                <label class="control-label" for="rest_Status">تفعيل العرض</label>
                <div class="controls">
                    <input type="checkbox" name="status" value="1" checked="checked"/>
                </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" for="rest_Status"></label>
            <div class="controls">
                <input type="hidden" name="rest_ID" value="<?php echo $rest['rest_ID'];?>"/>
                <?php 
                if(isset($offer)){
                    ?>
                <input type="hidden" name="id" value="<?php echo $offer['id'];?>"/>
                <?php
                }
                ?>
                <input type="submit" name="submit" value=" حفظ " class="btn btn-primary"/>
                <a href="<?php if(isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER']; else echo site_url('ar/offers');?>" class="btn" title="إلغاء">إلغاء</a>
            </div>
        </div>
    </fieldset>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $("#startDate").datepicker({dateFormat:'yy-mm-dd'});
        $("#endDate").datepicker({dateFormat:'yy-mm-dd'});
        $('.chzn-select').chosen();  
    });
	
	$("#offerForm").validate();
	
    CKEDITOR_BASEPATH = '<?php echo base_url();?>js/admin/ckeditor/';
     var editor1=CKEDITOR.replace('longDesc', {toolbar : 'MyToolbar',width : '470px',height : '200px',forcePasteAsPlainText : true,filebrowserBrowseUrl : '<?php echo base_url();?>js/admin/ckfinder/ckfinder.html',filebrowserImageBrowseUrl : '<?php echo base_url();?>js/admin/ckfinder/ckfinder.html?Type=Images',filebrowserFlashBrowseUrl : '<?php echo base_url();?>js/admin/ckfinder/ckfinder.html?Type=Flash',filebrowserUploadUrl : '<?php echo base_url();?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',filebrowserImageUploadUrl : '<?php echo base_url();?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',filebrowserFlashUploadUrl : '<?php echo base_url();?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'});
     var editor2=CKEDITOR.replace('longDescAr', {toolbar : 'MyToolbar',width : '470px',height : '200px',forcePasteAsPlainText : true,filebrowserBrowseUrl : '<?php echo base_url();?>js/admin/ckfinder/ckfinder.html',filebrowserImageBrowseUrl : '<?php echo base_url();?>js/admin/ckfinder/ckfinder.html?Type=Images',filebrowserFlashBrowseUrl : '<?php echo base_url();?>js/admin/ckfinder/ckfinder.html?Type=Flash',filebrowserUploadUrl : '<?php echo base_url();?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',filebrowserImageUploadUrl : '<?php echo base_url();?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',filebrowserFlashUploadUrl : '<?php echo base_url();?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'});
      var editor3=CKEDITOR.replace('terms', {toolbar : 'MyToolbar',width : '470px',height : '200px',forcePasteAsPlainText : true,filebrowserBrowseUrl : '<?php echo base_url();?>js/admin/ckfinder/ckfinder.html',filebrowserImageBrowseUrl : '<?php echo base_url();?>js/admin/ckfinder/ckfinder.html?Type=Images',filebrowserFlashBrowseUrl : '<?php echo base_url();?>js/admin/ckfinder/ckfinder.html?Type=Flash',filebrowserUploadUrl : '<?php echo base_url();?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',filebrowserImageUploadUrl : '<?php echo base_url();?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',filebrowserFlashUploadUrl : '<?php echo base_url();?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'});
	  var editor3=CKEDITOR.replace('termsAr', {toolbar : 'MyToolbar',width : '470px',height : '200px',forcePasteAsPlainText : true,filebrowserBrowseUrl : '<?php echo base_url();?>js/admin/ckfinder/ckfinder.html',filebrowserImageBrowseUrl : '<?php echo base_url();?>js/admin/ckfinder/ckfinder.html?Type=Images',filebrowserFlashBrowseUrl : '<?php echo base_url();?>js/admin/ckfinder/ckfinder.html?Type=Flash',filebrowserUploadUrl : '<?php echo base_url();?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',filebrowserImageUploadUrl : '<?php echo base_url();?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',filebrowserFlashUploadUrl : '<?php echo base_url();?>js/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'});

</script>

</div>
    </article>

  </div>
</section>