<div class="overflow" id="step4-container">
	<div class="overflow">
		<button type="button" class="btn btn-camera btn-lg pull-right user-step4-btn step-btn"><?php echo Lang::get('messages.finish');?></button>
	</div>
	<div class="overflow">
		<?php 
		if(count($users)>0){
			?>
			<h3>
				<?php echo Lang::get('messages.follow_top_users');?>
			</h3>
			<div class="spacing-container">
			</div>
			<?php
			foreach ($users as $usr) {
				$username=($usr->user_NickName!="")?stripcslashes($usr->user_NickName):stripcslashes($usr->user_FullName);
				$userthumb=($usr->image=="")?'user-default.svg':$usr->image;
				?>
			<div class="overflow rest-like-sugg-blk col-sm-4">
				<a class="rest-logo pull-left" href="<?php echo Azooma::URL('user/'.$usr->user_ID);?>" title="<?php echo $username;?>">
					<img src="<?php echo Azooma::CDN('images/100/'.$userthumb);?>" alt="<?php echo $username;?>">
				</a>
				<div class="pull-left sec-col">
					<div>
						<a class="normal-text" href="<?php echo Azooma::URL('user/'.$usr->user_ID);?>" title="<?php echo $username;?>">
							<b><?php echo $username;?></b>
						</a>
					</div>
					<div>
						<?php  echo '<span data-total-followers'.$usr->user_ID.'="'.$usr->followers.'">'.$usr->followers.'</span> '.Lang::get('messages.followers').', '.$usr->following.' '.Lang::get('messages.following'); ?>
					</div>
					<div>
						<button class="btn btn-danger btn-block follow-btn" data-user="<?php echo $usr->user_ID;?>" data-following="0">
		    				<?php echo Lang::get('messages.follow');?>
		    			</button>
					</div>
				</div>
			</div>
				<?php
			}
		}
		?>
	</div>
	<?php
	if(isset($friends)&&count($friends)>0){ ?>
	<div class="overflow">
		<div class="spacing-container">
		</div>
		<h3>
			<?php echo Lang::get('messages.following_facebook_friends');?>
		</h3>
		<div class="spacing-container">
		</div>
		<div class="overflow">
			<?php
			foreach ($friends as $usr) {
				$username=($usr->user_NickName!="")?stripcslashes($usr->user_NickName):stripcslashes($usr->user_FullName);
				$userthumb=($usr->image=="")?'user-default.svg':$usr->image;
				?>
			<div class="overflow rest-like-sugg-blk col-sm-4">
				<a class="rest-logo pull-left" href="<?php echo Azooma::URL('user/'.$usr->user_ID);?>" title="<?php echo $username;?>">
					<img src="<?php echo Azooma::CDN('images/100/'.$userthumb);?>" alt="<?php echo $username;?>">
				</a>
				<div class="pull-left sec-col">
					<div>
						<a class="normal-text" href="<?php echo Azooma::URL('user/'.$usr->user_ID);?>" title="<?php echo $username;?>">
							<b><?php echo $username;?></b>
						</a>
					</div>
					<div>
						<?php  echo '<span data-total-followers'.$usr->user_ID.'="'.$usr->followers.'">'.$usr->followers.'</span> '.Lang::get('messages.followers').', '.$usr->following.' '.Lang::get('messages.following'); ?>
					</div>
					<div>
						<?php $checkfollowing=User::checkFollowing(Session::get('userid'),$usr->user_ID);
						if($checkfollowing>0){
							?>
							<button class="btn btn-danger btn-block follow-btn following-btn" data-user="<?php echo $usr->user_ID;?>" data-following="0">
			    				<?php echo Lang::get('messages.following');?>
			    			</button>
							<?php
						}else{
						?>
						<button class="btn btn-danger btn-block follow-btn" data-user="<?php echo $usr->user_ID;?>" data-following="0">
		    				<?php echo Lang::get('messages.follow');?>
		    			</button>
		    			<?php } ?>
					</div>
				</div>
			</div>
				<?php
			}
			?>
		</div>
	</div>
	<?php } ?>
	<div class="overflow">
		<button type="button" class="btn btn-camera btn-lg pull-right user-step4-btn step-btn"><?php echo Lang::get('messages.finish');?></button>
	</div>
</div>