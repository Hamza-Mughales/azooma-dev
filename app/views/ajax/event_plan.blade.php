<div class="Azooma-popup-box" id="event-plan-box">
    <?php if(!isset($noajax)){ ?>
    <h3 class="popup-heading Azooma-head">
       <?php echo Lang::get('messages.plan_event');?>
    </h3>
    <div class="popup-content">
    <?php } ?>
    	<form class="form-horizontal" id="organise-event-form" action="<?php echo Azooma::URL('');?>" method="post"<?php if(isset($noajax)){ echo ' data-nopop="true"'; }?>>
    		<div id="organise-step1">
    			<?php if(Session::has('userid')){
    				$name=Session::get('name');
    				$userid=Session::get('userid');
    				$user=User::checkUser(Session::get('userid'))[0];
    				$number=$user->user_Mobile;
    			}
    			?>
    			<div class="form-group form-group-lg">
					<label class="control-label col-sm-3" for="yourName"><?php echo Lang::get('messages.fullname');?></label>
					<div class="col-sm-7">
						<input class="form-control input-lg" type="text" name="yourName" id="yourName" placeholder="<?php echo Lang::get('messages.fullname');?>"<?php if(Session::has('userid')){ ?> value="<?php echo $name;?>" disabled<?php } ?>/>
					</div>
				</div>
				<?php if(!Session::has('userid')){ ?>
				<div class="form-group row">
					<label class="control-label col-sm-3" for="yourEmail"><?php echo Lang::get('messages.email_address');?></label>
					<div class="col-sm-7">
						<input class="form-control input-lg" type="email" name="yourEmail" id="yourEmail" placeholder="<?php echo Lang::get('messages.email_address');?>"/>
					</div>
				</div>
				<?php } ?>
				<div class="form-group row">
					<label class="control-label col-sm-3" for="yourNumber"><?php echo Lang::get('messages.mobile');?></label>
					<div class="col-sm-7">
						<input class="form-control input-lg" type="text" name="yourNumber" id="yourNumber" placeholder="<?php echo Lang::get('messages.mobile');?>" <?php if(Session::has('userid')&&$number!=''){ ?> value="<?php echo $number; ?>" <?php } ?>/>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-3" for="eventTitle"><?php echo Lang::get('messages.event_title');?></label>
					<div class="col-sm-7">
						<input class="form-control input-lg" type="text" name="eventTitle" id="eventTitle" placeholder="<?php echo Lang::get('messages.event_title_place');?>"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-3"><?php echo Lang::get('messages.event_type');?></label>
					<div class="col-sm-9">
						<label><input type="radio" name="eventType" value="Private Event"/> <?php echo Lang::get('messages.private_event');?> &nbsp;&nbsp;</label>
						<label><input type="radio" name="eventType" value="Corporate Event"/> <?php echo Lang::get('messages.corporate_event');?> &nbsp;&nbsp;</label>
						<label><input type="radio" name="eventType" value="Singles"/> <?php echo Lang::get('messages.singles');?> &nbsp;&nbsp;</label>
						<label><input type="radio" name="eventType" value="Mixed/Family"/> <?php echo Lang::get('messages.mixed_family');?> &nbsp;&nbsp;</label>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-3" for="guests"><?php echo Lang::get('messages.number_of_guests');?></label>
					<div class="col-sm-7">
						<input class="form-control input-lg" type="text" name="guests" id="guests" placeholder="<?php echo Lang::get('messages.number_of_guests');?> <?php echo Lang::get('messages.minimum_25');?>"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-3"><?php echo Lang::get('messages.budget_range_person');?></label>
					<div class="col-sm-7">
						<label><input type="radio" name="budget" value="50-100"/>&nbsp;<?php echo ($lang=="en")?$country->currency:$country->currencyAr;?> 50-100 &nbsp;&nbsp;</label>
						<label><input type="radio" name="budget" value="100-160"/>&nbsp;<?php echo ($lang=="en")?$country->currency:$country->currencyAr;?> 100-160 &nbsp;&nbsp;</label>
						<label><input type="radio" name="budget" value="200+"/>&nbsp;<?php echo ($lang=="en")?$country->currency:$country->currencyAr;?> 200+ &nbsp;&nbsp;</label>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-3" for="eventDate"><?php echo Lang::get('messages.event_date');?></label>
					<div class="col-sm-7">
						<input class="form-control input-lg" type="text" name="eventDate" id="eventDate" placeholder="<?php echo Lang::get('messages.event_date');?> - <?php echo Lang::get('messages.minimum_2_weeks');?>"/>
					</div>
				</div>
				<div class="form-group overflow">
					<label class="control-label col-sm-3"><?php echo Lang::get('messages.event_time');?></label>
					<div class="col-sm-7">
						<select class="form-control input-lg" name="eventTime" id="eventTime">
							<option value=""><?php echo Lang::get('messages.event_time');?></option>
							<option value="Breakfast"><?php echo Lang::get('messages.breakfast');?> (8 am till 11 am )</option>
							<option value="Lunch"><?php echo Lang::get('messages.lunch');?> (12 pm till 3 pm)</option>
							<option value="Tea Time"><?php echo Lang::get('messages.tea_time');?> (4 pm  till 6 pm)</option>
							<option value="Dinner"><?php echo Lang::get('messages.dinner');?> (7 pm till 12 am)</option>
						</select>
					</div>
				</div>
				<div class="form-group overflow">
					<label class="control-label col-sm-3"></label>
					<div class="col-sm-7">
						<button type="button" id="catering-form1-button" class="btn btn-camera btn-lg btn-block"><?php echo Lang::get('messages.next');?></button>
					</div>
				</div>
    		</div>
    		<div id="organise-step2" class="hidden">
    			<div class="form-group row">
					<label class="control-label col-sm-3"><?php echo Lang::get('messages.event_venue');?></label>
					<div class="col-sm-7">
						<label><input type="radio" name="eventVenue" value="On Site"/> <?php echo Lang::get('messages.on_site');?> &nbsp;&nbsp;</label>
						<label><input type="radio" name="eventVenue" value="In Restaurant"/> <?php echo Lang::get('messages.in_restaurant');?> &nbsp;&nbsp;</label>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-3"><?php echo Lang::get('messages.pref_food_cuisines');?></label>
					<div class="col-sm-8">
						<select class="form-control" multiple name="cuisines[]" id="catering-cuisines">
							<?php
							foreach ($masters as $mc) { ?>
							<optgroup label="<?php echo ($lang=="en")?stripcslashes($mc->name):stripcslashes($mc->name_ar);?>">
								<?php if(isset($mc->cuisines)&&count($mc->cuisines)>0){
									foreach ($mc->cuisines as $cuisine) { ?>
									<option value="<?php echo $cuisine->cuisine_ID;?>">
										<?php echo ($lang=="en")?stripcslashes($cuisine->cuisine_Name):stripcslashes($cuisine->cuisine_Name_ar);?>
									</option>
									<?php
									}
									?>
									<?php
								}
								?>
							</optgroup>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group overflow">
					<label class="control-label col-sm-3"><?php echo Lang::get('messages.select_meal_course');?></label>
					<div class="col-sm-8">
						<label><input type="checkbox" name="meal[]" value="Canapes"/> <?php echo Lang::get('messages.canapes');?> &nbsp;&nbsp;</label>
						<label><input type="checkbox" name="meal[]" value="Appetizers"/> <?php echo Lang::get('messages.appetizers');?> &nbsp;&nbsp;</label>
						<label><input type="checkbox" name="meal[]" value="Main Course"/> <?php echo Lang::get('messages.main_course');?> &nbsp;&nbsp;</label>
						<label><input type="checkbox" name="meal[]" value="Desserts"/> <?php echo Lang::get('messages.desserts');?> &nbsp;&nbsp;</label><br/>
						<label><input type="checkbox" name="meal[]" value="Cake Servie"/> <?php echo Lang::get('messages.cake_service');?> &nbsp;&nbsp;</label>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-3"><?php echo Lang::get('messages.select_beverage_service');?></label>
					<div class="col-sm-8">
						<label><input type="checkbox" name="beverage[]" value="Coffee/Tea"/> <?php echo Lang::get('messages.coffee').'/'.Lang::get('messages.tea');?> &nbsp;&nbsp;</label>
						<label><input type="checkbox" name="beverage[]" value="Canned Soft Drinks"/> <?php echo Lang::get('messages.canned_soft_drinks');?> &nbsp;&nbsp;</label>
						<label><input type="checkbox" name="beverage[]" value="Juices"/> <?php echo Lang::get('messages.juices');?> &nbsp;&nbsp;</label>
						<label><input type="checkbox" name="beverage[]" value="Water"/> <?php echo Lang::get('messages.water');?> &nbsp;&nbsp;</label>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-3"><?php echo Lang::get('messages.preferred_serving_style');?></label>
					<div class="col-sm-7">
						<label><input type="radio" name="servingStyle" value="Buffet - Self Service"/> <?php echo Lang::get('messages.buffet_self_service');?> &nbsp;&nbsp;</label>
						<label><input type="radio" name="servingStyle" value="Seated Table Service"/> <?php echo Lang::get('messages.seated_table_service');?> &nbsp;&nbsp;</label>
					</div>
				</div>
				<div class="form-group onsite hidden">
					<label class="control-label col-sm-3"><?php echo Lang::get('messages.dining_setup');?></label>
					<div class="col-sm-9">
						<label><input type="checkbox" name="diningSetup[]" value="Basic"/> <?php echo Lang::get('messages.basic');?> &nbsp;&nbsp;</label>
						<label><input type="checkbox" name="diningSetup[]" value="Casual"/> <?php echo Lang::get('messages.casual');?> &nbsp;&nbsp;</label>
						<label><input type="checkbox" name="diningSetup[]" value="Fine Dining"/> <?php echo Lang::get('messages.fine_dining');?> &nbsp;&nbsp;</label>
						<label><input type="checkbox" name="diningSetup[]" value="Outdoors"/> <?php echo Lang::get('messages.outdoors');?> &nbsp;&nbsp;</label><br/>
						<label><input type="checkbox" name="diningSetup[]" value="Live Cooking Station"/> <?php echo Lang::get('messages.live_cooking_station');?> &nbsp;&nbsp;</label>
						<label><input type="checkbox" name="diningSetup[]" value="Tables &amp; Chairs"/> <?php echo Lang::get('messages.tables_chairs');?> &nbsp;&nbsp;</label>
						<label><input type="checkbox" name="diningSetup[]" value="Drinks Station"/> <?php echo Lang::get('messages.drinks_station');?> &nbsp;&nbsp;</label><br/>
						<label><input type="checkbox" name="diningSetup[]" value="Cutlery"/> <?php echo Lang::get('messages.cutlery');?> &nbsp;&nbsp;</label>
						<label><input type="checkbox" name="diningSetup[]" value="Tableware"/> <?php echo Lang::get('messages.table_ware');?> &nbsp;&nbsp;</label>
					</div>
				</div>
				<div class="form-group onsite hidden">
					<label class="control-label col-sm-3"><?php echo Lang::get('messages.servicing_staff_requirements');?></label>
					<div class="col-sm-7">
						<label><input type="checkbox" name="staffReq[]" value="Waiters"/> <?php echo Lang::get('messages.waiters');?> &nbsp;&nbsp;</label>
						<label><input type="checkbox" name="staffReq[]" value="Bartender"/> <?php echo Lang::get('messages.bartender');?> &nbsp;&nbsp;</label>
						<label><input type="checkbox" name="staffReq[]" value="Usher"/> <?php echo Lang::get('messages.usher');?> &nbsp;&nbsp;</label>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-3"><?php echo Lang::get('messages.event_location');?></label>
					<div class="col-sm-7 relative">
						<textarea class="form-control" id="eventLocation" name="location" rows="3" placeholder="<?php echo Lang::get('messages.location_of_event');?>"></textarea>
						<button class="btn btn-light btn-sm" type="button" id="use-my-location"><i class="fa fa-map-marker"></i> <?php echo Lang::get('messages.use_my_location');?></button>
					</div>
				</div>
				<div class="form-group overflow">
					<label class="control-label col-sm-3"><?php echo Lang::get('messages.additional_reqs');?></label>
					<div class="col-sm-7">
						<textarea class="form-control" name="notes" rows="3" placeholder="<?php echo Lang::get('messages.additional_reqs_place');?>"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-3">&nbsp;</label>
					<div class="col-sm-7">
						<label>
							<input type="checkbox" id="cateringagree" name="agree"/>
							<?php echo Lang::get('messages.read_and_agreed');?> <a href="<?php echo Azooma::URL('planevent/terms');?>" target="_blank"><?php echo Lang::get('messages.terms_conditions');?></a>
							</label>
						</div>
				</div>
				<div class="form-group overflow">
					<div class="col-sm-12">
						<div class="col-sm-6">
							<button id="catering-form2-button" type="button" class="btn btn-camera btn-lg btn-block"><?php echo Lang::get('messages.back');?></button>
						</div>
						<div class="col-sm-6">
							<button id="catering-submit-button" type="submit" class="btn btn-camera btn-lg btn-block"><?php echo Lang::get('messages.submit');?></button>
						</div>
					</div>
				</div>
    		</div>
    	</form>
    <?php if(!isset($noajax)){ ?>
    </div>
    <?php } ?>
</div>