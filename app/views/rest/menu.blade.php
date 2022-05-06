<h2>
<?php echo $restname.' '.Lang::get('messages.menu');?>
</h2>
<div class="rest-menu-box">
{{-- List Nav --}}
	<?php
	if(count($menu)>0||count($pdfs)>0){
	?>
	{{-- Start List Nav --}}
	<ul class="menu-tabs">
		<?php
		$i=0;
		if(count($menu)>0){
		foreach ($menu as $mnt) {
		$i++;
		?>
			{{-- Nav Item --}}
			<li>
				<button class="<?php if($i==1){ echo 'active'; } ?>" id="menu-<?php echo $mnt['menu_id'];?>-tab"
				data-bs-target="menu-<?php echo $mnt['menu_id'];?>" type="button"><?php echo ($lang=="en")?stripcslashes($mnt['menu_name']):stripcslashes($mnt['menu_name_ar']); ?></button>
			</li>
		<?php } }
		if(count($pdfs)>0){
		foreach ($pdfs as $pdf) {
		$i++;
		?>
		{{-- Nav Item --}}
			<li>
				<button class="<?php if(count($menu) ==0)	{ echo 'active'; } ?>" id="menu-pdf-<?php echo $pdf->id;?>-tab" data-bs-toggle="tab"
				data-bs-target="menu-pdf-<?php echo $pdf->id;?>" type="button"> <?php 
				if($lang=="en"){
				echo ($pdf->title!="")?stripcslashes($pdf->title):stripcslashes($restname).' '.Lang::get('messages.menu');
				}else{
				echo ($pdf->title_ar!="")?stripcslashes($pdf->title_ar):stripcslashes($restname).' '.Lang::get('messages.menu');
				}
				?></button>
			</li>

			<?php } } ?>
	</ul>
	{{-- End List Nav --}}

<div class="menus-content">
	{{-- Start Menus --}}
	<?php
		$te=0;
		if(count($menu)>0){
			$te++;
			foreach ($menu as $mnt) {
			if(count($mnt['categories'])>0){
	 	?>
			<?php if($te == 1){  ?>
				<div class="menu-tab active" id="menu-<?php echo $mnt['menu_id'];?>">
			<?php } else { ?>
				<div class="menu-tab" id="menu-<?php echo $mnt['menu_id'];?>">
			<?php } ?>
				<?php
					/* Menu Categories */
					foreach ($mnt['categories'] as $category) {
				?>
				{{-- Start Category --}}
				<div class="menu-category">
					<h3 class="category-title"><i class="fas fa-utensils"></i> <?php echo ($lang=="en")?stripcslashes($category['cat_name']):stripcslashes($category['cat_name_ar']); ?></h3>
					<ul class="category-items">
						{{-- Items Loop --}}
						<?php 
						if(count($category['items'])>0){
							$i=0;
							foreach ($category['items'] as $item) {
							$i++;
						?>
						{{-- Item Start --}}
						<li>
							<?php if($item->image!=""){ ?>
							{{-- Item Img --}}
							<div class="item-img">
								<img src="<?php echo Azooma::CDN('images/menuItem/thumb/'.$item->image);?>"
								alt="<?php echo ($lang=="en")?stripcslashes($item->menu_item):stripcslashes($item->menu_item_ar);?>" />
							</div>
							<?php } ?>
							<div class="item-info">
								{{-- Item Head --}}
								<div class="item-head">
									{{-- Item title --}}
									<div class="title">
										<?php echo ($lang=="en")?stripcslashes($item->menu_item):stripcslashes($item->menu_item_ar); ?>
									</div>
									{{-- Item price --}}
									<div class="price">
										<?php 
											if($item->price!=""){
												echo Azooma::GetCurrency($city->country).' '.$item->price;
											}
										?>
									</div>
								</div>
								{{-- Item description --}}
								<div class="item-description">
									<?php echo ($lang=="en")?stripcslashes($item->description):stripcslashes($item->descriptionAr);?>
								</div>
								{{-- Item Footer --}}
								<div class="item-footer">
									{{-- Item Recommends Number --}}
									<div class="recommends">
										<i class="fa fa-heart"></i>
										<?php 
											if($item->recommend==0){
												echo '<span></span> '.Lang::get('messages.be_first_recommend');
											}else{
												echo '<span>'.$item->recommend.'</span> '.Lang::choice('messages.recommendation',$item->recommend); 
											}
										?>
									</div>
									{{-- Item Recommend button --}}
									<div class="recommend-btn">
										<?php 
											$checkuserrecommended=0;
											if(Session::has('userid')){
												$checkuserrecommended=MRestaurant::checkUserRecommended(Session::get('userid'),$item->id);
											}
										?>
										<button
										class="btn btn-link btn-xs menu-recommend-btn <?php if($checkuserrecommended>0) echo 'recommended';?>"
										data-menu="<?php echo $item->id;?>">
										<?php if($checkuserrecommended>0){ ?>
										<i class="fa fa-thumbs-up"></i>
										<?php }else{ ?>
										<i class="fa fa-thumbs-o-up"></i>
										<?php } ?>
										</button>
									</div>
								</div>
							</div>
						</li>
						{{-- Item End --}}
						<?php } } ?>
					</ul>
				</div>
				{{-- End Category --}}
				<?php }?> </div>  <?php }?> 
				
				<?php } } ?>
		
		{{-- Start PDF Menu --}}
		<?php
		if(count($pdfs)>0){ $i=0; ?>
		<?php 
			foreach ($pdfs as $pdf) {
			$i++;
		?>
		 <?php if(count($menu) == 0){  ?>
			<div class="menu-tab active" id="menu-pdf-<?php echo $pdf->id;?>">
			<?php } else { ?>
				<div class="menu-tab" id="menu-pdf-<?php echo $pdf->id;?>">
			<?php } ?>
	
			<div class="menu-pdf">
				{{-- <iframe src="<?php echo Azooma::CDN('images/menuItem/'.$pdf->menu);?>" width="100%" height="500px">
				</iframe>  --}}
				<button class="mt-4 big-main-btn" onclick="downloadMenu(<?php echo $pdf->id;?>);">
					<i class="fa fa-download"></i> <?php echo Lang::get('messages.download_pdf_menu');?>
				</button>
			</div>
	</div>
		<?php } } ?>
	</div>

	{{-- End PDF Menu --}}

<?php
}else{
?>

<?php
$totalrequest=MRestaurant::getTotalMenuRequests($rest->rest_ID);
?>
	<div id="can-you-believe-it">
	<?php echo '" '.Lang::get('messages.can_you_believe').' "';?>
	</div>
	<p class="lead">
	<?php echo $restname.' '.Lang::get('messages.can_you_believe_helper');
	if($totalrequest>0){
	echo '<br/><span class="pink">('.$totalrequest.' '.Lang::choice('messages.so_far',$totalrequest).')</span>';
	}
	?>
	</p>
	<form id="menu-request-form" class="form-horizontal"
		action="<?php echo Azooma::URL($city->seo_url.'/aj/menurequest');?>" method="post">
		<?php if(!Session::has('userid')){ ?>
		<div class="form-group row">

		<div class="col-sm-9">
		<input type="text" name="menuname" id="menuname" class="form-control input-lg"
		placeholder="<?php echo Lang::get('messages.your').' '.Lang::get('messages.name');?>" />
		</div>
		</div>
		<div class="form-group row">

		<div class="col-sm-9">
		<input type="email" name="menuemail" id="menuemail" class="form-control input-lg"
		placeholder="<?php echo Lang::get('messages.your').' '.Lang::get('messages.email');?>" />
		</div>
		</div>
		<?php } ?>
		<div class="form-group row">
	
		<div class="col-sm-9">
		<textarea rows="5" name="menutext" id="menutext" class="form-control input-lg"
		placeholder="<?php echo Lang::get('messages.your').' '.Lang::get('messages.request');?>"></textarea>
		</div>
		</div>
		<?php if(!Session::has('userid')){ ?>
		<div class="d-md-flex">
		<div class="form-check">
			<input class="form-check-input" type="checkbox" value="1" name="subscribe" id="subscribe" checked>
			<label class="form-check-label" for="delivery">
				<?php echo Lang::get('messages.subscribe_to_newsletter');?>
			</label>
		</div>

		<div class="form-check">
			<input class="form-check-input" type="checkbox" value="1" name="register" id="register" checked>
			<label class="form-check-label" for="delivery">
				<?php echo Lang::get('messages.register').' '.Lang::get('messages.with_azooma');?>
			</label>
		</div>
	</div>

		
		<div class="spacing-container"></div>
		<?php } ?>
		<div class="form-group row">
		<label for="menutext" class="col-sm-3 control-label"></label>
		<div class="col-sm-9">
		<input type="hidden" name="rest" value="<?php echo $rest->rest_ID;?>" />
		<button class="big-main-btn"
		type="submit"><?php echo Lang::get('messages.request').' '.Lang::get('messages.menu');?></button>
		</div>
		</div>
	</form>

<?php
}
?>
	</div>