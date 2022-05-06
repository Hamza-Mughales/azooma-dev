<div class="spacing-container"></div>
<?php
if(count($notifications)>0){
	foreach ($notifications as $notification) {
		switch ($notification->activity_text) {
			case 'Comment approved':
				$comment=User::getPossibleComment($notification->activity_ID);
				if(count($comment)>0){
				$rest=MRestaurant::getRest($comment->rest_ID);
				$restlogo=($rest->rest_Logo=="")?"default_logo.gif":$rest->rest_Logo;
				$restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar);
		?>
		<div class="notification-block <?php if($notification->read==0){ echo 'unread'; } ?>">
			<div class="overflow">
				<span class="rest-logo pull-left" >
					<img src="<?php echo Azooma::CDN('logos/70/'.$restlogo);?>" alt="<?php echo $restname;?>">
				</span>
				<div class="pull-left notification-text">
					<?php echo Lang::get('messages.your_review_on').' ';?>
					<b class="link">
						<?php echo $restname;?>
					</b> <?php echo Lang::get('messages.has_been_approved').'.';?>
				</div>
				<div class="pull-right time-stamp">
					<?php echo Azooma::Ago($notification->createdAt)?>
				</div>
			</div>
			<a href="<?php echo Azooma::URL('clearnotif/'.$notification->id);?>" class="main-link"></a>
		</div>
		<?php	
		}	
				break;
			case 'following':
				$follower=User::checkUser($notification->activity_ID);
				if(count($follower)>0){
					$follower=$follower[0];
					$followername=($follower->user_NickName=="")?stripcslashes($follower->user_FullName):stripcslashes($follower->user_NickName);
					$followerimage=($follower->image=="")?'user-default.svg':$follower->image;
				?>
		<div class="notification-block <?php if($notification->read==0){ echo 'unread'; } ?>">
			<div class="overflow">
				<span class="rest-logo pull-left">
					<img src="<?php echo Azooma::CDN('images/100/'.$followerimage);?>" alt="<?php echo $followername;?>"/>
				</span>
				<div class="pull-left notification-text">
					<b class="link">
						<?php echo $followername;?>
					</b>
					<?php echo Lang::get('messages.followed_you').'.';?>
				</div>
				<div class="pull-right time-stamp">
					<?php echo Azooma::Ago($notification->createdAt)?>
				</div>
			</div>
			<a href="<?php echo Azooma::URL('clearnotif/'.$notification->id);?>" class="main-link"></a>
		</div>
				<?php 
				}
				break;
			case 'Photo approved':
				$photo=User::getPossiblePhoto($notification->activity_ID);
				if(count($photo)>0){
					$rest=MRestaurant::getRest($photo->rest_ID);
					$restlogo=($rest->rest_Logo=="")?"default_logo.gif":$rest->rest_Logo;
					$restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar);	
					?>
		<div class="notification-block <?php if($notification->read==0){ echo 'unread'; } ?>">
			<div class="overflow">
				<span class="rest-logo pull-left" >
					<img src="<?php echo Azooma::CDN('logos/70/'.$restlogo);?>" alt="<?php echo $restname;?>">
				</span>
				<div class="pull-left notification-text">
					<?php echo Lang::get('messages.your_photo_for').' ';?>
					<b class="link">
						<?php echo $restname;?>
					</b> <?php echo Lang::get('messages.has_been_approved').'.';?>
				</div>
				<div class="pull-right time-stamp">
					<?php echo Azooma::Ago($notification->createdAt)?>
				</div>
			</div>
			<a href="<?php echo Azooma::URL('clearnotif/'.$notification->id);?>" class="main-link"></a>
		</div>
					<?php
				}
				break;
			case 'Comment Upvoted':
				$support=User::getSupport($notification->activity_ID);
				if(count($support)>0){
				$comment=User::getPossibleComment($support->comment_id);
				if(count($comment)>0){
					$rest=MRestaurant::getRest($comment->rest_ID);
					$restlogo=($rest->rest_Logo=="")?"default_logo.gif":$rest->rest_Logo;
					$restname=($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar);
					$upvoter=User::checkUser($notification->activity_ID)[0];
					$upvotername=($upvoter->user_NickName=="")?stripcslashes($upvoter->user_FullName):stripcslashes($upvoter->user_NickName);
					?>
		<div class="notification-block <?php if($notification->read==0){ echo 'unread'; } ?>">
			<div class="overflow">
				<span class="rest-logo pull-left" >
					<img src="<?php echo Azooma::CDN('logos/70/'.$restlogo);?>" alt="<?php echo $restname;?>">
				</span>
				<div class="pull-left notification-text">
					<b class="link">
						<?php echo $upvotername;?>
					</b>
					<?php echo Lang::get('messages.upvoted_your_comment').' ';?>
					<b class="link">
						<?php echo $restname;?>
					</b>
				</div>
				<div class="pull-right time-stamp">
					<?php echo Azooma::Ago($notification->createdAt)?>
				</div>
			</div>
			<a href="<?php echo Azooma::URL('clearnotif/'.$notification->id);?>" class="main-link"></a>
		</div>
					<?php
				}
			}
				break;
		}
	}
}
?>