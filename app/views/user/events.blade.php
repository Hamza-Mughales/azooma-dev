
<?php
if(Session::has('userid')&&Session::get('userid')==$user->user_ID){
	$events=User::getUserEvents($user->user_ID);
?>
	<div class="sufrati-white-box inner-padding put-border">
		<?php
		if(count($events)>0){
			?>
			<div class="alert alert-warning alert-dismissible" role="alert">
			 	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			 	<i class="fa fa-info-sign"></i> <?php echo Lang::get('messages.read_about_cancellation');?>
			 	<a href="<?php echo Azooma::URL('catering-terms');?>"><?php echo ' '.Lang::get('messages.here');?></a>
			</div>
			<?php
			$i=0;
			foreach ($events as $event) {
				$i++;
				?>
				<div class="event-list overflow<?php if($event->status==2){ echo ' cancelled';} if(count($events)==$i){ echo ' no-border'; }?>">
					<div class="pull-left event-title" data-event="<?php echo $event->id;?>">
						<a href="javascript:void(0);" class="event-name" >
							<?php echo $event->name;?>
						</a>
						&nbsp;&nbsp;-&nbsp;&nbsp;<?php echo date('F jS, Y',  strtotime($event->createdAt));?>
					</div>
					<?php 
					$time=time();
					if($event->status!=2&&(strtotime($event->date)>$time)){
						?>
					<div class="pull-left">
						<a class="btn btn-sm btn-light cancel-event" data-event="<?php echo $event->id;?>">
							<?php echo Lang::get('messages.cancel_event');?>
						</a>
					</div>
						<?php
					}else{
						if($event->status==1||$event->status==0){
							?>
							<div class="pull-left">
							<?php echo Lang::get('messages.event_finished');?>
							</div>
							<?php
						}
					}
					?>
				</div>
				<?php
			}
		}
		?>
	</div>
<?php } ?>