
<div class="pt-3">
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo base_url('home'); ?>"><?=lang('Dashboard')?></a> <span class="divider">/</span>
        </li>
        <li class="active"><?=lang('account_settings')?> </li>
    </ul>
</div>
<?php
echo message_box('error');
echo message_box('success');
?>
<section class="card">



    <div class="card-body">
            <h4 >
                    <?php echo $pagetitle; ?> 
            </h4>
            <div id="results">



                <form id="memberForm" class="form-horizontal restaurant-form" method="post" action="<?php echo base_url('settings/save'); ?>" enctype="multipart/form-data">
                    <fieldset>

                        <div class="form-group row mt-2">
                            <label class="control-label col-md-3 col-md-2" for="full_name"> <?=lang('contact_person')?></label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="full_name" id="full_name" placeholder="<?=lang('contact_person')?>" <?php echo isset($member) ? 'value="' . $member['full_name'] . '"' : ""; ?> />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 col-md-2" for="phone"> <?=lang('contact_number')?></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="<?=lang('contact_number')?>" <?php echo isset($member) ? 'value="' . $member['phone'] . '"' : ""; ?> />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-12" for="email"> <?=lang('contact_emails')?></label>
                            <div class="col-md-12 sufrati-backend-input-seperator" id="account-emails">
                                <?php if (isset($member)) {
                                    $memberemails = explode(',', $member['email']);

                                    for ($i = 0; $i < count($memberemails); $i++) {
                                ?>
                                        <div class="row my-2" >
                                        <div class="col-4">
                                            <input class="form-control" type="text" name="emails[]" placeholder="<?=lang('contact_email')?>" <?php echo isset($memberemails) ? 'value="' . $memberemails[$i] . '"' : ""; ?> />
                                        </div>
                                        <div class="col-6">
                                        <a class="btn mt-2 btn-danger email-remove py-0 px-1" href="javascript:void(0);" data-dismiss="input-<?php echo $i; ?>">&times;</a>
                                        </div>
                                        </div>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <div id="input-0">
                                        <input class="form-control" type="text" name="emails[]" placeholder="<?=lang('contact_email')?>" />
                                    </div>
                                <?php } ?>
                        </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <a href="#" class="btn btn-sm  btn-primary" title="Add another email" onclick="addMoreEmail();"><i class="fa fa-plus"></i> </a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 col-md-2" for="preferredlang"> <?=lang('preferred_lang')?></label>
                            <div class="col-md-3 col-md-2">
                                <select class="form-control" name="preferredlang" id="preferredlang">
                                    <option value="0" <?php if (isset($member)) {
                                                            if ($member['preferredlang'] == 0) echo 'selected="selected"';
                                                        } ?>><?=lang('English')?></option>
                                    <option value="1" <?php if (isset($member)) {
                                                            if ($member['preferredlang'] == 1) echo 'selected="selected"';
                                                        } ?>><?=lang('arabic')?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 col-lg-1" for="status"><?=lang('publish')?></label>
                            <div class="col-md-9">
                                <input  type="checkbox" <?php if (!isset($member['status']) || $member['status'] == 1) echo 'checked="checked"'; ?> name="status" value="1" />
                            </div>
                        </div>
                        <div class="form-group row text-end">
                            <div class="col-md-12">
                                
                                    <input type="hidden" name="rest_ID" value="<?php echo rest_id(); ?>" />
                                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>" />
                             
                                <input type="submit" name="submit" value="<?=lang('save')?>" class="btn btn-primary" />
                                <a href="<?php if (isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER'];
                                            else echo base_url('settings'); ?>" class="btn" title="Cancel Changes"><?=lang('cancel')?></a>
                            </div>
                        </div>
                    </fieldset>
                </form>


                <script type="text/javascript">
                    <?php if (isset($member)) {
                        if ($member['email'] != "") {
                    ?>
                            counter = <?php echo count($memberemails); ?>;
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
                            "emails[]": {
                                required: true,
                                email: true
                            },
                            full_name: "required",
                            phone: "required"
                        }
                    });
        
                </script>

            </div>

    </div>
</section>
<script>

$('body').on('click', '.email-remove', function() {
        $(this).parent().parent().remove();
    });

    function addMoreEmail() {
        var html = '   <div class="row my-2" ><div class="col-4">'+
        ' <input class="form-control" type="text" name="emails[]" placeholder="Contact Email"  />'+
                                       ' </div>'+
                                        '<div class="col-6">'+
                                        '<a class="btn mt-2 btn-danger email-remove py-0 px-1" href="javascript:void(0);" >&times;</a>'+
                                        '</div></div>';
    
        $("#account-emails").append(html);

    }
    
</script>