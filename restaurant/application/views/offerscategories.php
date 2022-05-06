<link href="<?= base_url(css_path()) ?>/datatable/datatable.css" rel="stylesheet">

<div class="pt-3">
    <ul class="breadcrumb">
        <li>
            <?php
            echo message_box('error');
            echo message_box('success');
            ?>
            <a href="<?php echo base_url('offers'); ?>"><?=lang('special_offers')?></a> <span class="divider">/</span>
        </li>
        <li class="active"><?=lang('offer')?> </li>
    </ul>
</div>
<section class="card">

    <?php
    if (count($total) > 0) {
        echo  $this->pagination->create_links();
    }
    ?>

    <div class="card-body ">
        <div class="text-end mb-2">
            <h4 class="pull-start">
                <?=lang('total_offer_cat')?> (<?php echo $total; ?>)

            </h4>
            <a href="<?php echo base_url('offers/form?rest=' . $rest['rest_ID']); ?>" title="<?=lang('add_new_offer')?>" class="btn btn-primary "><?=lang('add_new_offer')?></a>
        </div>
        <div id="results">


            <?php
            if (count($offers) > 0) {
            ?>

                <table class="table table-bordered table-striped sufrati-backend-table" id="basic-1">
                    <thead>
                        <th class="span4">
                           <?=lang('category_name')?>
                        </th>
                        <th>
                           <?=lang('category_name_ar')?>
                        </th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($offers as $offer) {
                        ?>
                            <tr>
                                <td <?php if (isset($offer['status'])) if ($offer['status'] == 0) echo 'class="strike"';  ?>>
                                    <?php echo $offer['categoryName']; ?>
                                </td>
                                <td <?php if (isset($offer['status'])) if ($offer['status'] == 0) echo 'class="strike"';  ?>>
                                    <?php echo $offer['categoryNameAr']; ?>
                                </td>
                            </tr>

                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            <?php
            }
            ?>


        </div>

    </div>
    <?php
    if (count($total) > 0) {
        echo  $this->pagination->create_links();
    }
    ?>
</section>
<script src="<?= base_url(js_path()) ?>/datatable/jquery.dataTables.min.js"></script>
<script src="<?= base_url(js_path()) ?>/datatable/datatable.custom.js"></script>