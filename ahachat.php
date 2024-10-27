<?php
/*
* Plugin Name: AhaChat-Messenger-Marketing
* Plugin URI: https://docs.ahachat.com/growth/abandoned-cart
* Description: Get your customers back & increase sales with Messenger automation
* Version: 1.1
* Author: AhaChat
* Author URI: https://ahachat.com
*/
if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!defined('AHACHAT_WP_DIR')) {
    define('AHACHAT_WP_DIR', plugin_dir_path(__FILE__));
}
if (!class_exists('AHACHAT_WP_SETUP')):
    /**
     *
     */
    class AHACHAT_WP_SETUP
    {
        function __construct()
        {
            $this->defineConstants();
            $this->includeFiles();
            add_action('init', array(&$this, 'checkPluginDefaults'));
            register_activation_hook(__FILE__, array($this, 'ahachat_setup_db'));
            register_deactivation_hook(__FILE__, array($this, 'ahachat_finish_cronjob'));

            if (!function_exists('is_plugin_active')) {
                include_once(ABSPATH . 'wp-admin/includes/plugin.php');
            }
        }

        public function defineConstants()
        {
            global $wpdb;
            if (!defined('AHACHAT_WP')) {
                define('AHACHAT_WP', 'ahachat-wp');
            }
            if (!defined('AHACHAT_PREFIX')) {
                define('AHACHAT_PREFIX', 'ahachat_');
            }
            if (!defined('AHACHAT_WP_VER')) {
                define('AHACHAT_WP_VER', '1.0');
            }
            if (!defined('AHACHAT_WP_LIB_PATH')) {
                define('AHACHAT_WP_LIB_PATH', AHACHAT_WP_DIR . 'includes' . '/');
            }
            if (!defined('AHACHAT_WP_PLUGIN_PATH')) {
                define('AHACHAT_WP_PLUGIN_PATH', plugin_dir_url(__FILE__));
            }
            if (!defined('AHACHAT_FIRST_REMINDER_CRON_ACTION_NAME')) {
                define('AHACHAT_FIRST_REMINDER_CRON_ACTION_NAME', 'ahachat_first_reminder_cron_action');
            }
            if (!defined('AHACHAT_SECOND_REMINDER_CRON_ACTION_NAME')) {
                define('AHACHAT_SECOND_REMINDER_CRON_ACTION_NAME', 'ahachat_second_reminder_cron_action');
            }
            if (!defined('AHACHAT_THIRD_REMINDER_CRON_ACTION_NAME')) {
                define('AHACHAT_THIRD_REMINDER_CRON_ACTION_NAME', 'ahachat_third_reminder_cron_action');
            }
            if (!defined('AHACHAT_USER_ADD_TO_CART_POST_TYPE')) {
                define('AHACHAT_USER_ADD_TO_CART_POST_TYPE', 'aha_user_add_cart_pt');
            }
            if (!defined('AHACHAT_LIST_EMAIL_POST_TYPE')) {
                define('AHACHAT_LIST_EMAIL_POST_TYPE', 'aha_list_email_pt');
            }
            if (!defined('AHACHAT_USER_REF_TABLE')) {
                define('AHACHAT_USER_REF_TABLE', $wpdb->prefix . 'ahachat_user_ref');
            }
            if (!defined('AHACHAT_ANALYTICS_TABLE')) {
                define('AHACHAT_ANALYTICS_TABLE', $wpdb->prefix . 'ahachat_analytics');
            }
            if (!defined('AHACHAT_ANALYTICS_FB_TABLE')) {
                define('AHACHAT_ANALYTICS_FB_TABLE', $wpdb->prefix . 'ahachat_analytics_fb');
            }
            if (!defined('AHACHAT_SHORTCODES_TABLE')) {
                define('AHACHAT_SHORTCODES_TABLE', $wpdb->prefix . 'ahachat_shortcodes');
            }

            if (!defined('AHACHAT_BASE_URL')) {
                define('AHACHAT_BASE_URL', 'https://ahachat.com/');
            }

            // languages
            load_textdomain(AHACHAT_WP, AHACHAT_WP_DIR . 'languages/' . get_option('WPLANG') . '.mo');
        }

        public function includeFiles()
        {
            require_once AHACHAT_WP_DIR . 'includes/facebook-api/'.AHACHAT_PREFIX.'facebook_api.php';
            require_once AHACHAT_WP_DIR . 'includes/facebook-api/'.AHACHAT_PREFIX.'api.php';
            require_once AHACHAT_WP_DIR . 'includes/facebook-api/'.AHACHAT_PREFIX.'rule.php';
            require_once AHACHAT_WP_LIB_PATH . AHACHAT_PREFIX . 'posttype-add-to-cart-user.php';
            require_once AHACHAT_WP_LIB_PATH . AHACHAT_PREFIX . 'post-list-email.php';
            require_once AHACHAT_WP_LIB_PATH . AHACHAT_PREFIX . 'settings.php';
            require_once AHACHAT_WP_LIB_PATH . AHACHAT_PREFIX . 'functions.php';
            require_once AHACHAT_WP_LIB_PATH . AHACHAT_PREFIX . 'cartback_reminder.php';
            require_once AHACHAT_WP_LIB_PATH . AHACHAT_PREFIX . 'plugins.php';
            require_once AHACHAT_WP_LIB_PATH . AHACHAT_PREFIX . 'ajax_cart.php';
        }

        public function checkPluginDefaults()
        {
            if (!defined('WOOCOMMERCE_VERSION')) {
                add_action('admin_notices', array(&$this, 'ahachat_notice_woo'));
                return;
            }

            $currency = get_woocommerce_currency_symbol();
            update_option('ahachat_currency', $currency);


            if (!wp_next_scheduled(AHACHAT_FIRST_REMINDER_CRON_ACTION_NAME)) {
                wp_schedule_event(time(), 'ahachat_first_reminder', AHACHAT_FIRST_REMINDER_CRON_ACTION_NAME);
            }
            if (!wp_next_scheduled(AHACHAT_SECOND_REMINDER_CRON_ACTION_NAME)) {
                wp_schedule_event(time(), 'ahachat_second_reminder', AHACHAT_SECOND_REMINDER_CRON_ACTION_NAME);
            }
            if (!wp_next_scheduled(AHACHAT_THIRD_REMINDER_CRON_ACTION_NAME)) {
                wp_schedule_event(time(), 'ahachat_third_reminder', AHACHAT_THIRD_REMINDER_CRON_ACTION_NAME);
            }
            $label = array(
                'name' => 'List User',
                'singular_name' => 'List User'
            );
            $args = array(
                'labels' => $label,
                'description' => 'List user',
                'supports' => array(
                    'title',
                    'trackbacks',
                    'revisions',
                    'custom-fields'
                ),
                'hierarchical' => false,
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => false, // true
                'show_in_nav_menus' => false,
                'show_in_admin_bar' => false,
                'menu_position' => 5,
                'menu_icon' => '',
                'can_export' => false,
                'has_archive' => false,
                'exclude_from_search' => false,
                'publicly_queryable' => true,
                'capability_type' => 'post' //
            );
            register_post_type(AHACHAT_USER_ADD_TO_CART_POST_TYPE, $args);
            $label1 = array(
                'name' => 'List User Get Email',
                'singular_name' => 'List User Email'
            );
            $args1 = array(
                'labels' => $label1,
                'description' => 'List user Get Email',
                'supports' => array(
                    'title',
                    'trackbacks',
                    'revisions',
                    'custom-fields'
                ),
                'hierarchical' => false,
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => false, // true
                'show_in_nav_menus' => false,
                'show_in_admin_bar' => false,
                'menu_position' => 5,
                'menu_icon' => '',
                'can_export' => false,
                'has_archive' => false,
                'exclude_from_search' => false,
                'publicly_queryable' => true,
                'capability_type' => 'post' //
            );
            register_post_type(AHACHAT_LIST_EMAIL_POST_TYPE, $args1);
        }

        public function ahachat_setup_db()
        {
            global $wpdb;
            $charset_collate = $wpdb->get_charset_collate();
            $tableUserRef = AHACHAT_USER_REF_TABLE;
            $tableAnalystic = AHACHAT_ANALYTICS_TABLE;
            $tableAnalysticFB = AHACHAT_ANALYTICS_FB_TABLE;
            $tableShortcode = AHACHAT_SHORTCODES_TABLE;

            if ($wpdb->get_var("show tables like '$tableUserRef'") != $tableUserRef) {
                createAhaChatUserRefTable($tableUserRef, $charset_collate);
            }
            if ($wpdb->get_var("show tables like '$tableAnalystic'") != $tableAnalystic) {
                createAhaChatAnalyticTable($tableAnalystic, $charset_collate);
            }
            if ($wpdb->get_var("show tables like '$tableAnalysticFB'") != $tableAnalysticFB) {
                createAhaChatAnalyticFBTable($tableAnalysticFB, $charset_collate);
            }
            if ($wpdb->get_var("show tables like '$tableShortcode'") != $tableShortcode) {
                createAhaChatShortCodeTable($tableShortcode, $charset_collate);
            }

            if (!get_option('ahachat_app_enable_status')) {
                update_option('ahachat_app_enable_status', "on");
            }
        }

        public function ahachat_finish_cronjob()
        {
            // find out when the last event was scheduled
            $timestamp1 = wp_next_scheduled(AHACHAT_FIRST_REMINDER_CRON_ACTION_NAME);
            // unschedule previous event if any
            wp_unschedule_event($timestamp1, AHACHAT_FIRST_REMINDER_CRON_ACTION_NAME);
            // find out when the last event was scheduled
            $timestamp2 = wp_next_scheduled(AHACHAT_SECOND_REMINDER_CRON_ACTION_NAME);
            // unschedule previous event if any
            wp_unschedule_event($timestamp2, AHACHAT_SECOND_REMINDER_CRON_ACTION_NAME);
            $timestamp3 = wp_next_scheduled(AHACHAT_THIRD_REMINDER_CRON_ACTION_NAME);
            // unschedule previous event if any
            wp_unschedule_event($timestamp2, AHACHAT_THIRD_REMINDER_CRON_ACTION_NAME);
        }

        // Check Woo Install
        public function ahachat_notice_woo()
        {
            $plugin = get_plugin_data(__FILE__);
            echo '
				  <div class="error"> <!-- calss default wordpress-->
				    <p>' . sprintf(__('<strong>%s</strong> requires <strong><a href="https://vi.wordpress.org/plugins/woocommerce/" target="_blank">WooCommerce</a></strong> plugin to be installed and activated on your site.', AHACHAT_WP), $plugin['Name']) . '</p>
				  </div>';
        }
    }

    if (!function_exists('createAhaChatUserRefTable')) {
        function createAhaChatUserRefTable($table, $charset_collate)
        {
            $sql = 'CREATE TABLE ' . $table . ' (
		              `id` int(11) NOT NULL AUTO_INCREMENT,
		              `user_ref` TEXT NOT NULL,
		              `your_cart` TEXT NULL,
		              `session_key` VARCHAR(255) NOT NULL,
		              `status_send_first` int(11) NOT NULL default 0,
		              `status_send_second` int(11) NOT NULL default 0,
		              `status_send_third` int(11) NOT NULL default 0,
		              `is_shortcode` int(11) NOT NULL default 0,
		              `create_time` DATETIME NOT NULL, 
		              `update_time` DATETIME NOT NULL,
		               UNIQUE KEY id (id)
		              ) ' . $charset_collate . ';';
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
            dbDelta($sql);
        }
    }
    if (!function_exists('createAhaChatAnalyticTable')) {
        function createAhaChatAnalyticTable($table, $charset_collate)
        {
            $sql = 'CREATE TABLE ' . $table . ' (
		              `id` int(11) NOT NULL AUTO_INCREMENT,
		              `user_test` double NOT NULL default 0,
		              `send_user` double NOT NULL default 0,
		              `coupon_user` double NOT NULL default 0,
		              `coupon_sent` double NOT NULL default 0,
		              `list_coupon_user` TEXT NULL,
		              `shortcode_user` double NOT NULL default 0,
		              `shortcode_sent` double NOT NULL default 0,
		              `list_shortcode_user` TEXT NULL,
		              `first_reminder_sent` double NOT NULL default 0,
		              `second_reminder_sent` double NOT NULL default 0,
		              `third_reminder_sent` double NOT NULL default 0,
		              `list_user` TEXT NULL,
		              `day` int(11) NOT NULL,
		              `month` int(11) NOT NULL,
		              `year` int(11) NOT NULL,
		              `date_statis` DATE NOT NULL, 
		               UNIQUE KEY id (id)
		              ) ' . $charset_collate . ';';
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
            dbDelta($sql);
        }
    }
    if (!function_exists('createAhaChatAnalyticFBTable')) {
        function createAhaChatAnalyticFBTable($table, $charset_collate)
        {
            $sql = 'CREATE TABLE ' . $table . ' (
		              `id` int(11) NOT NULL AUTO_INCREMENT,
		              `count_user_click` double NOT NULL default 0,
		              `count_user_order` double NOT NULL default 0,
		              `order_total_suc` double NOT NULL default 0,
		              `first_reminder` TEXT NULL,
		              `second_reminder` TEXT NULL,
		              `third_reminder` TEXT NULL,
		              `arr_order` TEXT NULL,
		              `day` int(11) NOT NULL,
		              `month` int(11) NOT NULL,
		              `year` int(11) NOT NULL,
		              `date_statis` DATE NOT NULL, 
		               UNIQUE KEY id (id)
		              ) ' . $charset_collate . ';';
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
            dbDelta($sql);
        }
    }
    if (!function_exists('createAhaChatShortCodeTable')) {
        function createAhaChatShortCodeTable($table, $charset_collate)
        {
            $sql = 'CREATE TABLE ' . $table . ' (
		              `id` int(11) NOT NULL AUTO_INCREMENT,
		              `title` TEXT NULL,
		              `sub_title` TEXT NULL,
		              `button_type` TEXT NULL,
		              `message_type` TEXT NULL,
		              `text_type_cb` TEXT NULL,
		              `list_product` TEXT NULL,
		              `message` TEXT NULL,
		              `message_cb` TEXT NULL,
		               UNIQUE KEY id (id)
		              ) ' . $charset_collate . ';';
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
            dbDelta($sql);
        }
    }
endif;
new AHACHAT_WP_SETUP;
