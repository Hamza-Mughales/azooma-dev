<link href="<?=base_url(css_path())?>/datatable/datatable.css" rel="stylesheet">
<div class="pt-2">
<ul class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="<?php echo base_url('home'); ?>"> <?=lang('Dashboard')?></a> <span class="divider">/</span>
    </li>
    <li class="active"> <?=lang('branches_locations')?></li>
  </ul>
  </div>
<section class="card" id="top-banner">

    <div class="card-body">

    <div class="text-end">
    <span class="h5 pull-start"> <?=lang('total_branch')?> (<?php echo $total; ?>) <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i></span>
    <a class="btn btn-danger" href="<?= base_url('branches/from/' . $rest['rest_ID']) ?>" title="Add New Branch"><?=lang('add_new_branch')?></a>
  </div>
  <br>
      <div id="results" class="accordion-inner">
        <?php
        echo message_box('error');
        echo message_box('success');
        ?>
        <?php
        if (count($total) > 0) {
        ?>
        <div class="table-responsive">

          <table class="table table-bordered" id="basic-1">
            <thead class="text-center">
              <tr>
                <th><?=lang('city_english')?></th>
                <th><?=lang('city_arabic')?></th>
                <th><?=lang('total_branch')?></th>
                <th><?=lang('actions')?></th>
            </thead>
            <tbody class="text-center">

              <?php foreach ($branches as $p) { ?>
                <tr>
                  <td><a class="text-dark" href="<?= base_url() ?>branches/branch/<?= $p['city_ID'] ?>">
                      <?php echo ($p['city_Name']); ?></a></td>
                  <td><a class="text-dark" href="<?= base_url() ?>branches/branch/<?= $p['city_ID'] ?>"><?php echo ($p['city_Name_ar']); ?></a></td>
                  <td><?php echo $this->MRestBranch->getTotalBranches($restid, $p['city_ID']); ?></td>
                  <td>
                    <a class="btn btn-sm btn-primary" href="<?= base_url() ?>branches/branch/<?= $p['city_ID'] ?>" rel="tooltip" data-original-title="Edit <?php echo (htmlspecialchars($rest['rest_Name'])); ?>">
                    <?=lang("view")?> 
                    </a>

                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

        <?php
        }
        ?>
      </div>
    

  </div>
</section>
<script src="<?=base_url(js_path())?>/datatable/jquery.dataTables.min.js" ></script>
<script src="<?=base_url(js_path())?>/datatable/datatable.custom.js" ></script>
