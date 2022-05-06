<div class="register-step-2" id="step2-container">
	<div class="row steps-header">
		<div class="col-md-6 col-sm-12">
			<h2>Favorate Food</h2>
		</div>
		<div class="col-md-6 col-sm-12">
			<button form="myform2" type="submit" class="big-main-btn user-step2-btn step-btn mb-4"><?php echo Lang::get('messages.next');?></button>
		</div>
	</div>
<?php if(count($cuisines)>0){ ?>
		<ul class="cuisine-like-list">
		<?php
			foreach ($cuisines as $cuisine) {
				$cuisineimage=($cuisine->image=="")?"default.gif":$cuisine->image;
				$checkuserliked=User::checkUserLikeCuisine($cuisine->cuisine_ID,Session::get('userid'));	
		?>
			<li>
				<a <?php if(count($checkuserliked)>0){ ?>data-selected="1"<?php } ?> data-cuisine="<?php echo $cuisine->cuisine_ID;?>" href="javascript:void(0);" title="<?php echo ($lang=="en")?stripcslashes($cuisine->cuisine_Name):stripcslashes($cuisine->cuisine_Name_ar);?>">
					{{-- <img src="http://uploads.azooma.co/logos/Sufrati60383b3d15696Mask Group 8.png" /> --}}
						<img class="sufrati-super-lazy" src="<?php echo Config::get('settings.uploadurl') .'images/cuisine/'.$cuisineimage;?>" alt="<?php echo ($lang=="en")?stripcslashes($cuisine->cuisine_Name):stripcslashes($cuisine->cuisine_Name_ar);?>">
			      <span class="title"><?php echo ($lang=="en")?stripcslashes($cuisine->cuisine_Name):stripcslashes($cuisine->cuisine_Name_ar);?></span>
			      <span class="selected"><i class="far fa-heart"></i></span>
			    </a>
			</li>
		<?php
		}
		?>
		</ul>
		<?php } ?>>
	<form id="myform2" action="<?php echo Azooma::URL('preference/2');?>" method="post">
		<input type="hidden" name="cuisines[]" id="user-liked-cuisines"/>
	</form>
</div>