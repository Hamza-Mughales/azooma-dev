<div class="breadcrumb-div">
<ul class="breadcrumb">
        <li>
            <a href="<?php echo base_url('home'); ?>"><?=lang('Dashboard')?></a> <span class="divider">/</span>
        </li>
        <li class="active"><?=lang('my_diner')?> </li>
    </ul>
</div>
<?php
echo message_box('error');
echo message_box('success');
?>
<section id="top-banner">
 

    <div class="row-fluid spacer">
            <h2 data-toggle="collapse" class="accordion-heading " data-target="#results">
                <div class="accordion-toggle" href="javascript:void(0);">
                    <h4 class="d-inline-block">
                        <?php echo $pagetitle . '  (' . $total_diner . ')'; ?>
                      
                    

                    </h4>
             

                    <span class="float-end">
                        <a class="right-float btn btn-primary link-heading" href="<?php echo base_url('mydiners/dinermessages'); ?>"> <img src="<?php echo base_url('images/messages20.png'); ?>" alt=""/> <?=lang('History')?></a>
                        <?php if ($member['allowed_messages'] > 0) {?>
                        <a class="right-float btn btn-danger link-heading" href="<?php echo base_url('mydiners/sendMessage'); ?>"> <i class="icon-envelope icon-white"></i> <?=lang('send_msg')?> </a>
                        <?php } else {?>
                        <a class="right-float btn btn-primary link-heading" href="<?php echo base_url('accounts'); ?>"> <i class="icon-envelope icon-white"></i> <?=lang('purchase_messages')?> </a>
                        <?php }?>
                    </span>
                </div>
            </h2>
 
            </div>
    
</section>


<section class="container-fluid">
    <div class="row my-3">
        <div class="col-md-5">
            <input placeholder="<?=lang('search')?>" type="text" id="diner-search" class="form-control" />
        </div>
    </div>
<div class="row staff-grid-row"  id="diners-list" >
<div class="col-md-12 text-center">
    <div class="text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>

</div>

</div>
</section>
<div class="row">
    <div class="col-12">
        <div class="text-center my-3">
            <button style="display:none" class="btn btn-sm btn-primary see-more" id="load_more-btn" onclick="load_more();"><i class="mdi mdi-spin mdi-loading me-1"></i> <?= lang('view_more') ?> <i class="fa  fa-arrow-left"></i> </button>
        </div>
    </div> <!-- end col-->
</div>
<input type="hidden" id="total_records" value="0" />
<input type="hidden" id="offset" value="0" />

<script type="text/javascript">
    $(document).ready(function() {
        refresh_diners_list();
    });

    function get_diners_uri() {
        var uri = "";
        return uri;
    }

    function getdiners() {
        var total_records = $("#total_records").val();
        var offset = $("#offset").val();
        var data = {
            iDisplayLength: 8,
            iDisplayStart: offset
        };
        var url = "<?= base_url("mydiners/get_diners_grid_filter?status=1") ?>" + get_diners_uri();
        $.post(url, data, function(result) {
            $("#diners-list").append(result.data);
            $("#total_records").val(result.total_records);
            $("#offset").val(result.offset);
            $("#load_more-btn").prop("disabled", false);
            if (result.total_records < result.offset + 8) {
                $("#load_more-btn").hide();
            } else {
                $("#load_more-btn").show();

            }
            $("#load_more-btn").html('<?= lang('view_more') ?> <i class="fa  fa-arrow-left"></i>');
            $("#left-sidebar").niceScroll({
            cursorcolor:'#ccc',
          cursorwidth:"12px",
          railalign: 'right'
        });
        });
    }

    function refresh_diners_list() {
        var total_records = $("#total_records").val();
        var offset = 0;
        var search = $("#diner-search").val();
        var data = {
            iDisplayLength: 8,
            iDisplayStart: offset,
            sSearch: search
        };
        var url = "<?= base_url("mydiners/get_diners_grid_filter?status=1") ?>" + get_diners_uri();
        $.post(url, data, function(result) {
            $("#diners-list").html(result.data);
            $("#total_records").val(result.total_records);
            $("#offset").val(result.offset);
            if (result.total_records < result.offset + 8) {
                $("#load_more-btn").hide();
            } else {
                $("#load_more-btn").show();

            }
         
        });
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#diner-search").on('change', function(ev) {
            refresh_diners_list();
        });


        $("#diner-search").on('keypress', function(ev) {
            refresh_diners_list();
        });
        $("#diner-search").on('keydown', function(ev) {
            refresh_diners_list();
        });
    });

    function load_more() {
        var offset = parseInt($("#offset").val());
        offset = parseInt(offset) + 8;
        $("#load_more-btn").html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>')
        $("#offset").val(offset);
        $("#load_more-btn").prop("disabled", true);

        getdiners();


    }
</script>
<script>
    function sortByDiners(ivalue) {
        if (ivalue == "" || ivalue == "0") {
            //do nothing
        } else {
            document.location = base + "mydiners?sortby=" + ivalue;
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
            document.location = base + "mydiners/sendMessage?diner=" + ivalue;
        }
    }
</script>