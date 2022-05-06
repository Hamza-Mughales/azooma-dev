<h2> <?php echo $restname;?></h2>

<?php 
if($rest->rest_Description!=""){ ?>
<div class="about-description mb-4">
    <?php 
   $description=($lang=="en")?stripcslashes($rest->rest_Description):stripcslashes($rest->rest_Description_Ar);
   echo stripcslashes($description);
   ?>
</div>
<?php } ?>

<ul class="head-types">
    <li><span><i class="fas fa-utensils"></i> <?php echo Lang::get('messages.cuisine');?></span> - <?php $t=0; foreach ($cuisines as $cuisine) { $t++;
        ?>
        <a href="<?php echo Azooma::URL($city->seo_url.'/'.$cuisine->seo_url.'/restaurants');?>">
            <?php echo ($lang=="en")?stripcslashes($cuisine->cuisine_Name):stripcslashes($cuisine->cuisine_Name_ar); ?>
        </a>
        <?php  
        if($t!=count($cuisines)){
            echo ", ";
        }
    }
    ?></li>
    <li><span> <i class="fas fa-tag"></i> <?php echo Lang::get('messages.price_range');?></span> -
        <?php echo Azooma::LangSupport($rest->price_range);?>
        <?php echo Azooma::GetCurrency($city->country);?></li>
    <li><span> <i class="fas fa-tag"></i><?php echo Lang::get('messages.category');?></span> -
        <?php echo Azooma::LangSupport($rest->class_category);?></li>
</ul>

<div class="about-images">
    <?php
    if(count($minigallery)>0){
        $i=0;
        foreach ($minigallery as $photo) {
            if($lang=="en"){
                $photoname=(strlen($photo->title)>2)?stripcslashes($photo->title):stripcslashes($rest->rest_Name);
            }else{
                $photoname=(strlen($photo->title_ar)>2)?stripcslashes($photo->title_ar):stripcslashes($rest->rest_Name_Ar);
            }
        ?>
    <?php if ($i != 3) { ?>
    <a href="<?php echo Azooma::URL($city->seo_url.'/photo/'.$photo->image_ID);?>" class="load-gallery-tab ajax-link">
        <img itemprop="photo" src="<?php echo Azooma::CDN('Gallery/150x150/'.$photo->image_full);?>">
    </a>
    <?php } else {  ?>
    <a href="#gallary">
        <img itemprop="photo" src="<?php echo Azooma::CDN('Gallery/150x150/'.$photo->image_full);?>">
        <div class="more-photos">
            <div class="text-center">
                <div class="strong">
                    + <?php echo count($minigallery); ?>
                </div>
                <span>Show all photos</span>
            </div>
        </div>
    </a>
    <?php } ?>
    <?php  $i++; ?>



    <?php
        }
    }
    ?>
</div>
<hr>
<?php 
if(count($populardishes)>0){
?>
<div class="features mb-4">
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#dishes" aria-expanded="true" aria-controls="dishes">
                    <h2 style="padding:0 1rem">   <?php echo Lang::get('messages.popular_dishes');?> </h2>
                </button>
            </h2>
            <div id="dishes" class="accordion-collapse collapse" aria-labelledby="headingOne"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <ul class="rest-feature-list">
                    <?php foreach ($populardishes as $dish) {
                        ?>
                        <li class="dishes">
                            <?php echo ($lang=="en")?stripcslashes($dish->menu_item).' - '.stripcslashes($dish->cat_name):stripcslashes($dish->menu_item_ar).' - '.stripcslashes($dish->cat_name_ar); ?>
                        </li>
                        <?php
                    }
                    ?>
                       
                    
                    </ul>
                    <a class="big-trans-btn" href="#menu" data-bs-toggle="tab">
                        <?php echo Lang::get('messages.view_all');?>
                    </a>
             
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>

{{-- Features --}}

<div class="features">
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <h2 style="padding:0 1rem"> <?php echo Lang::get('messages.features_of_restaurant',array('name'=>$restname));?></h2>
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <?php 
                if(count($features)>0){
                    $mainfeatures=$features['mainfeatures'];
                    $restfeatures=$features['restaurantfeatures'];
                    ?>
                    <ul class="rest-feature-list">
                        <?php
                    foreach ($mainfeatures as $mf) { 
                        $present=FALSE;
                        if(in_array($mf['name'], $restfeatures)){
                            $present=TRUE;
                        }
                        if(!$present) continue;
                        if($lang=="en"){
                            $title=($present)?$mf['presenten']:$mf['notpresenten'];
                        }else{
                            $title=($present)?$mf['presentar']:$mf['notpresentar'];
                        }
                    ?>
                        <li>
                            <span <?php if(!$present){ echo 'class="faded"'; } ?> data-bs-toggle="tooltip"
                                data-title="<?php echo $title;?>">
                                <?php if($present){ ?>
                                <img src="<?php echo asset('img/icons/true.svg') ?>">
                                <?php }else{
                                ?>
                                <img src="<?php echo asset('img/icons/false.svg') ?>">
                                <?php
                                }
                                ?>
                                <?php echo stripcslashes(Azooma::LangSupport($mf['name']));?>
                            </span>
                        </li>
                        <?php } ?>
                        <hr style="margin:10px auto;background: #b9b9b9;">
                        <?php
                    foreach ($mainfeatures as $mf) { 
                        $present=FALSE;
                        if(in_array($mf['name'], $restfeatures)){
                            $present=TRUE;
                        }
                        if($present) continue;
                        if($lang=="en"){
                            $title=($present)?$mf['presenten']:$mf['notpresenten'];
                        }else{
                            $title=($present)?$mf['presentar']:$mf['notpresentar'];
                        }
                    ?>
                        <li>
                            <span <?php if(!$present){ echo 'class="faded"'; } ?> data-bs-toggle="tooltip"
                                data-title="<?php echo $title;?>">
                                <?php if($present){ ?>
                                <img src="<?php echo asset('img/icons/true.svg') ?>">
                                <?php }else{
                                ?>
                                <img src="<?php echo asset('img/icons/false.svg') ?>">
                                <?php
                                }
                                ?>
                                <?php echo stripcslashes(Azooma::LangSupport($mf['name']));?>
                            </span>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php
                }
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
{{-- Features --}}
<div class="locations"  id="locations">
    <div class="accordion" id="accordionExample2">
        <div class="accordion-item">
            <h2 class="accordion-header" style="box-shadow: 0px 0px 8px 2px #e3e3e39e;
            border-radius: 5px;
            padding: 1rem;
            background: #fff;" id="headingOne2">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapselocations" aria-expanded="true" aria-controls="collapseOne">
                    <h2> <i class="fa fa-map-marker"></i>
                        <?php echo $restname.' '.$cityname.' <span class="main-color">'.Lang::get('messages.locations');?> </span></h2>
                </button>
            </h2>
            <div id="collapselocations" class="accordion-collapse collapse" aria-labelledby="headingOne2" style="    background: rgb(250, 250, 250);
            border-radius: 5px;
            margin: 1rem 0px;
            padding: 1rem;"
                data-bs-parent="#accordionExample2">
                <div class="accordion-body">
                <?php 
                    if(count($restbranches)>0){
                        $i=0;
                        foreach ($restbranches as $branch) {
                            $i++;
                            ?>
                        <div itemprop="department" itemscope itemtype="http://schema.org/Restaurant"
                        class="locations-list <?php if($i==count($restbranches)){ echo ' last-child'; } ?>">
                        <div class="address-block">
                            <div>
                                <address itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                    <strong>
                                        <a class="ajax-link"
                                            href="<?php echo Azooma::URL($city->seo_url.'/'.$rest->seo_url.'/'.$branch->url);?>"
                                            title="<?php echo $restname.' ';?><?php echo ($lang=="en")?stripcslashes($branch->br_loc).', '.stripcslashes($branch->district_Name):stripcslashes($branch->br_loc_ar).', '.stripcslashes($branch->district_Name_ar);?>">
                                            <?php if($lang=="en"&&$branch->br_loc!=""){
                                                    ?>
                                            <span itemprop="streetAddress"><?php echo $branch->br_loc;?></span>,&nbsp;
                                            <?php
                                                }
                                                if($lang!="en"&&$branch->br_loc_ar!=""){
                                                    ?>
                                            <span
                                                itemprop="streetAddress"><?php echo $branch->br_loc_ar;?></span>,&nbsp;
                                            <?php
                                                }
                                                if($lang=="en"&&$branch->district_Name!=""){
                                                    ?>
                                            <span
                                                itemprop="addressLocality"><?php echo $branch->district_Name;?></span>,&nbsp;
                                            <?php
                                                }
                                                if($lang!="en"&&$branch->district_Name_ar!=""){
                                                    ?>
                                            <span
                                                itemprop="addressLocality"><?php echo $branch->district_Name_ar;?></span>,&nbsp;
                                            <?php
                                                }
                                                ?>
                                            &nbsp;-&nbsp;<span itemprop="addressRegion"><?php echo $cityname;?></span>
                                        </a>
                                    </strong>
                                </address>
                            </div>
                            <?php if($branch->branch_type!=""){ ?>
                            <div class="small">
                                <?php echo '<strong>'.Lang::get('messages.branch_type').': </strong> '.stripcslashes(Azooma::LangSupport($branch->branch_type));?>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="contact-block">
                            <?php 
                                $tel='';
                                if(strlen($branch->br_number)>7){
                                    $tel=$branch->br_number;
                                }else{
                                    if($branch->br_mobile!=''){
                                        $tel=$branch->br_mobile;
                                    }else{
                                        if($branch->br_toll_free!=''){
                                            $tel=$branch->br_toll_free;
                                        }else{
                                            if($rest->rest_TollFree!=''){
                                                $tel=$rest->rest_TollFree;
                                            }
                                        }
                                    }
                                }
                                ?>
                            <strong class="arabic-right" itemprop="telephone">
                                <?php echo $tel;?>
                            </strong>
                        </div>
                    </div>
                        <?php
                        }
                    }
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="write-review mt-5" id="write-reviews">
    <h2> <?php echo Lang::get('messages.write_review_for').' '.$restname;?></h2>
    <form method="post" action="<?php echo Azooma::URL($city->seo_url.'/aj/comment');?>" role="form"
        class="form-horizontal" id="rest-review-form">
        <div class="form-group row">
            <div class="col-sm-12">
                <textarea class="form-control" name="user-comment" id="user-comment"
                    placeholder="<?php echo Lang::get('messages.share_your_experience').' '.$restname;?>"
                    rows="8"></textarea>
            </div>
            <div class="col-sm-12" id="comment-error-box">
                <div class="spacing-container"></div>
                <div class=" alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo Lang::get('messages.please_add_review');?>
                </div>
            </div>
        </div>
        <h3 class="p-2">
            <?php echo Lang::get('messages.add_your_rating');?>
        </h3>
   
        <div class="review-food">
            <div class="ranges">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo Lang::get('messages.food');?></label>
                    <div class="col-sm-10">
                        <input type="range" value="0" min="0" max="5" name="food" id="foodM" data-rangeslider data-direction='<?php if($lang == "ar") { echo "rtl";} else { echo "ltr";} ?>'>
                        <span class="value">0<span style="color: #000">( <?php echo Lang::get('messages.worst');?> )</span></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3"
                        class="col-sm-2 control-label"><?php echo Lang::get('messages.service');?></label>
                    <div class="col-sm-10">
                        <input type="range" value="0" min="0" max="5" name="service" id="serviceM" data-rangeslider data-direction='<?php if($lang == "ar") { echo "rtl";} else { echo "ltr";} ?>'>
                        <span class="value">0<span style="color: #000">( <?php echo Lang::get('messages.worst');?> )</span></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3"
                        class="col-sm-2 control-label"><?php echo Lang::get('messages.atmosphere');?></label>
                    <div class="col-sm-10">
                        <input type="range" value="0" min="0" max="5" name="atmosphere" id="atmosphereM" data-rangeslider data-direction='<?php if($lang == "ar") { echo "rtl";} else { echo "ltr";} ?>'>
                        <span class="value">0<span style="color: #000">( <?php echo Lang::get('messages.worst');?> )</span></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3"
                        class="col-sm-2 control-label"><?php echo Lang::get('messages.value');?></label>
                    <div class="col-sm-10">
                        <input type="range" value="0" min="0" max="5" name="value" id="valueM" data-rangeslider data-direction='<?php if($lang == "ar") { echo "rtl";} else { echo "ltr";} ?>'>
                        <span class="value">0<span style="color: #000">( <?php echo Lang::get('messages.worst');?> )</span></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3"
                        class="col-sm-2 control-label"><?php echo Lang::get('messages.variety');?></label>
                    <div class="col-sm-10">
                        <input type="range" value="0" min="0" max="5" name="variety" id="varietyM" data-rangeslider data-direction='<?php if($lang == "ar") { echo "rtl";} else { echo "ltr";} ?>'>
                        <span class="value">0<span style="color: #000">( <?php echo Lang::get('messages.worst');?> )</span></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3"
                        class="col-sm-2 control-label"><?php echo Lang::get('messages.presentation');?></label>
                    <div class="col-sm-10">
                        <input type="range" value="0" min="0" max="5" name="presentation" id="presentationM"
                            data-rangeslider data-direction='<?php if($lang == "ar") { echo "rtl";} else { echo "ltr";} ?>'>
                        <span class="value">0 <span style="color: #000">( <?php echo Lang::get('messages.worst');?> )</span></span>
                    </div>
                </div>
            </div>
            <div class="form-group m-0">
                <div class="form-check recom">
                    <label class="form-check-label" for="delivery">
                        <?php echo Lang::get('messages.do_you_recommend',array('restname'=>$restname));?>
                    </label>
                    <div class="right-btns">
                    <button type="button" class="active" id="recommendTrue"><i class='fa fa-thumbs-o-up'></i> <?php echo Lang::get('messages.yes');?></button>
                    <button type="button" id="recommendFalse"><i class='fa fa-thumbs-o-down'></i> <?php echo Lang::get('messages.no');?></button>
                    </div>
                    <input style="display: none" type="checkbox" checked="true" class="form-check-input checkbox_check" name="recommend" id="recommend"  />
                </div>
            </div>
      
            <hr>
            <div class="form-group row">
                <label for="mealtype"
                    class="col-sm-9 control-label"><?php echo Lang::get('messages.what_kind_meal');?></label>
            </div>
            <div class="row meal-type">
                <div class="col-sm-3">
                    <div class="form-check button-check active">
                        <input class="form-check-input" type="checkbox" value="delivery" name="mealtype" id="delivery"
                            checked="checked">
                        <label class="form-check-label" for="delivery">
                            <?php echo Lang::get('messages.delivery');?>
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-check button-check">
                        <input class="form-check-input" type="checkbox" value="takeaway" name="mealtype" id="takeaway">
                        <label class="form-check-label" for="takeaway">
                            <?php echo Lang::get('messages.takeaway');?>
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-check button-check">
                        <input class="form-check-input" type="checkbox" value="dine_in" name="mealtype" id="dine_in">
                        <label class="form-check-label" for="dine_in">
                            <?php echo Lang::get('messages.dine_in');?>
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-check button-check">
                        <input class="form-check-input" type="checkbox" value="event" name="mealtype" id="event">
                        <label class="form-check-label" for="event">
                            <?php echo Lang::get('messages.event');?>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row mt-4">             
                <div class="col-md-12 col-sm-12">
                    <input type="hidden" name="rest" id="rest" value="<?php echo $rest->rest_ID;?>" />
                    <button id="submit-review-btn" type="submit"
                        class="big-main-btn"><?php echo Lang::get('messages.add_comment');?></button>
                </div>
            </div>




        </div>
    </form>
</div>