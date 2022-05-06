function sendDraft(iva) {
    calculate_total_price();
    if (iva == 0) {
        $('#is_draft').val('yes');
        $('#invoiceForm').submit();
    } else {
        $('#is_draft').val('');
        $('#invoiceForm').submit();
    }
}

$(document).ready(function() {
    $("#invoiceForm").validate({
        submitHandler: function(myform) {
            var Q = "";
            if ($('#total_price').val() == "") {
                $('#total-price-error').removeClass('hidden');
                Q = "1111";
            } else if ($('#total_price').val() == "0" || $('#total_price').val() == "NaN") {
                $('#total-price-error').removeClass('hidden');
                Q = "1111";
            } else {
                $('#total-price-error').addClass('hidden');
            }

            if ($('#payment_option').val() == "2") {
                var down_payment = $('#down_payment').val();
                var monthly_price = $('#monthly_price').val();
                var installment_duration = $('#installment_duration').val();
                var vtotal = $('#total_price').val();
                vtotal = parseInt(vtotal);
                down_payment = parseInt(down_payment);
                monthly_price = parseInt(monthly_price);
                installment_duration = parseInt(installment_duration);
                var tmp = monthly_price * installment_duration;
                tmp = down_payment + tmp;
                if (tmp == vtotal) {
                    $('#inst-price-error').addClass('hidden');
                } else {
                    Q = "1111";
                    $('#inst-price-error').removeClass('hidden');
                }
            }

            if (Q == "") {
                myform.submit();
                return true;
            } else {
                return false;
            }
        }
    });
})
var creative_servic = 0;
var advert = 0;
var total = 0;
var itotal = 0;
var discount_price = 0;
function calculate_total_price() {
    var subscription_price = spot_light_video = hi_light_video = top_banner = bottom_banner = home_page_slider = 0;
    var horizon_banner = bottom_banner_home = horizon_banner_second = gold_box_banner = sliver_box_banner = bronze_box_banner = 0;
    var sponsorship_banner = horizon_banner_third = logo_box = banner_design = 0;
    if ($('#subscription_yes').is(':checked')) {
        subscription_price = $("#subscription_price").val();
    }

    if ($('#spot_light_video').is(':checked')) {
        spot_light_video = $("#spot_light_video_value").val();
    }
    if ($('#hi_light_video').is(':checked')) {
        hi_light_video = $("#hi_light_video_value").val();
    }
    if ($('#banner_design').is(':checked')) {
        banner_design = $("#banner_design_value").val();
    }



    if ($('#top_banner').is(':checked')) {
        top_banner = $("#top_banner_value").val();
    }
    if ($('#bottom_banner').is(':checked')) {
        bottom_banner = $("#bottom_banner_value").val();
    }
    if ($('#home_page_slider').is(':checked')) {
        home_page_slider = $("#home_page_slider_value").val();
    }
    if ($('#horizon_banner').is(':checked')) {
        horizon_banner = $("#horizon_banner_value").val();
    }
    if ($('#bottom_banner_home').is(':checked')) {
        bottom_banner_home = $("#bottom_banner_home_value").val();
    }
    if ($('#horizon_banner_second').is(':checked')) {
        horizon_banner_second = $("#horizon_banner_second_value").val();
    }
    if ($('#gold_box_banner').is(':checked')) {
        gold_box_banner = $("#gold_box_banner_value").val();
    }
    if ($('#sliver_box_banner').is(':checked')) {
        sliver_box_banner = $("#sliver_box_banner_value").val();
    }
    if ($('#bronze_box_banner').is(':checked')) {
        bronze_box_banner = $("#bronze_box_banner_value").val();
    }

    if ($('#sponsorship_banner').is(':checked')) {
        sponsorship_banner = $("#sponsorship_banner_value").val();
    }
    if ($('#horizon_banner_third').is(':checked')) {
        horizon_banner_third = $("#horizon_banner_third_value").val();
    }
    if ($('#logo_box').is(':checked')) {
        logo_box = $("#logo_box_value").val();
    }

    creative_servic = parseInt(spot_light_video) + parseInt(hi_light_video) + parseInt(banner_design);
    advert = parseInt(top_banner) + parseInt(bottom_banner) + parseInt(home_page_slider) + parseInt(horizon_banner) + parseInt(bottom_banner_home) + parseInt(horizon_banner_second) + parseInt(gold_box_banner) + parseInt(sliver_box_banner) + parseInt(bronze_box_banner) + parseInt(sponsorship_banner) + parseInt(horizon_banner_third) + parseInt(logo_box);
    itotal = parseInt(subscription_price) + parseInt(creative_servic) + parseInt(advert);
    discount_price = $("#discount_price").val();
    if (discount_price == "") {
        discount_price = 0;
    }
    total = parseInt(itotal) - parseInt(discount_price);
    $('#total-price').html(total + ' SAR');
    $('#sub-total-price').html(itotal + ' SAR');
    $('#total_price').val(total);
}


function view_invoice() {
    $("#ref-no").html($('#reference_number').val());
    $("#creative-id").html(creative_servic + ' SAR');
    $("#advertising-id").html(advert + ' SAR');
    $("#discount-id").html(discount_price + ' SAR');
    $("#total-id").html(total + ' SAR');
    $("#sub-total-id").html(itotal + ' SAR');
    $('#invoice-date-div').html($('#invoice_date').val());
    if ($('#subscription_yes').is(':checked')) {
        $("#subscribe-price").html($("#subscription_price").val() + ' SAR');
    } else {
        $("#subscribe-price").html('0' + ' SAR');
    }

    if ($('#payment_option').val() == 2) {
        $("#payment-option-id").html('Monthly Payment');
        $("#down-payment-tr").removeClass('hidden');
        $("#monthly-payment-tr").removeClass('hidden');
        $("#duration-payment-tr").removeClass('hidden');
        $("#down-payment-id").html($('#down_payment').val() + ' SAR');
        $("#monthly-payment-id").html($('#monthly_price').val() + ' SAR');
        $("#duration-payment-id").html($('#installment_duration').val() + ' SAR');
    } else {
        $("#payment-option-id").html('Full Payment');
        $("#down-payment-tr").addClass('hidden');
        $("#monthly-payment-tr").addClass('hidden');
        $("#duration-payment-tr").addClass('hidden');
    }
}

function select_packge(i_val) {
    console.log(i_val);
    if (i_val == 2) {
        $('#id_startup_price').removeClass('hidden');
        $('#id_monthly_price').removeClass('hidden');
        $('#installment_duration_div').removeClass('hidden');
    } else {
        $('#id_startup_price').addClass('hidden');
        $('#id_monthly_price').addClass('hidden');
        $('#installment_duration_div').addClass('hidden');
        $('#down_payment').val('');
        $('#monthly_price').val('');
        $('#installment_duration').val('');
    }
}

$("#invoice_date").datepicker({dateFormat: 'yy-mm-dd'});
