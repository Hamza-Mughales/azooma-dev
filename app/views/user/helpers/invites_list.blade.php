<?php
foreach($contacts as $invite){
	$fusername=($invite['name']=="")?$invite['email']:$invite['name'];
	$fuserimage='user-default.svg';
	?>
	<div class="overflow follow-users-list">
      	<div class="pull-left user-logo follow-col-1">
        	<span class="rest-logo">
          		<img src="<?php echo Azooma::CDN('images/100/'.$fuserimage);?>" alt="<?php echo $fusername;?>"/>
        	</span>
      	</div>
      	<div class="pull-left follow-col-2">
          	<span class="normal-text block">
            	<?php echo $fusername;?>
          	</span>
      	</div>
      	<div class="pull-left follow-col-3">
          <button data-invite-email="<?php echo $invite['email'];?>" class="btn btn-light email-invite-btn"><?php echo Lang::get('messages.send_invite');?></button>
      	</div>
     </div>
	<?php
}