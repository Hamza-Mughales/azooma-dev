<?php
echo message_box('error');
echo message_box('success');
?>
<div class="pt-2">
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo base_url('video'); ?>"><?=lang('restaurant_videos')?></a> <span class="divider">/</span>
        </li>
        <li class="active"><?=lang('Video')?> </li>

    </ul>
</div>
<section class="card">

    <div class="card-body">
        <h4>
                <?php echo $pagetitle; ?> 
        </h4>
        <div id="results" >
           
            <form id="videoForm" class="form-horizontal restaurant-form" method="post" action="<?php echo base_url('video/save'); ?><?php if (!isset($rest)) {
                                                                                                                                        echo '?type=other';
                                                                                                                                    } ?>" enctype="multipart/form-data">

                <?php
                if (isset($_GET['ref'])) {
                ?>
                    <input type="hidden" name="ref" value="<?php echo $_GET['ref']; ?>" />
                    <input type="hidden" name="per_page" value="<?php echo $_GET['per_page']; ?>" />
                    <input type="hidden" name="limit" value="<?php echo $_GET['limit']; ?>" />
                <?php
                }
                ?>

                <div class="form-group row">
                    <label class="control-label col-md-3" for="name_en"><?=lang('video_title')?></label>
                    <div class="col-md-9">
                        <input class="form-control" required type="text" name="name_en" id="name_en" placeholder="<?=lang('title')?>" <?php echo isset($video) ? 'value="' . (htmlspecialchars($video['name_en'])) . '"' : ""; ?> />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3" for="name_ar"><?=lang('video_title_ar')?> </label>
                    <div class="col-md-9">
                        <input class="form-control" required type="text" name="name_ar" id="name_ar" dir="rtl" placeholder="<?=lang('video_title_ar')?>" <?php echo isset($video) ? 'value="' . (htmlspecialchars($video['name_ar'])) . '"' : ""; ?> />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3" for="youtube_en"><?=lang('youtube_link')?></label>
                    <div class="col-md-9">
                        <input class="form-control" required type="text" name="youtube_en" id="youtube_en" placeholder="<?=lang('youtube_link')?>" <?php echo isset($video) ? 'value="' . $video['youtube_en'] . '"' : ""; ?> />
                        <p class="help-block"> Eg:- http://www.youtube.com/watch?v=lPXLRuvVyI4</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3" for="youtube_ar"> <?=lang('youtube_link_ar')?></label>
                    <div class="col-md-9">
                        <input class="form-control" required dir="rtl" type="text" name="youtube_ar" id="youtube_ar" placeholder="<?=lang('youtube_link_ar')?>" <?php echo isset($video) ? 'value="' . $video['youtube_ar'] . '"' : ""; ?> />
                        <p class="help-block"> Eg:- http://www.youtube.com/watch?v=lPXLRuvVyI4</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3" for="video_description"> <?=lang('description')?></label>
                    <div class="col-md-9">
                        <textarea class="form-control" name="video_description" id="video_description" rows="5" placeholder=" <?=lang('Video')?>  <?=lang('description')?>"><?php echo isset($video) ? str_replace(array("\\r\\n", "\r\n", "\r", "\\r", "\\n", "\n"), "\n", $video['video_description']) : ""; ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3" for="shortDescAr">  <?=lang('description_ar')?></label>
                    <div class="col-md-9">
                        <textarea class="form-control" name="video_description_ar" id="video_description_ar" rows="5" placeholder="<?=lang('Video')?> <?=lang('description_ar')?>"><?php echo isset($video) ? str_replace(array("\\r\\n", "\r\n", "\r", "\\r", "\\n", "\n"), "\n", $video['video_description_ar']) : ""; ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3" for="video_tags">  <?=lang('video_tags')?></label>
                    <div class="col-md-9">
                        <input class="form-control" type="text" name="video_tags" id="video_tags" placeholder="<?=lang('video_tags')?>" <?php echo isset($video) ? 'value="' . $video['video_tags'] . '"' : ""; ?> />

                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3" for="video_tags_ar"><?=lang('video_tags_ar')?></label>
                    <div class="col-md-9">
                        <input class="form-control" type="text"  name="video_tags_ar" id="video_tags_ar" placeholder="<?=lang('video_tags_ar')?>" <?php echo isset($video) ? 'value="' . $video['video_tags_ar'] . '"' : ""; ?> />

                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3" for="rest_Status"><?=lang('publish')?></label>
                    <div class="col-md-9">
                        <input type="checkbox" <?php if (!isset($video['status']) || $video['status'] == 1) echo 'checked="checked"'; ?> name="status" value="1" />
                    </div>
                </div>
                <div class="form-group row text-end">
                    <div class="col-md-12">
                        <?php
                        if (isset($rest)) { ?>
                            <input type="hidden" name="rest_ID" value="<?php echo $rest['rest_ID']; ?>" />
                        <?php } else { ?>
                            <input type="hidden" name="rest_ID" value="0" />
                        <?php } ?>
                        <?php if (isset($video)) {
                        ?>
                            <input type="hidden" name="id" value="<?php echo $video['id']; ?>" />
                        <?php
                        }
                        ?>
                        <input type="submit" name="submit" value="<?=lang('save')?>" class="btn btn-primary" />
                        <a href="<?php if (isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER'];
                                    else echo base_url('home'); ?>" class="btn" title="Cancel Changes"> <?=lang('cancel')?></a>
                    </div>
                </div>
            </form>
            <script type="text/javascript">
                $("#videoForm").validate();
            </script>
        </div>

    </div>
</section>