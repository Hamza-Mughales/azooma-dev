<link href="<?= base_url(css_path()) ?>/datatable/datatable.css" rel="stylesheet">

<?php
echo message_box('error');
echo message_box('success');
?>
<div class="pt-2">
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo base_url(); ?>"><?= lang('Dashboard') ?></a> <span class="divider">/</span>
        </li>
        <li class="active"><?= lang('customer_comments') ?> </li>
    </ul>
</div>
<section id="top-banner">


    <div class="row-fluid spacer card">
        <article class="span12 accordion-group card-body">
            <h5> <?= lang('latest_comments') ?> </h5>
            <div id="usercomments" class=" in accordion-inner table-responsive">
            <div class="table-responsive">

                <table class="table table-bordered table-striped" id="basic-1">
                    <thead>
                        <tr>
                            <th><?= lang('id') ?></th>
                            <th><?= lang('user_name') ?></th>
                            <th><?= lang('comment') ?></th>
                            <th><?= lang('comment_date') ?></th>
                            <th width="105px"><?= lang('action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($latestcomments) and !empty($latestcomments)) {

                            $i = 0;
                            foreach ($latestcomments as $p) {
                                $i++;
                        ?>
                                <tr <?php if (isset($p['is_read'])) if ($p['is_read'] == 0) { ?> class="new-row" onclick="readcomment('<?php echo $p['review_ID'] ?>')" <?php } ?> data-row="<?php echo $p['review_ID'] ?>">
                                    <td <?php if (isset($p['review_Status'])) if ($p['review_Status'] == 0) echo 'class="strike"';  ?>><?php echo $i; ?></td>
                                    <td <?php if (isset($p['review_Status'])) if ($p['review_Status'] == 0) echo 'class="strike"';  ?>><?php echo $this->MRestBranch->getUserName($p['user_ID']); ?></td>
                                    <td <?php if (isset($p['review_Status'])) if ($p['review_Status'] == 0) echo 'class="strike"';  ?> width="350px"><?php echo substr($p['review_Msg'], 0, 50) . '...'; ?></td>
                                    <td <?php if (isset($p['review_Status'])) if ($p['review_Status'] == 0) echo 'class="strike"';  ?>><?php echo date("Y-m-d", strtotime($p['review_Date'])); ?></td>
                                    <td class="d-flex">
                                      
                                        <a title="<?= lang('reply') ?>" class="btn btn-sm mx-1 my-1 btn-primary" href="<?php echo base_url(); ?>home/response/<?php echo $p['user_ID']; ?>/<?php echo $p['review_ID']; ?>"><i class="fa fa-reply"></i> </a>

                                        <a title="<?php echo $p['review_Status'] == 0 ? lang('publish') : lang('keep_private'); ?>" class="btn btn-sm my-1 <?php echo $p['review_Status'] == 0 ? 'btn-primary' : 'btn-danger'; ?>" href="<?php echo base_url('home/usercommentstatus?id=' . $p['review_ID']); ?>" rel="tooltip" data-original-title="<?php echo $p['review_Status'] == 0 ? 'Publish Comment' : 'Keep Private Comment'; ?>">
                                            <i <?php echo $p['review_Status'] == 0 ? 'class="fa fa-flag"' : 'class="fa fa-power-off"'; ?>> </i>
                                        </a>
                                    </td>

                                </tr>

                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="8">
                                    &nbsp;&nbsp;<?=lang('no_comments_yet')?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            </div>

        </article>
    </div>
</section>

<script src="<?= base_url(js_path()) ?>/datatable/jquery.dataTables.min.js"></script>
<script src="<?= base_url(js_path()) ?>/datatable/datatable.custom.js"></script>