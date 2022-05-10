@extends('admin.index')
@section('content')

<ol class="breadcrumb">
    <li><a href="<?= route('adminhome'); ?>">Dashboard</a></li>  
    <li><a href="<?= route('adminsubscriptions'); ?>">Subscriptions</a></li>  
    <li class="active">{{ $title }}</li>
</ol>

<link href="<?=asset(css_path())?>/pricing_cards.css" rel="stylesheet">
<br>

<style>
    .head-title {
    font-size: 15px;
    }
</style>
<?php
        $permissions1 = array();
        $permissions2 = array();
        if (isset($lists1) && !empty($lists1->sub_detail)) {
            $permissions1 = explode(",", $lists1->sub_detail);
        }
        if (isset($lists2) && !empty($lists2->sub_detail)) {
            $permissions2 = explode(",", $lists2->sub_detail);
        }
        ?>
<!-- Start Cards -->
<div id="generic_price_table">   
<section>

        <div class="container">
            
            <!--BLOCK ROW START-->
            <div class="row justify-content-center">

                <div class="col-md-3">
                
                  <!--PRICE CONTENT START-->
                    <div class="generic_content clearfix features w-100">
                        
                        <!--HEAD PRICE DETAIL START-->
                        <div class="generic_head_price clearfix">
                        
                            <!--HEAD CONTENT START-->
                            <div class="generic_head_content clearfix">
                            
                              <!--HEAD START-->
                                <div class="head_bg"></div>
                                <div class="head text-left">
                                    <span>Features</span>
                                </div>
                                <!--//HEAD END-->
                                
                            </div>
                            <!--//HEAD CONTENT END-->
                            
                        </div>                            
                        <!--//HEAD PRICE DETAIL END-->
                        
                        <!--FEATURE LIST START-->
                        <div class="generic_feature_list  text-left pl-2">
                          <ul>
                              <li>Profile Page</li>
                                <li>Branch Managment</li>
                                <li>Sample Menu	</li>
                                <li>Full Menu + PDF	</li>
                                <li>Photo Gallery - 3 Photos</li>
                                <li> Photo Gallery - 6 Photos</li>
                                <li>Photo Gallery - 12 Photos</li>
                                <li>Photo Gallery - 20 Photos</li>
                                <li>Special Offer - 1 Offer</li>
                                <li>Special Offer - 3 offers</li>
                                <li>  Booking	</li>
                                <li>  Poll	</li>
                                <li>Comment Response	</li>
                                <li>Video Gallery	</li>
                                <li>News Feed	</li>
                          
                            </ul>
                        </div>
                        <!--//FEATURE LIST END-->
                        
                        <!--BUTTON START-->
                        <div class="generic_price_btn clearfix">
                          <!-- <a class="" href="">Sign up</a> -->
                        </div>
                        <!--//BUTTON END-->
                        
                    </div>
                    <!--//PRICE CONTENT END-->
                        
                </div>

                <div class="col-md-4">
                
                  <!--PRICE CONTENT START-->
                    <div class="generic_content basic clearfix">
                        
                        <!--HEAD PRICE DETAIL START-->
                        <div class="generic_head_price clearfix">
                        
                            <!--HEAD CONTENT START-->
                            <div class="generic_head_content clearfix">
                            
                              <!--HEAD START-->
                                <div class="head_bg"></div>
                                <div class="head">
                                    <span class="head-title"><?=mb_substr($lists1->accountName,1,7)?>..</span>
                                </div>
                                <!--//HEAD END-->
                                
                            </div>
                            <!--//HEAD CONTENT END-->
                            
                        </div>                            
                        <!--//HEAD PRICE DETAIL END-->
                        
                        <!--FEATURE LIST START-->
                        <div class="generic_feature_list">
                          <ul>
                                <li>
                                <?=(isset($lists1) and in_array(1, $permissions1)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>
                                <li>
                                <?=(isset($lists1) and in_array(2, $permissions1)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>     <li>
                                <?=(isset($lists1) and in_array(3, $permissions1)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>     <li>
                                <?=(isset($lists1) and in_array(4, $permissions1)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>     <li>
                                <?=(isset($lists1) and in_array(6, $permissions1)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>     <li>
                                <?=(isset($lists1) and in_array(7, $permissions1)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>     <li>
                                <?=(isset($lists1) and in_array(8, $permissions1)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>     <li>
                                <?=(isset($lists1) and in_array(9, $permissions1)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>     <li>
                                <?=(isset($lists1) and in_array(10, $permissions1)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>
                                <li>
                                <?=(isset($lists1) and in_array(11, $permissions1)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>
                                <li>
                                <?=(isset($lists1) and in_array(12, $permissions1)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>
                                <li>
                                <?=(isset($lists1) and in_array(13, $permissions1)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>
                                <li>
                                <?=(isset($lists1) and in_array(14, $permissions1)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>
                                <li>
                                <?=(isset($lists1) and in_array(15, $permissions1)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>
                                <li>
                                <?=(isset($lists1) and in_array(16, $permissions1)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>
                            </ul>
                        </div>
                        <!--//FEATURE LIST END-->
                        
                        <!--BUTTON START-->
                     
                        <!--//BUTTON END-->
                        
                    </div>
                    <!--//PRICE CONTENT END-->
                        
                </div>
                <div class="col-md-4">
                
                  <!--PRICE CONTENT START-->
                    <div class="generic_content prem clearfix">
                        
                        <!--HEAD PRICE DETAIL START-->
                        <div class="generic_head_price clearfix">
                        
                            <!--HEAD CONTENT START-->
                            <div class="generic_head_content clearfix">
                            
                              <!--HEAD START-->
                                <div class="head_bg"></div>
                                <div class="head">
                                    <span class="head-title"><?=mb_substr($lists2->accountName,1,7);?>..</span>
                                </div>
                                <!--//HEAD END-->
                                
                            </div>
                            <!--//HEAD CONTENT END-->
                            
                        </div>                            
                        <!--//HEAD PRICE DETAIL END-->
                        
                        <!--FEATURE LIST START-->
                        <div class="generic_feature_list">
                          <ul>
                          <li>
                                <?=(isset($lists2) and in_array(1, $permissions2)) ? '<i class="fa fa-check"></i>' :'<i class="fa fa-close"></i>'?>
                                </li>
                                <li>
                                <?=(isset($lists2) and in_array(2, $permissions2)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>     <li>
                                <?=(isset($lists2) and in_array(3, $permissions2)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>     <li>
                                <?=(isset($lists2) and in_array(4, $permissions2)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>     <li>
                                <?=(isset($lists2) and in_array(6, $permissions2)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>     <li>
                                <?=(isset($lists2) and in_array(7, $permissions2)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>     <li>
                                <?=(isset($lists2) and in_array(8, $permissions2)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>     <li>
                                <?=(isset($lists2) and in_array(9, $permissions2)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>
                                <li>
                                <?=(isset($lists2) and in_array(10, $permissions2)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>
                                <li>
                                <?=(isset($lists2) and in_array(11, $permissions2)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>
                                <li>
                                <?=(isset($lists2) and in_array(12, $permissions2)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>
                                <li>
                                <?=(isset($lists2) and in_array(13, $permissions2)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>
                                <li>
                                <?=(isset($lists2) and in_array(14, $permissions2)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>
                                <li>
                                <?=(isset($lists2) and in_array(15, $permissions2)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>
                                <li>
                                <?=(isset($lists2) and in_array(16, $permissions2)) ? '<i class="fa fa-check "></i>' :'<i class="fa fa-close "></i>'?>
                                </li>
                            </ul>
                        </div>
                        <!--//FEATURE LIST END-->
                        
                        <!--BUTTON START-->
                     
                        <!--//BUTTON END-->
                        
                    </div>
                    <!--//PRICE CONTENT END-->
                        
                </div>
            </div>  
            <!--//BLOCK ROW END-->
            
        </div>
    </section>
</div>
<!-- End Cards -->

@endsection