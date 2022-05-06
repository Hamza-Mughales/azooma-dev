<section id="top-banner">
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('ar');?>"> الصفحه الرئيسية </a> <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo site_url('ar/mydiners'); ?>">عملائي</a> <span class="divider">/</span>
        </li>
        <li class="active"> <?php echo $pagetitle; ?> </li>
    </ul>
    <div class="right-float">
        <span class="btn-left-margin right-float">
        </span>
    </div>
    <div class="row-fluid spacer">
        <article class="left span12 accordion-group">
            <h2 data-toggle="collapse" class="accordion-heading " data-target="#results">
                <a class="accordion-toggle" href="javascript:void(0);">
                    <?php echo $pagetitle; ?> <span class="right-float" style=" font-size: 16px; ">( تبقى  <?php echo $this->MGeneral->convertToArabic($member['allowed_messages']); ?> كريديت)</span>
                </a>
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
                <form class="form-horizontal restaurant-form no-margin" name="diner-form" id="diner-form" method="post" action="<?php echo site_url('mydiners/savemessage'); ?>" enctype="multipart/form-data">
                    <div class="control-group">
                        <label class="control-label" for="">إلى</label>
                        <div class="controls">
                            <?php
                            if (isset($user) && !empty($user)) {
                                echo $user['user_NickName'] == "" ? $user['user_FullName'] : $user['user_NickName'];
                                ?>
                                <input type="hidden" name="user_ID"  value="<?php echo $user['user_ID']; ?>">
                                <input type="hidden" name="audienceType"  value="<?php echo $audienceType; ?>">
                                <?php
                            } else {
                                ?>
                                <select class="required" name="audienceType" id="audienceType" onchange="return sendMessageToDinners(this.value);">
                                    <option value="">إختر مستقبلون </option>
                                    <option value="2" <?php
                                    if (isset($event) && $event['audienceType'] == '2') {
                                        echo 'selected="selected"';
                                    }
                                    ?> >كل العملا </option>
                                    <option value="3" <?php
                                    if (isset($event) && $event['audienceType'] == '3') {
                                        echo 'selected="selected"';
                                    }
                                    ?> >العملاء المختارون </option>
                                    <!--                                    <option value="3">All Diners Who like Your Page  </option>
                                                                        <option value="4">All Diners Who Commented on Your Page  </option>
                                                                        <option value="5">All Diners Who Rated on Your Page  </option>-->
                                </select>
                                <div id="selected-diners" <?php
                                if (isset($event) && $event['audienceType'] == '3') {
                                    
                                } else {
                                    echo 'class="hidden"';
                                }
                                ?>>
                                         <?php
                                         if (count($likedpeople) > 0) {
                                             foreach ($likedpeople as $person) {
                                                 $userimage = $person['image'];
                                                 if ($userimage == "") {
                                                     $userimage = 'user-default.svg';
                                                 }
                                                 ?>
                                            <div id="customer" data-id="<?php echo $person['user_ID']; ?>" class="overflow customer cust-main-div cust">
                                                <div>
                                                    <a class="customer-title" title="<?php echo $person['user_NickName'] == "" ? $person['user_FullName'] : $person['user_NickName']; ?>" href="#">
                                                        <?php echo $person['user_NickName'] == "" ? $person['user_FullName'] : $person['user_NickName']; ?>
                                                    </a>
                                                    <a class="customer-body" title="<?php echo $person['user_NickName'] == "" ? $person['user_FullName'] : $person['user_NickName']; ?>" href="#">
                                                        <img src="http://uploads.azooma.co/images/userx130/<?php echo $userimage; ?>" alt="<?php echo $person['user_NickName'] == "" ? $person['user_FullName'] : $person['user_NickName']; ?>" width="100" height="100" style="min-width:100px;width:100px;min-height:100px;height:100px;"/>
                                                    </a>
                                                    <span>
                                                        Since <?php echo date('Y', strtotime($person['createdAt'])); ?>
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
                                                </div>
                                                <?php
                                                $class = "hidden";
                                                $checked = '';
                                                if (isset($event) && $event['recipients']) {
                                                    if (strpos($event['recipients'], ",")) {
                                                        $arr = explode(",", $event['recipients']);
                                                        if (in_array($person['user_ID'], $arr)) {
                                                            $class = "";
                                                            $checked = 'checked="checked"';
                                                        }
                                                    } elseif (!empty($event['recipients'])) {
                                                        if ($event['recipients'] == $person['user_ID']) {
                                                            $class = "";
                                                            $checked = 'checked="checked"';
                                                        }
                                                    }
                                                }
                                                ?>
                                                <div class="<?php echo $class; ?> cust-mouseover" id="cust-<?php echo $person['user_ID']; ?>" data-id="<?php echo $person['user_ID']; ?>">
                                                    <input <?php echo $checked; ?> class="icon-seprate" id="msg-<?php echo $person['user_ID']; ?>" type="checkbox" name="msg[]" value="<?php echo $person['user_ID']; ?>">                                                    
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="subject">العنوان</label>
                        <div class="controls">
                            <input type="text" name="subject" class="required" id="subject" placeholder="العنوان" <?php echo isset($event) ? 'value="' . (htmlspecialchars($event['subject'])) . '"' : ""; ?> />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="message"> رسالة<br><span class="small-font">مسموح لـ 500 شخصية</span></label>
                        <div class="controls">
                            <textarea class="required" name="message" id="message" rows="10" placeholder="رسالة"><?php echo isset($event) ? $event['message'] : ""; ?></textarea>
                            
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="message"> الصور <br><span class="small-font">(640*500)</span></label>
                        <div class="controls">
                            <input type="file" name="image" id="image">
                            <?php if(isset($event) && !empty($event['image'])){?>
                            <input type="hidden" name="image_old" value="<?php echo $event['image']; ?>">
                            <a href="<?php echo site_url('images/'.$event['image']); ?>"> <img src="<?php echo site_url('images/'.$event['image']); ?>" width="100" alt=""/></a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <?php if (isset($event)) { ?>
                                <input type="hidden" name="status" value="<?php echo $event['status']; ?>">
                                <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
                            <?php } ?>
                            <input type="submit" name="submit" value="إظهار" class="btn btn-primary">
                            <a href="<?php echo site_url(); ?>" class="btn" title="إلغاء ">إلغاء </a>
                        </div>
                    </div>
                </form>
            </div>
        </article>
    </div>
</section>
<style>
    .restaurant-form .control-label {
        width: 100px;
    }
    .restaurant-form .controls{
        margin-left: 110px;
    }
    input, textarea, select {
        width: 500px;
    }
    
    form .counter{
        margin-left: 10px;
        font-size:14px;
        font-weight:bold;
        color:#ccc;
        display: block;
    }
    form .warning{color:#600;}	
    form .exceeded{color:#e00;}	

</style>


<script type="text/javascript">
    $("#newsletterForm").validate();

    function sendMessageToDinners(ivalue) {
        if (ivalue == "" || ivalue == "0") {
            $('#selected-diners').addClass('hidden');
        } else if (ivalue == "3") {
            //select individuals
            $('#selected-diners').removeClass('hidden');
        } else {
            $('#selected-diners').addClass('hidden');
        }
    }


    $(document).ready(function() {
        var id = 0;
        $('.cust-main-div').mouseover(function() {
            id = $(this).attr('data-id');
            if ($('#msg-' + id).is(':checked')) {
                //nothing
            } else {
                $('#cust-' + id).removeClass('hidden');
            }
        });

        $('.cust-main-div').mouseout(function() {
            if ($('#msg-' + id).is(':checked')) {
                //nothing
            } else {
                $('#cust-' + id).addClass('hidden');
            }
        });

        $('.cust-mouseover').click(function(e) {
            e.preventDefault();
            id = $(this).attr('data-id');
            if ($('#msg-' + id).is(':checked')) {
                $('#cust-' + id).addClass('hidden');
                $('#msg-' + id).attr("checked", false);
            } else {
                $('#cust-' + id).removeClass('hidden');
                $('#msg-' + id).attr("checked", "checked");
            }
        });



    });
    
    $(document).ready(function(){	
        $("#message").charCount({
            allowed: 500,		
            warning: 20,
            counterText: 'Characters left: '	
        });
    });


</script>

