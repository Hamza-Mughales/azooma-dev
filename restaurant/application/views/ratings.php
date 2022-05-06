<section id="top-banner">
  
    <ul class="breadcrumb">
  <li>
    <a href="<?php echo site_url();?>">Home</a> <span class="divider">/</span>
  </li>
  <li class="active">Ratings </li>
</ul>
  <div class="row-fluid spacer">
    <article class="span12 accordion-group">
      <h2 data-toggle="collapse" class="accordion-heading " data-target="#userratings"> <a class="accordion-toggle" href="javascript:void(0);"> Latest User Ratings <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i> </a> </h2>
      <div id="userratings" class="collapse in accordion-inner">
        <?php 
          if(count($total)>0){
    echo  $this->pagination->create_links();
          }
  ?>
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="actv">ID</th>
              <th>User Name</th>
              <th class="actv">Food</th>
              <th class="actv">Service</th>
              <th class="actv">Atmosphere</th>
              <th class="actv">Value</th>
              <th class="actv">Presentation</th>
              <th class="actv">Variety</th>
          </thead>
          <tbody>
            <?php if(isset($getlates) and !empty($getlates)){?>
            <?php $i=0;	foreach ( $getlates as $p ) { $i++; ?>
            <tr <?php if(isset($p['review_Status'])) if($p['review_Status']==0) echo 'class="strike"';  ?>  <?php if(isset($p['is_read'])) if($p['is_read']==0){ ?> class="new-row" onclick="readRating('<?php echo $p['rating_ID'] ?>')" <?php }  ?> data-row="<?php echo $p['rating_ID'] ?>" >
              <td align="center"><?php echo $i;?></td>
              <td><?php echo $this->MRestBranch->getUserName($p['user_ID']); ?></td>
              <td align="center"><?php echo $p['rating_Food'];?></td>
              <td align="center"><?php echo $p['rating_Service'];?></td>
              <td align="center"><?php echo $p['rating_Atmosphere'];?></td>
              <td align="center"><?php echo $p['rating_Value'];?></td>
              <td align="center"><?php echo $p['rating_Presentation'];?></td>
              <td align="center"><?php echo $p['rating_Variety'];?></td>
            </tr>
            <?php } ?>
            <?php }else{ ?>
            <tr>
              <td colspan="8">&nbsp;&nbsp;No Ratings Yet </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <?php 
          if(count($total)>0){
    echo  $this->pagination->create_links();
          }
  ?>
    </article>
  </div>
</section>
