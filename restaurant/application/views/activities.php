

<div class="pt-2">
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo base_url(); ?>"><?= lang('Dashboard') ?></a> <span class="divider">/</span>
        </li>
       
        <li class="active"><?= lang('activities') ?> </li>
    </ul>
</div>
<link href="<?= base_url(css_path()) ?>/datatable/datatable.css" rel="stylesheet">

<div class="card">
  <div class="card-body">
    <div class="table-responsive">

      <table class="table table-bordered table-striped" id="basic-1">
        <thead>
          <tr>
            <th><?=lang('id')?></th>
            <th><?=lang('activity')?></th>
            <th><?=lang('date')?></th>
        </thead>
        <tbody>
          <?php $i = 1;
          foreach ($activities as $p) { ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $p['activity']; ?></td>
              <td><?php echo $p['date_add']; ?></td>
            </tr>
          <?php $i++;
          } ?>
        </tbody>
      </table>
    </div>

  </div>
</div>

<script src="<?= base_url(js_path()) ?>/datatable/jquery.dataTables.min.js"></script>
<script src="<?= base_url(js_path()) ?>/datatable/datatable.custom.js"></script>