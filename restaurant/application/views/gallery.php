<link href="<?= base_url(css_path()) ?>/datatable/datatable.css" rel="stylesheet">

<div class="pt-2">
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo base_url('gallery'); ?>"><?=lang('photo_gallery')?></a> <span class="divider">/</span>
        </li>
        <li class="active"><?=lang('restaurant_photos')?> </li>

    </ul>
</div>

<?php
echo message_box('error');
echo message_box('success');
?>
<section id="top-banner">

    <div class="row-fluid spacer card">
        <article class=" card-body">
            <div class="text-end my-3">
                <h5 class="pull-start">

                    <?php echo $pagetitle; ?>

                </h5>
                <span>
                    <a href="<?php echo base_url('gallery/image?rest=' . $rest['rest_ID']); ?>" title="" class="btn btn-sm btn-danger"><?=lang('add_new_photo')?></a>

                    <a target="_blank" href="<?php echo $this->config->item('sa_url') . 'rest/' . $rest['seo_url'] . '/gallery'; ?>" title="" class="btn btn-sm d-none btn-primary"> <?=lang('preview')?></a>
                </span>
            </div>
            <div id="results" class=" in accordion-inner table-responsive">
             


                <?php
                if (count($images) > 0) {
                ?>
            <div class="table-responsive">

                    <table class="table table-bordered table-striped azooma-backend-table" id="basic-1">
                        <thead>
                            <th class="span4">
                                 <?=lang('preview')?>
                            </th>
                            <th class="span4">
                                <?=lang('title')?>
                            </th>
                            <th>
                                 <?=lang('actions')?>
                            </th>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($images as $image) {
                            ?>
                                <tr>
                                    <td>
                                      <a href="<?=app_files_url()?>Gallery/<?php echo $image['image_full']; ?>">  <img src="<?=app_files_url()?>Gallery/thumb/<?php echo $image['image_full']; ?>" /></a>
                                    </td>
                                    <td>
                                        <?php echo $image['title'] . ' - ' . $image['title_ar']; ?>
                                    </td>
                                    <td class="d-flex">
                                        <a class="p-1 border mx-1 btn btn-sm  btn-primary" href="<?php echo base_url('gallery/image/' . $image['image_ID'] . '?rest=' . $rest['rest_ID']); ?>" rel="tooltip" title="Update Image">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
                                                <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
                                                <line x1="3" y1="22" x2="21" y2="22"></line>
                                            </svg>
                                        </a><br />
                                        <a class="p-1 border mx-1 btn btn-sm  btn-danger cofirm-delete-btn" link="<?php echo base_url('gallery/delete/' . $image['image_ID'] . '?rest=' . $rest['rest_ID']); ?>" rel="tooltip" title="<?=lang('delete')?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                            </svg>
                                        </a><br />
                                        <?php if ($image['is_featured'] == 0) { ?>
                                            <a class="p-1 border mx-1 btn btn-sm  btn-primary" href="<?php echo base_url('gallery/makeFeaturedImage/' . $image['image_ID'] . '?rest=' . $rest['rest_ID']); ?>" rel="tooltip" title="Make Profile Photo">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image">
                                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                    <polyline points="21 15 16 10 5 21"></polyline>
                                                </svg>
                                            </a>
                                        <?php } else { ?>
                                            <a class="p-1 border mx-1 btn btn-sm  btn-info" href="<?php echo base_url('gallery/unsetFeaturedImage/' . $image['image_ID'] . '?rest=' . $rest['rest_ID']); ?>" rel="tooltip" title="Profile Photo" onclick="return confirm('<?=lang('confirm_remove_photo')?>')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-camera-off">
                                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                                    <path d="M21 21H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h3m3-3h6l2 3h4a2 2 0 0 1 2 2v9.34m-7.72-2.06a4 4 0 1 1-5.56-5.56"></path>
                                                </svg>
                                            </a>
                                        <?php } ?>
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
        $(function () {
  $('[data-toggle="popover"]').popover({html:true})
});
    });
</script>