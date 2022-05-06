<section id="top-banner">
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
        </li>
        <li class="active">عملائي </li>
    </ul>
    <div class="right-float">
        <span class="btn-left-margin right-float">
        </span>
    </div>
    <div class="row-fluid spacer">
        <article class="left span12 accordion-group">
            <h2 data-toggle="collapse" class="accordion-heading " data-target="#results">
                <div class="accordion-toggle" href="javascript:void(0);">
                    <h4 class="inline-block">
                        <?php echo $pagetitle.'  ('.$this->MGeneral->convertToArabic($totallikedpeople).')'; ?> 
                        <span style=" margin-right: 25px;font-size: 14px;">    
                        متابعين (<?php echo $this->MGeneral->convertToArabic(count($likedpeople)); ?>)
                        </span>
                        <span style=" margin-right: 25px;font-size: 14px;">    
                        مستخدمين
                        (<?php
                        $guests = $totallikedpeople - count($likedpeople);
                        echo $this->MGeneral->convertToArabic($guests);
                        ?>)
                        </span>
                    </h4>
                    <?php /*?><select class="auto-width sort-by-head" name="sortby" id="sortby" onchange="return sortByDiners(this.value);">
                        <option value="">Sort by</option>
                        <option value="mostactive" <?php if(isset($sortby) && $sortby =="mostactive"){ echo 'selected="selected"'; } ?>>Most Active</option>
                        <option value="location" <?php if(isset($sortby) && $sortby =="location"){ echo 'selected="selected"'; } ?>>City</option>
                        <option value="Male" <?php if(isset($sortby) && $sortby =="Male"){ echo 'selected="selected"'; } ?>>Male</option>
                        <option value="female" <?php if(isset($sortby) && $sortby =="female"){ echo 'selected="selected"'; } ?>>Female</option>
                    </select>
                    <?php */ ?>

                    <a class="right-float btn btn-info link-heading" href="<?php echo site_url('ar/mydiners/dinermessages'); ?>"> <img src="<?php echo site_url('images/messages20.png'); ?>" alt=""/> سجل</a>
                    <?php if($member['allowed_messages']>0){ ?>
                    <a class="right-float btn btn-inverse link-heading" href="<?php echo site_url('ar/mydiners/sendMessage'); ?>"> <i class="icon-envelope icon-white"></i> ارسل رسالة </a>
                    <?php }else{ ?>
                    <a class="right-float btn btn-inverse link-heading" href="<?php echo site_url('ar/accounts'); ?>"> <i class="icon-envelope icon-white"></i> رسائل تأكيد الشرا </a>
                    <?php } ?>
                </div>
            </h2>
            <div id="resultsss" class="collapse in accordion-inner">
                <?php
                if ($this->session->flashdata('error')) {
                    echo '<br /><div class="alert alert-error"><a class="close" data-dismiss="alert">x</a><strong>' . $this->session->flashdata('error') . '</strong></div>';
                }
                if ($this->session->flashdata('message')) {
                    echo '<br /><div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong>' . $this->session->flashdata('message') . '</strong></div>';
                }
                ?>
                <form class="no-margin" name="diner-form" id="diner-form" method="post" action="<?php echo site_url('ar/mydiners/sendMessage'); ?>">
<!--                    <div class="">
                        <a href="#">Latest</a> |
                        <a href="#">Oldest</a>
                    </div>-->
                    <div class="overflow customer-main" >

                        <?php
                        if (count($likedpeople) > 0) {
                            foreach ($likedpeople as $person) {
                                $userimage = $person['image'];
                                if ($userimage == "") {
                                    $userimage = 'user-default.svg';
                                }
                                ?>
                                <div class="overflow customer">

                                    <a class="customer-title" target="_blank" title="<?php echo $person['user_NickName'] == "" ? $person['user_FullName'] : $person['user_NickName']; ?>" href="<?php echo $this->config->item('sa_url') . ('user/' . $person['user_ID']); ?>">
                                        <?php echo $person['user_NickName'] == "" ? $person['user_FullName'] : $person['user_NickName']; ?>
                                    </a>

                                    <a target="_blank" class="customer-body" title="<?php echo $person['user_NickName'] == "" ? $person['user_FullName'] : $person['user_NickName']; ?>" href="<?php echo $this->config->item('sa_url') . ('user/' . $person['user_ID']); ?>">
                                        <img src="http://uploads.azooma.co/images/userx130/<?php echo $userimage; ?>" alt="<?php echo $person['user_NickName'] == "" ? $person['user_FullName'] : $person['user_NickName']; ?>" width="100" height="100" style="min-width:100px;width:100px;min-height:100px;height:100px;"/>
                                    </a>
                                    <span>
                                        منذ <?php echo $this->MGeneral->convertToArabic(date('Y', strtotime($person['createdAt']))); ?>
                                        <?php
                                        if (!empty($person['user_City'])) {
                                            if (!is_numeric($person['user_City'])) {
                                                echo " | " . $person['user_City'];
                                            } else {
                                                $city = "";
                                                $city = $this->MGeneral->getCity($person['user_City']);
                                                if (is_array($city)) {
                                                    echo " | " . $city['city_Name_ar'];
                                                }
                                            }
                                        }
                                        ?>
                                    </span>
                                    <div>
                                        <input class="icon-seprate msg-class hidden" type="checkbox" name="msg[]" value="<?php echo $person['user_ID']; ?>">
                                        <?php 
                                        if(isset($person['action']) && $person['action']=="review"){
                                        ?>
                                        <a target="_blank" title="إظهار <?php echo $person['user_NickName'] == "" ? $person['user_FullName'] : $person['user_NickName']; ?>" href="<?php echo $this->config->item('sa_url') . ('rest/'.$rest['seo_url'].'#comment-' . $person['actionID']); ?>"><i class="icon-comment  icon-seprate"></i></a>
                                        <?php } ?>
                                        <a target="_blank" title="إظهار <?php echo $person['user_NickName'] == "" ? $person['user_FullName'] : $person['user_NickName']; ?>" href="<?php echo $this->config->item('sa_url') . ('user/' . $person['user_ID']); ?>"><i class="icon-user icon-seprate"></i></a>
                                        <a title="ارسل رسالة <?php echo $person['user_NickName'] == "" ? $person['user_FullName'] : $person['user_NickName']; ?>" href="<?php echo site_url('ar/mydiners/sendMessage?user_ID='.$person['user_ID']); ?>"><i class="icon-envelope "></i></a>
                                    </div>
                                </div>
                                <?php
                            }
                            $guests = $totallikedpeople - count($likedpeople);
                            ?>
                            <div class="overflow customer guest-customer">
                                <div>
                                    زائر  <?php echo $this->MGeneral->convertToArabic($guests); ?>  لديك 
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="control-group submit-class hidden">
                        <div class="controls">
                            <input type="submit" name="submit" value="Submit" class="btn btn-primary right-float">
                        </div>
                    </div>
                    <div class="control-group margin-bottom">
                    </div>
                </form>
            </div>
        </article>
    </div>
</section>
<script>
    function sortByDiners(ivalue) {
        if (ivalue == "" || ivalue == "0") {
            //do nothing
        } else {
            document.location = base + "ar/mydiners?sortby=" + ivalue;
        }
    }

    function sendMessageToDinners(ivalue) {
        if (ivalue == "" || ivalue == "0") {
            //do nothing
            $('.msg-class').addClass('hidden');
            $('.submit-class').addClass('hidden');
        } else if (ivalue == "4") {
            //select individuals
            $('.msg-class').removeClass('hidden');
            $('.submit-class').removeClass('hidden');
        } else {
            document.location = base + "ar/mydiners/sendMessage?diner=" + ivalue;
        }
    }
</script>