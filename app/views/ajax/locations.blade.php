<div class="Azooma-popup-box locations-box">
	
	<div class="popup-content photo-popup relative">
		<div class="spacing-container"></div>
		<?php 
		if(count($countries)>0){
			foreach ($countries as $country) {
				?>
				<div class="overflow country-list">
					<h2>
						<?php echo ($lang=="en")?stripcslashes($country->name):stripcslashes($country->nameAr);?>
					</h2>
					<?php 
					if(count($country->cities)>0){ ?>
					<ul>
					<?php
						foreach ($country->cities as $city) {
						?>
						<li>
							<a href="<?php echo Azooma::URL($city->seo_url);?>" title="<?php echo ($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_Ar); echo ' '.Lang::choice('messages.restaurants',2);?>" <?php if( (Session::has('sfcity'))&&($city->city_ID==(Session::get('sfcity')))) { echo 'class="active"'; } ?>>
								<?php echo ($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_Ar);?>
							</a>
						</li>
						<?php	
						}
						?>
					</ul>
						<?php
					}
					?>
				</div>
				<?php
			}
		}
		?>
		<div class="spacing-container"></div>
	</div>
</div>