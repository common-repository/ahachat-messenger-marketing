<?php   if(!class_exists('WP_List_Table')){    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );}class AHACHAT_ADD_TO_CART_USER_AUDIENCE extends WP_List_Table{    private  $locale;        function __construct(){        global $status, $page;                      //Set parent defaults        parent::__construct( array(            'singular'  => __( 'List User', AHACHAT_WP ),            'plural'    => __( 'List User', AHACHAT_WP ),            'ajax'      => false                ) );        $this->locale = array(                          'af_ZA' => 'Afrikaans',                          // Arabic                          'ar_AR' => 'Arabic',                          // Azerbaijani                          'az_AZ' => 'Azerbaijani',                          // Belarusian                          'be_BY' => 'Belarusian',                          // Bulgarian                          'bg_BG' => 'Bulgarian',                          // Bengali                          'bn_IN' => 'Bengali',                          // Bosnian                          'bs_BA' => 'Bosnian',                          // Catalan                          'ca_ES' => 'Catalan',                          // Czech                          'cs_CZ' => 'Czech',                          // Welsh                          'cy_GB' => 'Welsh',                          // Danish                          'da_DK' => 'Danish',                          // German                          'de_DE' => 'German',                          // Greek                          'el_GR' => 'Greek',                          // English (UK)                          'en_GB' => 'English (GB)',                          // English (Pirate)                          'en_PI' => 'English (Pirate)',                          // English (Upside Down)                          'en_UD' => 'English (Upside Down)',                          // English (US)                          'en_US' => 'English (US)',                          // Esperanto                          'eo_EO' => 'Esperanto',                          // Spanish (Spain)                          'es_ES' => 'Spanish (Spain)',                          // Spanish                          'es_LA' => 'Spanish',                          // Estonian                          'et_EE' => 'Estonian',                          // Basque                          'eu_ES' => 'Basque',                          // Persian                          'fa_IR' => 'Persian',                          // Leet Speak                          'fb_LT' => 'Leet Speak',                          // Finnish                          'fi_FI' => 'Finnish',                          // Faroese                          'fo_FO' => 'Faroese',                          // French (Canada)                          'fr_CA' => 'French (Canada)',                          // French (France)                          'fr_FR' => 'French (France)',                          // Frisian                          'fy_NL' => 'Frisian',                          // Irish                          'ga_IE' => 'Irish',                          // Galician                          'gl_ES' => 'Galician',                          // Hebrew                          'he_IL' => 'Hebrew',                          // Hindi                          'hi_IN' => 'Hindi',                          // Croatian                          'hr_HR' => 'Croatian',                          // Hungarian                          'hu_HU' => 'Hungarian',                          // Armenian                          'hy_AM' => 'Armenian',                          // Indonesian                          'id_ID' => 'Indonesian',                          // Icelandic                          'is_IS' => 'Icelandic',                          // Italian                          'it_IT' => 'Italian',                          // Japanese                          'ja_JP' => 'Japanese',                          // Georgian                          'ka_GE' => 'Georgian',                          // Khmer                          'km_KH' => 'Khmer',                          // Korean                          'ko_KR' => 'Korean',                          // Kurdish                          'ku_TR' => 'Kurdish',                          // Latin                          'la_VA' => 'Latin',                          // Lithuanian                          'lt_LT' => 'Lithuanian',                          // Latvian                          'lv_LV' => 'Latvian',                          // Macedonian                          'mk_MK' => 'Macedonian',                          // Malayalam                          'ml_IN' => 'Malayalam',                          // Malay                          'ms_MY' => 'Malay',                          // Norwegian (bokmal)                          'nb_NO' => 'Norwegian (bokmal)',                          // Nepali                          'ne_NP' => 'Nepali',                          // Dutch                          'nl_NL' => 'Dutch',                          // Norwegian (nynorsk)                          'nn_NO' => 'Norwegian (nynorsk)',                          // Punjabi                          'pa_IN' => 'Punjabi',                          // Polish                          'pl_PL' => 'Polish',                          // Pashto                          'ps_AF' => 'Pashto',                          // Portuguese (Brazil)                          'pt_BR' => 'Portuguese (Brazil)',                          // Portuguese (Portugal)                          'pt_PT' => 'Portuguese (Portugal)',                          // Romanian                          'ro_RO' => 'Romanian',                          // Russian                          'ru_RU' => 'Russian',                          // Slovak                          'sk_SK' => 'Slovak',                          // Slovenian                          'sl_SI' => 'Slovenian',                          // Albanian                          'sq_AL' => 'Albanian',                          // Serbian                          'sr_RS' => 'Serbian',                          // Swedish                          'sv_SE' => 'Swedish',                          // Swahili                          'sw_KE' => 'Swahili',                          // Tamil                          'ta_IN' => 'Tamil',                          // Telugu                          'te_IN' => 'Telugu',                          // Thai                          'th_TH' => 'Thai',                          // Filipino                          'tl_PH' => 'Filipino',                          // Turkish                          'tr_TR' => 'Turkish',                          //                          'uk_UA' => 'Ukrainian',                          // Vietnamese                          'vi_VN' => 'Vietnamese',                          //                          'zh_CN' => 'Simplified Chinese (China)',                          //                          'zh_HK' => 'Traditional Chinese (Hong Kong)',                          //                          'zh_TW' => 'Traditional Chinese (Taiwan)',        );           }    function get_custom_post( $per_page = 5, $page_number = 1){        global $wpdb,$post,$wp_query;        $users = array();        $args=array();        $result = array();        $args_locale='';        $args_gender='';        $args_type='';         $def=array(          'paged' => $page_number,          'posts_per_page' => $per_page,          'post_type'=>AHACHAT_USER_ADD_TO_CART_POST_TYPE,        );        $arg_s_1 = array();        if (!empty($_REQUEST['s'])) {          $arg_s_1 =array(              'relation' => 'OR',                array(                     'key' => 'ahachat_first_name_user',                    'value' =>$_REQUEST['s'],                    'compare'=>'LIKE'                  ),                array(                     'key' => 'ahachat_last_name_user',                    'value' =>$_REQUEST['s'],                    'compare'=>'LIKE'                  )              );          }        if (isset($_REQUEST['locale']) && !empty($_REQUEST['locale'])) {            $args_locale=array(                      'key' => 'ahachat_locale_user',                      'value' =>$_REQUEST['locale'],                      'compare'=>'='                       );        }        if (isset($_REQUEST['gender']) && !empty($_REQUEST['gender'])) {            $args_gender=array(                      'key' => 'ahachat_gender_user',                      'value' =>$_REQUEST['gender'],                      'compare'=>'='                      );          }        if (isset($_REQUEST['type']) && !empty($_REQUEST['type'])) {            $args_type=array(                      'key' => 'ahachat_type',                      'value' =>$_REQUEST['type'],                      'compare'=>'like'                      );          }        $args_sender=array(                      'key' => 'ahachat_sender_id',                      'value' =>"-",                      'compare'=>'!='                      );        $args = array(              'meta_query' => array(                  'relation' => 'AND',                  $args_locale,                  $args_gender,                  $arg_s_1,                  $args_type,                  $args_sender            ),        );         $args = wp_parse_args($args,$def);        $users  = new  WP_Query($args);      return $users;    }    public function loops($users){        $result = array();        if($users->have_posts()){        while ($users->have_posts()){          $users->the_post();          $result[]=get_post(get_the_id(),'ARRAY_A');        }      }      return $result;    }    public function no_items() {        _e( 'No User avaliable.', AHACHAT_WP );    }        function column_cb($item){        return sprintf(            '<input type="checkbox" name="%1$s[]" value="%2$s" />',            /*$1%s*/ $this->_args['singular'],              /*$2%s*/ $item['ID']                        );    }    function column_id($item){        return $item['ID'];    }        function column_avatar($item){      if(get_post_meta($item['ID'],'ahachat_avatar_user' ,true)!="-"){          $fb_api = new AHACHAT_WP_API();          $sender_id=get_post_meta($item['ID'],'ahachat_sender_id' ,true);          $page_access_token=$fb_api->AHA_Get_Access_Token_Page();          $page_token=$page_access_token["access_token"];          $array_info=$fb_api->AHA_Get_Info_User_With_Recepit_ID($page_token,$sender_id);          $href = 'https://facebook.com/' . get_post_meta($item['ID'],'ahachat_id_user' ,true) ;          return sprintf('<a href="%2$s" target="_blank" ><img width="30" src="%1$s" /></a>',$array_info["profile_pic"],$href);          //return sprintf('<a href="%2$s" target="_blank" ><img width="30" src="%1$s" /></a>',get_post_meta($item['ID'],'ahachat_avatar_user' ,true),$href);      }else{        return "-";      }              }    function column_first_name($item){             return get_post_meta($item['ID'],'ahachat_first_name_user' ,true);          }    function column_last_name($item){          return get_post_meta($item['ID'],'ahachat_last_name_user' ,true);        }    function column_gender($item){      return get_post_meta($item['ID'],'ahachat_gender_user' ,true);    }    function column_locale($item){      $key=get_post_meta($item['ID'],'ahachat_locale_user' ,true);      if($key!="-"){        return  $this->locale[$key] ;      }else{        return "-";      }          }    function column_day($item){      return get_the_date('m/d/Y',$item['ID']);    }        function column_cookie_browser($item){      //ahachat_recipient_id_user        return get_post_meta($item['ID'],'ahachat_cookie_browser' ,true);    }        function column_user_ref($item){        return get_post_meta($item['ID'],'ahachat_page_id' ,true);    }    function column_sender_id($item){        return get_post_meta($item['ID'],'ahachat_sender_id' ,true);    }    function column_product($item){                $arr_product_quantity=unserialize(get_post_meta($item['ID'],'ahachat_product_user' ,true));          if(!empty(get_post_meta($item['ID'],'ahachat_product_user' ,true))){                  if(count($arr_product_quantity)>0){                    foreach ($arr_product_quantity as $key => $product) {                      if($product["product_id"]!=0 && $product["product_id"]!=-1 ){                        $title=get_the_title($product["product_id"]);                        $quantity=$product["quantity"];                        $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $product["product_id"], "thumbnail" ))[0];                        ?>                        <p><img style="width: 20px;height: 20px;float: left;padding: 0 10px;" src="<?php echo $image_url; ?>"><?php echo $title.' X'.$quantity; ?></p>                        <?php                      }/*else{                        echo "<p style='padding: 0 10px;'>Coupon</p>";                      }*/                                                              }                                     }          }else{            return "-";          }            }    function column_type($item){        if(!get_post_meta($item['ID'],'ahachat_type' ,true)){            update_post_meta($item['ID'],'ahachat_type' ,'Add-to-cart');            return get_post_meta($item['ID'],'ahachat_type' ,true);        }else{            $list_type=get_post_meta($item['ID'],'ahachat_type',true);            $array_type=explode(",", $list_type);            $ahachat_type=implode(", ", $array_type);            return $ahachat_type;        }            }    // GET FILEDS TABLE CUSTOM    public function get_columns(){        $columns = array(            'cb'        => '<input type="checkbox" />',            'id'    =>__('ID',AHACHAT_WP),            'avatar'=>__('Avatar',AHACHAT_WP),            'first_name'     => __('First Name',AHACHAT_WP),            'last_name'     => __('Last Name',AHACHAT_WP),            'gender'    => __('Gender',AHACHAT_WP),            'locale' =>__('Locale',AHACHAT_WP),            //'cookie_browser' => __('Cookie Browser',AHACHAT_WP),            //'user_ref' =>__('Page ID',AHACHAT_WP),            //'sender_id' =>__('Sender ID',AHACHAT_WP),            'product'=>__('Product',AHACHAT_WP),            'type'=>__('Type',AHACHAT_WP),            'day' =>__('Date',AHACHAT_WP),        );        return $columns;    }    // GET SHOW BULK ACTIONS    public function get_bulk_actions() {        $actions = array(            'delete'    => __('Delete',AHACHAT_WP),        );        return $actions;    }    // PROCESS BULK ACTION CUSTOM    public function process_bulk_action() {        if ( 'delete' === $this->current_action() )         {          if((isset( $_GET['action']) && $_GET['action'] == 'delete')||isset( $_GET['action2']) && $_GET['action2'] == 'delete'){            $delete_ids = esc_sql( $_GET['listuser'] );                     foreach ( $delete_ids as $id ) {                             wp_delete_post($id);              }            wp_safe_redirect( add_query_arg( array( 'page' => 'ahachat-audiences','menu' => 'send' ), admin_url( 'admin.php' )));          }else{            self::delete_post( absint( $_GET['listuser'] ));            wp_safe_redirect( add_query_arg( array( 'page' => 'ahachat-audiences','menu' => 'send' ), admin_url( 'admin.php' )));          }           }    }    // SHOW LIST CATEGORY EXTRA TABLE NAV ( SEARCH, FILTER, ...)    public function extra_tablenav($which){        if ($which == 'top') {          ?>          <div class="alignleft actions">                 <?php                $selected_locale = ((isset($_GET['locale'])) ? $_GET['locale']: '');                $locales = $this->locale;              ?>              <select name="locale" id="">                  <option value="" <?php selected('', $selected_locale); ?>>                      <?php _e('All Locales', AHACHAT_WP); ?>                  </option>                  <?php                  foreach ($locales as $k => $v) {                      print_r($v);                      // if (!empty($v->locale)) {                          echo sprintf('<option value="%1$s" %3$s>%2$s</option>', esc_attr($k),$v , selected($k, $selected_locale, false));                      //}                  }                  ?>              </select>              <?php              /*               * Filter by gender               */              $selected_gender = ((isset($_GET['gender'])) ? $_GET['gender']: '');              $genders = array('male', 'female');              ?>              <select name="gender" id="">                  <option value="" <?php selected('', $selected_gender); ?>>                      <?php _e('All Genders', AHACHAT_WP); ?>                  </option>                  <?php                  foreach ($genders as $k => $v) {                      echo sprintf('<option value="%1$s" %3$s>%2$s</option>', $v, $v, selected($v, $selected_gender, false));                  }                  ?>              </select>              <?php              /*******Type****/              $selected_type = ((isset($_GET['type'])) ? $_GET['type']: '');              $types = array(                          'Add-to-cart' => 'Add-to-cart',                          // Arabic                          'Coupon' => 'Coupon',                          // Azerbaijani                          'Shortcode' => 'Shortcode',                        /*                            // Belarusian                          'Add-to-cart,Coupon' => 'Add-to-cart & Coupon',                          // Bulgarian                          'Add-to-cart,Shortcode' => 'Add-to-cart & Shortcode',                          // Bengali                          'Coupon,Shortcode' => 'Coupon & Shortcode',                        */                          );              ?>              <select name="type" id="">                  <option value="" <?php selected('', $selected_type); ?>>                      <?php _e('All Type', AHACHAT_WP); ?>                  </option>                  <?php                  print_r($types);                  foreach ($types as $k => $v) {                      echo sprintf('<option value="%1$s" %3$s>%2$s</option>', esc_attr($k), $v, selected($k, $selected_type, false));                  }                  ?>              </select>              <!--/*******Type****/-->              <input type="submit" name="filter_action" class="button action" value="<?php _e('Filter',AHACHAT_WP); ?>">                                          <div style="margin:0;margin-left: 15px;" class="button button-primary abd_sen_message">                <?php echo __('Send Messages', AHACHAT_WP); ?>              </div>            </div>          <?php        }    }    public  function record_count(){      $count =self::get_custom_post(-1);      return $count->post_count;      }    public  function column_default($item, $column_name)    {        return ((in_array($column_name, array_keys($this->get_columns()))) ? $item[$column_name] : print_r($item, true));    }    // SHOW TABLE CUSTOM    public function prepare_items() {        $per_page = $this->get_items_per_page('ahachat_user_per_page', 20);        $columns = $this->get_columns();        $hidden = array();        $sortable = $this->get_sortable_columns();        $this->_column_headers = array($columns,$hidden,$sortable);  // SHOW COLUM FIELDS CUSTOM        $this->process_bulk_action();        $current_page = $this->get_pagenum();         $total_items  = self::record_count();        $loops = $this->get_custom_post($per_page,$current_page);        $this->items = $this->loops($loops);        $this->set_pagination_args( array(            'total_items' => $total_items,                              'per_page'    => $per_page,               ) );    }}?>