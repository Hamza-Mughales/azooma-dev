<?php
echo message_box('error');
echo message_box('success');
?>
<div class="pt-2">
  <ul class="breadcrumb">
  <li>
    <a href="<?php echo base_url();?>"><?=lang('home')?></a> <span class="divider">/</span>
  </li>
  <li class="active">Change Password </li>
</ul>
</div>
<section class="card">
  <div class="card-body">
    <article class="span12 accordion-group">
      <h4 > Update Your account Password 

      </h4>

      <div id="restinfo" >

          <form id="restMainForm" class="form-horizontal restaurant-form" method="post" action="<?php echo base_url('home/savepassword/');?>" enctype="multipart/form-data">
  <fieldset>
      <div class="form-group row">
        <label class="control-label col-md-12" for="cat_name">Current Password</label>
        <div class=" col-md-12">
            <input type="password" name="current_password" class="form-control" required id="current_password" placeholder="Current Password" <?php echo isset($menucat)?'value="'.$menucat['menu_name'].'"':""; ?> />
        </div>
     </div>
     <div class="form-group row">
        <label class="control-label col-md-12" for="cat_name">New Password</label>
        <div class=" col-md-12">
            <input type="password" name="new_password" class="form-control" required id="new_password" placeholder="New Password" <?php echo isset($menucat)?'value="'.$menucat['menu_name'].'"':""; ?> />
        </div>
     </div>
     <div class="form-group row">
        <label class="control-label col-md-12" for="cat_name">Confirm Password</label>
        <div class=" col-md-12">
            <input type="password" name="confirm_password" equalto="#new_password" class="form-control" required id="confirm_password" placeholder="Confirm Password" <?php echo isset($menucat)?'value="'.$menucat['menu_name'].'"':""; ?> />
        </div>
     </div> 
  </fieldset>
  
  <div class="form-group row text-end">
          <div class=" col-md-12">
              <input type="submit" name="submit" value="Save" class="btn btn-primary-gradien"/>
              <a href="<?php if(isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER']; else echo base_url('admin/rest');?>" class="btn" title="Cancel Changes">Cancel</a>
          </div>
      <?php 
              if(isset($rest)){
                  ?>
              <input type="hidden" name="rest_ID" value="<?php echo $rest['rest_ID'];?>"/>
              <input type="hidden" name="rest_Name" value="<?php echo (htmlspecialchars($rest['rest_Name']));?>"/>
              <?php
              }
              ?>
      </div>
</form>
          
      <script type="text/javascript">
    $("#restMainForm").validate();
</script>
      </div>
    </article>
  </div>
</section>