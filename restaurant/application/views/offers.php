<div class="pt-2">
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo base_url('offers'); ?>"><?=lang('special_offers')?></a> <span class="divider">/</span>
        </li>
        <li class="active"><?=lang('offer')?> </li>
    </ul>
</div>
<link href="<?= base_url(css_path()) ?>/datatable/datatable.css" rel="stylesheet">

<?php
echo message_box('error');
echo message_box('success');
?>
<section class="card">


    <div class="card-body">
        <div class="text-end mb-2">
            <h4 class="pull-start">

                <?=lang('total_Offers')?> (<?php echo $total; ?>)
            </h4>
            <a href="<?php echo base_url('offers/form?rest=' . $rest['rest_ID']); ?>" title="Add new Offer" class="btn btn-danger "><?=lang('add_new_offer')?></a>
            <a href="<?php echo base_url('offers/categories?rest=' . $rest['rest_ID']); ?>" class="btn btn-primary" title="Offer categories"><?=lang('offer_cats')?></a>&nbsp;&nbsp;
        </div>

        <div id="results">

            <?php
            if (count($offers) > 0) {
            ?>
          <div class="table-responsive">

                <table class="table table-bordered table-striped " id="basic-1">
                    <thead>
                        <th class="span4">
                           <?=lang('offer_name')?>
                        </th>
                        <th class="span3">
                            <?=lang('description')?>
                        </th>
                        <th class="span2">
                           <?=lang('starting_date')?>
                        </th>
                        <th class="span2">
                        <?=lang('end_date')?>

                        </th>
                        <th>
                            <?=lang('actions')?>

                        </th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($offers as $offer) {
                        ?>
                            <tr>
                                <td <?php if (isset($offer['status'])) if ($offer['status'] == 0) echo 'class="strike"';  ?>>
                                    <?php echo ($offer['offerName']) . ' - ' . ($offer['offerNameAr']); ?>
                                </td>
                                <td <?php if (isset($offer['status'])) if ($offer['status'] == 0) echo 'class="strike"';  ?>>
                                    <?php echo substr(strip_tags(($offer['shortDesc'])), 0, 50) . '...'; ?>
                                </td>
                                <td <?php if (isset($offer['status'])) if ($offer['status'] == 0) echo 'class="strike"';  ?>>
                                    <?php echo $offer["startDate"]; ?>
                                </td>

                                <td <?php if (isset($offer['status'])) if ($offer['status'] == 0) echo 'class="strike"';  ?>>
                                    <?php echo $offer["endDate"]; ?>
                                </td>
                                <td>

                                    <a class="btn btn-sm btn-primary"  href="<?php echo base_url('offers/form/' . $offer['id'] . '?rest=' . $rest['rest_ID']); ?>" rel="tooltip" title="<?=lang('edit_offer')?>">
                                        <i class="fa fa-edit"></i> 
                                    </a>
                                    <a class="btn btn-sm <?php echo $offer['status'] == 1 ? "btn-danger" : "btn-primary"; ?>" href="<?php echo base_url('offers/status/' . $offer['id'] . '?rest=' . $rest['rest_ID']); ?>" rel="tooltip" title="<?php echo $offer['status'] == 1 ? lang('deactivate') :lang('activate'); ?> <?=lang('Offer')?>">
                                        <?php
                                        if ($offer['status'] == 1) {
                                        ?>
                                            <i class="fa  fa-ban"></i> 
                                        <?php
                                        } else {
                                        ?>
                                            <i class="fa fa-check"></i> 
                                        <?php } ?>
                                    </a>
                                
                                        <a  class="btn btn-sm btn-danger cofirm-delete-btn" link="<?php echo base_url('offers/delete/' . $offer['id'] . '?rest=' . $rest['rest_ID']); ?>"  title="<?=lang('delete')?>" >
                                        <i class="fa  fa-trash"></i>
                                        
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

    </div>
</section>
<script src="<?= base_url(js_path()) ?>/datatable/jquery.dataTables.min.js"></script>
<script src="<?= base_url(js_path()) ?>/datatable/datatable.custom.js"></script>
<script>
    $(document).ready(function() {

        $(".cofirm-delete-btn").click(function(e) 
        {
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