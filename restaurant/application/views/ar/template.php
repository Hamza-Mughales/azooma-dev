<!doctype html>
<html lang="en">
    <head>
        <?php $this->load->view('inc/metaheader'); ?>
    </head>

    <body itemscope itemtype="http://schema.org/WebPage" data-spy="scroll" data-target=".bs-docs-sidebar" dir="rtl">
        <?php $this->load->view('inc/ar/header'); ?>
        <div class="top-nav sufrati-seperator">
            <div class="container hidden-overflow"> 
                <div class="left"> 
                    <?php
                    $restid = $this->session->userdata('rest_id');
                    $permissions = $this->MGeneral->getRestPermissions($restid);
                    if ($permissions['accountType'] == 0) { ##FREE ACCOUNT
                        echo 'عضو مجاني ';
                    } elseif ($permissions['accountType'] == 1) { ##BRONZE ACCOUNT
                        echo ' العضو البرونزي';
                    } elseif ($permissions['accountType'] == 2) { ##SILVER ACCOUNT
                        echo ' العضو الفضي ';
                    } elseif ($permissions['accountType'] == 3) { ##GOLD ACCOUNT
                        echo ' العضو الدهبي';
                    }
                    ?> 
                </div> 
                <ul class="nav pull-right settings">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
                            <?php echo (htmlspecialchars($rest['rest_Name_Ar'])); ?> إدارة
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo site_url('ar/settings'); ?>"> خيارات</a></li>
                            <li class="divider"></li>  
                            <li><a href="<?php echo site_url('ar/home/password'); ?>">تحديث كلمة السر</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo site_url('ar/home/logo'); ?>">تغيير الشعار</a></li>
                            <li class="divider"></li>
                            <li><a target="_blank" href="http://www.sufrati.com/saudi-arabian-dining/analytics/view/<?php echo $rest['rest_ID']; ?>.html"> التقرير الشهري</a></li>
                            <li class="divider"></li>
                            <?php
                            $url = "";
                            $cityURL = $this->MGeneral->getRestaurantCityURL($rest['rest_ID']);
                            $url = 'http://www.sufrati.com/' . $cityURL['seo_url'] . '/' . $rest['seo_url'];
                            ?>
                            <li><a target="_blank" href="<?php echo $url; ?>">معاينة صفحة</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo site_url('ar/home/logout'); ?>">خروج</a></li>
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
                        <h1> مرحبا،  <?php echo ucwords((htmlspecialchars($rest['rest_Name_Ar']))); ?></h1>
                    </div>
                <?php } ?>
                <div class="span3 bs-docs-sidebar left">
                    <?php $this->load->view('inc/ar/menuleft'); ?>
                </div>
                <div class="span9 left">
                    <?php $this->load->view($main); ?>
                </div>
            </div>
        </div>
        <?php $this->load->view('inc/footer'); ?>
    </body>
</body>
</html>
