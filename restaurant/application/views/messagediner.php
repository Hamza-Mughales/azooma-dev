<div class="breadcrumb-div">
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo base_url('home'); ?>"><?= lang('Dashboard') ?></a> <span class="divider">/</span>
        </li>
        <li class="breadcrumb-item">
            <a href="<?php echo base_url('mydiners'); ?>"><?= lang('my_diner') ?></a> <span class="divider">/</span>
        </li>
        <li class="active"> <?php echo $pagetitle; ?> </li>
    </ul>
</div>
<?php
echo message_box('error');
echo message_box('success');
?>
<section id="top-banner">

    <div class="right-float">
        <span class="btn-left-margin right-float">
        </span>
    </div>
    <div class="card">

        <div id="resultsss" class="card-body">
            <h5>
                <?php echo $pagetitle; ?> <span class="right-float" style=" font-size: 16px; ">(<?php echo $member['allowed_messages']; ?> <?= lang('credits_remaining') ?>)</span>

            </h5>
            <form class="form-horizontal restaurant-form no-margin" name="diner-form" id="diner-form" method="post" action="<?php echo base_url('mydiners/savemessage'); ?>" enctype="multipart/form-data">
                <div class="form-group row">
                    <label class="col-md-2 control-label" for=""><?= lang('to') ?></label>
                    <div class="col-md-9">
                        <?php
                        if (isset($user) && !empty($user)) {
                            echo $user['user_NickName'] == "" ? $user['user_FullName'] : $user['user_NickName'];
                        ?>
                            <input type="hidden" name="user_ID" value="<?php echo $user['user_ID']; ?>">
                            <input type="hidden" name="audienceType" value="<?php echo $audienceType; ?>">
                        <?php
                        } else {
                        ?>
                            <select class="form-control" required name="audienceType" id="audienceType" onchange="sendMessageToDinners(this.value);">
                                <option value=""><?= lang('select_receivers') ?> ...</option>
                                <option value="2" <?php
                                                    if (isset($event) && $event['audienceType'] == '2') {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>><?= lang('all_diners') ?> </option>
                                <option value="3" <?php
                                                    if (isset($event) && $event['audienceType'] == '3') {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>><?= lang('selected_diners') ?> </option>

                            </select>

                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div id="selected-diners" class="selected-diners d-none">
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for=""><?= lang('selected_diners') ?></label>
                        <div class="col-md-9">

                            <select class="form-control select2" name="diners[]" multiple>
                                <?php
                                $recipients = isset($event['recipients']) ? explode(",", $event['recipients']) : [];

                                foreach ($diners as $d) {
                                ?>
                                    <option value="<?= $d->user_ID ?>" <?= in_array($d->user_ID, $recipients) ? "selected" : "" ?>> <?= $d->user_FullName ?></option>
                                <?php } ?>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="subject"><?= lang('subject') ?></label>
                    <div class="col-md-9">
                        <input type="text" name="subject" class="form-control" required id="subject" placeholder="<?= lang('subject') ?>" <?php echo isset($event) ? 'value="' . (htmlspecialchars($event['subject'])) . '"' : ""; ?> />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="message"> <?= lang('message') ?><br><span class="small-font">500 <?= lang('char_allowed') ?></span></label>
                    <div class="col-md-9">
                        <textarea required class="form-control" name="message" id="message" rows="10" placeholder="<?= lang('message') ?>"><?php echo isset($event) ? $event['message'] : ""; ?></textarea>

                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label" for="message"> <?= lang('image') ?> <br><span class="small-font">(640*500)</span></label>
                    <div class="col-md-9">
                        <input type="file" class="form-control" name="image" id="image">
                        <?php if (isset($event) && !empty($event['image'])) { ?>
                            <input type="hidden" name="image_old" value="<?php echo $event['image']; ?>">
                            <a href="<?php echo base_url('images/' . $event['image']); ?>">
                                <img src="<?php echo base_url('images/' . $event['image']); ?>" width="100px" alt="" /></a>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group row text-start">
                    <div class="col-md-2"></div>
                    <div class="col-md-5">
                        <?php if (isset($event)) { ?>
                            <input type="hidden" name="status" value="<?php echo $event['status']; ?>">
                            <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
                        <?php } ?>
                        <button type="submit" name="submit" value="Preview" class="btn btn-primary"><?= lang('preview') ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<style>
    .restaurant-form .col-md-12 control-label {
        width: 100px;
    }

    .restaurant-form .col-md-12 {
        margin-left: 110px;
    }

    input,
    textarea,
    select {
        width: 500px;
    }

    form .counter {
        margin-left: 10px;
        font-size: 14px;
        font-weight: bold;
        color: #ccc;
        display: block;
    }

    form .warning {
        color: #600;
    }

    form .exceeded {
        color: #e00;
    }
</style>


<script type="text/javascript">
    // $("#diner-form").validate();

    function sendMessageToDinners(ivalue) {
        console.log(ivalue);
        if (ivalue == "" || ivalue == "0") {
            $('.selected-diners').addClass('d-none');
        } else if (ivalue == "3") {
            //select individuals
            $('.selected-diners').removeClass('d-none');
        } else {
            $('.selected-diners').addClass('d-none');
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
    $(document).ready(function() {
        $('.select2').select2();
        var val = $("#audienceType").val();
        if (val == "" || val == "0") {
            $('.selected-diners').addClass('d-none');
        } else if (val == "3") {
            //select individuals
            $('.selected-diners').removeClass('d-none');
        } else {
            $('.selected-diners').addClass('d-none');
        }
    });
</script>