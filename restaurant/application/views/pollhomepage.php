<?php 
if(count($poll)>0){
    $j=$offset;
    foreach($poll as $value){
       $j++;
        ?>
<tr onclick="document.location='<?php echo site_url('polls/options/'.$value['id']);?>';" >
    <td <?php if(isset($value['status'])) if($value['status']==0) echo 'class="strike"';  ?>>
        <?php echo $j;?>
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
                echo $result['field'].' - '.$result['votes'].' Votes<br/>';
            }
        }
        ?>
    </td>
    <td>
        <a class="sufrati-backend-actions" href="<?php echo site_url('polls/options/'.$value['id']);?>" rel="tooltip" title="Poll options">
            <i class="icon icon-eye-open"></i> View Options
        </a>
    </td>
    <td <?php if(isset($value['status'])) if($value['status']==0) echo 'class="strike"';  ?>>
        <?php echo $this->MGeneral->ago($value['date_add']);?>
    </td>
    <td>
        
        <a class="sufrati-backend-actions" href="<?php echo site_url('polls/form/'.$value['id']);?>" rel="tooltip" title="Update Poll">
            <i class="icon icon-edit"></i> Edit
        </a><br/>
         <a class="sufrati-backend-actions" href="<?php echo site_url('polls/questionstatus/'.$value['id'].'?limit='.$limit.'&per_page='.$offset);?>" rel="tooltip" title="<?php echo $value['status']==1? "Deactivate ":"Activate ";?> Poll">
            <?php
            if($value['status']==1){
                ?>
            <i class="icon icon-ban-circle"></i> DeActivate
            <?php
            }else{
            ?>
            <i class="icon icon-ok"></i> Activate
            <?php }?>
        </a><br/>
        <a class="sufrati-backend-actions" href="<?php echo site_url('polls/questiondelete/'.$value['id'].'?limit='.$limit.'&per_page='.$offset);?>" rel="tooltip" title="Delete Poll" onclick="return confirm('Do You Want to Delete?')">
            <i class="icon icon-remove"></i>
            Delete 
        </a>
    </td>
</tr>
<?php
    }
}
?>