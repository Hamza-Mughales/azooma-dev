<script src="<?= base_url(js_path()) ?>high-charts/high-charts.js"></script>
<?php
echo message_box('error');
echo message_box('success');
?>
<div class="container-fluid">

  <div class="row pt-2">

    <div class="col-12">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><?= lang('Dashboard') ?></li>
      </ol>
    </div>
  </div>

</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-6 col-xl-3 col-lg-6">
      <div class="card o-hidden">
        <div class="bg-primary b-r-4 card-body">
          <div class="media static-top-widget">
            <div class="align-self-center text-center"><i data-feather="thumbs-up"></i></div>
            <div class="media-body"><span class="m-0"><?= lang('liked_by') ?></span>
              <h4 class="mb-0 counter"><?= $like_by ?></h4><i class="icon-bg" data-feather="thumbs-up"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-xl-3 col-lg-6">
      <div class="card o-hidden">
        <div class="bg-secondary b-r-4 card-body">
          <div class="media static-top-widget">
            <div class="align-self-center text-center"><i data-feather="message-circle"></i></div>
            <div class="media-body"><span class="m-0"><?= lang('comments') ?></span>
              <h4 class="mb-0 counter"><?= $total_comments ?></h4><i class="icon-bg" data-feather="message-circle"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3 col-lg-6">
      <div class="card o-hidden">
        <div class="bg-primary b-r-4 card-body">
          <div class="media static-top-widget">
            <div class="align-self-center text-center"><i data-feather="star"></i></div>
            <div class="media-body"><span class="m-0"><?= lang('reviews') ?></span>
              <h4 class="mb-0 counter"><?php echo $statics['total_reviews']; ?></h4><i class="icon-bg" data-feather="star"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3 col-lg-6">
      <div class="card o-hidden">
        <div class="bg-primary b-r-4 card-body">
          <div class="media static-top-widget">
            <div class="align-self-center text-center"><i data-feather="users"></i></div>
            <div class="media-body"><span class="m-0"><?= lang('diners') ?></span>
              <h4 class="mb-0 counter"><?= $total_diners ?></h4><i class="icon-bg" data-feather="users"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php

    $this_month_liked_by = $statics['this_month_liked_by'];
    $last_month_liked_by = $statics['last_month_liked_by'];
    $this_month_mins = $this_month_liked_by - $last_month_liked_by;
    $last_month_mins = $last_month_liked_by - $this_month_liked_by;
    $bigger_liked_by = $this_month_liked_by;
    $this_month_plus = "";
    $last_month_plus = "";
    if ($this_month_mins > 0) {
      $this_month_plus = "+";
    }
    if ($last_month_mins > 0) {
      $last_month_plus = "+";
    }

    ?>
    <div class="col-xl-6 xl-100 box-col-12">
      <div class="widget-joins card widget-arrow">
        <div class="row">
          <div class="col-sm-6 pe-0">
            <div class="media border-after-xs">
              <div class="align-self-center me-3 text-start"><span class="mb-1"><?= lang('liked_by') ?></span>
                <h5 class="mb-0"><?= lang('this_month') ?></h5>
              </div>
              <div class="media-body align-self-center"><i class="font-primary" data-feather="<?= ($statics['this_month_liked_by'] >= $statics['last_month_liked_by'] and $statics['this_month_liked_by'] != 0) ? "arrow-up" : "arrow-down" ?>"></i></div>
              <div class="media-body">

                <h5 class="mb-0"><span class="counter"><?= $statics['this_month_liked_by'] ?></span></h5><span class="mb-1"><?= $this_month_plus . " " . ($statics['this_month_liked_by'] - $statics['last_month_liked_by']) ?></span>
              </div>
            </div>
          </div>
          <div class="col-sm-6 ps-0">
            <div class="media">
              <div class="align-self-center me-3 text-start"><span class="mb-1"><?= lang('liked_by') ?></span>
                <h5 class="mb-0"><?= lang('last_month') ?></h5>
              </div>
              <div class="media-body align-self-center"><i class="font-primary" data-feather="<?= ($statics['last_month_liked_by'] >= $statics['this_month_liked_by'] and $statics['last_month_liked_by'] != 0) ? "arrow-up" : "arrow-down" ?>"></i></div>
              <div class="media-body ps-2">
                <h5 class="mb-0"><span class="counter"><?= $statics['last_month_liked_by'] ?></span></h5><span class="mb-1"><?= $last_month_plus . " " . ($statics['last_month_liked_by'] - $statics['this_month_liked_by']) ?></span>
              </div>
            </div>
          </div>
          <div class="col-sm-12">
            <hr>
          </div>
          <div class="col-sm-6 pe-0">
            <?php

            $total_comments_this_month = $statics['total_comments_this_month'];
            $total_comments_last_month = $statics['total_comments_last_month'];
            $this_month_c_mins = $total_comments_this_month - $total_comments_last_month;
            $last_month_c_mins = $total_comments_last_month - $total_comments_this_month;
            $this_month_c_plus = "";
            $last_month_c_plus = "";
            if ($this_month_c_mins > 0) {
              $this_month_c_plus = "+";
            }
            if ($last_month_c_mins > 0) {
              $last_month_c_plus = "+";
            }

            ?>
            <div class="media border-after-xs">
              <div class="align-self-center me-3 text-start"><span class="mb-1"><?= lang('comments') ?></span>
                <h5 class="mb-0"><?= lang('this_month') ?></h5>
              </div>
              <div class="media-body align-self-center"><i class="font-primary" data-feather="<?= ($this_month_c_mins >= $last_month_c_mins and $this_month_c_mins != 0) ? "arrow-up" : "arrow-down" ?>"></i></div>
              <div class="media-body">
                <h5 class="mb-0"><span class="counter"><?= $total_comments_this_month ?></span></h5><span class="mb-1"><?= $this_month_c_plus . " " . $this_month_c_mins ?></span>
              </div>
            </div>
          </div>
          <div class="col-sm-6 ps-0">
            <div class="media">
              <div class="align-self-center me-3 text-start"><span class="mb-1"><?= lang('comments') ?></span>
                <h5 class="mb-0"><?= lang('last_month') ?></h5>
              </div>
              <div class="media-body align-self-center ps-3"><i class="font-primary" data-feather="<?= ($last_month_c_mins >= $this_month_c_mins and $last_month_c_mins != 0) ? "arrow-up" : "arrow-down" ?>"></i></div>
              <div class="media-body ps-2">
                <h5 class="mb-0"><span class="counter"><?= $total_comments_last_month ?></span></h5><span class="mb-1"><?= $last_month_c_plus . " " . $last_month_c_mins ?> </span>
              </div>
            </div>
          </div>
          <div class="col-sm-12">
            <hr>
          </div>
          <div class="col-sm-6 pe-0">
            <?php

            $total_vistors_this_month = $statics['total_vistors_this_month'];
            $total_vistors_last_month = $statics['total_vistors_last_month'];
            $this_month_v_mins = $total_vistors_this_month - $total_vistors_last_month;
            $last_month_v_mins = $total_vistors_last_month - $total_vistors_this_month;
            $this_month_v_plus = "";
            $last_month_v_plus = "";
            if ($this_month_v_mins > 0) {
              $this_month_v_plus = "+";
            }
            if ($last_month_v_mins > 0) {
              $last_month_v_plus = "+";
            }

            ?>
            <div class="media border-after-xs">
              <div class="align-self-center me-3 text-start"><span class="mb-1"><?= lang('Vistors') ?></span>
                <h5 class="mb-0"><?= lang('this_month') ?></h5>
              </div>
              <div class="media-body align-self-center"><i class="font-primary" data-feather="<?= ($this_month_v_mins >= $last_month_v_mins and $this_month_v_mins != 0) ? "arrow-up" : "arrow-down" ?>"></i></div>
              <div class="media-body">
                <h5 class="mb-0"><span class="counter"><?= $total_vistors_this_month ?></span></h5><span class="mb-1"><?= $this_month_v_mins ?></span>
              </div>
            </div>
          </div>
          <div class="col-sm-6 ps-0">
            <div class="media">
              <div class="align-self-center me-3 text-start"><span class="mb-1"><?= lang('Vistors') ?></span>
                <h5 class="mb-0"><?= lang('last_month') ?></h5>
              </div>
              <div class="media-body align-self-center"><i class="font-primary" data-feather="<?= ($last_month_v_mins >= $this_month_v_mins and $last_month_v_mins != 0) ? "arrow-up" : "arrow-down" ?>"></i></div>
              <div class="media-body ps-2">
                <h5 class="mb-0"><span class="counter"><?= $total_vistors_last_month ?></span></h5><span class="mb-1"><?= $last_month_v_mins ?></span>
              </div>
            </div>
          </div>
        </div>

      </div>



    </div>

    <div class="col-xl-7  col-lg-7 box-col-7">
      <div style="position: absolute;width: 100px;right: 51px;z-index: 1;">
        <select name="chart_years" id="chart_years">
          <?php
            foreach ($YearsChart as $year) {
              echo '<option value="'.$year.'">'.$year.'</option>';
            }
          ?>
        </select>
      </div>

      <figure id="chart1">
      </figure>
    </div>
    <div class="col-xl-5 col-md-12 box-col-12">
      <div class="card o-hidden">

        <div class="bar-chart-widget">

          <div class="bottom-content card-body">
            <h5 class="mx-3"><?= lang('user_rating') ?></h5>

            <div class="row">
              <div class="col-12">
                <div id="chart-widget5"> </div>
              </div>
            </div>
            <div class="row text-center">
              <div class="col-6 b-r-light">
                <div><span class="font-primary"><?=$statics['total_year_rating']?>%<i class="icon-angle-up f-12 ms-1"></i></span><span class="text-muted block-bottom"><?=lang('this_year')?></span>
                  <h4 class="num m-0"><span class="counter color-bottom"><?=$statics['total_year_rating_points']?></span></h4>
                </div>
              </div>
              <div class="col-6 b-r-light">
                <div><span class="font-primary"><?=$statics['total_month_rating']?>%<i class="icon-angle-up f-12 ms-1"></i></span><span class="text-muted block-bottom"><?=lang('this_month')?></span>
                  <h4 class="num m-0"><span class="counter color-bottom"><?=$statics['total_month_rating_points']?></span></h4>
                </div>
              </div>
      
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-7">
      <div class="card">
        <div class="card-header card-no-border">
          <h5 class="text-uppercase"><?= lang('recent_activity') ?></h5>
          <div class="card-header-right">
          <a class="btn  btn-primary" href="<?=base_url('rest/activities')?>"><?=lang('view_all')?></a>

          </div>
        </div>
        <div class="card-body new-update pt-0">
          <div class="activity-timeline">
            <?php
            $i = 1;
            foreach ($activities as $p) {
              $class = "activity-dot-secondary";
              $icon = '<i class="fa fa-circle circle-dot-secondary pull-right"></i>';
              if ($i % 2 == 0) {
                $class = "activity-dot-secondary";
                $icon = '<i class="fa fa-circle circle-dot-secondary pull-right"></i>';
                $icon = '';
              } else {
                $class = "activity-dot-primary";
                $icon = '<i class="fa fa-circle circle-dot-primary pull-right"></i>';
              }
            ?>
              <div class="media">
                <div class="activity-line"></div>
                <div class="<?= $class ?>"></div>
                <div class="media-body"><span><?php echo $p['activity']. " " . $icon ; ?></span>
                  <p class="font-roboto"><?php echo $p['date_add']; ?></p>
                </div>
              </div>
            <?php $i++;
            }
            ?>

          </div>

        </div>
      </div>
    </div>
    <div class="col-md-5 notification ">
      <div class="card">
        <div class="card-header card-no-border">
          <div class="header-top">
            <h5 class="text-uppercase m-0">notification</h5>
            <div class="card-header-right-icon">
              <div class="dropdown">
                <button class="btn dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">Today</button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday </a></div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body pt-0">
          <div class="media">
            <div class="media-body">
              <p>20-04-2020 <span>10:10</span></p>
              <h6>Updated Product<span class="dot-notification"></span></h6><span>Quisque a consequat ante sit amet magna...</span>
            </div>
          </div>
          <div class="media">
            <div class="media-body">
              <p>20-04-2020<span class="ps-1">Today</span><span class="badge badge-secondary">New</span></p>
              <h6>Tello just like your product<span class="dot-notification"></span></h6><span>Quisque a consequat ante sit amet magna... </span>
            </div>
          </div>
          <div class="media">
            <div class="media-body">
              <p>20-04-2020 <span>10:10</span></p>
              <h6> Product liked by<span class="dot-notification"></span></h6><span>Quisque a consequat ante sit amet magna...</span>
            </div>
          </div>
          <div class="media">
            <div class="media-body">
              <div class="d-flex mb-3">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>







    <div class="col-xl-6 xl-100 box-col-12">
      <div class="card">
        <div class="card-header">
          <h5 class="text-uppercase"><?= lang('latest_rating') ?></h5>
          <div class="card-header-right">
          <a class="btn  btn-primary" href="<?=base_url('rate')?>"><?=lang('view_all')?></a>

          </div>
        </div>
        <div class="card-body">
          <div class="user-status table-responsive">
            <table class="table table-bordernone">
              <thead class="text-center">
                <tr>

                  <th scope="col"><?= lang('id') ?></th>
                  <th><?= lang('user_name') ?></th>
                  <th scope="col"><?= lang('Food') ?></th>
                  <th scope="col"><?= lang('Service') ?></th>
                  <th scope="col"><?= lang('Atmosphere') ?></th>
                  <th scope="col"><?= lang('Value') ?></th>
                  <th scope="col"><?= lang('Presentation') ?></th>
                  <th scope="col"><?= lang('Variety') ?></th>
                  <th width="15%" scope="col"><?= lang('Total') ?></th>
                </tr>
              </thead>
              <tbody class="text-center">
                <?php if (isset($getlates) and !empty($getlates)) { ?>
                  <?php
                  $i = 0;

                  foreach ($getlates as $p) {
                    $total = 0;
                    $i++;
                  ?>
                    <tr <?php if (isset($p['is_read'])) if ($p['is_read'] == 0) { ?> class="new-row" onclick="readRating('<?php echo $p['rating_ID'] ?>')" <?php } ?> data-row="<?php echo $p['rating_ID'] ?>">
                      <td><?php echo $i; ?></td>
                      <td><?php echo $this->MRestBranch->getUserName($p['user_ID']); ?></td>
                      <td><?php $total += $p['rating_Food'];
                          echo $p['rating_Food']; ?></td>
                      <td><?php $total += $p['rating_Service'];
                          echo $p['rating_Service']; ?></td>
                      <td><?php $total += $p['rating_Atmosphere'];
                          echo $p['rating_Atmosphere']; ?></td>
                      <td><?php $total += $p['rating_Value'];
                          echo $p['rating_Value']; ?></td>
                      <td><?php $total += $p['rating_Presentation'];
                          echo $p['rating_Presentation']; ?></td>
                      <td><?php $total += $p['rating_Variety'];
                          echo $p['rating_Variety']; ?></td>
                      <td>
                        <?php $p_total = round(($total * 10) / 6, 2);
                        $class = "bg-primary";
                        if ($p_total <= 50)
                          $class = "bg-secondary";
                        ?>
                        <div class="progress-showcase">
                          <?= $p_total ?>%
                          <div class="progress" style="height: 8px;">
                            <div class="progress-bar <?= $class ?>" role="progressbar" style="width: <?= $p_total ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } else { ?>
                  <tr>
                    <td colspan="8">&nbsp;&nbsp;<?= lang('no_rating_yet') ?> </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
    <div class="col-xl-6 xl-100 box-col-12">
      <div class="card">
        <div class="card-header">
          <h5 class="text-uppercase"><?= lang('latest_comments') ?></h5>
          <div class="card-header-right">
          <a class="btn  btn-primary" href="<?=base_url('home/comments')?>"><?=lang('view_all')?></a>

          </div>
        </div>
        <div class="card-body">
          <div class="user-status table-responsive">
            <table class="table table-bordernone">
              <thead class="text-center">
                <tr>
                  <th><?= lang('id') ?></th>
                  <th><?= lang('user_name') ?></th>
                  <th><?= lang('comment') ?></th>
                  <th><?= lang('comment_date') ?></th>
                  <th width="105px"><?= lang('action') ?></th>
                </tr>
              </thead>
              <tbody class="text-center">
                <?php if (isset($latestcomments) and !empty($latestcomments)) { ?>
                  <?php
                  $i = 0;
                  foreach ($latestcomments as $p) {
                    $i++;
                  ?>
                    <tr <?php if (isset($p['is_read'])) if ($p['is_read'] == 0) { ?> class="new-row" onclick="readcomment('<?php echo $p['review_ID'] ?>')" <?php } ?> data-row="<?php echo $p['review_ID'] ?>">
                      <td <?php if (isset($p['review_Status'])) if ($p['review_Status'] == 0) echo 'class="strike"';  ?>><?php echo $i; ?></td>
                      <td <?php if (isset($p['review_Status'])) if ($p['review_Status'] == 0) echo 'class="strike"';  ?>><?php echo $this->MRestBranch->getUserName($p['user_ID']); ?></td>
                      <td <?php if (isset($p['review_Status'])) if ($p['review_Status'] == 0) echo 'class="strike"';  ?> width="350px"><?php echo substr($p['review_Msg'], 0, 50); ?></td>
                      <td <?php if (isset($p['review_Status'])) if ($p['review_Status'] == 0) echo 'class="strike"';  ?>><?php echo date("Y-m-d", strtotime($p['review_Date'])); ?></td>
                      <td>
                        <a title="<?= lang('reply') ?>" class="btn btn-sm my-1 btn-primary" href="<?php echo base_url(); ?>home/response/<?php echo $p['user_ID']; ?>/<?php echo $p['review_ID']; ?>"><i class="fa fa-reply"></i> </a>

                        <a title="<?php echo $p['review_Status'] == 0 ? lang('publish') : lang('keep_private'); ?>" class="btn btn-sm my-1 btn-primary" href="<?php echo base_url('home/usercommentstatus?id=' . $p['review_ID']); ?>" rel="tooltip" data-original-title="<?php echo $p['review_Status'] == 0 ? 'Publish Comment' : 'Keep Private Comment'; ?>">
                          <i <?php echo $p['review_Status'] == 0 ? 'class="fa fa-flag"' : 'class="fa fa-power-off"'; ?>> </i>
                        </a>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } else { ?>
                  <tr>
                    <td colspan="8">&nbsp;&nbsp;<?= lang('no_comments_yet') ?> </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
    <div class="col-xl-6 xl-100 box-col-12">
      <div class="card">
        <div class="card-header">
          <h5 class="text-uppercase"><?= lang('latest_photo') ?></h5>
          <div class="card-header-right">
       
            <a class="btn  btn-primary" href="<?=base_url('home/userUploads')?>"><?=lang('view_all')?></a>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive product-table">
            <table class="table   table-bordernone">
              <thead class="text-center">
                <tr>
                  <th><?= lang('id') ?></th>
                  <th><?= lang('img_preview') ?></th>
                  <th><?= lang('user_name') ?></th>
                  <th><?= lang('date') ?></th>
                  <th width="97px"><?= lang('action') ?></th>
                </tr>
              </thead>
              <tbody class="text-center">
                <?php if (isset($latestUserUpload) and !empty($latestUserUpload)) { ?>
                  <?php
                  $i = 0;
                  foreach ($latestUserUpload as $p) {
                    $i++;
                  ?>
                    <tr <?php if (isset($p['is_read'])) if ($p['is_read'] == 0) { ?> class="new-row" onclick="readPhoto('<?php echo $p['image_ID'] ?>')" <?php } ?> data-row="<?php echo $p['image_ID'] ?>">
                      <td <?php if (isset($p['status'])) if ($p['status'] == 0) echo 'class="strike"';  ?>><?php echo $i; ?></td>
                      <td <?php if (isset($p['status'])) if ($p['status'] == 0) echo 'class="strike"';  ?>> <a href="<?=app_files_url()?>Gallery/<?php echo $p['image_full']; ?>"> <img src="<?= app_files_url() ?>Gallery/thumb/<?php echo $p['image_full']; ?>" width="100" /></a></td>
                      <td <?php if (isset($p['status'])) if ($p['status'] == 0) echo 'class="strike"';  ?> width="350px"><?php echo $this->MRestBranch->getUserName($p['user_ID']); ?></td>
                      <td <?php if (isset($p['status'])) if ($p['status'] == 0) echo 'class="strike"';  ?>> <?php echo date('jS M Y H:i:s', strtotime($p['enter_time'])); ?></td>
                      <td>
                        <a  <?php echo $p['status'] == 0 ? 'class="btn btn-sm btn-primary"' : 'class="btn btn-sm btn-danger"'; ?> href="<?php echo site_url('home/usergallerystatus?id=' . $p['image_ID']); ?>" rel="tooltip" title="<?php echo $p['status'] == 0 ? lang('activate_img') : lang('deactivate_img'); ?>">
                          <i <?php echo $p['status'] == 0 ? 'class="fa fa-check"' : 'class="fa fa-ban"'; ?>> </i>
                        </a>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } else { ?>
                  <tr>
                    <td colspan="8">&nbsp;&nbsp;<?= lang('no_photo_yet') ?> </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>

  </div>
</div>
  <?php $this->load->view('home_gallery') ?>
<!-- Container-fluid Ends-->
<script src="<?= base_url(js_path()) ?>chart/apex-chart/moment.min.js"></script>
<script src="<?= base_url(js_path()) ?>chart/apex-chart/apex-chart.js"></script>
<script src="<?= base_url(js_path()) ?>owl.carousel.js"></script>
<script src="<?= base_url(js_path()) ?>counter/jquery.waypoints.min.js"></script>
<script src="<?= base_url(js_path()) ?>counter/jquery.counterup.min.js"></script>
<script src="<?= base_url(js_path()) ?>counter/counter-custom.js"></script>
<script src="<?= base_url(js_path()) ?>general-widget.js"></script>
<?php
$index = 0;

$month_data =$statics['months_vistors_data'];

$vistors_data[$index]['lineColor'] = "#d55c46";
$vistors_data[$index]['color'] = "#995144";
$vistors_data[$index]['lineWidth'] = "5px";
$vistors_data[$index]['name'] = "";
$vistors_data[$index]['data'] = $month_data;
$index++;

$vistors = json_encode($vistors_data);
?>

<script type="text/javascript">
  function load_months_applications_chart(result = '') {

      var totalVisits = result.TotalVisits;
      var englishVisits = result.EnglishVisits;
      var arabicVisits = result.ArabicVisits;
    

    Highcharts.chart('chart1', {
    chart: {
    type: 'line'
    },
    title: {
    text: 'Average Visits'
    },
    xAxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
    title: {
    text: ''
    }
    },
    legend: {
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle'
    },
    tooltip: {
    shared: true,
    crosshairs: true,
    },
    plotOptions: {
      line: {
        dataLabels: {
        enabled: true
        },
        enableMouseTracking: false
      }
    },
      series: [
        {
          "name":"Total Visits",   
          "data": totalVisits
        },
        {
          "name":"English Visits", 
          "data":englishVisits
        },
        {
          "name":"Arabic Visits",  
          "data":arabicVisits
        }
      ] 
  });
  }

  $(document).ready(function() {
    $.ajax({
        url: "<?= base_url('home/visitors_chart') ?>",
        type: "POST",
        dataType:"json",
        data: {
            year: "<?=date("Y")?>"
        },
        success: function(t) {
          console.log(t);
          load_months_applications_chart(t);
        }
     
    });
  });
</script>

<script>

  $('#chart_years').on('change', function(e) {
    console.log( e.target.value );
    var year =e.target.value;
    $.ajax({
        url: "<?= base_url('home/visitors_chart') ?>",
        type: "POST",
        dataType:"json",
        data: {
            year: year
        },
        success: function(t) {
          console.log(t);
          load_months_applications_chart(t);
        }
     
    });
  });  
</script>
