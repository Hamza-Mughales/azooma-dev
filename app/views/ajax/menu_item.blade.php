<div class="sufrati-popup-box" id="menu-item-pop-box">
    <h3 class="popup-heading sufrati-head">
       <?php echo ($lang=="en")?stripcslashes($item->menu_item):stripcslashes($item->menu_item_ar);?>
    </h3>
    <div class="popup-content">
    <?php 
    if($item->image!=""){
        ?>
        <div>
            <img width="500" src="<?php echo Azooma::CDN('images/menuItem/'.$item->image);?>" alt="<?php echo ($lang=="en")?stripcslashes($item->menu_item):stripcslashes($item->menu_item_ar);?>"/>
        </div>
        <div class="spacing-container"></div>
        <?php
    }
    ?>
    <div class="overflow">
        <div class="pull-left">
            <?php echo ($lang=="en")?stripcslashes($item->description):stripcslashes($item->descriptionAr);?>
        </div>
        <div class="pull-right">
            <?php 
            if($item->price!=""){
                echo Azooma::GetCurrency($city->country).' '.$item->price;
            }
            ?>
        </div>
    </div>
    <div class="overflow menu-recommend">
        <div class="pull-left small" id="menu-recommend-total-<?php echo $item->id;?>">
            <?php if($recommendations==0){
                echo '<span></span> '.Lang::get('messages.be_first_recommend');
            }else{
                echo '<span>'.$recommendations.'</span> '.Lang::choice('messages.recommendation',$recommendations); 
            } ?>
        </div>
        <?php 
        $checkuserrecommended=0;
        if(Session::has('userid')){
            $checkuserrecommended=MRestaurant::checkUserRecommended(Session::get('userid'),$item->id);
        }
        ?>
        <div class="pull-right">
            <button class="btn btn-link btn-xs menu-recommend-btn <?php if($checkuserrecommended>0) echo 'recommended';?>" data-menu="<?php echo $item->id;?>">
                <?php if($checkuserrecommended>0){ ?>
                <i class="fa fa-thumbs-up"></i>
               <?php }else{ ?>
                <i class="fa fa-thumbs-o-up"></i>
                <?php } ?>
            </button>
        </div>
    </div>
    </div>
 </div>