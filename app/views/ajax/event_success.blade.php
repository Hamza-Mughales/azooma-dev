<div class="Azooma-popup-box" id="event-plan-box">
    <h3 class="popup-heading Azooma-head">
       <?php echo Lang::get('messages.thank_you');?>
    </h3>
    <div class="popup-content">
    	<h3>
			<?php echo Lang::get('messages.place_order_with_azooma');?>
		</h3>
		<p>
			<?php echo Lang::get('messages.place_order_desc');?> <a href="<?php echo Azooma::URL('user/'.$user->user_ID.'/events');?>" title="<?php echo Lang::get('messages.click_to_view_events');?>"><?php echo Lang::get('messages.click_to_view_events');?></a>
		</p>
    </div>
</div>