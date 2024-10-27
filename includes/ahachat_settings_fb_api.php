<?php

if (!class_exists('AHACHAT_WP_SETUP_FB_API')): /****/
    class AHACHAT_WP_SETUP_FB_API {
        public function __construct() {
        ?>
<style type="text/css">

    /*#wpwrap{background: #fff;}*/

    .notice.notice-warning {
        display: none;
    }

</style>
<div class="wrap">

    <h1><?php echo __("Settings", AHACHAT_WP) ?></h1>

</div>

<div class="ahachat-fb-admin-tab-controls">


    <div class="ahachat-fb-admin-tab-control <?php if (!isset($_GET['tab'])) echo 'ahachat-fb-tab-active'; ?>"
         data-target="#ahachat-fb-tab-1"><?php echo __("Facebook Settings", AHACHAT_WP) ?></div>

    <div class="ahachat-fb-admin-tab-control"
         data-target="#ahachat-fb-tab-2"><?php echo __("Woo Settings", AHACHAT_WP) ?></div>


</div>


<form action="options.php" method="post" id="nj-fb-class" novalidate>

    <?php

    settings_fields(AHACHAT_WP);

    $ahachat_app_id = get_option('ahachat_app_id');
    $ahachat_broadcast_token = get_option('ahachat_broadcast_token');
    $ahachat_page_name = get_option('ahachat_page_name');
    $ahachat_page_id = get_option('ahachat_page_id');

    $ahachat_app_test_mode = get_option('ahachat_is_test_mode');

    $ahachat_enable_cart = get_option('ahachat_app_enable_status');

    $ahachat_enable_non_login_user = get_option('ahachat_non_login_user');

    $ahachat_enable_skipit_on_time = get_option('ahachat_is_skip_ontime');

    $ahachat_enable_checkbox_checkout = get_option('ahachat_enable_checkbox_checkout');

    $ahachat_enable_skip_checkbox = get_option('ahachat_is_skip_checkbox');

    $ahachat_app_message = get_option('ahachat_customize_message');

    //

    $ahachat_message_checkout = get_option('ahachat_customize_checkout_message');

    //

    $ahachat_custom_skipit = get_option('ahachat_skip_message');

    $ahachat_enable_alow_user_add_cart = get_option('ahachat_allow_user_add_cart');

    /**/

    $ahachat_first_reminder = get_option('ahachat_first_reminder');

    $ahachat_second_reminder = get_option('ahachat_second_reminder');

    $ahachat_third_reminder = get_option('ahachat_third_reminder');

    /*****update******/


    $ahachat_customize_coupon = get_option('ahachat_coupon_customize');

    /*****coupon*********/

    $ahachat_text_send = get_option('ahachat_text_send');

    $ahachat_coupon = get_option('ahachat_coupons');


    $cart_ahachat_hide_product = get_option('ahachat_hide_product');

    $cart_ahachat_show_product = get_option('ahachat_show_product');

    ?>

    <?php if (!get_option('ahachat_customize_message')) {
        $ahachat_app_message = "Please opt in the checkbox below to receive special offers in the future (optional)";
    }

    ?>

    <?php if (!get_option('ahachat_customize_checkout_message')) {
        $ahachat_message_checkout = "Please opt in the checkbox below to receive special coupon in the next purchase";
    }

    ?>

    <?php if (!get_option('ahachat_skip_message')) {
        $ahachat_custom_skipit = "skip it";
    }

    ?>

    <?php if (!empty($ahachat_first_reminder)): ?>

        <?php if (isset($ahachat_first_reminder['hour']) && !empty($ahachat_first_reminder['hour'])): ?>

            <input type="hidden" name="ahachat_first_reminder[hour]"
                   value="<?php echo $ahachat_first_reminder['hour']; ?>">

        <?php endif; ?>

        <?php if (isset($ahachat_first_reminder['on_of']) && $ahachat_first_reminder['on_of'] == "on"): ?>

            <input type="hidden" name="ahachat_first_reminder[on_of]"
                   value="<?php echo $ahachat_first_reminder['on_of']; ?>">

        <?php endif; ?>

        <?php if (isset($ahachat_first_reminder['something'])) : ?>

            <input type="hidden" name="ahachat_first_reminder[something]"
                   value="<?php echo $ahachat_first_reminder['something']; ?>">

        <?php endif; ?>

        <?php if (isset($ahachat_first_reminder['checkout'])) : ?>

            <input type="hidden" name="ahachat_first_reminder[checkout]"
                   value="<?php echo $ahachat_first_reminder['checkout']; ?>">

        <?php endif; ?>

    <?php endif; ?>

    <?php if (!empty($ahachat_second_reminder)): ?>

        <?php if (isset($ahachat_second_reminder['hour']) && !empty($ahachat_second_reminder['hour'])): ?>

            <input type="hidden" name="ahachat_second_reminder[hour]"
                   value="<?php echo $ahachat_second_reminder['hour']; ?>">

        <?php endif; ?>

        <?php if (isset($ahachat_second_reminder['on_of']) && $ahachat_second_reminder['on_of'] == "on"): ?>

            <input type="hidden" name="ahachat_second_reminder[on_of]"
                   value="<?php echo $ahachat_second_reminder['on_of']; ?>">

        <?php endif; ?>

        <?php if (isset($ahachat_second_reminder['something'])) : ?>

            <input type="hidden" name="ahachat_second_reminder[something]"
                   value="<?php echo $ahachat_second_reminder['something']; ?>">

        <?php endif; ?>

        <?php if (isset($ahachat_second_reminder['checkout'])) : ?>

            <input type="hidden" name="ahachat_second_reminder[checkout]"
                   value="<?php echo $ahachat_second_reminder['checkout']; ?>">

        <?php endif; ?>

    <?php endif; ?>

    <?php if (!empty($ahachat_third_reminder)): ?>

        <?php if (isset($ahachat_third_reminder['hour']) && !empty($ahachat_third_reminder['hour'])): ?>

            <input type="hidden" name="ahachat_third_reminder[hour]"
                   value="<?php echo $ahachat_third_reminder['hour']; ?>">

        <?php endif; ?>

        <?php if (isset($ahachat_third_reminder['on_of']) && $ahachat_third_reminder['on_of'] == "on"): ?>

            <input type="hidden" name="ahachat_third_reminder[on_of]"
                   value="<?php echo $ahachat_third_reminder['on_of']; ?>">

        <?php endif; ?>

        <?php if (isset($ahachat_third_reminder['something'])) : ?>

            <input type="hidden" name="ahachat_third_reminder[something]"
                   value="<?php echo $ahachat_third_reminder['something']; ?>">

        <?php endif; ?>

        <?php if (isset($ahachat_third_reminder['checkout'])) : ?>

            <input type="hidden" name="ahachat_third_reminder[checkout]"
                   value="<?php echo $ahachat_third_reminder['checkout']; ?>">

        <?php endif; ?>

    <?php endif; ?>



    <?php if (!empty($ahachat_customize_coupon)): ?>

        <?php if (isset($ahachat_customize_coupon['box_width']) && !empty($ahachat_customize_coupon['box_width'])): ?>

            <input type="hidden" name="ahachat_coupon_customize[box_width]"
                   value="<?php echo $ahachat_customize_coupon['box_width']; ?>">

        <?php endif; ?>

        <?php if (isset($ahachat_customize_coupon['title_color']) && !empty($ahachat_customize_coupon['title_color'])): ?>

            <input type="hidden" name="ahachat_coupon_customize[title_color]"
                   value="<?php echo $ahachat_customize_coupon['title_color']; ?>">

        <?php endif; ?>

        <?php if (isset($ahachat_customize_coupon['subtitle_color']) && !empty($ahachat_customize_coupon['title_color'])): ?>

            <input type="hidden" name="ahachat_coupon_customize[subtitle_color]"
                   value="<?php echo $ahachat_customize_coupon['subtitle_color']; ?>">

        <?php endif; ?>

        <?php if (isset($ahachat_customize_coupon['background_color'])) : ?>

            <input type="hidden" name="ahachat_coupon_customize[background_color]"
                   value="<?php echo $ahachat_customize_coupon['background_color']; ?>">

        <?php endif; ?>


        <?php if (isset($ahachat_customize_coupon['border_size'])) : ?>

            <input type="hidden" name="ahachat_coupon_customize[border_size]"
                   value="<?php echo $ahachat_customize_coupon['border_size']; ?>">

        <?php endif; ?>

        <?php if (isset($ahachat_customize_coupon['border_style'])) : ?>

            <input type="hidden" name="ahachat_coupon_customize[border_style]"
                   value="<?php echo $ahachat_customize_coupon['border_style']; ?>">

        <?php endif; ?>

        <?php if (isset($ahachat_customize_coupon['border_color'])) : ?>

            <input type="hidden" name="ahachat_coupon_customize[border_color]"
                   value="<?php echo $ahachat_customize_coupon['border_color']; ?>">

        <?php endif; ?>


    <?php endif; ?>

    <!-- coupon-->

    <?php if (!empty($ahachat_text_send)): ?>

        <input type="hidden" name="ahachat_text_send"
               value="<?php echo (isset($ahachat_text_send)) ? $ahachat_text_send : ''; ?>">

    <?php endif; ?>

    <?php if (!empty($ahachat_coupon)): ?>

        <?php if (isset($ahachat_coupon['enable'])) : ?>

            <input type="hidden" name="ahachat_coupons[enable]"
                   value="<?php echo (isset($ahachat_coupon['enable'])) ? 'on' : ''; ?>">

        <?php endif; ?>

        <input type="hidden" name="ahachat_coupons[title]"
               value="<?php echo (isset($ahachat_coupon['title'])) ? $ahachat_coupon['title'] : '15% Discount'; ?>">

        <input type="hidden" name="ahachat_coupons[sub_title]"
               value="<?php echo (isset($ahachat_coupon['sub_title'])) ? $ahachat_coupon['sub_title'] : 'Get your 15% discount now by subscribing to our newsletter in facebook messenger. Just click the blue button below.'; ?>">

        <input type="hidden" name="ahachat_coupons[display]"
               value="<?php echo (isset($ahachat_coupon['display'])) ? $ahachat_coupon['display'] : 'evething'; ?>">

    <?php endif; ?>

    <?php if (!empty($cart_ahachat_hide_product)): ?>

        <input type="hidden" name="ahachat_hide_product"
               value="<?php echo (isset($cart_ahachat_hide_product)) ? $cart_ahachat_hide_product : ''; ?>">

    <?php endif; ?>

    <?php if (!empty($cart_ahachat_show_product)): ?>

        <input type="hidden" name="ahachat_show_product"
               value="<?php echo (isset($cart_ahachat_show_product)) ? $cart_ahachat_show_product : ''; ?>">

    <?php endif; ?>


    <div style="padding-top: 20px" class="ahachat-fb-admin-tab-contents">

        <div id="ahachat-fb-tab-1"
             class="ahachat-fb-admin-tab-content <?php if (!isset($_GET['tab'])) echo 'ahachat-fb-tab-active'; ?>">

            <table class="form-table">

                <tr class="">

                    <th scope="row">

                        <label for="">Broadcast Api Token</label>

                    </th>

                    <td>
                        <input type="hidden" class="regular-text" name="ahachat_app_id"
                                                       value="<?php echo empty($ahachat_app_id) ? '' : $ahachat_app_id; ?>" required>

                        <input type="text" class="regular-text" name="ahachat_broadcast_token"
                               value="<?php echo empty($ahachat_broadcast_token) ? '' : $ahachat_broadcast_token; ?>" required>

                        <p class="description" id="connect-page-name">
                            <?php if (!empty($ahachat_page_name) && !empty($ahachat_broadcast_token)): ?>
                                Connected page <b><?php echo $ahachat_page_name?></b>
                            <?php else: ?>
                                Settings -> General -> Broadcasting API Token
                            <?php endif ?>
                        </p>

                        <input type="hidden" class="regular-text" name="ahachat_page_name"
                               value="<?php echo empty($ahachat_page_name) ? '' : $ahachat_page_name; ?>" required>

                        <input type="hidden" class="regular-text" name="ahachat_page_id"
                               value="<?php echo empty($ahachat_page_id) ? '' : $ahachat_page_id; ?>" required>

                        <?php $url_webhooks=home_url()."/callback?callback_abd_cart=webhook";
                              $url_webhooks=str_replace ("http://","https://", $url_webhooks);
                        ?>
                        <input style="width: 80%;" type="hidden" readonly="readonly" class="ahachat_webhooks" value="<?php echo $url_webhooks;?>">
                    </td>

                </tr>


            </table>

            <?php submit_button("Save Changes") ?>

        </div>

        <div id="ahachat-fb-tab-2" class="ahachat-fb-admin-tab-content">


            <table class="form-table">


                <tr class="ahachat_show_tab_cartback_setting">

                    <th scope="row">

                        <label for="">Checkbox under Add to cart button</label>

                    </th>

                    <td>

                        <label class="ahachat-switch-button">

                            <!-- checked=""-->

                            <input <?php if ($ahachat_enable_cart == "on") echo "checked='checked'"; ?>
                                    name="ahachat_app_enable_status"
                                    class="ahachat-switch-button-input ahachat_app_enable_status" type="checkbox"/>

                            <span class="ahachat-switch-button-label" data-on="On" data-off="Off"></span>

                            <span class="ahachat-switch-button-handle"></span>

                        </label>

                        <p class="description">Enable to show Messenger checkbox under <strong>Add to cart</strong>
                            button</p>

                    </td>

                </tr>

                <tr class="ahachat_show_tab_cartback_setting">

                    <th scope="row">

                        <label for="">Allow add to cart without checking Messenger checkbox for non-login users</label>

                    </th>

                    <td>

                        <label class="ahachat-switch-button">

                            <!-- checked=""-->

                            <input <?php if ($ahachat_enable_non_login_user == "on") echo "checked='checked'"; ?>
                                    name="ahachat_non_login_user"
                                    class="ahachat-switch-button-input ahachat_non_login_user" type="checkbox"/>

                            <span class="ahachat-switch-button-label" data-on="On" data-off="Off"></span>

                            <span class="ahachat-switch-button-handle"></span>

                        </label>

                        <p class="description">Allow add to cart without checking Messenger box for non-login users</p>

                    </td>

                </tr>

                <tr class="ahachat_show_tab_cartback_setting">

                    <th scope="row">

                        <label for="">Message asking users to add to cart</label>

                    </th>

                    <td>

                        <input type="text" class="regular-text" id="ahachat_customize_message"
                               name="ahachat_customize_message"
                               value="<?php echo empty($ahachat_app_message) ? '' : $ahachat_app_message; ?>" required>

                    </td>

                </tr>


                <tr class="ahachat_app_enable_disable">

                    <th scope="row" style="/*padding-left: 20px*/">

                        <label for="">Add skip it</label>

                    </th>

                    <td>

                        <label class="ahachat-switch-button">

                            <input <?php if ($ahachat_enable_alow_user_add_cart == "on") echo "checked='checked'"; ?>
                                    name="ahachat_allow_user_add_cart"
                                    class="ahachat-switch-button-input ahachat_allow_user_add_cart"
                                    type="checkbox"/>

                            <span class="ahachat-switch-button-label" data-on="On" data-off="Off"></span>

                            <span class="ahachat-switch-button-handle"></span>

                        </label>

                        <p class="description">Enable to allow add to cart without Messenger checkbox by clicking on
                            Skip it text instead</p>

                    </td>

                </tr>

                <tr class="ahachat_enable_skipit">

                    <th scope="row">

                        <label for="">Skip it text</label>

                    </th>

                    <td>

                        <input type="text" class="regular-text" id="ahachat_skip_message"
                               name="ahachat_skip_message"
                               value="<?php echo empty($ahachat_custom_skipit) ? '' : $ahachat_custom_skipit; ?>">

                    </td>

                </tr>


                <tr class="">

                    <th scope="row">

                        <label for="">Display Skip it first time only</label>

                    </th>

                    <td>

                        <label class="ahachat-switch-button">

                            <!-- checked=""-->

                            <input <?php if ($ahachat_enable_skipit_on_time == "on") echo "checked='checked'"; ?>
                                    name="ahachat_is_skip_ontime"
                                    class="ahachat-switch-button-input ahachat_is_skip_ontime"
                                    type="checkbox"/>

                            <span class="ahachat-switch-button-label" data-on="On" data-off="Off"></span>

                            <span class="ahachat-switch-button-handle"></span>

                        </label>

                        <p class="description">Enable to let users click Skip it at the first time only</p>

                    </td>

                </tr>

                <tr class="">

                    <th scope="row">

                        <label for="">Skip Checkbox</label>

                    </th>

                    <td>

                        <label class="ahachat-switch-button">

                            <!-- checked=""-->

                            <input <?php if ($ahachat_enable_skip_checkbox == "on") echo "checked='checked'"; ?>
                                    name="ahachat_is_skip_checkbox"
                                    class="ahachat-switch-button-input ahachat_is_skip_checkbox" type="checkbox"/>

                            <span class="ahachat-switch-button-label" data-on="On" data-off="Off"></span>

                            <span class="ahachat-switch-button-handle"></span>

                        </label>

                        <p class="description">Enable to skip required checkbox when add to cart</p>

                    </td>

                </tr>

                <tr class="ahachat_app_enable_disable">

                    <th scope="row" style="/*padding-left: 20px*/">

                        <label for="">Add Checkbox at Checkout</label>

                    </th>

                    <td>

                        <label class="ahachat-switch-button">

                            <input <?php if ($ahachat_enable_checkbox_checkout == "on") echo "checked='checked'"; ?>
                                    name="ahachat_enable_checkbox_checkout"
                                    class="ahachat-switch-button-input ahachat_enable_checkbox_checkout" type="checkbox"/>

                            <span class="ahachat-switch-button-label" data-on="On" data-off="Off"></span>

                            <span class="ahachat-switch-button-handle"></span>

                        </label>

                        <p class="description">Enable to show Messenger checkbox at Checkout page</p>

                    </td>

                </tr>

                <tr class="ahachat_enable_cb_checkout">

                    <th scope="row">

                        <label for="">Message asking users to check out</label>

                    </th>

                    <td>

                        <input type="text" class="regular-text" id="ahachat_customize_checkout_message"
                               name="ahachat_customize_checkout_message"
                               value="<?php echo empty($ahachat_message_checkout) ? '' : $ahachat_message_checkout; ?>" required>

                    </td>

                </tr>

                <tr class="">

                    <th scope="row">

                        <label for="">Test Mode</label>

                    </th>

                    <td>

                        <label class="ahachat-switch-button">

                            <!-- checked=""-->

                            <input <?php if ($ahachat_app_test_mode == "on") echo "checked='checked'"; ?>
                                    name="ahachat_is_test_mode"
                                    class="ahachat-switch-button-input ahachat_is_test_mode" type="checkbox"/>

                            <span class="ahachat-switch-button-label" data-on="On" data-off="Off"></span>

                            <span class="ahachat-switch-button-handle"></span>

                        </label>

                        <p class="description">The message will be sent to your Messenger inbox immediately after you
                            click <strong>Add to cart</strong> button to test</p>

                    </td>

                </tr>


            </table>

            <?php submit_button("Save Changes") ?>

        </div>


        <div id="ahachat-fb-tab-3"
             class="ahachat-fb-admin-tab-content <?php if (isset($_GET['tab']) && $_GET['tab'] == 'product-license') echo 'ahachat-fb-tab-active'; ?>">
        </div>


    </div>

</form>


<script type="text/javascript">

    jQuery(document).ready(function ($) {

        $('.ahachat-fb-admin-tab-control').on('click', function () {


            $('.ahachat-fb-admin-tab-control').removeClass('ahachat-fb-tab-active');


            $('.ahachat-fb-admin-tab-content').removeClass('ahachat-fb-tab-active');


            $(this).addClass('ahachat-fb-tab-active');


            $($(this).data('target')).addClass('ahachat-fb-tab-active');


            return false


        });


        $('#ahachat-fb-tab-1').find('#submit').prop('disabled', true);
        $('input[name=ahachat_broadcast_token]').on('input', function() {
            $.post('<?php echo AHACHAT_BASE_URL ?>wp-cart/setting', {ahachat_broadcast_token: $(this).val(), origin: window.location.origin}, function(result) {
                if (result && result.data) {
                    $('input[name=ahachat_app_id]').val(result.data.app_id);
                    $('input[name=ahachat_page_id]').val(result.data.fb_id);
                    $('input[name=ahachat_page_name]').val(result.data.name);
                    $('#connect-page-name').html('Token valid. Page name: <b>' + result.data.name + '</b>');
                    $('#ahachat-fb-tab-1').find('#submit').prop('disabled', false);
                }
            }).fail(function() {
                $('#ahachat-fb-tab-1').find('#submit').prop('disabled', true);
                $('#connect-page-name').html('Go Settings > General > Broadcasting API Token to get code.');
            });
        });
    });

</script>

<?php
           }
       }
   endif;
   new AHACHAT_WP_SETUP_FB_API();
?>
