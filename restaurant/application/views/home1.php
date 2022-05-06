<section id="top-banner">
    <?php
    if ($this->session->flashdata('error')) {
        echo '<br /><div class="alert alert-error"><a class="close" data-dismiss="alert">x</a><strong>' . $this->session->flashdata('error') . '</strong></div>';
    }
    if ($this->session->flashdata('message')) {
        echo '<br /><div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong>' . $this->session->flashdata('message') . '</strong></div>';
    }

    if (isset($firstTimeLogin) && isset($profilecompletionstatus)) {
        if ($profilecompletionstatus['profilecompletion'] == 0) {
            ?>
            <div class="alert alert-info">
                <span class="welcome-text">Welcome to your Profile Management page. Follow the 4 simple steps to get started</span>
                <br/><br/><strong>STEP 1:&nbsp;&nbsp;</strong> 
                <a class="btn btn-success" href="<?= site_url('profile') ?>">Update all your Profile Page details Now.</a>
            </div>
            <?php
        } elseif ($profilecompletionstatus['profilecompletion'] == 1) {
            $restid = $this->session->userdata('rest_id');
            $uuserid = $this->session->userdata('id_user');
            if ($this->MRestBranch->getTotalBranches($restid) > 0) {
                $this->MGeneral->updateProfileCompletionStatus($restid, $uuserid, 2);
                redirect();
            }
            ?>
            <div class="alert alert-info">
                <span class="welcome-text">Welcome to your Profile Management page. Follow the 4 simple steps to get started</span>
                <br/><br/><strong>STEP 2:&nbsp;&nbsp;</strong>  
                <a class="btn btn-success" href="<?= site_url('branches') ?>">Add / Update Branch details Now.</a>
            </div>
            <?php
        } elseif ($profilecompletionstatus['profilecompletion'] == 2) {
            $restid = $this->session->userdata('rest_id');
            $uuserid = $this->session->userdata('id_user');
            if ($this->MRestBranch->getTotalMenu($restid) > 0) {
                $this->MGeneral->updateProfileCompletionStatus($restid, $uuserid, 3);
                redirect();
            }
            ?>
            <div class="alert alert-info">
                <span class="welcome-text">Welcome to your Profile Management page. Follow the 4 simple steps to get started</span>
                <br/><br/><strong>STEP 3:&nbsp;&nbsp;</strong>  
                <a class="btn btn-success" href="<?= site_url('menus') ?>">Add / Update Menu details Now.</a>
            </div>
            <?php
        } elseif ($profilecompletionstatus['profilecompletion'] == 3 && $rest['rest_Logo'] == "") {
            ?>
            <div class="alert alert-info">
                <span class="welcome-text">Welcome to your Profile Management page. Follow the 4 simple steps to get started</span>
                <br/><br/><strong>STEP 4:&nbsp;&nbsp;</strong>  
                <a class="btn btn-success" href="<?= site_url('home/logo') ?>">Add Restaurant Logo Now.</a>
            </div>
            <?php
        } elseif ($profilecompletionstatus['profilecompletion'] == 3) {
            $firstTimeLogin = $this->session->userdata('firstTimeLogin');
            if (isset($firstTimeLogin) && $firstTimeLogin == TRUE) {
                $data['firstTimeLogin'] = $this->session->userdata('firstTimeLogin');
                $restid = $this->session->userdata('rest_id');
                $uuserid = $this->session->userdata('id_user');
                $profilecompletionstatus = $this->MGeneral->getProfileCompletionStatus($restid, $uuserid);
                if ($profilecompletionstatus['profilecompletion'] == 3) {
                    $this->MGeneral->updateProfileCompletionStatus($restid, $uuserid, 4);
                }
            }
        }
    }
    ?>
    <div class="row-fluid spacer">
        <article class="left span6 accordion-group">
            <h2 data-toggle="collapse" class="accordion-heading " data-target="#stats"> <a class="accordion-toggle" href="javascript:void(0);"> Analytics <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i> </a> </h2>
            <div id="stats" class="collapse in accordion-inner">
                <table class="table table-bordered table-striped">
                    <tr>
                        <td class="st_cl">Total Visitors:</td>
                        <td class="val_st">&nbsp;<?php echo $rest['rest_Viewed']; ?></td>
                    </tr>
                    <tr>
                        <td class="st_cl">User Rating:</td>
                        <td class="val_st">&nbsp;
                            <?php printf("%.1f", $overallratings); ?>
                            / 10</td>
                    </tr>
                    <tr>
                        <td class="st_cl">Liked By:</td>
                        <td class="val_st">&nbsp;<?php echo intval($like_percentage); ?>%</td>
                    </tr>
                    <tr>
                        <td class="st_cl">Followers:</td>
                        <td class="val_st">&nbsp;<?php echo $favourite; ?></td>
                    </tr>
                    <tr>
                        <td class="st_cl"><a href="<?= site_url() ?>home/comments">User Comments:</a></td>
                        <td class="val_st">&nbsp;<a title="Latest comments" href="<?= site_url() ?>home/comments"><?php echo $comments; ?></a></td>
                    </tr>
                </table>
            </div>
        </article>
        <article class="left span6 accordion-group">
            <h2 data-toggle="collapse" class="accordion-heading " data-target="#notify"> <a class="accordion-toggle" href="javascript:void(0);"> Notifications <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i> </a> </h2>
            <div id="notify" class="collapse in accordion-inner">
                <table class="table table-bordered table-striped">
                    <tr>
                        <td class="st_cl">User Comments:</td>
                        <td class="val_st">&nbsp;<a title="Latest comments" href="<?= site_url() ?>home/comments"><?php echo $newcomments; ?></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="st_cl">User Photos:</td>
                        <td class="val_st">&nbsp;<a title="Latest Users Photos" href="<?= site_url() ?>home/useruploads"><?php echo $newphotos; ?></a></td>
                    </tr>
                    <tr>
                        <td class="st_cl">User Ratings:</td>
                        <td class="val_st">&nbsp;<a title="Latest Users Ratings" href="<?= site_url() ?>home/ratings"><?php echo round($latestRatings); ?></a></td>
                    </tr>
                    <tr>
                        <td class="st_cl">User Recommendations:</td>
                        <td class="val_st">&nbsp;<?php echo round($recommendations); ?></td>
                    </tr>
                </table>
            </div>
        </article>
    </div>
    <div class="row-fluid spacer">
        <article class="span12 accordion-group">
            <h2 data-toggle="collapse" class="accordion-heading " data-target="#activities"> 
                <a class="accordion-toggle inline-block" href="javascript:void(0);"> Latest Activities  </a>
                <a class="normal inline-block right-float right-padding" href="<?php echo site_url('home/activities'); ?>" rel="tooltip" data-original-title="View all Activities">View All Activities</a>
            </h2>
            <div id="activities" class="collapse in accordion-inner">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Activity</th>
                            <th>Date</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($activities as $p) {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $p['activity']; ?></td>
                                <td><?php echo $p['date_add']; ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </article>
    </div>

    <div class="row-fluid spacer">
        <article class="span12 accordion-group">
            <h2 data-toggle="collapse" class="accordion-heading " data-target="#userratings"> 
                <a class="accordion-toggle inline-block" href="javascript:void(0);"> Latest User Ratings</a> 
                <a class="normal inline-block right-float right-padding" href="<?php echo site_url('home/ratings'); ?>" rel="tooltip" data-original-title="View all Ratings">View All Ratings</a> 
            </h2>
            <div id="userratings" class="collapse in accordion-inner">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="actv">ID</th>
                            <th>User Name</th>
                            <th class="actv">Food</th>
                            <th class="actv">Service</th>
                            <th class="actv">Atmosphere</th>
                            <th class="actv">Value</th>
                            <th class="actv">Presentation</th>
                            <th class="actv">Variety</th>
                           
                    </thead>
                    <tbody>
                        <?php if (isset($getlates) and !empty($getlates)) { ?>
                            <?php
                            $i = 0;
                            foreach ($getlates as $p) {
                                $i++;
                                ?>
                                <tr <?php if (isset($p['is_read'])) if ($p['is_read'] == 0) { ?> class="new-row" onclick="readRating('<?php echo $p['rating_ID'] ?>')" <?php } ?> data-row="<?php echo $p['rating_ID'] ?>" >
                                    <td align="center"><?php echo $i; ?></td>
                                    <td><?php echo $this->MRestBranch->getUserName($p['user_ID']); ?></td>
                                    <td align="center"><?php echo $p['rating_Food']; ?></td>
                                    <td align="center"><?php echo $p['rating_Service']; ?></td>
                                    <td align="center"><?php echo $p['rating_Atmosphere']; ?></td>
                                    <td align="center"><?php echo $p['rating_Value']; ?></td>
                                    <td align="center"><?php echo $p['rating_Presentation']; ?></td>
                                    <td align="center"><?php echo $p['rating_Variety']; ?></td>
                             
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="8">&nbsp;&nbsp;No Ratings Yet </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </article>
    </div>

    <div class="row-fluid spacer">
        <article class="span12 accordion-group">
            <h2 data-toggle="collapse" class="accordion-heading " data-target="#usercomments"> 
                <a class="accordion-toggle inline-block" href="javascript:void(0);"> Latest User Comments </a> 
                <a class="normal inline-block right-float right-padding" href="<?php echo site_url('home/comments'); ?>" rel="tooltip" data-original-title="View all Comments">View All Comments</a> 
            </h2>
            <div id="usercomments" class="collapse in accordion-inner">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Comment</th>
                            <th>Comment Date</th>
                            <th width="105px">Action</th>
                    </thead>
                    <tbody>
                        <?php if (isset($latestcomments) and !empty($latestcomments)) { ?>
                            <?php
                            $i = 0;
                            foreach ($latestcomments as $p) {
                                $i++;
                                ?>
                                <tr <?php if (isset($p['is_read'])) if ($p['is_read'] == 0) { ?> class="new-row" onclick="readcomment('<?php echo $p['review_ID'] ?>')" <?php } ?> data-row="<?php echo $p['review_ID'] ?>" >
                                    <td <?php if (isset($p['review_Status'])) if ($p['review_Status'] == 0) echo 'class="strike"';  ?>><?php echo $i; ?></td>
                                    <td <?php if (isset($p['review_Status'])) if ($p['review_Status'] == 0) echo 'class="strike"';  ?>><?php echo $this->MRestBranch->getUserName($p['user_ID']); ?></td>
                                    <td <?php if (isset($p['review_Status'])) if ($p['review_Status'] == 0) echo 'class="strike"';  ?> width="350px"><?php echo substr($p['review_Msg'], 0, 50); ?></td>
                                    <td <?php if (isset($p['review_Status'])) if ($p['review_Status'] == 0) echo 'class="strike"';  ?>><?php echo date("Y-m-d", strtotime($p['review_Date'])); ?></td>
                                    <td>
                                        <a href="<?php echo site_url(); ?>home/response/<?php echo $p['user_ID']; ?>/<?php echo $p['review_ID']; ?>"><i class="icon icon-pencil"></i> Reply</a>
                                        <br />
                                        <a href="<?php echo site_url('home/usercommentstatus?id=' . $p['review_ID']); ?>"  rel="tooltip" data-original-title="<?php echo $p['review_Status'] == 0 ? 'Publish Comment' : 'Keep Private Comment'; ?>">
                                            <i <?php echo $p['review_Status'] == 0 ? 'class="icon-ok"' : 'class="icon icon-ban-circle"'; ?>> </i> <?php echo $p['review_Status'] == 0 ? 'Publish' : 'Keep Private'; ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php }else { ?>
                            <tr>
                                <td colspan="8">&nbsp;&nbsp;No Comments Yet </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </article>
    </div>

    <div class="row-fluid spacer">
        <article class="span12 accordion-group">
            <h2 data-toggle="collapse" class="accordion-heading " data-target="#useruploads"> 
                <a class="accordion-toggle inline-block" href="javascript:void(0);"> Latest User Photos</a> 
                <a class="normal inline-block right-float right-padding" href="<?php echo site_url('home/userUploads'); ?>" rel="tooltip" data-original-title="View all Comments">View All Photos</a> 
            </h2>
            <div id="useruploads" class="collapse in accordion-inner">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image Preview</th>
                            <th>User Name</th>
                            <th>Date</th>
                            <th width="97px">Action</th>
                    </thead>
                    <tbody>
                        <?php if (isset($latestUserUpload) and !empty($latestUserUpload)) { ?>
                            <?php
                            $i = 0;
                            foreach ($latestUserUpload as $p) {
                                $i++;
                                ?>
                                <tr <?php if (isset($p['is_read'])) if ($p['is_read'] == 0) { ?> class="new-row" onclick="readPhoto('<?php echo $p['image_ID'] ?>')" <?php } ?> data-row="<?php echo $p['image_ID'] ?>" >
                                    <td <?php if (isset($p['status'])) if ($p['status'] == 0) echo 'class="strike"';  ?>><?php echo $i; ?></td>
                                    <td <?php if (isset($p['status'])) if ($p['status'] == 0) echo 'class="strike"';  ?>><img src="http://uploads.azooma.co/Gallery/thumb/<?php echo $p['image_full']; ?>" width="100"/></td>
                                    <td <?php if (isset($p['status'])) if ($p['status'] == 0) echo 'class="strike"';  ?> width="350px"><?php echo $this->MRestBranch->getUserName($p['user_ID']); ?></td>
                                    <td <?php if (isset($p['status'])) if ($p['status'] == 0) echo 'class="strike"';  ?>> <?php echo date('jS M Y H:i:s', strtotime($p['enter_time'])); ?></td>
                                    <td>
                                        <a href="<?php echo site_url('home/usergallerystatus?id=' . $p['image_ID']); ?>"  rel="tooltip" data-original-title="<?php echo $p['status'] == 0 ? 'Activate the Image' : 'Deactivate the Image'; ?>">
                                            <i <?php echo $p['status'] == 0 ? 'class="icon-ok"' : 'class="icon icon-ban-circle"'; ?>> </i> <?php echo $p['status'] == 0 ? 'Activate' : 'Deactivate'; ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php }else { ?>
                            <tr>
                                <td colspan="8">&nbsp;&nbsp;No Photos Yet </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </article>
    </div>

</section>
<style>
    section {
        padding-top: 10px !important;
    }
</style>