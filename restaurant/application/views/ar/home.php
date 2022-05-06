<section id="top-banner">
    <?php
    if ($this->session->flashdata('error')) {
        echo '<br /><div class="alert alert-error"><a class="close" data-dismiss="alert">x</a><strong>' . $this->session->flashdata('error') . '</strong></div>';
    }
    if ($this->session->flashdata('message')) {
        echo '<br /><div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong>' . $this->session->flashdata('message') . '</strong></div>';
    }

    if (isset($firstTimeLogin) && isset($profilecompletionstatus)) {
        if ($profilecompletionstatus['profilecompletion'] == 0) {
            ?>
            <div class="alert alert-success">
                مرحبا بك في صفحة الملف الشخصي الإدارية. اتبع الخطوات الأربعة بسيطة للبدء
                <br/><br/><strong>STEP 1</strong> 
                <a href="<?= site_url('ar/profile') ?>">&nbsp;&nbsp;خطوة واحدة تحديث الصفحة كل التفاصيل الخاصة بك من قبل بالضغط هنا</a>
            </div>
            <?php
        } elseif ($profilecompletionstatus['profilecompletion'] == 1) {
            $restid = $this->session->userdata('rest_id');
            $uuserid = $this->session->userdata('id_user');
            if ($this->MRestBranch->getTotalBranches($restid) > 0) {
                $this->MGeneral->updateProfileCompletionStatus($restid, $uuserid, 2);
                redirect();
            }
            ?>
            <div class="alert alert-success">
                مرحبا بك في صفحة الملف الشخصي الإدارية. اتبع الخطوات الأربعة بسيطة للبدء
                <br/><br/><strong>STEP 2</strong>  
                <a href="<?= site_url('ar/branches') ?>">&nbsp;&nbsp;إضافة / تحديث تفاصيل فرع الآن</a>
            </div>
            <?php
        } elseif ($profilecompletionstatus['profilecompletion'] == 2) {
            $restid = $this->session->userdata('rest_id');
            $uuserid = $this->session->userdata('id_user');
            if ($this->MRestBranch->getTotalMenu($restid) > 0) {
                $this->MGeneral->updateProfileCompletionStatus($restid, $uuserid, 3);
                redirect();
            }
            ?>
            <div class="alert alert-success">
                مرحبا بك في صفحة الملف الشخصي الإدارية. اتبع الخطوات الأربعة بسيطة للبدء
                <br/><br/><strong>STEP 3</strong>  
                <a href="<?= site_url('ar/menus') ?>">&nbsp;&nbsp;إضافة / تحديث تفاصيل القائمة الآن.</a>
            </div>
            <?php
        } elseif ($profilecompletionstatus['profilecompletion'] == 3 && $rest['rest_Logo'] == "") {
            ?>
            <div class="alert alert-success">
                مرحبا بك في صفحة الملف الشخصي الإدارية. اتبع الخطوات الأربعة بسيطة للبدء
                <br/><br/><strong>STEP 4</strong>  
                <a href="<?= site_url('ar/home/logo') ?>">&nbsp;&nbsp;Add Restaurant Logo Now.</a>
            </div>
            <?php
        } elseif ($profilecompletionstatus['profilecompletion'] == 3) {
            $firstTimeLogin = $this->session->userdata('firstTimeLogin');
            if (isset($firstTimeLogin) && $firstTimeLogin == TRUE) {
                $data['firstTimeLogin'] = $this->session->userdata('firstTimeLogin');
                $restid = $this->session->userdata('rest_id');
                $uuserid = $this->session->userdata('id_user');
                $profilecompletionstatus = $this->MGeneral->getProfileCompletionStatus($restid, $uuserid);
                if ($profilecompletionstatus['profilecompletion'] == 3) {
                    $this->MGeneral->updateProfileCompletionStatus($restid, $uuserid, 4);
                }
            }
        }
    }
    ?>
    <div class="row-fluid spacer">
        <article class="left span6 accordion-group">
            <h2 data-toggle="collapse" class="accordion-heading " data-target="#stats"> <a class="accordion-toggle" href="javascript:void(0);"> إحصائيات <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i> </a> </h2>
            <div id="stats" class="collapse in accordion-inner">
                <table class="table table-bordered table-striped">
                    <tr>
                        <td class="st_cl">مجموع الزوار:</td>
                        <td class="val_st">&nbsp;<?php echo $this->MGeneral->convertToArabic($rest['rest_Viewed']); ?></td>
                    </tr>
                    <tr>
                        <td class="st_cl">تقييم المستخدمين:</td>
                        <td class="val_st">&nbsp;
                            <?php printf("%.1f", $overallratings); ?>
                            / <?php echo $this->MGeneral->convertToArabic(10); ?></td>
                    </tr>
                    <tr>
                        <td class="st_cl">محبوب من قبل:</td>
                        <td class="val_st">&nbsp;<?php echo $this->MGeneral->convertToArabic(intval($like_percentage)); ?>%</td>
                    </tr>
                    <tr>
                        <td class="st_cl">المفضلة:</td>
                        <td class="val_st">&nbsp;<?php echo $this->MGeneral->convertToArabic($favourite); ?></td>
                    </tr>
                    <tr>
                        <td class="st_cl"><a href="<?= site_url() ?>home/comments">تعليقات المستخدمين :</a></td>
                        <td class="val_st">&nbsp;<a title="todays comments" href="<?= site_url() ?>home/comments"><?php echo $this->MGeneral->convertToArabic($comments); ?></a></td>
                    </tr>
                </table>
            </div>
        </article>
        <article class="left span6 accordion-group">
            <h2 data-toggle="collapse" class="accordion-heading " data-target="#notify"> <a class="accordion-toggle" href="javascript:void(0);"> التحديثات <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i> </a> </h2>
            <div id="notify" class="collapse in accordion-inner">
                <table class="table table-bordered table-striped">
                    <tr>
                        <td class="st_cl">تعليق:</td>
                        <td class="val_st">&nbsp;<a title="todays comments" href="<?php echo base_url(); ?>home/reviews"><?php echo $this->MGeneral->convertToArabic($newcomments); ?></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="st_cl">صور:</td>
                        <td class="val_st">&nbsp;<a title="todays comments" href="<?= site_url() ?>home/useruploads"><?php echo $this->MGeneral->convertToArabic(0); ?></a></td>
                    </tr>
                    <tr>
                        <td class="st_cl">تقيم:</td>
                        <td class="val_st">&nbsp;<a title="todays comments" href="<?= site_url() ?>home/ratings"><?php echo $this->MGeneral->convertToArabic(round($latestRatings)); ?></a></td>
                    </tr>
                    <tr>
                        <td class="st_cl">توصيات المستخدم:</td>
                        <td class="val_st">&nbsp;<?php echo round($recommendations); ?></td>
                    </tr>
                </table>
            </div>
        </article>
    </div>
    <div class="row-fluid spacer">
        <article class="span12 accordion-group">
            <h2 data-toggle="collapse" class="accordion-heading " data-target="#activities"> 
                <a class="accordion-toggle inline-block" href="javascript:void(0);"> آخر الأنشطة الخاصة بك  </a> 
                <a class="normal inline-block right-float right-padding" href="<?php echo site_url('ar/home/activities'); ?>" rel="tooltip" data-original-title="عرض جميع التحديثات">عرض جميع التحديثات </a>
            </h2>
            <div id="activities" class="collapse in accordion-inner">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>تاريخ</th>
                            <th>الأنشطة</th>
                            <th>تاريخ</th>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($activities as $p) {
                            ?>
                            <tr>
                                <td><?php echo $this->MGeneral->convertToArabic($i); ?></td>
                                <td><?php echo $p['activity']; ?></td>
                                <td><?php echo $this->MGeneral->convertToArabic($p['date_add']); ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </article>
    </div>
    <div class="row-fluid spacer">
        <article class="span12 accordion-group">
            <h2 data-toggle="collapse" class="accordion-heading " data-target="#userratings"> 
                <a class="accordion-toggle inline-block" href="javascript:void(0);"> أحدث التقييمات آخر</a> 
                <a class="normal inline-block right-float right-padding" href="<?php echo site_url('ar/home/ratings'); ?>" rel="tooltip" data-original-title="عرض جميع التقييمات">عرض جميع التقييمات</a>
            </h2>
            <div id="userratings" class="collapse in accordion-inner">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="actv">معرف</th>
                            <th>اسم المستخدم</th>
                            <th class="actv">المذاق</th>
                            <th class="actv">الخدمة</th>
                            <th class="actv">الجو</th>
                            <th class="actv">التقديم</th>
                            <th class="actv">التنوع</th>
                            <th class="actv">القيمة</th>
                    </thead>
                    <tbody>
                        <?php if (isset($getlates) and !empty($getlates)) { ?>
                            <?php
                            $i = 0;
                            foreach ($getlates as $p) {
                                $i++;
                                ?>
                                <tr <?php if (isset($p['is_read'])) if ($p['is_read'] == 0) { ?> class="new-row" onclick="readRating('<?php echo $p['rating_ID'] ?>')" <?php } ?> data-row="<?php echo $p['rating_ID'] ?>" >
                                    <td align="center"><?php echo $this->MGeneral->convertToArabic($i); ?></td>
                                    <td><?php echo $this->MRestBranch->getUserName($p['user_ID']); ?></td>
                                    <td align="center"><?php echo $this->MGeneral->convertToArabic($p['rating_Food']); ?></td>
                                    <td align="center"><?php echo $this->MGeneral->convertToArabic($p['rating_Service']); ?></td>
                                    <td align="center"><?php echo $this->MGeneral->convertToArabic($p['rating_Atmosphere']); ?></td>
                                    <td align="center"><?php echo $this->MGeneral->convertToArabic($p['rating_Value']); ?></td>
                                    <td align="center"><?php echo $this->MGeneral->convertToArabic($p['rating_Presentation']); ?></td>
                                    <td align="center"><?php echo $this->MGeneral->convertToArabic($p['rating_Variety']); ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="8">&nbsp;&nbsp;لا توجد تقييمات </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </article>
    </div>
    <div class="row-fluid spacer">
        <article class="span12 accordion-group">
            <h2 data-toggle="collapse" class="accordion-heading " data-target="#usercomments"> 
                <a class="accordion-toggle inline-block" href="javascript:void(0);">آخر أحدث التعليقات </a> 
                <a class="normal inline-block right-float right-padding" href="<?php echo site_url('ar/home/comments'); ?>" rel="tooltip" data-original-title="عرض جميع التعليقات">عرض جميع التعليقات</a>
            </h2>
            <div id="usercomments" class="collapse in accordion-inner">
                <div class="link-spacer right-float">  </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>معرف</th>
                            <th>اسم المستخدم</th>
                            <th>تعليق</th>
                            <th>تاريخ التعليق </th>
                            <th width="105px">الإجراءات</th>
                    </thead>
                    <tbody>
                        <?php if (isset($latestcomments) and !empty($latestcomments)) { ?>
                            <?php
                            $i = 0;
                            foreach ($latestcomments as $p) {
                                $i++;
                                ?>
                                <tr <?php if (isset($p['is_read'])) if ($p['is_read'] == 0) { ?> class="new-row" onclick="readcomment('<?php echo $p['review_ID'] ?>')" <?php } ?> data-row="<?php echo $p['review_ID'] ?>" >
                                    <td <?php if (isset($p['review_Status'])) if ($p['review_Status'] == 0) echo 'class="strike"';  ?>><?php echo $this->MGeneral->convertToArabic($i); ?></td>
                                    <td <?php if (isset($p['review_Status'])) if ($p['review_Status'] == 0) echo 'class="strike"';  ?>><?php echo $this->MRestBranch->getUserName($p['user_ID']); ?></td>
                                    <td <?php if (isset($p['review_Status'])) if ($p['review_Status'] == 0) echo 'class="strike"';  ?> width="350px"><?php echo substr($p['review_Msg'], 0, 50); ?></td>
                                    <td <?php if (isset($p['review_Status'])) if ($p['review_Status'] == 0) echo 'class="strike"';  ?>><?php echo $this->MGeneral->convertToArabic(date("Y-m-d", strtotime($p['review_Date']))); ?></td>
                                    <td>
                                        <a href="<?php echo site_url(); ?>ar/home/response/<?php echo $p['user_ID']; ?>/<?php echo $p['review_ID']; ?>"><i class="icon icon-pencil"></i> إرسال استجابة</a>
                                        <br />
                                        <a href="<?php echo site_url('ar/home/usercommentstatus?id=' . $p['review_ID']); ?>"  rel="tooltip" data-original-title="<?php echo $p['review_Status'] == 0 ? 'أعلن' : 'لا تعلن هذا التعليق'; ?>">
                                            <i <?php echo $p['review_Status'] == 0 ? 'class="icon-ok"' : 'class="icon icon-ban-circle"'; ?>> </i> <?php echo $p['review_Status'] == 0 ? 'أعلن' : 'لا تعلن هذا التعليق'; ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php }else { ?>
                            <tr>
                                <td colspan="8">&nbsp;&nbsp;لا يوجد تعليقات </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </article>
    </div>
    <div class="row-fluid spacer">
        <article class="span12 accordion-group">
            <h2 data-toggle="collapse" class="accordion-heading " data-target="#useruploads"> 
                <a class="accordion-toggle inline-block" href="javascript:void(0);"> آخر صور المستخدم </a> 
                <a class="normal inline-block right-float right-padding" href="<?php echo site_url('ar/home/userUploads'); ?>" rel="tooltip" data-original-title=" عرض جميع الصور"> عرض جميع الصور</a>
            </h2>
            <div id="useruploads" class="collapse in accordion-inner">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>معرف</th>
                            <th>صورة معاينة</th>
                            <th>اسم المستخدم</th>
                            <th>تاريخ</th>
                            <th width="105px">الإجراءات</th>
                    </thead>
                    <tbody>
                        <?php if (isset($latestUserUpload) and !empty($latestUserUpload)) { ?>
                            <?php
                            $i = 0;
                            foreach ($latestUserUpload as $p) {
                                $i++;
                                ?>
                                <tr <?php if (isset($p['is_read'])) if ($p['is_read'] == 0) { ?> class="new-row" onclick="readPhoto('<?php echo $p['image_ID'] ?>')" <?php } ?> data-row="<?php echo $p['image_ID'] ?>" >
                                    <td <?php if (isset($p['status'])) if ($p['status'] == 0) echo 'class="strike"';  ?>><?php echo $this->MGeneral->convertToArabic($i); ?></td>
                                    <td <?php if (isset($p['status'])) if ($p['status'] == 0) echo 'class="strike"';  ?>><img src="http://uploads.azooma.co/Gallery/thumb/<?php echo $p['image_full']; ?>" width="100"/></td>
                                    <td <?php if (isset($p['status'])) if ($p['status'] == 0) echo 'class="strike"';  ?> width="350px"><?php echo $this->MRestBranch->getUserName($p['user_ID']); ?></td>
                                    <td <?php if (isset($p['status'])) if ($p['status'] == 0) echo 'class="strike"';  ?>> <?php echo $this->MGeneral->convertToArabic(date('jS M Y H:i:s', strtotime($p['enter_time']))); ?></td>
                                    <td>
                                        <a href="<?php echo site_url('ar/home/usergallerystatus?id=' . $p['image_ID']); ?>"  rel="tooltip" data-original-title="<?php echo $p['status'] == 0 ? 'تفعيل الصورة' : 'إلغاء تفعيل الصورة'; ?>">
                                            <i <?php echo $p['status'] == 0 ? 'class="icon-ok"' : 'class="icon icon-ban-circle"'; ?>> </i> <?php echo $p['status'] == 0 ? 'تفعيل' : 'إلغاء تفعيل'; ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php }else { ?>
                            <tr>
                                <td colspan="8">&nbsp;&nbsp;لا توجد صور </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </article>
    </div>
</section>
<style>
    section {
        padding-top: 10px !important;
    }
</style>