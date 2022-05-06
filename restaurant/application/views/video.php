<?php
echo message_box('error');
echo message_box('success');
?>
<link href="<?= base_url(css_path()) ?>/datatable/datatable.css" rel="stylesheet">

<div class="pt-2">
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo base_url('video'); ?>"><?=lang('restaurant_videos')?></a> <span class="divider">/</span>
        </li>
        <li class="active"><?=lang('videos')?> </li>
    </ul>
</div>
<section class="card">



    <?php
    if (count($total) > 0) {
        echo  $this->pagination->create_links();
    }
    ?>
    <div class="card-body">
        <article class="left span12 accordion-group">
            <div class="text-end mb-3">
                <h4 class="pull-start">

                    <?php echo $pagetitle; ?>

                </h4>
                <a href="<?php echo base_url('video/form?rest=' . $rest['rest_ID']); ?>" title="<?=lang('add_new_video')?>" class="btn btn-danger "><?=lang('add_new_video')?></a>
                <a target="_blank" href="<?php echo $this->config->item('sa_url') . 'rest/' . $rest['seo_url'] . '/gallery#profile-nav'; ?>" title="Preview" class="btn btn-inverse d-none">Preview</a>

            </div>

            <div id="results">


                <?php
                if (count($videos) > 0) {
                ?>
                        <div class="table-responsive">
                    <table class="table table-bordered table-striped sufrati-backend-table" id="basic-1">
                        <thead>
                            <th class="span4">
                                 <?=lang('video_title')?>
                            </th>
                            <th class="span3">
                                <?=lang('description')?>
                            </th>
                            <th class="span3">
                                <?=lang('preview')?>
                            </th>
                            <th width="20%">
                                    <?=lang('actions')?>
                            </th>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            if (!isset($rest)) {
                                $i = 1;
                            }
                            foreach ($videos as $video) {
                                if ($i == 1) {
                                    $rest = $this->MRestaurant->getRest($video['rest_ID']);
                                }
                            ?>
                                <tr onclick="document.location.href='<?php echo base_url('video/form/' . $video['id'] . '?rest=' . $rest['rest_ID']); ?>'">
                                    <td <?php if (isset($video['status'])) if ($video['status'] == 0) echo 'class="strike"';  ?>>
                                        <?php echo $video['name_en'] . ' - ' . $video['name_ar']; ?>
                                    </td>
                                    <td <?php if (isset($video['status'])) if ($video['status'] == 0) echo 'class="strike"';  ?>>
                                        <?php echo stripcslashes(substr($video['video_description'], 0, 50)) . '...'; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $youtube = "";
                                        parse_str(parse_url($video['youtube_en'], PHP_URL_QUERY), $var);
                                        if (isset($var['v'])) {
                                            $youtube = $var['v'];
                                        }
                                        ?>
                                        <img src="http://i.ytimg.com/vi/<?php echo $youtube; ?>/default.jpg" alt="<?php echo $video['name_en']; ?>" width="120" height="90" />
                                    </td>
                                    <td>

                                        <a class="btn btn-sm btn-primary" title="<?=lang('edit')?>" href="<?php echo base_url('video/form/' . $video['id'] . '?rest=' . $rest['rest_ID']); ?>" rel="tooltip" >
                                            <i class="fa fa-edit"></i> 
                                        </a>
                                        <a class="btn btn-sm <?php echo $video['status'] == 1 ? "btn-danger " : "btn-primary "; ?> " href="<?php echo base_url('video/status/' . $video['id'] . '?rest=' . $rest['rest_ID']); ?>" rel="tooltip" title="<?php echo $video['status'] == 1 ? lang('deactivate') : lang('activate'); ?> <?=lang('Video')?>" >
                                            <?php
                                            if ($video['status'] == 1) {
                                            ?>
                                                <i class="fa fa-ban"></i> 
                                            <?php
                                            } else {
                                            ?>
                                                <i class="fa fa-check"></i> 
                                            <?php } ?>
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
    <?php
    if (count($total) > 0) {
        echo  $this->pagination->create_links();
    }
    ?>
</section>
<script src="<?= base_url(js_path()) ?>/datatable/jquery.dataTables.min.js"></script>
<script src="<?= base_url(js_path()) ?>/datatable/datatable.custom.js"></script>