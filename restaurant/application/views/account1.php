<!doctype html>
<html lang="en">
    <head>
        <?php $this->load->view('inc/metaheader'); ?>
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>css/account/liteaccordion.css" />
        <script type="text/javascript" src="<?php echo base_url(); ?>js/account/liteaccordion.js"></script>
        <link rel="shortcut icon" href="http://www.sufrati.com/sa/favicon.ico" />
        <script type="text/javascript" src="<?php echo base_url(); ?>js/newslider/jquery_cycle.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/newslider/structure.js"></script>
        <style>
            .icon-remove{ opacity: .3 ; }
            .table th, .table td{   
                padding: 12px;
            }
            .heading-table{
                font-size: 21px;
                font-weight: normal !important;
                padding-top: 20px !important;
                padding-bottom: 18px !important;
            }
            .sliver{
                background: #a3a6af;
                background-color: #a3a6af !important;
                color: #fff;
            }
            .gold{
                background: #d3af37;
                background-color: #d3af37 !important;
                color: #fff;
            }
            .small-font {
                font-size: 12px;
                color: #555;
                margin: 0px;
            }
            .label {
                display: inline;
                padding: .6em .9em .7em;
                font-size: 75%;
                font-weight: 700;
                line-height: 1;
                color: #fff;
                text-align: center;
                white-space: nowrap;
                vertical-align: baseline;
                border-radius: .25em;
            }
            .label-primary {
                background-color: #428bca;
            }
            .label-success {
                background-color: #5cb85c;
            }
            .no-border{
                border-bottom: 0px !important;
            }
        </style>
    </head>

    <body>
        <?php $this->load->view('inc/header'); ?>
        <div class="top-nav sufrati-seperator">
            <div class="container hidden-overflow">
                <div class="left"> 
                    <?php
                    $restid = $this->session->userdata('rest_id');
                    $permissions = $this->MGeneral->getRestPermissions($restid);
                    if ($permissions['accountType'] == 0) { ##FREE ACCOUNT
                        echo 'FREE MEMBER';
                    } elseif ($permissions['accountType'] == 1) { ##BRONZE ACCOUNT
                        echo 'BRONZE MEMBER';
                    } elseif ($permissions['accountType'] == 2) { ##SILVER ACCOUNT
                        echo 'SILVER MEMBER';
                    } elseif ($permissions['accountType'] == 3) { ##GOLD ACCOUNT
                        echo 'GOLD MEMBER';
                    }
                    ?> 
                </div>
                <ul class="nav pull-right settings">
                    <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" > <?php echo (htmlspecialchars($rest['rest_Name'])); ?> administrator <b class="caret"></b> </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo site_url('settings'); ?>">My Account</a></li>
                            <li class="divider"></li>  
                            <li><a href="<?php echo site_url('home/password'); ?>">Change Password</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo site_url('home/logo'); ?>">Change Logo</a></li>
                            <!--          <li class="divider"></li>
                              <li><a href="<?php echo site_url(); ?>">Restaurant Reports</a></li>-->
                            <li class="divider"></li>
                            <li><a target="_blank" href="http://www.sufrati.com/saudi-arabian-dining/analytics/view/<?php echo $rest['rest_ID']; ?>.html">Monthly Report</a></li>
                            <!--          <li class="divider"></li>
                              <li><a href="<?php echo site_url(); ?>">Theme selection</a></li>-->
                            <li class="divider"></li>
                            <li><a target="_blank" href="<? echo $this->config->item('sa_url') . 'rest/' . $rest['seo_url']; ?>">Preview Page</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo site_url('home/logout'); ?>">Logout</a></li>
                        </ul>
                    </li>
                </ul>
                <span class="right-float"></span> </div>
        </div>
        <div class="container">
            <div class="row">
                <form id="accountForm" action="<?php echo base_url(); ?>accounts/save" method="post">
                    <div class="span12">
                        <div class="page-header" style="margin-left: 0px;">
                            <h1>Upgrade Your Account </h1>
                            <div class="right-float top-padding">
                                <span class="btn-left-margin right-float">
                                    <a href="<?php
                                    if (isset($_SERVER['HTTP_REFERER']))
                                        echo $_SERVER['HTTP_REFERER'];
                                    else
                                        echo site_url();
                                    ?>" class="btn" title="Go Back">Go Back</a>
                                </span>
                            </div>
                        </div>
                        <?php
                        if ($this->session->flashdata('error')) {
                            echo '<br /><div class="alert alert-error"><a class="close" data-dismiss="alert">x</a><strong>' . $this->session->flashdata('error') . '</strong></div>';
                        }
                        if ($this->session->flashdata('message')) {
                            echo '<br /><div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong>' . $this->session->flashdata('message') . '</strong></div>';
                        }
                        /*
                          ?>
                          <div class="row-fluid spacer ">
                          <div class="slide-show">
                          <div class="slide-show-inner" id="slideshow">
                          <div class="slide"> <a href="#" > <img width="1160" class="center" src="<?php echo base_url(); ?>images/account/FREEMEMBER.jpg" alt="image" /></a> </div>
                          <div class="slide"> <a href="#" > <img width="1160" class="center" src="<?php echo base_url(); ?>images/account/SILVERMEMBER.jpg" alt="image" /></a> </div>
                          <div class="slide"> <a href="#" > <img width="1160" class="center" src="<?php echo base_url(); ?>images/account/GOLDMEMBER.jpg" alt="image" /></a> </div>
                          <div class="slide"> <a href="#" > <img width="1160" class="center" src="<?php echo base_url(); ?>images/account/VIDEOSERVICES.jpg" alt="image" /></a> </div>
                          </div>
                          <ul id="carouselnav" class="threeslides">
                          <li > <a href="#" rel="nofollow" class="morebluebold"> Free Member  </a> </li>
                          <li > <a href="#" rel="nofollow" class="morebluebold"> Silver Member  </a> </li>
                          <li > <a href="#" rel="nofollow" class="morebluebold"> Gold Member  </a> </li>
                          <li > <a href="#" rel="nofollow" class="morebluebold"> HD Video Services  </a> </li>

                          </ul>
                          </div>
                          </div>
                          <?php /*?>
                          <div class="accordion basic" id="demo">
                          <ol>
                          <li class="slide" name="one">
                          <h2 class="free"><span><strong>Free Member</strong></span></h2>
                          <div style="width:770px !important;"> <img src="<?php echo base_url(); ?>images/account/FREEMEMBER.jpg" alt="image" /> </div>
                          </li>
                          <li class="slide" name="two">
                          <h2 class="bronze"><span><strong>Bronze Member</strong></span></h2>
                          <div style="width:770px !important;"> <img src="<?php echo base_url(); ?>images/account/BRONZEMEMBER.jpg" alt="image"> </div>
                          </li>
                          <li class="slide" name="three">
                          <h2 class="silver"><span><strong>Silver Member</strong></span></h2>
                          <div style="width:770px !important;"> <img src="<?php echo base_url(); ?>images/account/SILVERMEMBER.jpg" alt="image"> </div>
                          </li>
                          <li class="slide" name="four">
                          <h2 class="gold"><span><strong>Gold Member</strong></span></h2>
                          <div style="width:770px !important;"> <img src="<?php echo base_url(); ?>images/account/GOLDMEMBER.jpg" alt="image"> </div>
                          </li>
                          <li class="slide" name="five">
                          <h2 class="hdvideo"><span><strong>HD Video Services</strong></span></h2>
                          <div style="width:770px !important;"> <img src="<?php echo base_url(); ?>images/account/VIDEOSERVICES.jpg" alt="image"> </div>
                          </li>
                          </ol>
                          </div>
                          <?php */
                        ?>

                        <div class="row-fluid spacer accordion">
                            <article class="accordion-group">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="heading-table" width="600">Features</th>              
                                            <th width="300" class="heading-table sliver center">Silver</th>
                                            <th width="300" class="heading-table gold center">Gold</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <b>Profile Page</b>
                                                <p class="small-font">Add and update all your business details and contact information.</p>
                                            </td>          
                                            <td class="center"><i class="icon icon-ok"></i></td>
                                            <td class="center"><i class="icon icon-ok"></i></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Branch Managment</b>
                                                <p class="small-font">Add and update branch location info, maps and more...</p>
                                            </td>
                                            <td class="center"><i class="icon icon-ok"></i></td>
                                            <td class="center"><i class="icon icon-ok"></i></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>PDF Menu</b>
                                                <p class="small-font">Add all your menu Items + add your PDF for customers to download.</p>
                                            </td>
                                            <td class="center"><i class="icon icon-ok"></i></td>
                                            <td class="center"><i class="icon icon-ok"></i></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Photo Gallery</b>
                                                <p class="small-font">Add and View unlimited photos</p>
                                            </td>
                                            <td class="center"><i class="icon icon-ok"></i></td>
                                            <td class="center"><i class="icon icon-ok"></i></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Website Link</b>
                                                <p class="small-font">Video Gallery</p>
                                            </td>
                                            <td class="center"><i class="icon icon-ok"></i></td>
                                            <td class="center"><i class="icon icon-ok"></i></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Social Media Links</b>
                                                <p class="small-font">Social Media Promotions.</p>
                                            </td>
                                            <td class="center"><i class="icon icon-ok"></i></td>
                                            <td class="center"><i class="icon icon-ok"></i></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b> Add Special Offers</b>
                                                <p class="small-font">Display your Latest Offer on your profile page and in sufrati.com’s Special offers page instantly.</p>
                                            </td>
                                            <td class="center"><i class="icon icon-ok"></i></td>
                                            <td class="center"><i class="icon icon-ok"></i></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b> E-Comment Card</b>
                                                <p class="small-font">Your Updates will appear on sufrati.com News Feed on home page eg. When you change your menu, images, offers, contact numbers.</p>
                                            </td>
                                            <td class="center"><i class="icon icon-ok"></i></td>
                                            <td class="center"><i class="icon icon-ok"></i></td>
                                        </tr>       
                                        <tr>
                                            <td>
                                                <b>Comment Response</b>
                                                <p class="small-font">Respond to important customer comments both good and bad.</p>
                                            </td>
                                            <td class="center"><i class="icon icon-ok"></i></td>
                                            <td class="center"><i class="icon icon-ok"></i></td>
                                        </tr>        

                                        <tr>
                                            <td>
                                                <b>Video Gallery</b>
                                                <p class="small-font">Video Gallery</p>
                                            </td>
                                            <td class="center"><i class="icon icon-ok"></i></td>
                                            <td class="center"><i class="icon icon-ok"></i></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Social Media Promotion</b>
                                                <p class="small-font">Social Media Promotion</p>
                                            </td>
                                            <td class="center"><label class="label label-primary">12 Posts</label></td>
                                            <td class="center"><label class="label label-success">52 Posts</label></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b> No Adverts on your profile page</b>
                                                <p class="small-font">No Adverts on your profile page</p>
                                            </td>
                                            <td class="center"><i class="icon icon-ok"></i></td>
                                            <td class="center"><i class="icon icon-remove"></i></td>
                                        </tr>

                                        <tr>
                                            <td>
                                                Choose Package
                                            </td>
                                            <td class="center sliver">
                                                <input type="radio" <?php
                                                if ($permissions['accountType'] == 2 || $permissions['accountType'] == 3) {
                                                    echo 'disabled="disabled"';
                                                }
                                                ?> name="preset" id="preset" value="1" />
                                            </td>
                                            <td class="center gold">
                                                <input type="radio" <?php
                                                if ($permissions['accountType'] == 3) {
                                                    echo 'disabled="disabled"';
                                                }
                                                ?> name="preset" id="preset" value="2" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="no-border">
                                                Package Duration
                                            </td>
                                            <td class="center" colspan="2">
                                                <label class="label"> 12 Months</label>
                                                <input type="hidden" name="duration" id="duration" value="12">
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                                <div class="" style="margin:10px;">
                                    <legend>Are You Interested in Our Creative Services.</legend>
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <td width="600">HD Video Services</td>
                                                <td width="650" class="center"><input type="checkbox" name="addservices[]" value="HD Video Services" id="hd"/></td>
                                            </tr>
                                            <tr>
                                                <td>Web Designing & Development</td>
                                                <td class="center"><input type="checkbox" name="addservices[]" value="Web Designing & Development" id="web" /></td>
                                            </tr>
                                            <tr>
                                                <td>Menu Design</td>
                                                <td class="center"><input type="checkbox" name="addservices[]" value="Menu Design" id="menu" /></td>
                                            </tr>
                                            <tr>
                                                <td>Photography Services</td>
                                                <td class="center"><input type="checkbox" name="addservices[]" value="Photography Services" id="photo" /></td>
                                            </tr>
                                            <tr>
                                                <td>Branding</td>
                                                <td class="center"><input type="checkbox" name="addservices[]" value="Branding" id="brand" /></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <legend>Do you have any questions?</legend>    
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <textarea name="msg" id="msg" cols="45" rows="3" style="width:98%"></textarea>
                                                </td>
                                            </tr>                  
                                            <tr>
                                                <td style="border-bottom: 0px !important;">
                                                    <input type="submit" class="btn btn-primary right-float" value="Send Request" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </article>



                        </div>
                        <?php
                        /*
                          ?>

                          <div class="row-fluid spacer accordion">
                          <article class="left span6 accordion-group">
                          <h2 data-toggle="collapse" class="accordion-heading " data-target="#activities"> <a class="accordion-toggle" href="javascript:void(0);"> Choose the right Sufrati.com account for you <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i> </a> </h2>
                          <div id="activities" class="collapse in accordion-inner">
                          <table class="table table-bordered table-striped">
                          <thead>
                          <tr>
                          <th>Features</th>
                          <th>Silver</th>
                          <th>Gold</th>
                          </thead>
                          <tbody>
                          <tr data-rel="tooltip" title="Add and update all your business details and contact information.">
                          <td>Profile Page</td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          </tr>
                          <tr data-rel="tooltip" title="Add and update branch location info, maps and more...">
                          <td>Branch Managment</td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          </tr>
                          <tr data-rel="tooltip" title="Add all your menu Items + add your PDF for customers to download.">
                          <td>PDF Menu</td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          </tr>
                          <tr data-rel="tooltip" title="Add and View unlimited photos">
                          <td>Photo Gallery</td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          </tr>
                          <tr data-rel="tooltip" title="Video Gallery">
                          <td>Website Link</td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          </tr>
                          <tr data-rel="tooltip" title="Social Media Promotions.">
                          <td>Social Media Links</td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          </tr>
                          <tr data-rel="tooltip" title="Display your Latest Offer on your profile page and in sufrati.com’s Special offers page instantly.">
                          <td>Add Special Offers</td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          </tr>
                          <tr data-rel="tooltip" title="Your Updates will appear on sufrati.com News Feed on home page eg. When you change your menu, images, offers, contact numbers.">
                          <td>E-Comment Card</td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          </tr>
                          <tr data-rel="tooltip" title="Respond to important customer comments both good and bad.">
                          <td>Comment Response</td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          </tr>

                          <tr data-rel="tooltip" title="Video Gallery">
                          <td>Video Gallery</td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          </tr>
                          <tr data-rel="tooltip" title="Social Media Promotion">
                          <td>Social Media Promotion</td>
                          <td class="center"><i class="icon icon-remove"></i></td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          </tr>
                          <tr data-rel="tooltip" title="No Adverts on your profile page">
                          <td>No Adverts on your profile page</td>
                          <td class="center"><i class="icon icon-remove"></i></td>
                          <td class="center"><i class="icon icon-ok"></i></td>
                          </tr>

                          </tbody>
                          </table>
                          </div>
                          </article>
                          <article class="left span6 accordion-group">
                          <h2 data-toggle="collapse" class="accordion-heading " data-target="#notify"> <a class="accordion-toggle" href="javascript:void(0);"> Choose Package <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i> </a> </h2>
                          <div id="notify" class="collapse in accordion-inner">
                          <form id="accountForm" action="<?php echo base_url(); ?>accounts/save" method="post">
                          <legend>Select an account</legend>
                          <table class="table table-bordered table-striped">
                          <thead>
                          <tr>
                          <th class="center">Silver</th>
                          <th class="center">Gold</th>
                          </thead>
                          <tbody>
                          <tr>

                          <td class="center">
                          <input type="radio" <?php
                          if ($permissions['accountType'] == 2) {
                          echo 'disabled="disabled"';
                          }
                          ?> name="preset" id="preset" value="1" />
                          </td>
                          <td class="center"><input type="radio" <?php
                          if ($permissions['accountType'] == 3) {
                          echo 'disabled="disabled"';
                          }
                          ?> name="preset" id="preset" value="2" /></td>
                          </tr>
                          </tbody>
                          </table>

                          <legend>Select Duration</legend>
                          <table class="table table-bordered table-striped">
                          <thead>
                          <tr>
                          <!-- <th class="center">3 Months</th>
                          <th class="center">6 Months</th> -->
                          <th class="center">1 Year</th>

                          </thead>
                          <tbody>
                          <tr>
                          <!-- <td class="center"><input class="required" type="radio" name="duration" id="duration" value="3"></td>
                          <td class="center"><input class="required" type="radio" name="duration" id="duration" value="6"></td> -->
                          <td class="center">
                          <input checked="checked" type="radio" name="duration" id="duration" value="12"></td>
                          </tr>
                          </tbody>
                          </table>

                          <legend>Are You Interested in Our Creative Services.</legend>
                          <table class="table table-bordered table-striped">
                          <tbody>
                          <tr>
                          <td>HD Video Services</td>
                          <td class="center"><input type="checkbox" name="addservices[]" value="HD Video Services" id="hd"/></td>
                          </tr>
                          <tr>
                          <td>Web Designing & Development</td>
                          <td class="center"><input type="checkbox" name="addservices[]" value="Web Designing & Development" id="web" /></td>
                          </tr>
                          <tr>
                          <td>Menu Design</td>
                          <td class="center"><input type="checkbox" name="addservices[]" value="Menu Design" id="menu" /></td>
                          </tr>
                          <tr>
                          <td>Photography Services</td>
                          <td class="center"><input type="checkbox" name="addservices[]" value="Photography Services" id="photo" /></td>
                          </tr>
                          <tr>
                          <td>Branding</td>
                          <td class="center"><input type="checkbox" name="addservices[]" value="Branding" id="brand" /></td>
                          </tr>
                          </tbody>
                          </table>

                          <legend>Do you have any questions?</legend>
                          <table class="table table-bordered table-striped">
                          <tbody>
                          <tr>
                          <td>
                          <textarea name="msg" id="msg" cols="45" rows="3" style="width:98%"></textarea>
                          </td>
                          </tr>
                          <tr>
                          <td><input type="submit" class="btn btn-primary right-float" value="Submit" /></td>
                          </tr>
                          </tbody>
                          </table>
                          </form>
                          </div>
                          </article>
                          </div>
                          <?php
                         */
                        ?>

                    </div>
                </form>
            </div>
        </div>
        <?php $this->load->view('inc/footer'); ?>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/account/memshipaccordian.js"></script> 
        <script>
            $(document).ready(function() {
                $("[data-rel=tooltip]").tooltip();
                $("#accountForm").validate();
            });
        </script>

    </body>
</html>