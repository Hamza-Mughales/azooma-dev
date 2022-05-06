<?php
$string = "";
$string = Request::segment(2);
$substring = Request::segment(3);
$setID = Request::segment(4);
if (isset($_GET['List_ID']) && !empty($_GET['List_ID'])) {
    $setID = $_GET['List_ID'];
}
if (isset($_GET['rest']) && !empty($_GET['rest'])) {
    $setID = $_GET['rest'];
}
if (isset($_GET['rest_ID']) && !empty($_GET['rest_ID'])) {
    $setID = $_GET['rest_ID'];
}

if (isset($rest)) {
    if (empty($setID) || !is_numeric($setID)) {
        $setID = $rest->rest_ID;
    }
    ?>
    <div class="inline-h1-container overflow"> 
        <div class="rest-profile-logo ">
            <?php
            if (isset($rest) && ($rest->rest_Logo != "")) {
                ?>
                <img src="<?php echo upload_url()?>/logos/<?php echo $rest->rest_Logo; ?>" width="130" height="130"/>
                <?php
            }
            ?>            
        </div>
        <?php
            echo '<span class="label p-1';
            if ($rest->rest_Subscription == 0) {
                echo ' label-danger  ">Not a Member';
            } else {
                switch ($rest->rest_Subscription) {
                    case 0:
                        echo ' label-default">Free member';
                        break;
                    case 1;
                        echo ' label-success">Bronze member';
                        break;
                    case 2:
                        echo ' label-info">Silver member';
                        break;
                    case 3:
                        echo ' label-warning">Gold Member';
                        break;
                }
            }
            echo "</span>";
        ?>

        <div class="rest-top-buttons col-md-10">
        

            <h3 class="rest-profile-heading w-100"> <?php echo stripslashes($rest->rest_Name) . ' - ' . $rest->rest_Name_Ar; ?> </h3> 
            <?php if ($rest->rest_Subscription == 0) { ?>
                <span class="btn-left-margin">
                    <a class="btn span my-2 badge rounded-pill btn-circle pill-badge-success" href="<?php echo route('adminrestaurants/newmember/', $rest->rest_ID); ?>" title="Activate Account <?php echo stripslashes($rest->rest_Name); ?>">Activate Account</a>
                </span>
            <?php } elseif ($rest->rest_Subscription > 0) {
                ?>
                <span class="btn-left-margin">
                    <a class="btn span my-2 badge rounded-pill pill-badge-success" href="<?php echo route('adminmembers/details/', $rest->rest_ID); ?>" title="View Account Details <?php echo stripslashes($rest->rest_Name); ?>">Membership Details</a>
                </span>
                <span class="btn-left-margin">
                    <a class="btn span my-2 badge rounded-pill pill-badge-primary" href="<?php echo route('adminmembers/sendpassword/', $rest->rest_ID); ?>" title="Send Account Details to <?php echo stripslashes($rest->rest_Name); ?>">Send Password</a>
                </span>
            <?php }
            ?>
           
            <?php
            if ($rest->rest_Status == 0) {
                ?>
                <span class="btn-left-margin">
                    <a class="btn span my-2 badge rounded-pill pill-badge-primary" href="<?php echo route('adminrestaurants/status/', $rest->rest_ID); ?>" title="DeActivate">Activate</a>
                </span>
            <?php } else {
                ?>
                <span class="btn-left-margin">
                    <a class="btn span my-2 badge rounded-pill pill-badge-warning " href="<?php echo route('adminrestaurants/status/', $rest->rest_ID); ?>" title="DeActivate">DeActivate</a>
                </span>
            <?php }
            ?>
            <span class="btn-left-margin">
                <a class="btn span my-2 badge rounded-pill pill-badge-danger btn-danger cofirm-delete-button"   href="#" link="<?=route('adminrestaurants/delete/',$rest->rest_ID)?>" title="Delete" title="Delete">
                    <i class="icon-trash icon-white"></i> Delete
                </a>
            </span>
            <?php
            if ($rest->rest_Status > 0) {
                ?>
                <span class="btn-left-margin">
                    <a target="_blank" class="btn span my-2 badge rounded-pill pill-badge-info" href="<?php echo URL::to(MRestActions::getRestCity($setID) . '/' . $rest->seo_url); ?>" title="View">Preview</a>
                </span>
                <?php
            }
            ?>
        </div> 
        </div> 
    
    <div class="spacer"></div>

    <ul class="nav nav-tabs restaurant-menu">
        <li <?php
        if (isset($string) && $string == "adminrestaurants" && $substring == "form") {
            echo 'class="nav-item active "';
        } else {
            echo "class='nav-item '";
        }
        ?>>
            <a class="nav-link" href="<?php
            if (isset($setID) && !empty($setID)) {
                echo route('adminrestaurants/form/', $setID);
            } else {
                echo route('adminrestaurants/form');
            }
            ?>">General Details</a>
        </li>
        <li <?php
        if (isset($string) && $string == "adminrestaurants" && ($substring == "branches" || $substring == "brancheimagefrom")) {
            echo 'class="active"';
        }
        ?>>
            <a class="nav-link" href="<?php
            if (isset($setID) && !empty($setID)) {
                echo route('adminrestaurants/branches', $setID);
            } else {
                echo route('adminrestaurants/form');
            }
            ?>">Branches</a>
        </li>
        <li class="<?php
        if (isset($string) && $string == "adminrestmenu") {
            echo 'active ';
        }
        ?> dropdown">
            <a class="nav-link" id="menu-id" href="#" data-bs-toggle="dropdown">
                Menus 
                <b class="caret"></b>
            </a>
            <ul id="rest-menu" class="dropdown-menu" role="menu" aria-labelledby="menu-id">
                <li role="presentation">
                    <a class="dropdown-item" role="menuitem" tabindex="-1" href="<?php echo route('adminrestmenu/', $setID); ?>">Interactive Menu</a>
                </li>
                <li role="presentation">
                    <a class="dropdown-item" role="menuitem" tabindex="-1" href="<?php echo route('adminrestmenu/pdf/', $setID); ?>">PDF Menu</a>
                </li>
            </ul>
        </li>
        <li <?php
        if (isset($string) && $string == "adminrestgallery") {
            echo 'class="active"';
        }
        ?>>
            <a class="nav-link" href="<?php
            if (isset($setID) && !empty($setID)) {
                echo route('adminrestgallery/', $setID);
            } else {
                echo route('adminrestaurants');
            }
            ?>">Gallery</a>
        </li>
        <li <?php
        if (isset($string) && $string == "adminrestoffer") {
            echo 'class="active"';
        }
        ?>>
            <a class="nav-link" href="<?php
            if (isset($setID) && !empty($setID)) {
                echo route('adminrestoffer/', $setID);
            } else {
                echo route('adminrestaurants');
            }
            ?>">Offers</a>
        </li>
        <li <?php
        if (isset($string) && $string == "adminrestaurants" && $substring == "videos") {
            echo 'class="active"';
        }
        ?>>
            <a class="nav-link" href="<?php
            if (isset($setID) && !empty($setID)) {
                echo route('adminrestaurants/videos/', $setID);
            } else {
                echo route('adminrestaurants/form');
            }
            ?>">Videos</a>
        </li>
        <li <?php
        if (isset($string) && $string == "adminrestaurants" && ( $substring == "polls" || $substring == "polloptions" || $substring == "polloptionform" )) {
            echo 'class="active"';
        }
        ?>>
            <a class="nav-link" href="<?php
            if (isset($setID) && !empty($setID)) {
                echo route('adminrestaurants/polls/', $setID);
            } else {
                echo route('adminrestaurants/form');
            }
            ?>">Polls</a>
        </li>
        <li <?php
        if (isset($string) && $string == "adminrestaurants" && $substring == "comments") {
            echo 'class="active"';
        }
        ?>>
            <a class="nav-link" href="<?php
            if (isset($setID) && !empty($setID)) {
                echo route('adminrestaurants/comments/', $setID);
            } else {
                echo route('adminrestaurants');
            }
            ?>">Comment & Ratings</a>
        </li>
    </ul>
    <?php
}
?>