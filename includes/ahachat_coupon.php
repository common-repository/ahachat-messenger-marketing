<?php
if (!class_exists('AHACHAT_WP_COUPON')): /****/
    class AHACHAT_WP_COUPON {
        public function __construct() {
        ?>
<div class="wrap">
    <h1>Coupon Settings</h1>
</div>

<?php if (isset($_GET['settings-updated'])): ?>

    <div style="margin-left: 0px;margin-top: 15px;" class="notice notice-success is-dismissible">
        <p><?php _e('Save changed!', AHACHAT_WP); ?></p>
    </div>


<?php endif; ?>

<form action="options.php" method="post" id="nj-fb-class">

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
    $ahachat_message_checkout = get_option('ahachat_customize_checkout_message');
    $ahachat_custom_skipit = get_option('ahachat_skip_message');
    $ahachat_enable_alow_user_add_cart = get_option('ahachat_allow_user_add_cart');
    $ahachat_first_reminder = get_option('ahachat_first_reminder');
    $ahachat_second_reminder = get_option('ahachat_second_reminder');
    $ahachat_third_reminder = get_option('ahachat_third_reminder');

    /**
     * shortcode
     */
    $ahachat_customize_coupon = get_option('ahachat_coupon_customize');


    /**
     * coupon
     */
    $ahachat_text_send = get_option('ahachat_text_send');
    $ahachat_coupon = get_option('ahachat_coupons');

    ?>

    <div style="padding-top: 20px" class="ahachat-fb-admin-tab-contents">

        <input type="hidden" name="ahachat_app_id" value="<?php echo $ahachat_app_id ?>">
        <input type="hidden" name="ahachat_broadcast_token" value="<?php echo $ahachat_broadcast_token ?>">
        <input type="hidden" name="ahachat_page_name" value="<?php echo $ahachat_page_name ?>">
        <input type="hidden" name="ahachat_page_id" value="<?php echo $ahachat_page_id ?>">
        <input type="hidden" name="ahachat_is_test_mode" value="<?php echo $ahachat_app_test_mode; ?>">
        <input type="hidden" name="ahachat_app_enable_status" value="<?php echo $ahachat_enable_cart; ?>">
        <input type="hidden" name="ahachat_non_login_user" value="<?php echo $ahachat_enable_non_login_user; ?>">
        <input type="hidden" name="ahachat_is_skip_ontime" value="<?php echo $ahachat_enable_skipit_on_time; ?>">
        <input type="hidden" name="ahachat_enable_checkbox_checkout" value="<?php echo $ahachat_enable_checkbox_checkout; ?>">
        <input type="hidden" name="ahachat_is_skip_checkbox" value="<?php echo $ahachat_enable_skip_checkbox; ?>">
        <input type="hidden" name="ahachat_allow_user_add_cart" value="<?php echo $ahachat_enable_alow_user_add_cart; ?>">
        <input type="hidden" name="ahachat_customize_message" value="<?php echo $ahachat_app_message; ?>">
        <input type="hidden" name="ahachat_customize_checkout_message" value="<?php echo $ahachat_message_checkout; ?>">
        <input type="hidden" name="ahachat_skip_message" value="<?php echo $ahachat_custom_skipit; ?>">

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

        <div>
            <table class="form-table">
                <tr class="">
                    <th scope="row">
                        <label for="">Add "Get Coupon code" box after Add to cart button</label>
                    </th>

                    <td>
                        <label class="ahachat-switch-button">
                            <input <?php if (isset($ahachat_coupon['enable']) && $ahachat_coupon['enable'] == "on") echo "checked='checked'"; ?>
                                    name="ahachat_coupons[enable]"
                                    class="ahachat-switch-button-input ahachat_cartback_coupon_enable" type="checkbox"/>
                            <span class="ahachat-switch-button-label" data-on="On" data-off="Off"></span>
                            <span class="ahachat-switch-button-handle"></span>
                        </label>
                    </td>
                </tr>
            </table>
            <table class="form-table ahachat_show_tab_coupon">
                <tr>
                    <th scope="row">
                        <label for="">Coupon Title</label>
                    </th>
                    <td>
                        <input type="text" class="regular-text" id="ahachat_coupons[title]"
                               name="ahachat_coupons[title]"
                               value="<?php echo (isset($ahachat_coupon) && isset($ahachat_coupon['title'])) ? $ahachat_coupon['title'] : '15% Discount'; ?>">
                        <input id="ahachat_title_coupon_color" type="text" class="regular-text"
                               name="ahachat_coupon_customize[title_color]"
                               value="<?php echo isset($ahachat_customize_coupon['title_color']) ? $ahachat_customize_coupon['title_color'] : '#444444'; ?>">
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="">Coupon Content</label>
                    </th>
                    <td>
                        <input id="ahachat_coupons[sub_title]" type="text" class="regular-text"
                               name="ahachat_coupons[sub_title]"
                               value="<?php echo (isset($ahachat_coupon) && isset($ahachat_coupon['sub_title'])) ? $ahachat_coupon['sub_title'] : 'Get your 15% discount now by clicking the blue button below. You will receive coupon in your Messenger inbox.'; ?>">
                        <input id="ahachat_subtitle_coupon_customize_color" type="text" class="regular-text"
                               name="ahachat_coupon_customize[subtitle_color]"
                               value="<?php echo isset($ahachat_customize_coupon['subtitle_color']) ? $ahachat_customize_coupon['subtitle_color'] : '#727272'; ?>">
                    </td>
                </tr>

                <tr class="ahachat_show_tab_customize">
                    <th scope="row">
                        <label for="">Box style</label>
                    </th>

                    <td>
                        <table class="form-table">
                            <tr class="ahachat_show_tab_customize">
                                <th scope="row" style="padding-top: 0;">Width</th>
                                <td style="padding-top: 0;"><input id="ahachat_customzie_coupon_box_width" style="width: 100px;" type="text"
                                     class="regular-text" name="ahachat_coupon_customize[box_width]"
                                      value="<?php echo isset($ahachat_customize_coupon['box_width']) ? $ahachat_customize_coupon['box_width'] : 390; ?>">(px)</td>
                            </tr>

                            <tr class="ahachat_show_tab_customize">
                                <th scope="row">
                                    <label for="">Background Color</label>
                                </th>
                                <td>
                                    <input id="ahachat_background_coupon_box_color" type="text" class="regular-text"
                                       name="ahachat_coupon_customize[background_color]"
                                       value="<?php echo isset($ahachat_customize_coupon['background_color']) ? $ahachat_customize_coupon['background_color'] : '#fffcc9'; ?>">
                                </td>
                            </tr>
                        </table>
                        <table class="form-table">
                            <tr class="ahachat_show_tab_customize">
                                <th scope="row">
                                    <label for="">Border</label>
                                </th>
                            </tr>

                            <tr class="ahachat_show_tab_customize">
                                <th style="padding-left: 10px;" scope="row">
                                    <label for="">- Size</label>
                                </th>
                                <td>
                                    <input id="ahachat_customzie_coupon_border_size" style="width: 100px" type="text"
                                           class="regular-text" name="ahachat_coupon_customize[border_size]"
                                           value="<?php echo isset($ahachat_customize_coupon['border_size']) ? $ahachat_customize_coupon['border_size'] : 2; ?>">(px)
                                </td>
                            </tr>


                            <tr class="ahachat_show_tab_customize">
                                <th style="padding-left: 10px;" scope="row">
                                    <label for="">- Style</label>
                                </th>
                                <td>
                                    <select id="ahachat_customzie_coupon_border_style"
                                            name="ahachat_coupon_customize[border_style]">
                                        <?php
                                            if (!isset($ahachat_customize_coupon['border_style']) || empty($ahachat_customize_coupon['border_style'])) {
                                                $ahachat_customize_coupon['border_style'] = 'dashed';
                                            }
                                        ?>
                                        <?php foreach (ahachat_cartback_border_style() as $key => $gender) { ?>
                                            <option <?php if ($key == $ahachat_customize_coupon['border_style']) echo 'selected="selected"'; ?>
                                                value="<?php echo $key; ?>"><?php echo $gender; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>


                            <tr class="ahachat_show_tab_customize">
                                <th style="padding-left: 10px;" scope="row">
                                    <label for="">- Color</label>
                                </th>
                                <td>
                                    <input id="ahachat_border_coupon_color" type="text" class="regular-text"
                                        name="ahachat_coupon_customize[border_color]"
                                        value="<?php echo isset($ahachat_customize_coupon['border_color']) ? $ahachat_customize_coupon['border_color'] : '#e8dc86'; ?>">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="">Coupon Message</label>
                    </th>
                    <td>
                        <textarea id="ahachat_text_send" name="ahachat_text_send"
                                  style="width: 50%"><?php if (!empty($ahachat_text_send)) echo $ahachat_text_send; else echo 'Thanks for your subscribing! 😍'; ?></textarea>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label><?php echo __("Display on", AHACHAT_WP) ?></label></th>
                    <td>
                        <select style="width: 300px;" name="ahachat_coupons[display]"
                                id="ahachat-cartback-display-coupon">
                            <option <?php if (isset($ahachat_coupon) && $ahachat_coupon['display'] == "evething") echo "selected='selected'"; ?>
                                    value="evething"><?php echo __("Display on all product pages", AHACHAT_WP) ?></option>
                            <option <?php if (isset($ahachat_coupon) && $ahachat_coupon['display'] == "except") echo "selected='selected'"; ?>
                                    value="except"><?php echo __("Display on all product pages but except", AHACHAT_WP) ?></option>
                            <option <?php if (isset($ahachat_coupon) && $ahachat_coupon['display'] == "display") echo "selected='selected'"; ?>
                                    value="display"><?php echo __("Display on product pages...", AHACHAT_WP) ?></option>
                        </select>
                        <p class="description"><?php echo __("Select pages you want to display(If it is not displayed, please make sure you selected 'Display all product pages but except' option)...", AHACHAT_WP) ?></p>
                    </td>
                </tr>

                <tr valign="top" id="ahachat-facebook-messenger-tr-hide" class="<?php if ($display == 1) {
                    echo 'hidden';
                } ?> ">
                    <th scope="row">
                        <label for="cartback_hide_product"><?php echo __("Display all product pages but except", AHACHAT_WP) ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="cartback-coupon-checkall"/> <label
                                for="cartback-coupon-checkall">All</label>
                        <ul id="cartback_hide_product" class="cartback_hide_product">
                            <?php $new = new WP_Query(array("posts_per_page" => -1, "post_type" => "product"));
                                $array_hide = get_option("ahachat_hide_product");
                                if (!$array_hide) {
                                    $array_hide = array();
                                }

                                while ($new->have_posts()) : $new->the_post();

                            ?>

                                <li><input <?php
                                    if (in_array(get_the_ID(), $array_hide)) {
                                        echo 'checked="checked"';
                                    }
                                    ?> name="ahachat_hide_product[]" class="cartback_hide_product" type="checkbox"
                                       value="<?php the_ID() ?>" id="cartback_hide_product_<?php the_ID() ?>"/> <label
                                            for="cartback_hide_product_<?php the_ID() ?>"><?php the_title() ?></label>
                                </li>
                            <?php
                                endwhile;
                                wp_reset_postdata();
                            ?>

                        </ul>
                        <p class="description"><?php _e("Select product page you want to display coupon but except", AHACHAT_WP); ?></p>
                    </td>
                </tr>


                <tr valign="top" id="ahachat-facebook-messenger-tr-show" class="<?php if ($display != 1) {
                    echo 'hidden';
                } ?> ">
                    <th scope="row"><label
                                for="cartback_show_product"><?php echo __("Display on product page", AHACHAT_WP) ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="cartback-coupon-checkall-1"/> <label
                                for="cartback-coupon-checkall-1">All</label>
                        <ul id="facebook_messenger_show_page" class="facebook_messenger_show_page">

                            <?php
                                $new = new WP_Query(array("posts_per_page" => -1, "post_type" => "product"));
                                $array_show = get_option("ahachat_show_product");
                                if (!get_option("ahachat_show_product")) {
                                    $array_show = array();
                                }

                                 while ($new->have_posts()) : $new->the_post();

                                ?>

                                <li><input <?php
                                    if (in_array(get_the_ID(), $array_show)) {
                                        echo 'checked="checked"';
                                    }
                                    ?> name="ahachat_show_product[]" class="facebook_messenger_show_page"
                                       type="checkbox" value="<?php the_ID() ?>"
                                       id="facebook_messenger_show_page_<?php the_ID() ?>"/> <label
                                            for="facebook_messenger_show_page_<?php the_ID() ?>"><?php the_title() ?></label>
                                </li>

                            <?php
                                endwhile;
                                wp_reset_postdata();
                            ?>
                        </ul>
                        <p class="description"><?php _e("Select product page you want to display coupon", AHACHAT_WP); ?></p>
                    </td>
                </tr>
            </table>
            <div class='ahachat-widget-preview-content ahachat_show_tab_coupon'>
                <div class='ahachat-cartback-widget'>
                    <h2 class='ahachat-cartback-widget__title'><?php echo (isset($ahachat_coupon) && isset($ahachat_coupon['title'])) ? $ahachat_coupon['title'] : '15% Discount'; ?></h2>
                    <h3 class='ahachat-cartback-widget__subtitle'><?php echo (isset($ahachat_coupon['sub_title']) && !empty($ahachat_coupon['sub_title'])) ? $ahachat_coupon['sub_title'] : 'Get your 15% discount now by subscribing to our newsletter in facebook messenger. Just click the blue button below.'; ?></h3>
                    <div style='width:350px;' class='ahachat-cartback-widget__box ahachat-cartback-widget-box'>
                        <div class='ahachat-cartback-widget-box__icon-container'>
                            <div class='ahachat-cartback-widget-box__icon ahachat-cartback-widget-box__discount-icon'>
                                <svg class='ahachat-cartback-widget-box__discount-icon-bg'
                                     xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'
                                     width='46px' height='46px'>
                                    <path fill-rule='evenodd'
                                          d='M23.000,-0.000 L27.203,5.040 L33.234,2.278 L34.779,8.597 L41.439,8.660 L40.020,15.007 L45.993,17.882 L41.890,23.000 L45.993,28.118 L40.020,30.993 L41.439,37.340 L34.779,37.403 L33.234,43.722 L27.203,40.960 L23.000,46.000 L18.797,40.960 L12.766,43.722 L11.221,37.403 L4.561,37.340 L5.980,30.993 L0.007,28.118 L4.110,23.000 L0.007,17.882 L5.980,15.007 L4.561,8.660 L11.221,8.597 L12.766,2.278 L18.797,5.040 L23.000,-0.000 Z'></path>
                                </svg>
                                <span>%</span>
                            </div>
                            <div class='ahachat-cartback-widget-box__icon ahachat-cartback-widget-box__loading-icon cartback-loading-icon cartback-loading-circle'></div>
                        </div>

                        <div class='ahachat-cartback-widget-box__content'>
                            <div id='ahachat-cartback-widget'>
                                <div class="fb-send-to-messenger" origin="<?php echo home_url('/'); ?>"
                                     prechecked='true' page_id="<?php echo get_option('ahachat_page_id'); ?>"
                                     messenger_app_id="<?php echo $ahachat_app_id; ?>"
                                     data-ref="wp_cart_<?php echo md5(rand(11111111, 999999999)); ?>" color="blue"
                                     size='xlarge'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php submit_button("Save Changes") ?>
    </div>
</form>


<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.ahachat-fb-admin-tab-control').on('click', function () {
            $('.ahachat-fb-admin-tab-control').removeClass('ahachat-fb-tab-active');
            $('.ahachat-fb-admin-tab-content').removeClass('ahachat-fb-tab-active');
            $(this).addClass('ahachat-fb-tab-active');
            $($(this).data('target')).addClass('ahachat-fb-tab-active');
            return false;
        });
        $('#ahachat_coupons_title').keyup(function() {
           $('.ahachat-cartback-widget__title').html($(this).val());
        });
        $('#ahachat_coupons__sub_title').keyup(function() {
           $('.ahachat-cartback-widget__subtitle').html($(this).val());
        });
    });
</script>

<style type="text/css">
    .emojionearea, .emojionearea.form-control {
        width: 50%;
    }

    .ahachat-widget-preview-content {
        position: absolute;
        right: 130px;
        top: 30%;
        width: <?php echo isset($ahachat_customize_coupon['box_width']) ? $ahachat_customize_coupon['box_width'] : 420; ?>px;
        border-width: <?php echo isset($ahachat_customize_coupon['border_size']) ? $ahachat_customize_coupon['border_size'] : 2; ?>px;
        border-style: <?php echo isset($ahachat_customize_coupon['border_style']) ? $ahachat_customize_coupon['border_style'] : 'solid'; ?>;
        border-color: <?php echo isset($ahachat_customize_coupon['border_color']) ? $ahachat_customize_coupon['border_color'] : '#f7ef90'; ?>;
        background: <?php echo isset($ahachat_customize_coupon['background_color']) ? $ahachat_customize_coupon['background_color'] : '#fffabf'; ?>;
        box-sizing: border-box;
    }

    .ahachat-cartback-widget__title {
        color: <?php echo isset($ahachat_customize_coupon['title_color']) ? $ahachat_customize_coupon['title_color'] : '#444444'; ?>
    }

    .ahachat-cartback-widget__subtitle {
        color: <?php echo isset($ahachat_customize_coupon['subtitle_color']) ? $ahachat_customize_coupon['subtitle_color'] : '#727272'; ?>
    }
</style>
<?php
            }
        }
    endif;
    new AHACHAT_WP_COUPON();
 ?>