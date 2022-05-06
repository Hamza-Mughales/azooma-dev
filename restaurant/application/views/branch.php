<link href="<?= base_url(css_path()) ?>/datatable/datatable.css" rel="stylesheet">

<div class="pt-2">
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo base_url(); ?>"><?= lang('Dashboard') ?></a> <span class="divider">/</span>
        </li>
        <li class="breadcrumb-item">
            <a href="<?php echo base_url('branches'); ?>"><?= lang('branches_locations') ?></a> <span class="divider">/</span>
        </li>
        <li class="active"><?= lang('branch_info') ?> </li>
    </ul>
</div>
<section class="card">
    <div class="card-body">
        <div class="text-end">
            <span class="h5 pull-start"><?= sprintf(lang('branch_title'), $city) ?> (<?php echo $total; ?>) <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i></span>
            <a class="btn btn-light" href="<?= base_url('branches/from/' . $rest['rest_ID']) ?>" title="<?=lang('add_new_branch')?>"><?=lang('add_new_branch')?></a>
            <a class="btn btn-danger" href="<?= base_url('branches/photofrom') ?>" title="<?=lang('add_branch_photo')?>"><?=lang('add_branch_photo')?></a>
        </div>

        <br>
        <div class="row-fluid spacer">

            <div id="results">
                <?php
                echo message_box('error');
                echo message_box('success');
                ?>
                <?php
                if (count($total) > 0) {
                ?>
                    <div class="table-responsive">

                        <table class="table table-bordered display" id="basic-1">

                            <thead class="text-center">
                                <tr>

                                    <th><?= lang('District') ?></th>
                                    <th><?= lang('branch_location') ?></th>
                                    <th><?= lang('branch_location_ar') ?></th>

                                    <th><?= lang('Number') ?></th>
                                    <th width="30%"><?= lang('actions') ?></th>
                            </thead>
                            <tbody class="text-center">

                                <?php foreach ($branches as $p) { ?>
                                    <tr>


                                        <td><a class="text-dark" href="<?= base_url() ?>branches/from/<?= $p['rest_fk_id'] ?>/<?= $p['br_id'] ?>">
                                                <?php
                                                echo ($p['district_Name']);
                                                ?></a></td>
                                        <td><a class="text-dark" href="<?= base_url() ?>branches/from/<?= $p['rest_fk_id'] ?>/<?= $p['br_id'] ?>"> <?= ($p['br_loc']) ?></a></td>
                                        <td><a class="text-dark" href="<?= base_url() ?>branches/from/<?= $p['rest_fk_id'] ?>/<?= $p['br_id'] ?>"> <?= ($p['br_loc_ar']) ?></a></td>
                                        <td>
                                            <?php echo $p['br_number'];
                                            ?></td>

                                        <td>
                                            <a title="<?= lang('edit') ?>" class="btn btn-sm btn-primary" href="<?= base_url() ?>branches/from/<?= $p['rest_fk_id'] ?>/<?= $p['br_id'] ?>" rel="tooltip" data-original-title="Edit <?php echo (htmlspecialchars($rest['rest_Name'])); ?>">
                                                <i class="fa fa-edit"></i>
                                            </a>


                                            <a title="<?= lang("view_Photos") ?>" class="btn btn-sm btn-primary" href="<?= base_url() ?>branches/photos/<?= $p['br_id'] ?>/<?= $p['rest_fk_id'] ?>" rel="tooltip" data-original-title="View Photos">
                                                <i class="fa fa-link"></i>

                                            </a>

                                            <a title="<?= lang('remove') ?>" class="btn btn-sm btn-danger cofirm-delete-btn" link="<?= base_url() ?>branches/delete_branch/<?= $p['br_id'] ?>/<?= $p['city_ID'] ?>" rel="tooltip" data-original-title="Remove Branch">
                                                <i class="fa fa-trash"></i>

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