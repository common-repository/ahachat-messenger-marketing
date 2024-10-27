<?phpclass AHA_POST_TYPE_USER_ADD_TO_CART{    public function __construct()    {    }    public function CheckUserExit($args = false)    {        $default = array(            'post_type' => AHACHAT_USER_ADD_TO_CART_POST_TYPE,            'post_status' => array('publish', 'pending', 'future'),            'meta_query' => array(                'relation' => 'AND',                array(                    'key' => 'ahachat_cookie_browser',                    'value' => $args['cookie_browser'],                    'compare' => '='                ),                array(                    'key' => 'ahachat_page_id',                    'value' => $args['page_id'],                    'compare' => '='                ),            ),        );        if ($args != false) {            $posts = new WP_Query($default);            if ($posts->have_posts()) {                return true;            }        }        return false;    }    public function Aha_Post_ID($args = false)    {        $default = array(            'post_type' => AHACHAT_USER_ADD_TO_CART_POST_TYPE,            'post_status' => array('publish', 'pending', 'future'),            'meta_query' => array(                'relation' => 'AND',                array(                    'key' => 'ahachat_cookie_browser',                    'value' => $args['cookie_browser'],                    'compare' => '='                ),                array(                    'key' => 'ahachat_page_id',                    'value' => $args['page_id'],                    'compare' => '='                ),            ),        );        if ($args != false) {            $posts = new WP_Query($default);            if ($posts->have_posts()) {                return $posts->post->ID;            }        }        return false;    }    //    public function CheckUserRefExit($args = false)    {        $default = array(            'post_type' => AHACHAT_USER_ADD_TO_CART_POST_TYPE,            'post_status' => array('publish', 'pending', 'future'),            'meta_query' => array(                'relation' => 'AND',                array(                    'key' => 'ahachat_user_ref',                    'value' => $args['user_ref'],                    'compare' => '='                ),                array(                    'key' => 'ahachat_page_id',                    'value' => $args['page_id'],                    'compare' => '='                ),            ),        );        if ($args != false) {            $posts = new WP_Query($default);            if ($posts->have_posts()) {                return true;            }        }        return false;    }    public function Aha_Post_User_Ref_ID($args = false)    {        $default = array(            'post_type' => AHACHAT_USER_ADD_TO_CART_POST_TYPE,            'post_status' => array('publish', 'pending', 'future'),            'meta_query' => array(                'relation' => 'AND',                array(                    'key' => 'ahachat_user_ref',                    'value' => $args['user_ref'],                    'compare' => '='                ),                array(                    'key' => 'ahachat_page_id',                    'value' => $args['page_id'],                    'compare' => '='                ),            ),        );        if ($args != false) {            $posts = new WP_Query($default);            if ($posts->have_posts()) {                return $posts->post->ID;            }        }        return false;    }    //    public function Check_Sender_ID_User_Exit($args = false)    {        $default = array(            'post_type' => AHACHAT_USER_ADD_TO_CART_POST_TYPE,            'post_status' => array('publish', 'pending', 'future'),            'meta_query' => array(                'relation' => 'AND',                array(                    'key' => 'ahachat_sender_id',                    'value' => $args['sender_id'],                    'compare' => '='                ),                array(                    'key' => 'ahachat_page_id',                    'value' => $args['page_id'],                    'compare' => '='                ),            ),        );        if ($args != false) {            $posts = new WP_Query($default);            if ($posts->have_posts()) {                return true;            }        }        return false;    }    public function Count_Found_Post_Sender_ID($args = false)    {        $default = array(            'post_type' => AHACHAT_USER_ADD_TO_CART_POST_TYPE,            'posts_per_page' => -1,            'post_status' => array('publish', 'pending', 'future'),            'meta_query' => array(                'relation' => 'AND',                array(                    'key' => 'ahachat_sender_id',                    'value' => $args['sender_id'],                    'compare' => '='                ),                array(                    'key' => 'ahachat_page_id',                    'value' => $args['page_id'],                    'compare' => '='                ),            ),        );        if ($args != false) {            $posts = get_posts($default);            return $posts;        }        return array();    }    //    public function Count_Found_Post_Cookie_Browser($args = false)    {        $default = array(            'post_type' => AHACHAT_USER_ADD_TO_CART_POST_TYPE,            'posts_per_page' => -1,            'post_status' => array('publish', 'pending', 'future'),            'meta_query' => array(                'relation' => 'AND',                array(                    'key' => 'ahachat_cookie_browser',                    'value' => $args['cookie_browser'],                    'compare' => '='                ),                array(                    'key' => 'ahachat_page_id',                    'value' => $args['page_id'],                    'compare' => '='                ),            ),        );        if ($args != false) {            $posts = get_posts($default);            return $posts;        }        return false;    }    //    public function Check_Sender_ID_Post($args = false)    {        $default = array(            'post_type' => AHACHAT_USER_ADD_TO_CART_POST_TYPE,            'post_status' => array('publish', 'pending', 'future'),            'meta_query' => array(                'relation' => 'AND',                array(                    'key' => 'ahachat_sender_id',                    'value' => $args['sender_id'],                    'compare' => '='                ),                array(                    'key' => 'ahachat_page_id',                    'value' => $args['page_id'],                    'compare' => '='                ),            ),        );        if ($args != false) {            $posts = new WP_Query($default);            if ($posts->have_posts()) {                return $posts->post->ID;            }        }        return false;    }    public function Insert($args = false)    {        $arr = array(            'post_content' => $args['mess'],            'post_date' => $args['post_date'],            'post_date_gmt' => $args['post_date'],            'post_type' => $args['post_type'],            'post_title' => wp_trim_words($args['mess'], 200),            'post_status' => 'publish',        );                if ($args != false && is_array($args)) {            $insert_id = wp_insert_post($arr);            if ($args['post_type'] == AHACHAT_USER_ADD_TO_CART_POST_TYPE) {                update_post_meta($insert_id, 'ahachat_id_user', $args['ahachat_id_user']);                update_post_meta($insert_id, 'ahachat_avatar_user', $args['ahachat_avatar_user']);                update_post_meta($insert_id, 'ahachat_first_name_user', $args['ahachat_first_name_user']);                update_post_meta($insert_id, 'ahachat_last_name_user', $args['ahachat_last_name_user']);                update_post_meta($insert_id, 'ahachat_gender_user', $args['ahachat_gender_user']);                update_post_meta($insert_id, 'ahachat_locale_user', $args['ahachat_locale_user']);                update_post_meta($insert_id, 'ahachat_recipient_id_user', $args['ahachat_recipient_id_user']);                update_post_meta($insert_id, 'ahachat_user_ref', $args['ahachat_user_ref']);                update_post_meta($insert_id, 'ahachat_cookie_browser', $args['ahachat_cookie_browser']);                update_post_meta($insert_id, 'ahachat_page_id', $args['ahachat_page_id']);                update_post_meta($insert_id, 'ahachat_product_user', $args['ahachat_product_user']);                update_post_meta($insert_id, 'ahachat_sender_id', $args['ahachat_sender_id']);                update_post_meta($insert_id, 'ahachat_type', $args['ahachat_type']);                update_post_meta($insert_id, 'ahachat_user_blacklist', $args['ahachat_user_blacklist']);            }            return $insert_id;        }        return false;    }    public function Aha_Check_Session_ID($args = false)    {        $default = array(            'post_type' => AHACHAT_USER_ADD_TO_CART_POST_TYPE,            'post_status' => array('publish', 'pending', 'future'),            'meta_query' => array(                'relation' => 'AND',                array(                    'key' => 'ahachat_session_id',                    'value' => $args['session_id'],                    'compare' => '='                ),                array(                    'key' => 'ahachat_page_id',                    'value' => $args['page_id'],                    'compare' => '='                ),            ),        );        if ($args != false) {            $posts = new WP_Query($default);            if ($posts->have_posts()) {                return true;            }        }        return false;    }    public function Aha_Session_ID($args = false)    {        $default = array(            'post_type' => AHACHAT_USER_ADD_TO_CART_POST_TYPE,            'post_status' => array('publish', 'pending', 'future'),            'meta_query' => array(                'relation' => 'AND',                array(                    'key' => 'ahachat_session_id',                    'value' => $args['session_id'],                    'compare' => '='                ),                array(                    'key' => 'ahachat_page_id',                    'value' => $args['page_id'],                    'compare' => '='                ),            ),        );        if ($args != false) {            $posts = new WP_Query($default);            if ($posts->have_posts()) {                return $posts->post->ID;            }        }        return false;    }}?>