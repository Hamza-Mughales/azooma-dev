<!doctype html>
<html lang="en">
    <head>
        <?php $this->load->view('inc/metaheader'); ?>
    </head>

    <body itemscope itemtype="http://schema.org/WebPage" data-spy="scroll" data-target=".bs-docs-sidebar">
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
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
                            <?php echo (htmlspecialchars($rest['rest_Name'])); ?> administrator
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo site_url('settings'); ?>">My Account</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo site_url('home/password'); ?>">Change Password</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo site_url('home/logo'); ?>">Change Logo</a></li>
                            <li class="divider"></li>
                            <li><a target="_blank" href="http://www.sufrati.com/saudi-arabian-dining/analytics/view/<?php echo $rest['rest_ID']; ?>.html">Monthly Report</a></li>
                            <li class="divider"></li>
                            <?php
                            $url = "";
                            $cityURL = $this->MGeneral->getRestaurantCityURL($rest['rest_ID']);
                            $url = 'http://www.sufrati.com/' . $cityURL['seo_url'] . '/' . $rest['seo_url'];
                            ?>
                            <li><a target="_blank" href="<?php echo $url; ?>">Preview Page</a></li>    
                            <li class="divider"></li>
                            <li><a href="<?php echo site_url('home/logout'); ?>">Logout</a></li>
                        </ul>
                    </li>
                </ul>
                <span class="right-float"></span>
            </div>    
        </div>
        <div class="container" id="main-container">
            <div class="row">
                <?php if (isset($home)) { ?>
                    <div class="page-header">
                        <h1>Welcome <?php echo ucwords((htmlspecialchars($rest['rest_Name']))); ?></h1>
                    </div>
                <?php } ?>
                <div class="span3 bs-docs-sidebar">
                    <?php $this->load->view('inc/menuleft'); ?>
                </div>
                <div class="span9">
                    <?php $this->load->view($main); ?>
                </div>
            </div>
        </div>
        <?php $this->load->view('inc/footer'); ?>
    </body>
</body>
</html>
