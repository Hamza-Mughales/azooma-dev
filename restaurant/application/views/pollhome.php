<section id="top-banner">
  
    <ul class="breadcrumb">
<li>
<a href="<?php echo site_url('polls');?>">Polls</a> <span class="divider">/</span>
</li>
<li class="active">Poll </li>
</ul>
    <div class="right-float">
        <span class="btn-left-margin right-float">
            <a href="<?php if(!empty($rest_ID)){ echo site_url('polls/form?restaurant='.$rest_ID); }else{ echo site_url('hungryn137/poll/form'); }?>" class="btn btn-primary" title="Add a new Poll>">Add New Poll</a>     
            <a target="_blank" href="<? echo $this->config->item('sa_url').'poll'; ?>" title="" class="btn btn-inverse">Preview</a>
        </span>
            
    </div>
  <div class="row-fluid spacer">
    <article class="left span12 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#results">
          <a class="accordion-toggle" href="javascript:void(0);">
           Total Results (<?php echo $total;?>)  <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i>
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
        if(count($total)>0){
          echo  $this->pagination->create_links();
            ?>
        <table class="table table-bordered table-striped sufrati-backend-table" id="table-results-table">
            <thead>
            <th>
            </th>
            <th class="span3">
                Poll
            </th>
            
            <th class="span3">
                Result
            </th>
            <th>
                Date Added
            </th>
            <th>
                Options
            </th>
            <th>
                Actions
            </th>
            </thead>
            <tbody>
               <?php echo $value; ?>
            </tbody>
        </table>
            
        
        </div>
    </article>

  </div>
        <?php
       echo $this->pagination->create_links();
        }
        ?>
</section>