jQuery(document).ready(function($) {
    // Toggle Buttons
    $('.ahachat-toggle-button__option').click(function() {
        $(this).addClass('js-checked').siblings().removeClass('js-checked');

        if ($(this).find('span').html() == "First Reminder") {
            $("#ahachat_second_reminder").hide();
            $("#ahachat_first_reminder").show();
            $("#ahachat_third_reminder").hide();
        }
        if ($(this).find('span').html() == "Second Reminder") {
            $("#ahachat_second_reminder").show();
            $("#ahachat_first_reminder").hide();
            $("#ahachat_third_reminder").hide();
        }
        if ($(this).find('span').html() == "Third Reminder") {
            $("#ahachat_third_reminder").show();
            $("#ahachat_second_reminder").hide();
            $("#ahachat_first_reminder").hide();
        }
    });
    $('#ahachat_first_reminder_select').change(function() {
        $('#ahachat_first_reminder_text').text($(this).val());
    });
    $('#ahachat_first_reminder_select').trigger('change');
    $('#ahachat_second_reminder_select').change(function() {
        $('#ahachat_second_reminder_text').text($(this).val());
    });
    $('#ahachat_second_reminder_select').trigger('change');
    $('#ahachat_third_reminder_select').change(function() {
        $('#ahachat_third_reminder_text').text($(this).val());
    });
    $('#ahachat_third_reminder_select').trigger('change');
    // select js page when change
    $('.ahachat_list_page').change(function() {
        var page_img_selected = $(".fnone").attr("src");
        $(".ahachat_page_image").attr("src", page_img_selected);
    });
    $('.ahachat_list_page').trigger("change");
    // change when change amount
    $('#ahachat_amount').on("input", function() {
        $('#ahachat_first_amount_dependence').text($(this).val());
    });
    $('#ahachat_amount_second').on("input", function() {
        $('#ahachat_second_amount_dependence').text($(this).val());
    });

    $('.ahachat_user_add_filecsv').click(function() {
        var action_data = {
            action: 'ahachat_export_csv',
            export: true
        };
        $('#ahachat_img_export_csv').show();
        $(this).css('margin-left', '0px');
        var ahachat_home_url = $('#ahachat_home_url').val();
        //alert(ahachat_home_url);
        $.post(ajaxurl, action_data, function(result) {
            if (result) {
                $('#ahachat_img_export_csv').hide();
                $('.ahachat_user_add_filecsv').css('margin-left', '15px');
                window.location = ahachat_home_url;
                console.log(result);
            }
        });
    });
    // statistical chart
    $('select#ahachat_statistical_month').change(function() {
        var url = $('#ahachat_href_statistical').val();
        var month = $(this).val();
        var year = $('select#ahachat_statistical_year').val();
        window.location.href = url + "&month=" + month + "&year=" + year;
    });
    $('select#ahachat_statistical_year').change(function() {
        var url = $('#ahachat_href_statistical').val();
        var year = $(this).val();
        var month = $('select#ahachat_statistical_month').val();
        window.location.href = url + "&month=" + month + "&year=" + year;
    });
    // statistical chart

    $('.ahachat_allow_user_add_cart').change(function() {
        if (this.checked) {
            $(".ahachat_enable_skipit").show();
        } else {
            $(".ahachat_enable_skipit").hide();
        }
    });
    $('.ahachat_allow_user_add_cart').trigger("change");

    $('.ahachat_enable_checkbox_checkout').change(function() {

        if (this.checked) {
            $(".ahachat_enable_cb_checkout").show();
        } else {
            $(".ahachat_enable_cb_checkout").hide();
        }
    });
    $('.ahachat_enable_checkbox_checkout').trigger("change");
    // UPDATE TAB COUPON
    $("#cartback-coupon-checkall").change(function() {

        $(".cartback_hide_product").prop('checked', $(this).prop("checked"));

    });

    $("#cartback-coupon-checkall-1").change(function() {

        $(".facebook_messenger_show_page").prop('checked', $(this).prop("checked"));

    });

    $("#ahachat-cartback-display-coupon").change(function() {

        var id = $(this).val();

        if (id == "evething") {

            $("#ahachat-facebook-messenger-tr-hide").addClass("hidden");
            $("#ahachat-facebook-messenger-tr-show").addClass("hidden");

        } else if (id == "except") {

            $("#ahachat-facebook-messenger-tr-hide").removeClass("hidden");
            $("#ahachat-facebook-messenger-tr-show").addClass("hidden");

        } else if (id == "display") {
            $("#ahachat-facebook-messenger-tr-show").removeClass("hidden");
            $("#ahachat-facebook-messenger-tr-hide").addClass("hidden");
        }
    });

    $("#ahachat-cartback-display-coupon").trigger("change");

    $(".ahachat_cartback_coupon_enable").change(function() {
        if (this.checked) {
            $(".ahachat_show_tab_coupon").show();
        } else {
            // $(".ahachat_show_tab_coupon").hide();
        }
    });
    $(".ahachat_cartback_coupon_enable").trigger("change");
});