<link href="<?=base_url(css_path())?>/pricing_cards.css" rel="stylesheet">
<br>

<?php
                        if ($this->session->flashdata('error')) {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                              <a class="btn-close float-end text-white" data-bs-dismiss="alert" aria-label="Close"><strong></strong></a>
                              <strong>' . $this->session->flashdata('error') . '</strong>
                              </div>';
                        }
                    ?>
                      <?php
     //   echo message_box('error');
        echo message_box('success');
        ?>
<!-- Start Cards -->
<div id="generic_price_table">   
<section>
<h5 class="mx-3"> Your account is : <?=$subscription->accountType==1? "PREMIUM" : "BASIC"?></h5>

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
                                <li>PDF Menu	</li>
                                <li>Photo Gallery	</li>
                                <li>Website Link	</li>
                                <li>Social Media Links	</li>
                                <li>Add Special Offers	</li>
                                <li>E-Comment Card	</li>
                                <li>Comment Response	</li>
                                <li>Video Gallery	</li>
                                <li>Social Media Promotion	</li>
                                <li>No Adverts on your profile page	</li>
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

                <div class="col-md-3">
                
                  <!--PRICE CONTENT START-->
                    <div class="generic_content basic clearfix">
                        
                        <!--HEAD PRICE DETAIL START-->
                        <div class="generic_head_price clearfix">
                        
                            <!--HEAD CONTENT START-->
                            <div class="generic_head_content clearfix">
                            
                              <!--HEAD START-->
                                <div class="head_bg"></div>
                                <div class="head">
                                    <span>Basic</span>
                                </div>
                                <!--//HEAD END-->
                                
                            </div>
                            <!--//HEAD CONTENT END-->
                            
                        </div>                            
                        <!--//HEAD PRICE DETAIL END-->
                        
                        <!--FEATURE LIST START-->
                        <div class="generic_feature_list">
                          <ul>
                                <li><i class="fa fa-check "></i></li>
                                <li><i class="fa fa-check "></i></li>
                                <li><i class="fa fa-check "></i></li>
                                <li><i class="fa fa-check "></i></li>
                                <li><i class="fa fa-check "></i></li>
                                <li><i class="fa fa-check "></i></li>
                                <li><i class="fa fa-check "></i></li>
                                <li><i class="fa fa-check "></i></li>
                                <li><i class="fa fa-check "></i></li>
                                <li><i class="fa fa-check "></i></li>
                                <li>12 Posts</li>
                                <li><i class="fa fa-close "></i></li>
                            </ul>
                        </div>
                        <!--//FEATURE LIST END-->
                        
                        <!--BUTTON START-->
                        <div class="generic_price_btn clearfix">
                          <a class="" href="<?=base_url("accounts/set_plan/0")?>">Select</a>
                        </div>
                        <!--//BUTTON END-->
                        
                    </div>
                    <!--//PRICE CONTENT END-->
                        
                </div>
                <div class="col-md-3">
                
                  <!--PRICE CONTENT START-->
                    <div class="generic_content prem clearfix">
                        
                        <!--HEAD PRICE DETAIL START-->
                        <div class="generic_head_price clearfix">
                        
                            <!--HEAD CONTENT START-->
                            <div class="generic_head_content clearfix">
                            
                              <!--HEAD START-->
                                <div class="head_bg"></div>
                                <div class="head">
                                    <span>Premium</span>
                                </div>
                                <!--//HEAD END-->
                                
                            </div>
                            <!--//HEAD CONTENT END-->
                            
                        </div>                            
                        <!--//HEAD PRICE DETAIL END-->
                        
                        <!--FEATURE LIST START-->
                        <div class="generic_feature_list">
                          <ul>
                                <li><i class="fa fa-check "></i></li>
                                <li><i class="fa fa-check "></i></li>
                                <li><i class="fa fa-check "></i></li>
                                <li><i class="fa fa-check "></i></li>
                                <li><i class="fa fa-check "></i></li>
                                <li><i class="fa fa-check "></i></li>
                                <li><i class="fa fa-check "></i></li>
                                <li><i class="fa fa-check "></i></li>
                                <li><i class="fa fa-check "></i></li>
                                <li><i class="fa fa-check "></i></li>
                                <li class=" text-white">52 Posts</li>
                                <li><i class="fa fa-check "></i></li>
                            </ul>
                        </div>
                        <!--//FEATURE LIST END-->
                        
                        <!--BUTTON START-->
                        <div class="generic_price_btn clearfix">
                          <a class="" href="<?=base_url("accounts/set_plan/1")?>">Select</a>
                        </div>
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