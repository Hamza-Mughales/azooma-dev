<section id="top-banner">
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('ar'); ?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo site_url('ar/settings'); ?>">حسابي </a> <span class="divider">/</span>
        </li>
        <li class="active">حسابي  </li>
    </ul>
    <div class="right-float">
        <span class="btn-left-margin right-float">
        </span>
    </div>
    <div class="row-fluid spacer">
        <article class="left span12 accordion-group">
            <h2 data-toggle="collapse" class="accordion-heading " data-target="#results">
                <a class="accordion-toggle" href="javascript:void(0);">
                    <?php echo $pagetitle; ?> <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i>
                </a>
            </h2>
            <div id="results" class="collapse in accordion-inner">
                <?php
                if ($this->session->flashdata('error')) {
                    echo '<br /><div class="alert alert-error"><a class="close" data-dismiss="alert">x</a><strong>' . $this->session->flashdata('error') . '</strong></div>';
                }
                if ($this->session->flashdata('message')) {
                    echo '<br /><div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong>' . $this->session->flashdata('message') . '</strong></div>';
                }
                ?>


                <form id="memberForm" class="form-horizontal restaurant-form" method="post" action="<?php echo site_url('settings/save'); ?>" enctype="multipart/form-data">
                    <fieldset>

                        <div class="control-group">
                            <label class="control-label" for="full_name"> الاسم الكامل</label>
                            <div class="controls">
                                <input type="text" name="full_name" id="full_name" placeholder="الاسم الكامل" <?php echo isset($member) ? 'value="' . $member['full_name'] . '"' : ""; ?> />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="phone"> المحمول</label>
                            <div class="controls">
                                <input type="text" name="phone" id="phone" placeholder="المحمول" <?php echo isset($member) ? 'value="' . $member['phone'] . '"' : ""; ?> />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="email"> البريد الإلكتروني</label>
                            <div class="controls sufrati-backend-input-seperator" id="memberemails">
                                <?php
                                if (isset($member)) {
                                    $memberemails = explode(',', $member['email']);

                                    for ($i = 0; $i < count($memberemails); $i++) {
                                        ?>
                                        <div id="input-<?php echo $i; ?>">
                                            <a class="close sufrati-close" href="javascript:void(0);" data-dismiss="input-<?php echo $i; ?>">&times;</a>
                                            <input  type="text" name="emails[]"  placeholder=" البريد الإلكتروني" <?php echo isset($memberemails) ? 'value="' . $memberemails[$i] . '"' : ""; ?> />
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div id="input-0">
                                        <input type="text" name="emails[]"  placeholder=" البريد الإلكتروني" />
                                    </div>                
<?php } ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for=""> </label>
                            <div class="controls">
                                <a href="javascript:void(0)" class="btn btn-inverse" onclick="addmoreAr();"><i class="icon-plus-sign icon-white"></i>  إضافة إيميل </a>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="preferredlang"> يفضل لغة للاتصال</label>
                            <div class="controls">
                                <select name="preferredlang" id="preferredlang">
                                    <option value="0" <?php if (isset($member)) {
    if ($member['preferredlang'] == 0) echo 'selected="selected"';
} ?>>English</option>
                                    <option value="1" <?php if (isset($member)) {
    if ($member['preferredlang'] == 1) echo 'selected="selected"';
} ?>>Arabic</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="status">تفعيل العرض</label>
                            <div class="controls">
                                <input type="checkbox" <?php if (!isset($member['status']) || $member['status'] == 1) echo 'checked="checked"'; ?> name="status" value="1"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for=""> </label>
                            <div class="controls">
                                <?php if (isset($member)) {
                                    ?>
                                    <input type="hidden" name="rest_ID" value="<?php echo $member['rest_id']; ?>"/>
                                    <input type="hidden" name="id_user" value="<?php echo $member['id_user']; ?>"/>
    <?php
}
?>
                                <input type="submit" name="submit" value=" حفظ " class="btn btn-primary"/>
                                <a href="<?php if (isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER'];
else echo site_url('ar/settings'); ?>" class="btn" title="إلغاء">إلغاء</a>
                            </div>
                        </div>
                    </fieldset>
                </form>


                <script type="text/javascript">
<?php
if (isset($member)) {
    if ($member['email'] != "") {
        ?>
                            counter =<?php echo count($memberemails); ?>;
        <?php
    } else {
        ?>
                            counter = 2;
        <?php
    }
}
?>
                    $("#memberForm").validate({
                        rules: {
                            "emails[]": {required: true, email: true},
                            full_name: "required",
                            phone: "required"
                        }
                    });
                </script>   


















            </div>
        </article>

    </div>
</section>