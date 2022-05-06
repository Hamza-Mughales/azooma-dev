<section id="top-banner">
  
    <ul class="breadcrumb">
<li>
<a href="<?php echo site_url('polls');?>">Polls</a> <span class="divider">/</span>
</li>
<li class="active"><?php echo $poll['question']; ?> </li>
</ul>
    <div class="right-float">
        <span class="btn-left-margin right-float">
            <a href="<?php echo site_url('polls/optionform?poll='.$poll['id']);?>" class="btn btn-primary" title="Add a new Option>">Add a New Option</a>
            <a target="_blank" href="<? echo $this->config->item('sa_url').'poll/'.$poll['id']; ?>" title="" class="btn btn-inverse">Preview</a>
        </span>
            
    </div>
  <div class="row-fluid spacer">
    <article class="left span12 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#results">
          <a class="accordion-toggle" href="javascript:void(0);">
           <?php echo $pagetitle;?>  <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i>
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
          


        <table class="table table-bordered table-striped sufrati-backend-table" id="table-results-table">
            <thead>
            <th>
            </th>
            <th class="span3">
                Option
            </th>
            <th>
                Votes
            </th>
            <th>
                Added On
            </th>
            <th>
                Actions
            </th>
            </thead>
            <tbody>
               <?php 
               if(count($options)>0){
                   $i=0;
                   foreach($options as $option){
                       $i++;
                       ?>
                <tr>
                    <td <?php if(isset($option['status'])) if($option['status']==0) echo 'class="strike"';  ?>>
                        <?php echo $i;?>
                    </td>
                    <td <?php if(isset($option['status'])) if($option['status']==0) echo 'class="strike"';  ?>>
                        <?php echo $option['field'];?>
                    </td>
                    <td <?php if(isset($option['status'])) if($option['status']==0) echo 'class="strike"';  ?>>
                        <?php echo $option['votes'];?>
                    </td>
                    <td <?php if(isset($option['status'])) if($option['status']==0) echo 'class="strike"';  ?>>
                        <?php echo $this->MGeneral->ago($option['createdAt']);?>
                    </td>
                    <td>
                        <a class="sufrati-backend-actions" href="<?php echo site_url('polls/optionform/'.$option['id'].'/'.$id);?>" rel="tooltip" title="Update Option">
                            <i class="icon icon-edit"></i> Edit
                        </a><br/>
                         <a class="sufrati-backend-actions" href="<?php echo site_url('polls/optionstatus/'.$option['id'].'?limit='.$limit.'&per_page='.$offset);?>" rel="tooltip" title="<?php echo $option['status']==1? "Deactivate ":"Activate ";?> Option">
                            <?php
                            if($option['status']==1){
                                ?>
                            <i class="icon icon-ban-circle"></i> DeActivate
                            <?php
                            }else{
                            ?>
                            <i class="icon icon-ok"></i> Activate
                            <?php }?>
                        </a><br/>
                        <a class="sufrati-backend-actions" href="<?php echo site_url('polls/optiondelete/'.$option['id'].'?limit='.$limit.'&per_page='.$offset);?>" rel="tooltip" title="Delete Option" onclick="return confirm('Do You Want to Delete?')">
                            <i class="icon icon-remove"></i>
                            Delete 
                        </a>
                    </td>
                </tr>
                <?php
                   }
               }
               ?>
            </tbody>
        </table>
     
        
        
        
</div>
    </article>

  </div>
</section>
    