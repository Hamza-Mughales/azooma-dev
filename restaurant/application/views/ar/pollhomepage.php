<?php 
if(count($poll)>0){
    $j=$offset;
    foreach($poll as $value){
       $j++;
        ?>
<tr>
    <td <?php if(isset($value['status'])) if($value['status']==0) echo 'class="strike"';  ?>>
        <?php echo $this->MGeneral->convertToArabic($j);?>
    </td>
    <td <?php if(isset($value['status'])) if($value['status']==0) echo 'class="strike"';  ?>>
        <?php echo $value['question'].' '.$value['question_ar'];?>
    </td>
    <td <?php if(isset($value['status'])) if($value['status']==0) echo 'class="strike"';  ?>>
        <?php echo $value['totalvotes'].' Total Votes';?>
        <br/>
        <?php 
        $results=$this->MPoll->getPollOptions($value['id']);
        if(count($results)>0){
            foreach($results as $result){
                echo $result['field'].' - '.$result['votes'].' تصويت <br/>';
            }
        }
        ?>
    </td>
    <td>
        <a class="sufrati-backend-actions" href="<?php echo site_url('ar/polls/options/'.$value['id']);?>" rel="tooltip" title="Poll options">
            <i class="icon icon-eye-open"></i> خيارات
        </a>
    </td>
    <td <?php if(isset($value['status'])) if($value['status']==0) echo 'class="strike"';  ?>>
        <?php echo $this->MGeneral->ago($value['date_add']);?>
    </td>
    <td>
        
        <a class="sufrati-backend-actions" href="<?php echo site_url('ar/polls/form/'.$value['id']);?>" rel="tooltip" title="تحرير">
            <i class="icon icon-edit"></i> تحرير
        </a><br/>
         <a class="sufrati-backend-actions" href="<?php echo site_url('ar/polls/questionstatus/'.$value['id'].'?limit='.$limit.'&per_page='.$offset);?>" rel="tooltip" title="<?php echo $value['status']==1? " إلغاء التنشيط ":" تنشيط ";?> Poll">
            <?php
            if($value['status']==1){
                ?>
            <i class="icon icon-ban-circle"></i> إلغاء تفعيل
            <?php
            }else{
            ?>
            <i class="icon icon-ok"></i> تفعيل
            <?php }?>
        </a><br/>
        <a class="sufrati-backend-actions" href="<?php echo site_url('ar/polls/questiondelete/'.$value['id'].'?limit='.$limit.'&per_page='.$offset);?>" rel="tooltip" title="حذف" onclick="return confirm('Do You Want to Delete?')">
            <i class="icon icon-remove"></i>
            حذف 
        </a>
    </td>
</tr>
<?php
    }
}
?>