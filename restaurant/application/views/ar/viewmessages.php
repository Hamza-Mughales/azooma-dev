<section id="top-banner">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo site_url('ar/mydiners'); ?>">عملائي</a> <span class="divider">/</span>
        </li>
        <li class="active"> الرسائل </li>
    </ul>
    <div class="row-fluid spacer">
        <article class="span12 accordion-group">
            <h2 data-toggle="collapse" class="accordion-heading " data-target="#usercomments"> <a class="accordion-toggle" href="javascript:void(0);"> كل الرسائل للعملاء <i class="icon icon-chevron-down icon-dashboard-widget right-float"></i> </a> </h2>
            <div id="usercomments" class="collapse in accordion-inner">
                <?php
                if ($this->session->flashdata('error')) {
                    echo '<br /><div class="alert alert-error"><a class="close" data-dismiss="alert">x</a><strong>' . $this->session->flashdata('error') . '</strong></div>';
                }
                if ($this->session->flashdata('message')) {
                    echo '<br /><div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong>' . $this->session->flashdata('message') . '</strong></div>';
                }
                ?>

                <?php
                if (count($total) > 0) {
                    echo $this->pagination->create_links();
                }
                ?> 
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>العنوان</th>
                            <th>الجمهور</th>
                            <th>الحالة</th>
                            <th>المجموع</th>
                            <th>التاريخ</th>
                            <th width="105px">نشاط</th>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($messages) and !empty($messages)) {

                            $i = 0;
                            foreach ($messages as $message) {
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $message['subject']; ?></td>
                                    <td><?php
                                        if ($message['audienceType'] == "1") {
                                            if(!empty($message['recipients'])){
                                                $person = $this->MRestBranch->getUser($message['recipients']);
                                                $name = $person['user_NickName'] == "" ? $person['user_FullName'] : $person['user_NickName'];
                                            }
                                            echo "مستخدم واحد - ".$name;
                                        } elseif ($message['audienceType'] == "2") {
                                            echo "كل العملاء";
                                        } elseif ($message['audienceType'] == "3") {
                                            echo "إختر مستقبلون";
                                        }
                                        ?></td>
                                    <td><?php 
                                    if($message['status']>0){
                                        echo 'تم الإرسال ';
                                    }else{
                                        echo 'في الإنتظار';
                                    }
                                    ?></td>
                                    <td><?php echo $this->MGeneral->convertToArabic($message['total_receiver']); ?></td>
                                    <td><?php echo $this->MGeneral->convertToArabic(date("d/m/Y",  strtotime($message['date']))); ?></td>
                                    <td>
                                        <a target="_blank" href="<?php echo site_url('ar/mydiners/view/' . $message['id']); ?>"  rel="tooltip" data-original-title="<?php echo $message['subject'];?>">
                                            <i class="icon-edit"> </i> اظهر
                                        </a>
                                        <?php if($message['status']==0){ ?>
                                        <br />
                                        <a href="<?php echo site_url('ar/mydiners/edit/' . $message['id']); ?>"  rel="tooltip" data-original-title="<?php echo $message['subject'];?>">
                                            <i class="icon-edit"> </i> عدِّل
                                        </a>
                                        <?php } ?>
                                    </td>                                        

                                </tr>

                            <?php } ?>
                        <?php } else { ?>
                            <tr><td colspan="8">
                                    &nbsp;&nbsp; لم يتم إنشاء رسالة
                                </td></tr>       
                        <?php } ?>                  
                    </tbody>
                </table>
            </div>

            <?php
            if (count($total) > 0) {
                echo $this->pagination->create_links();
            }
            ?>
        </article>
    </div>
</section>
