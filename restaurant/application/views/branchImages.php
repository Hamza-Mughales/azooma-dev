<?php
echo message_box('error');
echo message_box('success');
?>
<link href="<?= base_url(css_path()) ?>/datatable/datatable.css" rel="stylesheet">

<div class="pt-2">
  <ul class="breadcrumb">
    <li>
      <a href="<?php echo base_url(); ?>"><?= lang('Dashboard') ?></a> <span class="divider">/</span>
    </li>
    <li>
      <a href="<?php echo base_url('branches'); ?>"><?= lang('branches_locations') ?></a> <span class="divider">/</span>
    </li>
    <li class="active"><?php echo (htmlspecialchars($title)); ?> </li>
  </ul>
</div>
<section class="card">

  <div class="card-body">
    <article class="span12 accordion-group">
      <h4><?= lang('branch_images') ?>

      </h4>

      <div id="restinfo" class="">


        <?php
        if (isset($branchImages)) {
        ?>
          <div class="table-responsive">
            <table class="table table-bordered" id="basic-1">
              <thead>
                <th>
                  #
                </th>
                <th>
                  <?= lang('title') ?>
                </th>
                <th>
                  <?= lang('preview') ?>
                </th>
                <th>
                  <?= lang('actions') ?>
                </th>
              </thead>
              <tbody>

                <?php
                foreach ($branchImages as $value) {

                ?>
                  <tr>
                    <td>

                    </td>
                    <td>
                      <?php echo (htmlspecialchars($value['title'])) . ' - ' . (htmlspecialchars($value['title_ar'])); ?>
                    </td>
                    <td <?php if (isset($value['status'])) if ($value['status'] == 0) echo 'class="strike"';  ?>>
                      <img src="<?=app_files_url()?>/Gallery/thumb/<?php echo $value['image_full']; ?>" width="100" height="100" />
                    </td>
                    <td>
                      <a class="btn btn-sm btn-primary" title="<?= lang('edit') ?>" href="<?php echo base_url('branches/photofrom/' . $value['image_ID'] . '?rest=' . $value['rest_ID'] . '&br_id=' . $value['branch_ID']); ?>" rel="tooltip" data-original-title="Edit this Image">
                        <i class="fa  fa-edit"> </i>

                      </a>
                      <a class="btn btn-sm <?php echo $value['status'] == 0 ? 'btn-primary' : 'btn-danger' ?> " title="<?php echo $value['status'] == 0 ? lang('activate') : lang('deactivate'); ?>" href="<?php echo base_url('branches/usergallerystatus?id=' . $value['image_ID'] . '&rest=' . $value['rest_ID'] . '&br_id=' . $value['branch_ID']); ?>" rel="tooltip" data-original-title="<?php echo $value['status'] == 0 ? 'Activate the Image' : 'Deactivate the Image'; ?>">

                        <?php
                        if ($value['status'] == 1) {
                        ?>
                          <i class="fa fa-ban"></i>
                        <?php
                        } else {
                        ?>
                          <i class="fa fa-check"></i>
                        <?php } ?>
                      </a>
                      <a class="btn btn-sm btn-danger cofirm-delete-btn" title="<?= lang('delete') ?>" link="<?php echo base_url('branches/usergallerydelete?id=' . $value['image_ID'] . '&rest=' . $value['rest_ID'] . '&br_id=' . $value['branch_ID']); ?>" rel="tooltip" data-original-title="<?php echo $value['is_read'] == 0 ? 'Delete the Image' : 'Delete the Comment'; ?>">
                        <i class="fa fa-trash"> </i>

                      </a>
                    </td>
                  </tr>
                <?php
                }
                ?>

              </tbody>
            </table>
          </div>
        <?php
        }
        ?>



      </div>
    </article>
  </div>
</section>
<script src="<?= base_url(js_path()) ?>/datatable/jquery.dataTables.min.js"></script>
<script src="<?= base_url(js_path()) ?>/datatable/datatable.custom.js"></script>
<script>
  $(document).ready(function() {

    $(".cofirm-delete-btn").click(function() {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn-success p-0 mx-2',
          cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
      })
      var url = $(this).attr('link');
      swalWithBootstrapButtons.fire({
        title: '<?= lang('delete_confirm_msg') ?>',
        text: "<?= lang('cant_undo') ?>",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: ' <a class="btn btn-success text-white" href="' + url + '"><?= lang('yes') ?>!</a> ',
        cancelButtonText: ' <?= lang('no') ?>! ',
        reverseButtons: true
      }).then((result) => {
        if (result.value != true)
          (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
          )
      });
    });

  });
</script>