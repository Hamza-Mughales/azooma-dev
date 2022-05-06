<div class="pt-2">
  <ul class="breadcrumb">
    <li>
      <a href="<?php echo base_url(); ?>"><?= lang('Dashboard') ?></a> <span class="divider">/</span>
    </li>
    <li class="active"><?= lang('user_photos') ?> </li>
  </ul>
</div>
<?php
echo message_box('error');
echo message_box('success');
?>
<link href="<?= base_url(css_path()) ?>/datatable/datatable.css" rel="stylesheet">

<section class="card">
  <div class="card-body">
    <article class="span12 accordion-group">
      <h3> <?=lang('latest_photo')?> </h3>
      <div id="useruploads" class="">

        <table class="table table-bordered" id="basic-1">
          <thead>
            <tr>
              <th><?= lang('id') ?></th>
              <th><?= lang('img_preview') ?></th>
              <th><?= lang('user_name') ?></th>
              <th><?= lang('date') ?></th>
              <th width="97px"><?= lang('action') ?></th>
          </thead>
          <tbody >
            <?php if (isset($latestUserUpload) and !empty($latestUserUpload)) { ?>
              <?php $i = 0;
              foreach ($latestUserUpload as $p) {
                $i++; ?>
                <tr <?php if (isset($p['is_read'])) if ($p['is_read'] == 0) { ?> class="new-row" onclick="readPhoto('<?php echo $p['image_ID'] ?>')" <?php }  ?> data-row="<?php echo $p['image_ID'] ?>">
                  <td <?php if (isset($p['status'])) if ($p['status'] == 0) echo 'class="strike"';  ?>><?php echo $i; ?></td>
                  <td <?php if (isset($p['status'])) if ($p['status'] == 0) echo 'class="strike"';  ?>> <a href="<?=app_files_url()?>Gallery/thumb/<?php echo $p['image_full']; ?>"><img src="<?=app_files_url()?>Gallery/thumb/<?php echo $p['image_full']; ?>" width="100" /></a></td>
                  <td <?php if (isset($p['status'])) if ($p['status'] == 0) echo 'class="strike"';  ?> width="350px"><?php echo $this->MRestBranch->getUserName($p['user_ID']); ?></td>
                  <td <?php if (isset($p['status'])) if ($p['status'] == 0) echo 'class="strike"';  ?>> <?php echo date('jS M Y H:i:s',  strtotime($p['enter_time'])); ?></td>
                  <td class="text-center">
                    <a class="<?php echo $p['status'] == 0 ? 'btn btn-sm btn-primary' : 'btn btn-sm btn-danger'; ?>" title="<?php echo $p['status'] == 0 ? lang('activate') : lang('deactivate'); ?>" href="<?php echo base_url('home/usergallerystatus?id=' . $p['image_ID'] . '&ref=1&limit=' . $limit . '&per_page=' . $per_page); ?>" rel="tooltip" data-original-title="<?php echo $p['status'] == 0 ? 'Activate the Image' : 'Deactivate the Image'; ?>">
                      <i <?php echo $p['status'] == 0 ? 'class="fa fa-check"' : 'class="fa fa-ban"'; ?>> </i> 
                    </a>
                  </td>
                </tr>
              <?php } ?>
            <?php } else { ?>
              <tr>
                <td colspan="8">&nbsp;&nbsp;<?=lang('no_photo_yet')?> </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </article>
  </div>



</section>

<script src="<?= base_url(js_path()) ?>/datatable/jquery.dataTables.min.js"></script>
<script src="<?= base_url(js_path()) ?>/datatable/datatable.custom.js"></script>