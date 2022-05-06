<script async
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXFAxSgXP7b5D25WEtjxkYqoWM2PjxaLg&callback=initialize&libraries=places">
</script>
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">  <?php $branchname= $restname.' - ';
            $branchname.=($lang=="en")?stripcslashes($branch->br_loc).' '.stripcslashes($branch->district_Name).' '.stripcslashes($branch->city_Name):stripcslashes($branch->br_loc_ar).' '.stripcslashes($branch->district_Name_ar).' '.stripcslashes($branch->city_Name_ar); ?>
            <?php echo $branchname;?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><ion-icon name="close-outline"></ion-icon></button>
    </div>
    <div class="modal-body">

    	<div id="branch-map">
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
            if($branch->latitude!=""&&$branch->longitude!=""){ ?>
    		<div id="branch-map-container" style="   width: 100%;height: 250px; border-radius: 10px;">

            </div>
            <?php 
            if($tel!=""){
                ?>
                <div class="branch-phone">
                   <?php if($lang == "ar"){ ?>
							 <i class="fas fa-phone"></i> 
							 <?php } else { ?>
							 <i class="fa fa-phone"></i> 
							<?php } ?> <?php echo $tel;?>
                </div>
                <?php
            }
            } ?>
    	</div>
        <?php if(($branch->latitude==""&&$branch->longitude=="")&&$tel!=""){ ?>
        <div>
            <button class="btn btn-light btn-lg" type="button">
               <?php if($lang == "ar"){ ?>
							 <i class="fas fa-phone"></i> 
							 <?php } else { ?>
							 <i class="fa fa-phone"></i>
							<?php } ?> <?php echo $tel;?>
            </button>
        </div>
        <?php } ?>
        <div class="spacing-container"></div>
    	<div class="row " style="    border: 1px solid #eee;
        border-radius: 10px;
        padding: 1rem 0;
        margin: 1rem 0;">
    		<div class="col-md-6">
    			<dl class="dl-horizontal">
    				<dt>
    					<?php echo Lang::get('messages.location');?>
    				</dt>
    				<dd>
    					<?php echo ($lang=="en")?stripcslashes($branch->br_loc).' '.stripcslashes($branch->district_Name).' '.stripcslashes($branch->city_Name):stripcslashes($branch->br_loc_ar).' '.stripcslashes($branch->district_Name_ar).' '.stripcslashes($branch->city_Name_ar);?>
    				</dd>
    				<dt>
    					<?php echo Lang::get('messages.branch_type');?>
    				</dt>
    				<dd>
    					<?php echo Azooma::LangSupport($branch->branch_type);?>
    				</dd>
    				<dt>
    					<?php echo Lang::get('messages.seatings_rooms');?>
    				</dt>
    				<dd>
    					<?php
    					$seatings=explode(',', $branch->seating_rooms);
    					if(count($seatings)>0){
    						$i=0;
    						foreach ($seatings as $seating) {
    							echo Azooma::LangSupport($seating);
    							$i++;
    							if($i!=count($seatings)){
    								echo ', ';
    							}
    						}
    					}
    					?>
    				</dd>
    			</dl>
    		</div>
    		<div class="col-md-6">
    			<dl class="dl-horizontal">
                    <dt>
                        <?php echo Lang::get('messages.mood_atmosphere');?>
                    </dt>
                    <dd>
                        <?php
                        $moods=explode(',', $branch->mood_atmosphere);
                        $i=0;
                        if(count($moods)>0){
                            foreach ($moods as $mood) {
                                echo Azooma::LangSupport($mood);
                                $i++;
                                if($i!=count($moods)){
                                    echo ', ';
                                }   
                            }
                        }
                        ?>
                    </dd>
    				<dt>
                        <?php echo Lang::get('messages.features_services');?>
                    </dt>
                    <dd>
                        <?php
                        $features=explode(',', $branch->features_services);
                        $i=0;
                        if(count($features)>0){
                            foreach ($features as $feature) {
                                echo Azooma::LangSupport($feature);    
                                $i++;
                                if($i!=count($features)){
                                    echo ', ';
                                }
                            }
                        }
                        ?>
                    </dd>
    			</dl>
    		</div>
    	</div>
        
        <div class="spacing-container"></div>
    </div>
</div>
</div>
</div>

<script>
    function initialize() {
        initMap();
}
function initMap() {
    const myLatLng = {
        lat: <?php echo $branch->latitude ?> ,
        lng: <?php echo $branch->longitude ?>
    };
    const map = new google.maps.Map(document.getElementById("branch-map-container"), {
        zoom: 11,
        disableDefaultUI: true,
        mapTypeId: "roadmap",
        center: myLatLng,
    }); 
    var marker = new google.maps.Marker({
        position: {
            lat: <?php echo $branch->latitude ?> ,
            lng: <?php echo $branch->longitude ?>
        },
        map,
    })
            
}
</script>