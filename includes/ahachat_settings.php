<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly;
if (!class_exists('AHACHAT_WP_ADMIN_SETTINGS')) {
    class AHACHAT_WP_ADMIN_SETTINGS
    {
        public function __construct()
        {
            add_action('admin_menu', array($this, 'admin_menu_settings'));
            add_action('admin_enqueue_scripts', array($this, 'ahachat_admin_styles'));
            add_action('admin_init', array($this, 'ahachat_fb_api_like_comment_settings'));
            add_action('current_screen', array($this, 'ahachat_current_screen'));
        }

        public function ahachat_fb_api_like_comment_settings()
        {
            register_setting(AHACHAT_WP, 'ahachat_app_id');
            register_setting(AHACHAT_WP, 'ahachat_broadcast_token');
            register_setting(AHACHAT_WP, 'ahachat_page_name');
            register_setting(AHACHAT_WP, 'ahachat_page_id');
            register_setting(AHACHAT_WP, 'ahachat_is_test_mode');
            register_setting(AHACHAT_WP, 'ahachat_app_enable_status');
            register_setting(AHACHAT_WP, 'ahachat_non_login_user');
            register_setting(AHACHAT_WP, 'ahachat_allow_user_add_cart');
            register_setting(AHACHAT_WP, 'ahachat_customize_message');
            register_setting(AHACHAT_WP, 'ahachat_enable_checkbox_checkout');
            register_setting(AHACHAT_WP, 'ahachat_customize_checkout_message');
            register_setting(AHACHAT_WP, 'ahachat_skip_message');

            /*first reminder*/
            register_setting(AHACHAT_WP, 'ahachat_first_reminder');
            /*second reminder*/
            register_setting(AHACHAT_WP, 'ahachat_second_reminder');
            /*third reminder*/
            register_setting(AHACHAT_WP, 'ahachat_third_reminder');

            /*shortcode*/
            register_setting(AHACHAT_WP, 'ahachat_coupon_customize');

            /**Coupon**/
            register_setting(AHACHAT_WP, 'ahachat_text_send');
            register_setting(AHACHAT_WP, 'ahachat_coupons');
            register_setting(AHACHAT_WP, 'ahachat_hide_product');
            register_setting(AHACHAT_WP, 'ahachat_show_product');
            register_setting(AHACHAT_WP, 'ahachat_is_skip_ontime');
            register_setting(AHACHAT_WP, 'ahachat_is_skip_checkbox');
        }

        public function admin_menu_settings()
        {
            add_menu_page(__('AhaChat', AHACHAT_WP), __('AhaChat', AHACHAT_WP), 'manage_options', 'ahachat-settings', array($this, 'ahachat_call_fb_api_settings'), AHACHAT_WP_PLUGIN_PATH . 'assets/images/'.AHACHAT_PREFIX.'logo.svg', '58');
            add_submenu_page('ahachat-settings', 'Settings', 'Settings', 'manage_options', 'ahachat-settings', array($this, 'ahachat_call_fb_api_settings'));
            if (defined('WOOCOMMERCE_VERSION')) {
                add_submenu_page('ahachat-settings', 'Dashboard', 'Analytics', 'manage_options', 'ahachat-analytics', array($this, 'ahachat_call_fb_api_statictical'));
                add_submenu_page('ahachat-settings', __('Audiences', AHACHAT_WP), __('Audience', AHACHAT_WP), 'manage_options', 'ahachat-audiences', array($this, 'ahachat_call_fb_abd_user_add_to_cart'));
                add_submenu_page('ahachat-settings', 'Coupons', 'Coupons', 'manage_options',
                    'ahachat-coupons', array($this, 'ahachat_call_cartback_coupon'));
                add_submenu_page('ahachat-settings', 'Shortcodes', 'Shortcodes', 'manage_options', 'ahachat-shortcodes', array($this, 'ahachat_call_cartback_shortcode'));
                add_submenu_page('ahachat-settings', 'Abandoned Cart', 'Abandoned Cart', 'manage_options',
                    'ahachat-reminders', array($this, 'ahachat_call_fb_api_setup'));
            }
            global $submenu;
            $link = $submenu['ahachat-settings'][0];
            unset($submenu['ahachat-settings'][0]);
            $submenu['ahachat-settings'][] = $link;
        }

        public function ahachat_admin_styles()
        {
            wp_enqueue_style('ahachat_admin_style', AHACHAT_WP_PLUGIN_PATH . 'assets/css/' . AHACHAT_PREFIX . 'admin.css', array(), AHACHAT_WP_VER);
            wp_enqueue_style('ahachat_font_awesom_admin_style', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
            wp_enqueue_script('ahachat-fb-abandoned-cart-js', AHACHAT_WP_PLUGIN_PATH . 'assets/js/ahachat.js', array('jquery'), AHACHAT_WP_VER);
        }

        public function ahachat_call_fb_api_settings()
        {
            require_once(AHACHAT_WP_LIB_PATH . AHACHAT_PREFIX .'settings_fb_api.php');
        }

        public function ahachat_call_fb_api_setup()
        {
            require_once(AHACHAT_WP_LIB_PATH . AHACHAT_PREFIX . 'setup_fb_api.php');
        }

        public function ahachat_call_fb_api_statictical()
        {
            require_once(AHACHAT_WP_LIB_PATH . AHACHAT_PREFIX . 'anylystic.php');
        }

        public function ahachat_call_cartback_coupon()
        {
            require_once(AHACHAT_WP_LIB_PATH . AHACHAT_PREFIX . 'coupon.php');
        }

        public function ahachat_call_cartback_shortcode()
        {
            require_once(AHACHAT_WP_LIB_PATH . AHACHAT_PREFIX . 'shortcode.php');
        }

        public function ahachat_current_screen()
        {
            $currentScreen = get_current_screen();
            switch ($currentScreen->id) {
                case 'ahachat_page_ahachat-reminders':
                    add_action('admin_footer', array($this, 'ahachat_admin_footer_js'));
                    break;
                case 'ahachat_page_ahachat-analytics':
                    add_action('admin_footer', array($this, 'ahachat_admin_head_css_js'));
                    break;
                case 'ahachat_page_ahachat-audiences':
                    add_action('admin_footer', array($this, 'ahachat_admin_user_add_cart_footer'));
                    add_action('admin_enqueue_scripts', array($this, 'ahachat_user_add_cart_scripts'));
                    break;
                case 'ahachat_page_ahachat-coupons':
                    add_action('admin_enqueue_scripts', array($this, 'ahachat_user_add_cart_scripts'));
                    add_action('admin_head', array($this, 'ahachat_admin_head_menu_shortcode'));
                    break;
                case 'ahachat_page_ahachat-shortcodes':
                    add_action('admin_enqueue_scripts', array($this, 'ahachat_enqueue_scripts_shortcode'));
                    add_action('admin_footer', array($this, 'ahachat_admin_footer_menu_shortcode'));
                    add_action('admin_head', array($this, 'ahachat_admin_head_menu_shortcode'));
                    break;
                case 'ahachat_page_cartback-message-receipt':
                    add_action('admin_enqueue_scripts', array($this, 'ahachat_cb_messenger_receipt_scripts'));
                    break;
            }
        }

        public function ahachat_user_add_cart_scripts()
        {
            wp_enqueue_style('user_add_cart_scripts_style_mess', AHACHAT_WP_PLUGIN_PATH . 'assets/css/' . AHACHAT_PREFIX . 'send_messenger.css', array(), AHACHAT_WP_VER);
            wp_enqueue_script('user_add_cart_scripts_scripts_mess', AHACHAT_WP_PLUGIN_PATH . 'assets/js/' . AHACHAT_PREFIX . 'send_messenger.js', array('jquery'), AHACHAT_WP_VER);
            // emojionearea
            wp_enqueue_style('emojionearea_style_mess_css', AHACHAT_WP_PLUGIN_PATH . 'assets/css/emojionearea/emojionearea.min.css', array(), AHACHAT_WP_VER);
            wp_enqueue_script('emojionearea_scripts_mess_js', AHACHAT_WP_PLUGIN_PATH . 'assets/js/emojionearea/emojionearea.min.js', array('jquery'), AHACHAT_WP_VER);
            wp_enqueue_script('emojionearea_scripts_custom_js', AHACHAT_WP_PLUGIN_PATH . 'assets/js/emojionearea/emojionearea_custom.js', array('jquery'), AHACHAT_WP_VER);
            // Add the color picker css file
            wp_enqueue_style('wp-color-picker');
            // Include our custom jQuery file with WordPress Color Picker dependency
            wp_enqueue_script('custom-script-customzie-coupon', AHACHAT_WP_PLUGIN_PATH . 'assets/js/'.AHACHAT_PREFIX.'customize-coupon.js', array('wp-color-picker'), false, true);
            wp_enqueue_style('user_add_cart_scripts_style_coupon_cus', AHACHAT_WP_PLUGIN_PATH . 'assets/css/' . AHACHAT_PREFIX . 'coupon.css', array(), AHACHAT_WP_VER);
            wp_enqueue_script('user_add_cart_scripts_coupon_customize', AHACHAT_WP_PLUGIN_PATH . 'assets/js/'.AHACHAT_PREFIX.'coupon.js', array('jquery'), AHACHAT_WP_VER);
        }

        public function ahachat_cb_messenger_receipt_scripts()
        {
            wp_enqueue_style('shortcode_1_scripts_style_mess', AHACHAT_WP_PLUGIN_PATH . 'assets/css/shortcode/bootstrap.min.css');
            wp_enqueue_style('shortcode_2_scripts_style_mess', AHACHAT_WP_PLUGIN_PATH . 'assets/css/shortcode/' . AHACHAT_PREFIX . 'box_coupon.css', array(), AHACHAT_WP_VER);
            wp_enqueue_style('shortcode_3_scripts_style_mess', AHACHAT_WP_PLUGIN_PATH . 'assets/css/shortcode/' . AHACHAT_PREFIX . 'show_phone.css', array(), AHACHAT_WP_VER);
            //
            // emojionearea
            wp_enqueue_style('emojionearea_style_mess_css', AHACHAT_WP_PLUGIN_PATH . 'assets/css/emojionearea/emojionearea.min.css', array(), AHACHAT_WP_VER);
            wp_enqueue_script('emojionearea_scripts_mess_js', AHACHAT_WP_PLUGIN_PATH . 'assets/js/emojionearea/emojionearea.min.js', array('jquery'), AHACHAT_WP_VER);
            wp_enqueue_script('emojionearea_scripts_custom_js', AHACHAT_WP_PLUGIN_PATH . 'assets/js/emojionearea/emojionearea_custom.js', array('jquery'), AHACHAT_WP_VER);
            wp_enqueue_script('shortcode_action_btn_scripts', AHACHAT_WP_PLUGIN_PATH . 'assets/js/messenger_receipt.js', array('jquery'), AHACHAT_WP_VER);
        }

        public function ahachat_enqueue_scripts_shortcode()
        {
            wp_enqueue_style('shortcode_scripts_style_mess', AHACHAT_WP_PLUGIN_PATH . 'assets/css/' . AHACHAT_PREFIX . 'shortcode.css');
            wp_enqueue_style('shortcode_1_scripts_style_mess', AHACHAT_WP_PLUGIN_PATH . 'assets/css/shortcode/bootstrap.min.css');
            wp_enqueue_style('shortcode_2_scripts_style_mess', AHACHAT_WP_PLUGIN_PATH . 'assets/css/shortcode/' . AHACHAT_PREFIX . 'box_coupon.css', array(), AHACHAT_WP_VER);
            wp_enqueue_style('shortcode_3_scripts_style_mess', AHACHAT_WP_PLUGIN_PATH . 'assets/css/shortcode/' . AHACHAT_PREFIX . 'show_phone.css', array(), AHACHAT_WP_VER);
            wp_enqueue_style('shortcode_4_scripts_style_mess', AHACHAT_WP_PLUGIN_PATH . 'assets/css/shortcode/editor/medium-editor.min.css', array(), AHACHAT_WP_VER);
            wp_enqueue_style('shortcode_5_scripts_style_mess', AHACHAT_WP_PLUGIN_PATH . 'assets/css/shortcode/editor/medium-editor-insert-plugin.min.css', array(), AHACHAT_WP_VER);
            wp_enqueue_style('shortcode_6_scripts_style_mess', AHACHAT_WP_PLUGIN_PATH . 'assets/css/shortcode/editor/editor.css', array(), AHACHAT_WP_VER);
            // emojionearea
            wp_enqueue_style('emojionearea_style_mess_css', AHACHAT_WP_PLUGIN_PATH . 'assets/css/emojionearea/emojionearea.min.css', array(), AHACHAT_WP_VER);
            wp_enqueue_script('emojionearea_scripts_mess_js', AHACHAT_WP_PLUGIN_PATH . 'assets/js/emojionearea/emojionearea.min.js', array('jquery'), AHACHAT_WP_VER);
            wp_enqueue_script('emojionearea_scripts_custom_js', AHACHAT_WP_PLUGIN_PATH . 'assets/js/emojionearea/emojionearea_custom.js', array('jquery'), AHACHAT_WP_VER);
            // JS
            wp_enqueue_script('shortcode_action_btn_scripts', AHACHAT_WP_PLUGIN_PATH . 'assets/js/' . AHACHAT_PREFIX . 'shortcode.js', array('jquery'), AHACHAT_WP_VER);
        }

        public function ahachat_admin_user_add_cart_footer()
        {
            $args = array(
                'posts_per_page' => -1,
                'post_type' => AHACHAT_USER_ADD_TO_CART_POST_TYPE,
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'ahachat_sender_id',
                        'value' => '-',
                        'compare' => '!='
                    )
                ),
            );
            $post = get_posts($args);
            ?>
            <!--================POPUP================== -->
            <div class="ahachat_spider_create_group_popup">
                <div class="spider_create_group_format_body">
                    <div id="TB_title">
                        <div id="TB_ajaxWindowTitle"><?php _e("Send message to your audience", AHACHAT_WP); ?></div>
                        <div id="TB_closeAjaxWindow">
                            <button type="button" id="TB_closeWindowButton"><span
                                        class="screen-reader-text">Close</span><span class="tb-close-icon"></span>
                            </button>
                        </div>
                    </div>
                    <div class="spider-popup-content">
                        <form id="frm_add_new_group_spider" class="form-horizontal">
                            <div class="form-group row">
                                <div class="col-md-12" id="ahachat_first_send">
                                    <p class="ahachat_spider_margin p_ahachat_app_like_comment"><b>Message</b></p>
                                    <textarea id="ahachat_content_mess" style="width: 100%;height: 150px;"></textarea>
                                    <p style="padding-top: 20px;" class="ahachat_spider_margin p_ahachat_app_like_comment"><b>Send
                                            to</b></p>
                                    <select style="width: 100%" class="" name="ahachat_send_message_to_person"
                                            id="ahachat_send_message_to_person">
                                        <option value="all">All Users In Send List (<?php echo count($post); ?>)
                                        </option>
                                    </select>

                                    <p style="padding-top: 20px;" class="ahachat_spider_margin p_ahachat_app_like_comment"><b>Message tag</b></p>
                                    <select style="width: 100%" class="" name="abd_send_message_by_tag"
                                            id="abd_send_message_by_tag">
                                        <option value="CONFIRMED_EVENT_UPDATE" selected>CONFIRMED_EVENT_UPDATE</option>
                                        <option value="POST_PURCHASE_UPDATE">POST_PURCHASE_UPDATE</option>
                                        <option value="ACCOUNT_UPDATE">ACCOUNT_UPDATE</option>
                                        <option value="STANDARD_MESSAGING">STANDARD_MESSAGING</option>
                                    </select>
                                    <p style="white-space: pre-line;" class="ahachat_message_tag_tut" id="CONFIRMED_EVENT_UPDATE_TUT">Send the user reminders or updates for an event they have registered for (e.g., RSVP'ed, purchased tickets). This tag may be used for upcoming events and events in progress. Ex:
                                        - Reminder of upcoming classes, appointments, or events that the user has scheduled
                                        - Confirmation of user's reservation or attendance to an accepted event or appointment
                                        - Notification of user's transportation or trip scheduled, such as arrival, cancellation, baggage delay, or other status changes
                                    </p>
                                    <p style="white-space: pre-line;" class="ahachat_message_tag_tut" id="POST_PURCHASE_UPDATE_TUT">Notify the user of an update on a recent purchase. Ex:
                                    - Confirmation of transaction, such as invoices or receipts
                                    - Notifications of shipment status, such as product in-transit, shipped, delivered, or delayed
                                    - Changes related to an order that the user placed, such credit card has declined, backorder items, or other order updates that require user action</p>
                                    <p style="white-space: pre-line;" class="ahachat_message_tag_tut" id="ACCOUNT_UPDATE_TUT">Notify the user of a non-recurring change to their application or account. Ex:
                                    - A change in application status (e.g., credit card, job)
                                    - Notification of suspicious activity, such as fraud alerts</p>
                                    <p style="white-space: pre-line;" class="ahachat_message_tag_tut" id="STANDARD_MESSAGING_TUT">Respond to the user within the 24-hour standard messaging window. Messages may contain promotional content.</p>
                                    <div class="ahachat_first_send_complete" style="display: none;">
                                        <h3 id="abd_send_complete"><!--Complete--></h3>
                                        <ul>
                                            <li class="ahachat-fb-mess-result-sent">
                                                <?php _e('Sent:', AHACHAT_WP); ?>
                                                <strong class="ahachat_send_success_first">0</strong>
                                            </li>
                                            <li class="ahachat-fb-mess-result-fail">
                                                <?php _e('Fails:', AHACHAT_WP); ?>
                                                <strong class="ahachat_send_fail_first">0</strong>
                                                <a href="#" class="ahachat-fb-mess-view-fail-detail">
                                                    <?php _e('Detail', AHACHAT_WP); ?>
                                                </a>
                                            </li>
                                        </ul>
                                        <ul style="display: none;" class="ahachat-mess-fail-details"></ul>
                                    </div>
                                </div>
                                <div class="col-md-12" id="ahachat_second_send" style="display: none;">
                                    <div id="#result-<?php echo $id = rand(); ?>" class="result">
                                        <div style="width: 200px;height: 200px;margin: auto;">
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;"
                                                 xml:space="preserve">
                                          <style type="text/css">
                                              .st0 {
                                                  clip-path: url(#SVGID_2_);
                                              }

                                              .st1 {
                                                  fill: none;
                                                  stroke: #87CDAE;
                                                  stroke-width: 2;
                                                  stroke-linecap: round;
                                                  stroke-linejoin: round;
                                                  stroke-miterlimit: 10;
                                              }

                                              .st2 {
                                                  fill: none;
                                                  stroke: #2279BF;
                                                  stroke-width: 2;
                                                  stroke-miterlimit: 10;
                                              }

                                              .st3 {
                                                  fill: #2279BF;
                                              }

                                              .st4 {
                                                  fill: #87CDAE;
                                                  stroke: #2279BF;
                                                  stroke-width: 2;
                                                  stroke-linejoin: round;
                                                  stroke-miterlimit: 10;
                                              }

                                              .st5 {
                                                  fill: #FFFFFF;
                                                  stroke: #2279BF;
                                                  stroke-width: 2;
                                                  stroke-linejoin: round;
                                                  stroke-miterlimit: 10;
                                              }
                                          </style>
                                                <g>
                                                    <defs>
                                                        <path id="SVGID_1_" d="M50,88.4L21.4,71.9c-0.4-0.2-0.7-0.7-0.7-1.2v-33c0-0.5,0.3-0.9,0.7-1.2L50,19.9c0.4-0.2,1-0.2,1.4,0
                                          L80,36.5c0.4,0.2,0.7,0.7,0.7,1.2v33c0,0.5-0.3,0.9-0.7,1.2L51.4,88.4C51,88.7,50.5,88.7,50,88.4z"/>
                                                    </defs>
                                                    <clipPath id="SVGID_2_">
                                                        <use xlink:href="#SVGID_1_" style="overflow:visible;"/>
                                                    </clipPath>
                                                    <g class="st0 back">
                                                        <g class="motionblur">
                                                            <line class="st1" x1="75" y1="36" x2="75.2" y2="47.6"/>
                                                            <line class="st1" x1="69.3" y1="70.1" x2="69.5" y2="80.8"/>
                                                            <line class="st1" x1="35.4" y1="67.8" x2="35.6" y2="80.2"/>
                                                            <line class="st1" x1="45.4" y1="27.9" x2="45.7" y2="43.1"/>
                                                            <line class="st1" x1="26.7" y1="38.7" x2="26.8" y2="43.1"/>
                                                            <line class="st1" x1="58" y1="53.1" x2="58.2" y2="65.3"/>
                                                        </g>
                                                    </g>
                                                </g>
                                                <path class="st2" d="M50,88.4L21.4,71.9c-0.4-0.2-0.7-0.7-0.7-1.2v-33c0-0.5,0.3-0.9,0.7-1.2L50,19.9c0.4-0.2,1-0.2,1.4,0L80,36.5
                                    c0.4,0.2,0.7,0.7,0.7,1.2v33c0,0.5-0.3,0.9-0.7,1.2L51.4,88.4C51,88.7,50.5,88.7,50,88.4z"/>
                                                <g>
                                                    <path class="st3 rocket" d="M52.7,58c-1.6,0-6.7-0.7-6.7-0.7c0.6,1.7,2.5,7.1,2.5,7.1l0.9-3.2c1.5,4.8,3.3,11.5,3.3,11.5L56,61.2
                                      c0.5,1.5,1,3.2,1,3.2l1.7-7.1C58.8,57.3,54.3,58,52.7,58z"/>
                                                </g>
                                                <g class="rocket">
                                                    <g>
                                                        <path class="st4" d="M36.6,49.9l5.8-6l4.3,6.7l0,0c-3.3,0.9-5.3,3.3-5.1,5.9l0.2,2.4c0,0.2-0.2,0.3-0.4,0.3l-1.2,0
                                        c-0.5,0-1-0.3-1.1-0.6l-2.8-7.2C36,50.8,36.2,50.3,36.6,49.9z"/>
                                                        <path class="st4" d="M68.2,50l-5.8-6l-4.3,6.7l0,0c3.2,0.9,5.3,3.3,5,5.9l-0.3,2.4c0,0.2,0.2,0.3,0.4,0.3l1.2,0
                                        c0.5,0,1-0.3,1.1-0.6l2.8-7.2C68.7,50.9,68.6,50.4,68.2,50z"/>
                                                    </g>
                                                    <path class="st4" d="M52.5,52.1l-0.2,0l-5.8,0l0.5,1.5c0.3,0.8,1,1.3,1.8,1.3l3.4,0l0.2,0l3.4,0c0.8,0,1.5-0.5,1.8-1.3l0.5-1.5
                                      L52.5,52.1z"/>
                                                    <path class="st4" d="M52.5,47.5l-0.2,0l-9.6,0c0.7,1.7,1.4,3,1.8,3.8c0.3,0.5,0.9,0.9,1.4,0.9l0.6,0l5.8,0l0.2,0l5.8,0l0.6,0
                                      c0.6,0,1.1-0.3,1.4-0.9c0.4-0.8,1.1-2,1.8-3.8L52.5,47.5z"/>
                                                    <path class="st5" d="M59.4,18.3l-6.8,0l-0.2,0l-6.8,0c-8.8,13.9-5.6,21.4-2.9,29.2l9.6,0l0.2,0l9.7,0
                                      C64.9,39.6,68.2,32.3,59.4,18.3z"/>
                                                    <path class="st4"
                                                          d="M52.6,10.2L52.6,10.2l-0.2,0c-2.8,2.6-5.1,5.3-6.9,8.1l6.8,0l0.2,0l6.8,0C57.6,15.5,55.3,12.8,52.6,10.2z"/>
                                                    <ellipse
                                                            transform="matrix(2.703083e-03 -1 1 2.703083e-03 21.2413 83.3837)"
                                                            class="st4" cx="52.4" cy="31" rx="6.1" ry="6.1"/>
                                                </g>
                                  </svg>
                                        </div>
                                        <!--
                                <div style="text-align: center;" class="ahachat-fb-mess-results-warning"><?php _e('Please do not close this box (by clicking close button or clicking outside)', AHACHAT_WP) ?></div>
                              -->
                                        <?php //  PROGRESS BAR //
                                        ?>
                                        <progress style="width: 100%" id="ahachat_progress_send_mess" max="100"
                                                  value="0"></progress>
                                        <div class="ahachat-fb-mess-results">
                                            <div class="ahachat-fb-mess-results-warning"><?php _e('Please do not close this box (by clicking close button or clicking outside)', AHACHAT_WP) ?></div>
                                        </div>
                                        <?php //  PROGRESS BAR //
                                        ?>
                                    </div>
                                    <div class="ahachat_first_send_complete" style="display: none;">
                                        <h3 id="abd_send_complete"><!--Complete--></h3>
                                        <ul>
                                            <li class="ahachat-fb-mess-result-sent">
                                                <?php _e('Sent:', AHACHAT_WP); ?>
                                                <strong class="ahachat_send_success_first">0</strong>
                                            </li>
                                            <li class="ahachat-fb-mess-result-fail">
                                                <?php _e('Fails:', AHACHAT_WP); ?>
                                                <strong class="ahachat_send_fail_first">0</strong>
                                                <a href="#" class="ahachat-fb-mess-view-fail-detail">
                                                    <?php _e('Detail', AHACHAT_WP); ?>
                                                </a>
                                            </li>
                                        </ul>
                                        <ul style="display: none;" class="ahachat-mess-fail-details"></ul>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <p class="ahachat_spider_margin p_ahachat_app_like_comment">
                            <button data-type="addcart" style="margin-top: 45px;width: 100%"
                                    class="button button-primary abd_send_message_again" name="abd_send_message_again">
                                Send Now
                            </button>
                        </p>
                    </div>
                </div>
            </div>
            </div>
            <!--================POPUP================== -->
            <?php
        }

        public function ahachat_call_fb_abd_user_add_to_cart()
        {
            ?>
            <div class="wrap" style="margin-bottom: -20px;">
                <h1 class="wp-heading-inline"><?php _e("Audience", AHACHAT_WP); ?></h1>
                <p class="description">Includes add-to-cart users, get-coupon users, shortcode users.<br/>With
                    add-to-cart users, their full information (full name, Facebook profile, gender) appears once they
                    have sent messages back to your fanpage</p>
            </div><br/><br/>
            <h2 class="nav-tab-wrapper">
                <a href="?page=ahachat-audiences"
                   class="nav-tab <?php if (!isset($_GET['menu'])) echo 'nav-tab-active'; ?>">Users Added to cart</a>
                <a href="?page=ahachat-audiences&menu=send"
                   class="nav-tab <?php if (isset($_GET['menu']) && $_GET['menu'] == 'send') echo 'nav-tab-active'; ?>">Audience</a>
            </h2>
            <style type="text/css">.notice.notice-warning {
                    display: none
                }

                th#audience {
                    width: 10%;
                }</style>
            <?php
            if (!isset($_GET['menu'])) {
                include_once(AHACHAT_WP_LIB_PATH . AHACHAT_PREFIX . 'tables-user.php');
                $this->table = new AHACHAT_ADD_TO_CART_USER();
                $list_user = $this->table;
                cartback_show_table_list_user($list_user);
            } else {
                include_once(AHACHAT_WP_LIB_PATH . AHACHAT_PREFIX . 'tables-user-audience.php');
                $this->table = new AHACHAT_ADD_TO_CART_USER_AUDIENCE();
                $list_user = $this->table;
                cartback_show_table_list_user_audience($list_user);
            }
        }

        public function ahachat_admin_footer_js()
        {
            wp_enqueue_style('ahachat_admin_footer_style', AHACHAT_WP_PLUGIN_PATH . 'assets/css/shortcode/'.AHACHAT_PREFIX.'show_phone.css', array(), AHACHAT_WP_VER);
            wp_enqueue_style('ahachat_admin_footer_style', AHACHAT_WP_PLUGIN_PATH . 'assets/css/'.AHACHAT_PREFIX.'dd.css', array(), AHACHAT_WP_VER);
            wp_enqueue_script('ahachat_admin_footer_js', AHACHAT_WP_PLUGIN_PATH . 'assets/js/'.AHACHAT_PREFIX.'dd.js', array('jquery'), AHACHAT_WP_VER);
            wp_enqueue_script('ahachat_admin_footer_js', AHACHAT_WP_PLUGIN_PATH . 'assets/js/'.AHACHAT_PREFIX.'select_image.js', array('jquery'), AHACHAT_WP_VER);
        }

        public function ahachat_admin_head_css_js()
        {
            ?>
                <style>
                    #wpcontent {
                        background-color: white;
                    }
                </style>
            <?php
            wp_enqueue_script('ahachat_utils_js', AHACHAT_WP_PLUGIN_PATH . 'assets/js/charts/utils.js', array('jquery'), AHACHAT_WP_VER);
            wp_enqueue_script('ahachat_chart_js', AHACHAT_WP_PLUGIN_PATH . 'assets/js/charts/chart.js', array('jquery'), AHACHAT_WP_VER);
        }

        public function ahachat_admin_head_menu_shortcode()
        {
            $ahachat_app_id = get_option('ahachat_app_id');
            ?>
            <script>
                <?php
                    $app_languages = "en_US";
                ?>
                window.fbAsyncInit = function () {
                    FB.init({
                        appId: <?php echo $ahachat_app_id; ?>,
                        xfbml: true,
                        version: 'v2.10'
                    });
                    /*Event when use click Send Messenger Coupon*/
                    FB.Event.subscribe('send_to_messenger', function (e) {
                        // callback for events triggered by the plugin
                        console.log(e);
                    });
                    /*Event when use click Send Messenger Coupon*/
                    FB.Event.subscribe('messenger_checkbox', function (e) {
                        console.log(e);
                        if (e.event == 'checkbox') {
                            var checkboxState = e.state;
                            abd_state = checkboxState;
                            console.log("Checkbox state: " + checkboxState);
                        } else if (e.event == 'not_you') {
                            console.log("User clicked 'not you'");
                        } else if (e.event == 'hidden') {
                            console.log("Plugin was hidden");
                        }
                    });
                };
                (function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) {
                            return;
                        }
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "https://connect.facebook.net/<?php echo $app_languages; ?>/sdk.js";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk')
                );
            </script>
            <?php
        }

        // menu shortcode footer
        public function ahachat_admin_footer_menu_shortcode()
        {
            ?>
            <div class="alert alert-success ahachat_alert_shorcode_success"
                 style="position: fixed;top: 50px;right: 15px;display: none;">
                <strong class="ahachat_alert_action_done">Create shortcode successfully</strong>
            </div>
            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                 aria-hidden="true" style="/*display: block;padding-right: 17px;opacity: 1;transition: opacity .15s linear;overflow-x: hidden;
    overflow-y: auto;*/">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Shortcode</h5>
                            <button type="button" class="close ahachat_close_shortcode" data-dismiss="modal"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <?php $fb_api = new AHACHAT_WP_API();
                                $page_url = home_url();//"https://www.facebook.com/".$page_id;
                                $user_ref = md5(rand(11111111, 999999999));
                                ?>
                                <div class="row">
                                    <div class="col-xs-12 col-md-6 ">
                                        <div class='ahachat-widget-preview-content'>
                                            <div class='ahachat-cartback-widget'>
                                                <h2 class='ahachat-cartback-widget__title'>
                                                    <div id=""
                                                         class="editable cartback-shortcode-app-name cartback_shortcode_editor_name"
                                                         data-placeholder="Type some text title">
                                                        <p class="cartback_shortcode_name"
                                                           id="show_text_shortcode_title">15% discount</p>
                                                    </div>
                                                    <img style="width: 20px;position: absolute;right: 0px;
    top: 25px;" src="<?php echo AHACHAT_WP_PLUGIN_PATH . 'assets/images/'.AHACHAT_PREFIX.'edit_text_shortcode.png'; ?>">
                                                </h2>
                                                <h3 class='ahachat-cartback-widget__subtitle'>
                                                    <div id=""
                                                         class="editable cartback-shortcode-app-name cartback_shortcode_editor_name"
                                                         data-placeholder="Type some text subtitle">
                                                        <p class="cartback_shortcode_name"
                                                           id="show_text_shortcode_subtitle">Get your 15% discount now
                                                            by subscribing to our newsletter in facebook messenger. Just
                                                            click the blue button below.</p>
                                                        <!--Get your 15% discount now by subscribing to our newsletter in facebook messenger. Just click the blue button below. -->
                                                    </div>
                                                    <img style="width: 20px;position: absolute;right: 0px;
    top: 85px;" src="<?php echo AHACHAT_WP_PLUGIN_PATH . 'assets/images/'.AHACHAT_PREFIX.'edit_text_shortcode.png'; ?>">
                                                </h3>
                                                <div class='ahachat-cartback-widget'>
                                                    <b>Button Type:</b><br/>
                                                    <input id="ahachat_button_type_send_to" class="ahachat_button_type"
                                                           checked="checked" type="radio" name="messenger_type"
                                                           value="send_to"> Send to Messenger
                                                    <input id="ahachat_button_type_checbox" class="ahachat_button_type"
                                                           type="radio" name="messenger_type" value="checkbox">
                                                    Messenger Checkbox<br>
                                                </div>
                                                <?php ahachat_cartback_insert_send_to_messenger($page_url, $user_ref); ?>
                                                <?php ahachat_cartback_insert_show_messenger_checkbox($page_url, $user_ref); ?>
                                            </div>
                                            <?php ahachat_cartback_insert_send_custom_text_with_sendto(); ?>
                                            <?php ahachat_cartback_insert_message_type_with_checkbox(); ?>
                                        </div>
                                    </div>
                                    <?php ahachat_cartback_insert_showphone($fb_api->AHA_Get_FanPage()); ?>
                                </div>
                            </div>
                        </div>
                        <div style="justify-content:flex-start" class="modal-footer">
                            <span id="ahachat_cartback_add_button_create_edit_shortcode"></span>
                            <!--
                            <button type="button" data-action="create" class="btn btn-primary ahachat_save_changes_shortcode">Save changes</button>-->
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <!-- Modal -->
            <script src="<?php echo AHACHAT_WP_PLUGIN_PATH . 'assets/js/shortcode/bootstrap.min.js'; ?>"></script>
            <style type="text/css">
                #txt_preview img.emojioneemoji {
                    width: 20px;
                }
            </style>
            <script type="text/javascript">
                function ahachat_check_input_text_preview_phone(length, class_parent, txt_class_child, text_html, text_text) {
                    if (length != 0) {
                        jQuery(class_parent).css("border-color", "rgb(241, 240, 240)");
                        jQuery(txt_class_child).html(text_html);
                        jQuery("#tooltip_show_empty").attr("flow", "none");
                        jQuery("#shortcode_message").text(text_text);
                    } else {
                        jQuery(class_parent).css("border-color", "rgb(255, 98, 73)");
                        jQuery(txt_class_child).text("");
                        jQuery("#shortcode_message").text("");
                        jQuery("#tooltip_show_empty").attr("flow", "right");
                    }
                }

                function ahachat_check_outsite_preview_phone(length_preview, class_parent) {
                    if (length_preview != 0) {
                        jQuery(class_parent).css("border-color", "rgb(241, 240, 240)");
                        jQuery("#tooltip_show_empty").attr("flow", "none");
                    } else {
                        jQuery(class_parent).css("border-color", "rgb(255, 98, 73)");
                        jQuery("#tooltip_show_empty").attr("flow", "right");
                    }
                }

                setInterval(function () {
                    jQuery(document).ready(function ($) {
                        $(".send_custom_text_width_sendto .emojionearea .emojionearea-editor").keyup(function () {
                            var length = $(this).text().length;
                            //console.log(length);
                            ahachat_check_input_text_preview_phone(length, ".ahachat_text_preiew", "#txt_preview", $(this).html(), $(this).text());
                        });
                        $(".send_custom_text .emojionearea .emojionearea-editor").keyup(function () {
                            var length = $(this).text().length;
                            //console.log(length);
                            ahachat_check_input_text_preview_phone(length, ".ahachat_text_preiew_width_cb", "#txt_preview_width_cb", $(this).html(), $(this).text());
                        });
                        var length_preview = $(".send_custom_text_width_sendto .emojionearea .emojionearea-editor").text().length;
                        ahachat_check_outsite_preview_phone(length_preview, ".ahachat_text_preiew");
                        var length_preview_width_cb = $(".send_custom_text .emojionearea .emojionearea-editor").text().length;
                        ahachat_check_outsite_preview_phone(length_preview_width_cb, ".ahachat_text_preiew_width_cb");
                    });
                }, 1000);
            </script>
            <script src="<?php echo AHACHAT_WP_PLUGIN_PATH.'assets/js/shortcode/editor/medium-editor.js'; ?>"></script>
            <script src="<?php echo AHACHAT_WP_PLUGIN_PATH.'assets/js/shortcode/editor/handlebars.runtime.min.js'; ?>"></script>
            <script src="<?php echo AHACHAT_WP_PLUGIN_PATH.'assets/js/shortcode/editor/jquery-sortable-min.js'; ?>"></script>
            <script src="<?php echo AHACHAT_WP_PLUGIN_PATH.'assets/js/shortcode/editor/medium-editor-insert-plugin.min.js'; ?>"></script>
            <script src="<?php echo AHACHAT_WP_PLUGIN_PATH.'assets/js/shortcode/editor/call_editor.js'; ?>"></script>
            <?php
        }

    }
}
new AHACHAT_WP_ADMIN_SETTINGS();
