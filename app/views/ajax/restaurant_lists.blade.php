<div class="Azooma-popup-box" id="related-lists-box">
    <h3 class="popup-heading Azooma-head">
       <?php echo Lang::get('messages.related_user_lists');?>
    </h3>
    <div class="popup-content">
        <?php if(count($relatedlists)>0){
        	foreach ($relatedlists as $list) {
        		$userimage=($list->image=="")?'user-default.svg':$list->image;
                $username=($list->user_NickName=="")?stripcslashes($list->user_FullName):stripcslashes($list->user_NickName);
        		?>
        		<div class="related-list-box overflow">
        			<div class="pull-left list-col-left">
		                <a class="rest-logo" href="<?php echo Azooma::URL('user/'.$list->user_ID);?>" title="<?php echo $username;?>">
		                    <img src="<?php echo Azooma::CDN('images/100/'.$userimage);?>" alt="<?php echo $username;?>" width="50" height="50">
		                </a>
		            </div>
		            <div class="pull-left list-col-right">
		                <div>
		                    <a class="bold" href="<?php echo Azooma::URL('user/'.$list->user_ID);?>" title="<?php echo $username;?>">
		                        <?php echo $username;?>
		                    </a>
		                </div>
		                <div>
		                    <?php echo stripcslashes($list->name);?>
		                </div>
		            </div>
        		</div>
        		<?php
        	}
        }
        ?>
    </div>
</div>
