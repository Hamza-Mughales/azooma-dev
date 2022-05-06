	<?php 
	if($totallists>0){
		$lists=User::getUserLists($user->user_ID);
		 if(count($lists)>0){
			?>
			<?php
			foreach ($lists as $list) {
				$restaurants=User::getListRestaurants($list->id);
				?>
			   <div class="user-recommends" style="width: 100%">
				<div class="list-top d-flex justify-content-between align-items-center">
					<h4>  <?php echo  $list->name;?> - <?php echo $list->count;?> </h4>

					<button style="width: 150px;margin: 0;" data-list="<?php echo $list->id;?>" class="btn btn-danger pull-right delete-list big-main-btn"><?php echo Lang::get('messages.remove_list');?></button>

				</div>

			<div id="userLikes">
                <div class="row" style="width: 100%;margin:0">
						<?php 
							if(count($restaurants)>0){
							$listrestaurants=array(
								'lang'=>$lang,
								'user'=>$user,
								'userimage'=>$userimage,
								'username'=>$username,
								'restlikes'=>$restaurants,
								'list'=>$list->id
							);
							?>
							@include('user.helpers.like_rest',$listrestaurants)
							<?php
						}
						?>
                  </div>
                </div>
			</div>
                <?php
              }
          	?>
   

		
		<?php
	}
}
	?>
