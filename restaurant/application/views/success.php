<div class="pt-2">
<ul class="breadcrumb">
        <li>
            <a href="<?php echo base_url(); ?>"><?=lang('home')?></a> <span class="divider">/</span>
        </li>
        <li class="active">Success </li>
    </ul>
    </div>
<section class="card">
<?php
echo message_box('error');
echo message_box('success');
?>

    <div class="card-body">

        <div class="success-header">
            <h1>Congratulations!</h1>
        </div>
        

        <fieldset>
            <legend>You have Requested For the Following</legend>
            <article class="left span12 accordion-group" style="margin: 0">
                <div class="">
                    <table class="table table-bordered ">
                        <tr>
                            <td class="st_cl" style="width:280px">Account</td>
                            <td class="val_st">&nbsp;<?php echo $this->session->userdata('account'); ?></td>
                        </tr>
                        <tr>
                            <td class="st_cl">Duration</td>
                            <td class="val_st">&nbsp;
                                <?php echo $this->session->userdata('duration'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="st_cl">You are Interested in.</td>
                            <td class="val_st">
                                <?php
                                $addservices = $this->session->userdata('addservices');
                                if (isset($addservices) && is_array($addservices)) {
                                    foreach ($addservices as $add => $services) {
                                        echo '&nbsp;' . $services . '<br/>';
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="st_cl">Your Message</td>
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
