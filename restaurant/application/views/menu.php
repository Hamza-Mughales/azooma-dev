<link href="<?= base_url(css_path()) ?>/datatable/datatable.css" rel="stylesheet">
<?php
echo message_box('error');
echo message_box('success');
?>
<div class="pt-2">
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo base_url('menus'); ?>"><?=lang('menu_management')?></a> <span class="divider">/</span>
        </li>
        <?php
        if (isset($_GET['menu_id']) && !isset($_GET['cat_id'])) {
        ?>
            <li class="active">
               <?=lang('menu_categories')?>
            </li>
        <?php
        } elseif (isset($_GET['cat_id']) && isset($_GET['cat_id'])) {
        ?>
            <li>
                <a href="<?php echo base_url('menus?rest=' . $_GET['rest'] . '&menu_id=' . $_GET['menu_id']); ?>"> <?=lang('menu_categories')?></a> <span class="divider">/</span>
            </li>
            <li class="active">
               <?=lang('menu_items')?>
            </li>
        <?php } else { ?>

            <li class="active"><?=lang('menus')?> </li>
        <?php
        }
        ?>
    </ul>
</div>
<section class="card">



    <div class="card-body">
        <div class="text-end  mb-2">
            <h4 class="pull-start">
               <?=lang('total_menu')?> <?php echo ($topName); ?> (<?php echo $total; ?>)

            </h4>
            <a href="<?php echo base_url('menus/form?rest=' . $rest['rest_ID']); ?><?php if (isset($_GET['menu_id']) && ($_GET['menu_id'] != "")) {
                                                                                        echo '&cat_id=0&menu_id=' . $_GET['menu_id'];
                                                                                    } ?><?php if (isset($cat) && ($cat['cat_id'] != "")) {
                                                                                            echo '&cat=' . $cat['cat_id'];
                                                                                        } ?>" title="" class="btn  btn-sm btn-danger "><?php echo $pagetitlelink; ?></a>
        </div>
        <div id="results">



            <?php
            if (count($menus) > 0) {
            ?>
            <div class="table-responsive">

                <table class="table table-bordered table-striped azooma-backend-table" id="basic-1">
                    <thead>
                        <th class="span4">
                            <?php echo $tableheading; ?>
                        </th>
                        <th class="span4">
                            <?php echo $tableheadingAr; ?>
                        </th>
                        <th width="20%">
                            <?=lang('actions')?>
                        </th>
                    </thead>
                    <tbody>

                        <?php
                        foreach ($menus as $menu) {
                        ?>
                            <?php
                            $tmp_link = '?rest=' . $rest['rest_ID'];
                            if (isset($menu['menu_id']) && !isset($menu['cat_id'])) {
                                $tmp_link .= '&menu_id=' . $menu['menu_id'];
                            } elseif (isset($menu['cat_id']) && isset($menu['menu_id'])) {
                                $tmp_link .= '&cat_id=' . $menu['cat_id'] . '&menu_id=' . $menu['menu_id'];
                            }

                            ?>

                            <tr>
                                <td>
                                    <?php
                                    if (isset($menu['menu_name'])) {
                                        echo ($menu['menu_name']);
                                    } elseif (isset($menu['cat_name'])) {
                                        echo ($menu['cat_name']);
                                    } else {
                                        echo ($menu['menu_item']);
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (isset($menu['menu_name_ar'])) {
                                        echo ($menu['menu_name_ar']);
                                    } elseif (isset($menu['cat_name_ar'])) {
                                        echo ($menu['cat_name_ar']);
                                    } else {
                                        echo ($menu['menu_item_ar']);
                                    }
                                    ?>
                                </td>
                                <td>

                                    <?php if (!isset($cat)) { ?>
                                        <a class="btn btn-sm btn-primary my-1" title="<?php echo $pageview; ?>" href="<?php echo base_url('menus' . $tmp_link); ?><?php if (!isset($cat) && (isset($menu['cat_id']) && isset($menu['menu_id']))) {
                                                                                                                                                                        echo '&item=' . $menu['cat_id'];
                                                                                                                                                                    } ?>" rel="tooltip" title="<?php echo $pageview; ?>">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    <?php } ?>
                                    <a class="btn btn-sm btn-primary my-1" title="<?= lang('edit') ?>" href="<?php echo base_url('menus/form' . $tmp_link); ?><?php if (isset($cat)) {
                                                                                                                                                                echo '&cat=' . $cat['cat_id'] . '&item=' . $menu['id'] . '&menu_id=' . $_GET['menu_id'];
                                                                                                                                                            } ?>" rel="tooltip" title="Update Menu">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a class="btn btn-sm btn-danger my-1 cofirm-delete-btn" title="<?= lang('delete') ?>" link="<?php echo base_url('menus/delete' . $tmp_link); ?><?php if (isset($cat)) {
                                                                                                                                                                                        echo '&cat=' . $cat['cat_id'] . '&item=' . $menu['id'] . '&menu_id=' . $_GET['menu_id'];
                                                                                                                                                                                    } ?>" rel="tooltip" title="Delete Menu">
                                        <i class="fa fa-trash"></i>

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