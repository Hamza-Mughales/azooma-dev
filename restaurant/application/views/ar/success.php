
<section id="top-banner">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('ar'); ?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
        </li>
        <li class="active">التهاني </li>
    </ul>
    <div class="row-fluid spacer">

        <div class="success-header">
            <h1>التهاني!</h1>
        </div>
        <div class="alert alert-success">
            <strong>
                شكرا لك على طلبك. أحد أعضاء المبيعات سيكون معكم قريبا
            </strong>
        </div>

        <fieldset>
            <legend>لقد طلبت ما يلي</legend>
            <article class="left span12 accordion-group" style="margin: 0">
                <div class="collapse in accordion-inner">
                    <table class="table table-bordered ">
                        <tr>
                            <td class="st_cl" style="width:280px">حدد حسابك</td>
                            <td class="val_st">&nbsp;
                                <?php
                                $account = $this->session->userdata('account');
                                if ($account == 'Bronze') {
                                    echo 'البرونزي';
                                } elseif ($account == 'Silver') {
                                    echo 'الفضي';
                                } elseif ($account == 'Gold') {
                                    echo 'الذهبي';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="st_cl">حدد المدة</td>
                            <td class="val_st">&nbsp;
                                <?php
                                $duration = $this->session->userdata('duration');
                                if ($duration == '3') {
                                    echo 'ثلاثة أشهر';
                                } elseif ($duration == '6') {
                                    echo 'ستة أشهر';
                                } elseif ($duration == '12') {
                                    echo 'سنة واحدة';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="st_cl">أنت مهتما</td>
                            <td class="val_st">
                                <?php
                                $addservices = $this->session->userdata('addservices');
                                if (isset($addservices) && is_array($addservices)) {
                                    foreach ($addservices as $add => $services) {
                                        if ($services == 'HD Video Services') {
                                            echo '&nbsp; خدمات الفيديو <br/>';
                                        } elseif ($services == 'Web Designing & Development') {
                                            echo '&nbsp; تصميم وتطوير الويب<br/>';
                                        } elseif ($services == 'Menu Design') {
                                            echo '&nbsp; القائمة التصميم<br/>';
                                        } elseif ($services == 'Photography Services') {
                                            echo '&nbsp; خدمات التصوير الفوتوغرافي<br/>';
                                        } elseif ($services == 'Branding') {
                                            echo '&nbsp; العلامات التجارية<br/>';
                                        }
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="st_cl">هل لديكم أي أسئلة</td>
                            <td class="val_st">&nbsp;
                                <?php echo $this->session->userdata('msg'); ?>
                            </td>
                        </tr>
                    </table> 
                </div>
            </article>
        </fieldset>

    </div>
</section>
