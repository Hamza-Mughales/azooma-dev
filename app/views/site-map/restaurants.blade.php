 <!doctype html>
<html lang="<?php echo $lang;?>">
<head>
    @include('inc.metaheader',$meta)
    <?php
    if(isset($metastring)){
        echo $metastring;
    }
    ?>
</head>
<body itemscope itemtype="http://schema.org/WebPage" class="<?php if($lang == 'ar'){ echo 'rtl'; } ?>">
    @include('inc.header')
    <div>
        <div class="spacing-container">
        </div>
        <div class="container Azooma-white-box put-border inner-padding">
            <div>
                <?php
                if(count($city)>0){
                	?>
            	<div id="sitemap-main-block">
                    <a href="<?php echo Azooma::URL($city->seo_url);?>" title="<?php echo Lang::get('messages.azooma').' ';echo ($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar);?>">
                        <h1 class="inline-block">
                            <?php echo ($lang=="en")?stripcslashes($city->city_Name):stripcslashes($city->city_Name_ar); echo ' '.Lang::choice('messages.restaurants',2).' '.Lang::get('messages.starting_with').' '.$alphabet;?>
                        </h1>
                    </a>
                </div>
                <div class="row sitemap-content">
                	<?php
                	if(count($restaurants)>0){
                		foreach ($restaurants as $rest) {
                			?>
                			<div class="col-md-3">
                				<h3>
                                    <a class="normal-text" href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->seo_url);?>" title="<?php echo ($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar); ?>">
                                        <?php echo ($lang=="en")?stripcslashes($rest->rest_Name):stripcslashes($rest->rest_Name_Ar); ?>
                                    </a>            
                                </h3>
                			</div>
                			<?php
                		}
                	}
                    ?>
                </div>
                <?php }
                if($total>50){
                    echo $paginator->links();
                }
                ?>
                <div class="spacing-container"></div>
            </div>
        </div>
        <div class="spacing-container">
        </div>
    </div>
    @include('inc.footer')
</body>
</html>