<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if(!class_exists('AHACHAT_WP_PLUGINS')){
	class AHACHAT_WP_PLUGINS{
        private $hasCouponCss = false;

		public function __construct() {
			add_action('init', array($this,'ahachat_advoid_do_output_buffer')); //(1)
			add_action('wp_head',array($this,'ahachat_wp_head'),1,2);
			if(get_option('ahachat_app_enable_status')){
				add_action('wp_enqueue_scripts', array( $this, 'frontend_styles' ) );
			}
			
			add_action('woocommerce_after_add_to_cart_button', array($this,'add_button_facebook_after_add_to_cart'), 12);
			add_shortcode('cartback',array($this,'ahachat_cartback_shortcode'));
			//	UPDATE 19/10/2018  ADD CHECKBOX AFTER PLACE ORDER BUTTON
			if(get_option("cb_messenger_receipt")){
				$messenger_receipt = get_option("cb_messenger_receipt");
				$ahachat_enable_checkbox_checkout=get_option('ahachat_enable_checkbox_checkout');
				if(isset($messenger_receipt["on_off"]) && $ahachat_enable_checkbox_checkout=="on"){
					add_action( 'woocommerce_review_order_after_payment',array($this,'ahachat_add_messenger_plugin_checkout'));
				}
			}
			//
		}
		protected function _shortcode_atts($defaults=array(),$atts){
		    if(isset($atts['class']))
		      $atts['defined_class'] = $atts['class'];
		    return shortcode_atts ( $defaults, $atts );
	    }
	    public function ahachat_cartback_shortcode($atts, $content = null){
		      extract ( $this->_shortcode_atts ( array (
		        'id' => '',
		      ), $atts ) );
		      ob_start ();
		  		global $wpdb;
				$table_shortcode = AHACHAT_SHORTCODES_TABLE;
				$id_shortcode=(int)$id;
				$shortcode_selected=$wpdb->get_row("SELECT * FROM $table_shortcode WHERE id='".$id_shortcode."'");
				if($shortcode_selected->button_type=="checkbox"){
					$this->ahachat_show_messenger_checkbox_withshortcode($shortcode_selected->id,$shortcode_selected->text_type_cb,$shortcode_selected->title,$shortcode_selected->sub_title,$shortcode_selected->message_type,$shortcode_selected->message_cb,$shortcode_selected->list_product);
				}else{
					echo $messenger=$this->ahachat_show_messenger_with_shortcode($shortcode_selected->id,$shortcode_selected->title,$shortcode_selected->sub_title);
				}
		      return ob_get_clean ();
	    }
		public function ahachat_advoid_do_output_buffer(){
			ob_start();
			delete_option('cartback_popup_email');
			global $random_val,$wp;
			$random_val=md5(rand(111111111,99999999));
		}
		public function ahachat_wp_head(){
			$domain_url=home_url('/');
			//
			if (is_user_logged_in() ){
				$logged = 1;
				$user_info = wp_get_current_user();
				$email_login = $user_info->user_email;
			}else{
				$logged = 0;
				$email_login = "";
			}
            wp_enqueue_style('ahachat_frontend_style', AHACHAT_WP_PLUGIN_PATH.'assets/css/'.AHACHAT_PREFIX.'frontend.css', array(), AHACHAT_WP_VER);
			?>
            <script type='text/javascript' src="<?php echo $domain_url.'wp-includes/js/jquery/jquery.js';?>"></script>
			<script type="text/javascript">
				var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";	
			</script>
			<?php 
				$ahachat_enable_alow_user_add_cart=get_option('ahachat_allow_user_add_cart');
				if(!empty($ahachat_enable_alow_user_add_cart)){
			?>
				<script type="text/javascript">
						jQuery(document).ready(function(){
						//$("#ahachat_user_click_skip_it").click(function(e){
                            jQuery(document).on('click','#ahachat_user_click_skip_it',function(e){
								$(".img_loading_skipit").show();
								$(".img_loading_skipit").css('display','-webkit-inline-box');
								e.preventDefault();
								//
								var cookie = localStorage.cb_cookie;
							    if(cookie == undefined || cookie == null) {
							      //CREATE COOKIE
							      var day_current = new Date().getTime();
							      localStorage.cb_cookie = day_current;
							      cookie = localStorage.cb_cookie;
							    }
								//
								var action_data = {
									action:'ahachat_skip_it_ontime',
									ahachat_skip_it:"yes",
									cookie_browser:cookie
								};
								$.post(ajaxurl,action_data,function(result){
									console.log(result);
									$(".img_loading_skipit").hide();
									$(".single_add_to_cart_button").removeClass("ahachat_add_user_ref");
									$(".single_add_to_cart_button").click();       
								});
							});
						});
				</script>
			<?php } ?>
			<?php 
				$app_id=get_option('ahachat_app_id');
				$page_id=get_option('ahachat_page_id');
			?>
			<?php if(!empty($app_id)):?>
					<?php
						$app_languages="en_US";
					?>
						<script>
							 var abd_state;
							 var status_user_fb;
							 window.fbAsyncInit = function() {
							    FB.init({
							      appId      : <?php echo $app_id; ?>,
							      xfbml      : true,
							      version    : 'v2.10'
							    });
							    /*Event when use click Send Messenger Coupon*/
								FB.Event.subscribe('send_to_messenger', function(e) {
	  								//console.log(e);
		  							});
								/*Event Check status user login?*/
								FB.getLoginStatus(function(response) {
	  						  		console.log(response.status);
							        if (response.status === 'connected') {
							          //console.log(response);
							          //console.log('connected to app');
							        } else if (response.status === 'not_authorized') {
							          //console.log('not connected to app');
							        } else {
							          //console.log('not logged in to fb');
							        }
							        status_user_fb=response.status;
      							});
	  							/*Event when use click Send Messenger Coupon*/
							    FB.Event.subscribe('messenger_checkbox', function(e) {
							  		//console.log(e);
								    if (e.event == 'checkbox') {
								        var checkboxState = e.state;
								        abd_state=checkboxState;
								        //console.log("Checkbox state: " + checkboxState);
								    } else if (e.event == 'not_you') {
								        console.log("User clicked 'not you'");
								    } else if (e.event == 'hidden') {
								        console.log("Plugin was hidden");
								    }
	    						});
							  };
							  (function(d, s, id){
							    var js, fjs = d.getElementsByTagName(s)[0];
							      if (d.getElementById(id)) {return;}
							      js = d.createElement(s); js.id = id;
							      js.src = "https://connect.facebook.net/<?php echo $app_languages; ?>/sdk.js";
							      fjs.parentNode.insertBefore(js, fjs);
							    }(document, 'script', 'facebook-jssdk')
							  );
						</script>
			<?php endif; ?>
				<!-- -->
		<?php if(!empty($app_id)):  ?>
			<?php $ahachat_enable_skipit_on_time=get_option('ahachat_is_skip_ontime'); $cartback_popup_email=get_option("cartback_popup_email");?>
				<script type="text/javascript">
                    (function($) {
                        $(document).ready(function(){
                                //localStorage.removeItem("cb_cookie");
                                //localStorage.removeItem("cb_cookie_popup");
                                //console.log(localStorage.addcart_usf);
                                //localStorage.removeItem("addcart_usf");
                                //console.log(localStorage.addcart_usf);
                                //
                                var cookie_expire = 0;
                                <?php if(get_option("cartback_popup_email") && isset($cartback_popup_email["on_off"])){ if(isset($cartback_popup_email["test_mode"])){?>
                                        cookie_expire = 0;
                                <?php }else {?>
                                        cookie_expire = 365;
                                <?php }} ?>
                                var cookie = localStorage.cb_cookie;
                                //
                                var cookie_popup = localStorage.cb_cookie_popup;
                                if(cookie_popup == undefined || cookie_popup == null) {
                                    cookie_popup = 0;
                                }
                                //
                                var day_current = new Date().getTime();
                                if(cookie == undefined || cookie == null) {
                                    //CREATE COOKIE
                                    localStorage.cb_cookie = day_current;
                                    cookie = localStorage.cb_cookie;
                                }
                                var check_cookie = (day_current - cookie_popup)/ (1000 * 60 * 60 * 24);
                                //console.log(cookie_popup);
                                var user_logged = <?php echo $logged; ?>;
                                var user_email = "<?php echo $email_login; ?>";
                                var is_skip_checkbox = <?php echo get_option('ahachat_is_skip_checkbox') ? 1 : 0 ;?>
                                //==use for file js other
                                localStorage.user_logged = user_logged;
                                localStorage.user_email = user_email;
                                //
                                <?php if(get_option("cartback_popup_email") && isset($cartback_popup_email["on_off"])){?>
                                if(check_cookie > cookie_expire && user_logged==0){
                                    //
                                    function validateEmail(email) {
                                        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                                        return re.test(email);
                                    }
                                    function validate(email) {
                                        if (validateEmail(email)) {
                                          return true;
                                        } else {
                                          return false;
                                        }
                                        return false;
                                    }
                                    //
                                    $("button.single_add_to_cart_button").addClass('ahachat_show_popup_email');
                                    $(".single_add_to_cart_button").click(function(e){
                                        if($(this).hasClass('ahachat_show_popup_email')){
                                              e.preventDefault();
                                            $(".ahachat_spider_create_group_popup").addClass("spider-open");
                                        }
                                    });

                                    //
                                }
                                <?php } ?>
                            $(document).on('click','.single_add_to_cart_button',function(e){//
                                if($(this).hasClass('ahachat_add_user_ref')){
                                    //e.preventDefault();
                                    console.log("OK");
                                    if(abd_state=="checked"){
                                        var user_ref=$(this).attr('user_ref');
                                        var product_id=$(this).data('product_id');
                                        var quantity_product=$(this).data('quantity');
                                        var action_data = {
                                            action:'ahachat_add_user_ref',
                                            product_id:product_id,
                                            quantity_product:quantity_product,
                                            user_ref:user_ref,
                                            cookie_user:cookie,
                                            user_email:user_email,
                                            cookie_popup:cookie_popup
                                        };
                                        //
                                        localStorage.addcart_usf = user_ref;
                                        //
                                        $.post(ajaxurl,action_data,function(result){
                                            console.log(user_ref);
                                                    if(result=="error"){
                                                        console.log("error");
                                                    }else{
                                                        console.log(result);
                                                   }
                                        });
                                    }<?php if(!get_option('ahachat_is_skip_checkbox')){?>else if(abd_state=="unchecked"){
                                              <?php if(!get_option('ahachat_is_skip_ontime')){ if(get_option('ahachat_non_login_user')){?>if(status_user_fb == "connected" || status_user_fb== "not_authorized"){
                                                    $('#error_not_check_mes').show();
                                                    return false;
                                                    }
                                              <?php }else{ echo "$('#error_not_check_mes').show();"; echo "return false;";} }else if(!get_option('ahachat_non_login_user')){?>
                                                   var list_cookie = $("#user_exits").val();
                                                    if(list_cookie==""){
                                                        $('#error_not_check_mes').show();
                                                        return false;
                                                    }else{
                                                        var array_cookie = list_cookie.split(",");
                                                        if(!array_cookie.includes(cookie)){
                                                            $('#error_not_check_mes').show();
                                                            return false;
                                                        }
                                                    }
                                              <?php } else {?>if(status_user_fb == "connected" || status_user_fb == "not_authorized"){
                                                    //
                                                    var list_cookie = $("#user_exits").val();
                                                    if(list_cookie==""){
                                                        $('#error_not_check_mes').show();
                                                        return false;
                                                    }else{
                                                        var array_cookie = list_cookie.split(",");
                                                        if(!array_cookie.includes(cookie)){
                                                            $('#error_not_check_mes').show();
                                                            return false;
                                                        }
                                                    }
                                                    //
                                              }<?php } ?>
                                    }<?php }?>
                                }
                            });
                            //
                            $(document).on("click","#place_order",function(e){
                                //e.preventDefault();
                                var user_ref_addcart = localStorage.addcart_usf;
                                if(user_ref_addcart != undefined || user_ref_addcart != null) {
                                    $("#user_addcart_").val(user_ref_addcart);
                                }
                                // add cookie browser when click order (have reminder or not remider);
                                $("#ahachat_cookie_browser").val(cookie);
                                $("#user_cookie_popup_").val(cookie_popup);
                                if(abd_state=="checked"){
                                    var user_ref=$("#user_ref_checkout").val();
                                    $(this).attr("onclick",confirmOptIn(user_ref));
                                    $("#ahachat_user_checked_checkout").val(user_ref);
                                }
                            });
                        });
                    }(jQuery));
					function confirmOptIn(user_ref) {
						FB.AppEvents.logEvent('MessengerCheckboxUserConfirmation', null, {
							            'app_id':<?php echo $app_id; ?>,
							            'page_id':<?php echo get_option('ahachat_page_id'); ?>,
							            'ref':'ahachat_order_<?php echo home_url(); ?>',
							            'user_ref':user_ref
							          });
						console.log(user_ref);
					}
					function confirmOptIn_With_Shortcode(user_ref) {
						FB.AppEvents.logEvent('MessengerCheckboxUserConfirmation', null, {
							            'app_id':<?php echo $app_id; ?>,
							            'page_id':<?php echo $page_id; ?>,
							            'ref':'ahachat_cartback_shortcode',
							            'user_ref':user_ref
						});
						console.log(user_ref);
					}
				</script>
		<?php endif;?>
				<!-- -->
			<?php
		} 
		public function frontend_styles(){
			wp_enqueue_script('sendmgs',AHACHAT_WP_PLUGIN_PATH.'assets/js/ahachat_sendmassager.js',array('jquery'),time());
		}
		/**/
	    public function add_button_facebook_after_add_to_cart(){
			global $product,$random_val;
			//add_filter("rocket_override_donotcachepage",  true );
			//define( 'DONOTCACHEPAGE', true );
			$enable_single=get_option('ahachat_app_enable_status');
			$common=$random_val;
	    	$user_ref=$common.$product->get_id() . '_wp_cart_' . current(explode('/', isSecure() ? 'https': 'http')) . '_' . $_SERVER['HTTP_HOST'];
	    	$ahachat_coupon=get_option('ahachat_coupons');
	    	$type = (isset($ahachat_coupon) && isset($ahachat_coupon['display'])) ? $ahachat_coupon['display'] : "evething";
	    	$cart_ahachat_show_product=get_option('ahachat_show_product');
            $ahachat_customize_coupon=get_option('ahachat_coupon_customize');
            echo $this->getCouponCss($ahachat_customize_coupon);
	    	//print_r($type);
	    	?>
	    	<?php if(empty($enable_single)): ?>
			    	<style type="text/css">
			    		.fb-messenger-checkbox.ahachat_single.fb_iframe_widget{
			    			display: none;
			    		}
			    	</style>
			<?php else:?>
					<style type="text/css">
			    		.fb-messenger-checkbox.ahachat_single.fb_iframe_widget{
			    			display: block !important;
			    		}
			    	</style>
	    	<?php endif;?>
	    	<?php
	    		if(get_option("ahachat_list_user_skip_it")){
	    			$array_list_user_skip_it=get_option("ahachat_list_user_skip_it");
	    			if(!empty($array_list_user_skip_it)){
	    				$array_list_user_skip_it = implode(',', $array_list_user_skip_it);
	    			}
	    		}else{
	    			$array_list_user_skip_it="";
	    		} 
	    	?>
	    	<br/><br/>
	    	<?php if(get_option('ahachat_app_enable_status')){?>
	    		
	    		<input type="hidden" id="ahachat_random_val" value="<?php echo $user_ref; ?>"><input type="hidden" id="ahachat_product_id" value="<?php echo $product->get_id(); ?>"><input type="hidden" id="user_exits" value="<?php echo $array_list_user_skip_it; ?>">
	    		<?php
	    		echo $messenger=$this->ahachat_show_messenger($user_ref,'add-to-cart');
	    	}
	    	if(isset($ahachat_coupon) && !empty($ahachat_coupon['enable'])){
	    		?>
	    		<style type="text/css">
	    			.ahachat-widget-preview-content{border-radius: 9px}
	    			@media only screen and (max-width: 700px) {
					    .ahachat-cartback-widget-box__content {
					        padding: 10px 6px 10px 40px !important;
					    }
					    .ahachat-cartback-widget-box{
					      margin-right: 0px;
					    }
					    .ahachat-widget-preview-content{width: 325px !important;}
					}
					@media only screen and (max-width: 320px) {
					    .ahachat-cartback-widget-box__content {
					        padding: 10px 6px 10px 10px !important;
					    }
					    .ahachat-widget-preview-content{width: 270px !important;}
					    .ahachat-cartback-widget-box { margin-right: 0px; }
					}
	    		</style>
	    		<?php
	    		if($type=="evething" || $this->ahachat_fb_cartback_coupon_check()){
	    			echo $this->ahachat_show_messenger_coupon();
	    		}
	    	}
	    }
	    //
	    public function ahachat_add_messenger_plugin_checkout(){
			global $random_val;
	    	$user_ref=$random_val;
			?>
			<div id="ahachat_container_mess_checkbox" style="float:left">
				<input type='hidden' id='user_ref_checkout' value="<?php echo $user_ref;?>">
				<?php echo $this->ahachat_show_messenger($user_ref,'checkout');?>
			</div>
			<?php
		}
	    //
	    /**Check Display Page Product**/
	    public function ahachat_fb_cartback_coupon_check()
	    {
	    	global $wp_query;
		    $show = false;
		    $post_id = (isset($wp_query->post) ? $wp_query->post->ID : '');
		    $ahachat_coupon=get_option('ahachat_coupons');
		    if (empty($post_id)) {
		          return $show;
		    }
      		$type = (isset($ahachat_coupon) && isset($ahachat_coupon['display'])) ? $ahachat_coupon['display'] : "evething";
		      if ($type == "evething") {
		          $show=true;
		      }else if($type == "except"){
		          $all_page = get_option("ahachat_hide_product");
		          if( is_array($all_page) ){
		              if ( in_array($post_id,$all_page) ) {
		                 $show = false;
		              }else{
		                  $show =true;
		              }
		          }else{
		              $show = true;
		          }
		      }else if($type == "display"){
		      	$all_page = get_option("ahachat_show_product");
		      	if( is_array( $all_page ) ) {
			        if ( in_array($post_id, $all_page) ) {
			                 $show = true;
			        }
         		}
		      }
      		return $show;
	    }
	    public function ahachat_show_messenger($user_ref,$add_cart="add-to-cart"){
	    	$page_id=get_option('ahachat_page_id');
	    	$page_url=home_url();//"https://www.facebook.com/".$page_id;
			$app_id=get_option('ahachat_app_id');
			if($add_cart == "add-to-cart"):
				$ahachat_enable_alow_user_add_cart=get_option('ahachat_allow_user_add_cart');
				$ahachat_custom_skipit=get_option('ahachat_skip_message');
				if(!get_option('ahachat_skip_message')){
					$ahachat_custom_skipit="skip it";
				}
				if(!empty($ahachat_enable_alow_user_add_cart) && $ahachat_enable_alow_user_add_cart=="on"){
					$img="<img style='display:none;width:15px;' class='img_loading_skipit' src='".AHACHAT_WP_PLUGIN_PATH."assets/images/load.gif'>";
					$show_skip_it="or <a href='javascript:void(0)' id='ahachat_user_click_skip_it'>$ahachat_custom_skipit ".$img."</a>";
				}else{
					$show_skip_it="";
				}
				$ahachat_app_message=get_option('ahachat_customize_message');
				if(!get_option('ahachat_customize_message')){
					$ahachat_app_message="Please click the checkbox below to add the item to cart";
				}
				echo "<style>#error_not_check_mes{display:none}</style>";
			else:
				$ahachat_app_message = get_option("ahachat_customize_checkout_message");
				if(!get_option('ahachat_customize_checkout_message')){
					$ahachat_app_message="Please opt in the checkbox below to receive special coupon in the next purchase";
				}
				$show_skip_it="";
			endif;
			return  "<p style='color:red;margin:5px 0px 0px 0px;clear:both;' id='error_not_check_mes'>$ahachat_app_message $show_skip_it</p><div class='fb-messenger-checkbox' origin=$page_url page_id=$page_id messenger_app_id=$app_id user_ref='$user_ref' prechecked='true' allow_login='true' size='large'></div>";
	    }
	    /**SHOW CHECKBOX WITH SHORTCODE**/
	    public function ahachat_show_messenger_with_shortcode($id,$coupon_title,$coupon_sub_title){
	    	$page_id=get_option('ahachat_page_id');
	    	$page_url=home_url('/');
			$app_id=get_option('ahachat_app_id');
			global $post;
			$ref='wp_cart_'.md5(rand(111111111,99999999)).'_shortcode_'.$id.'_'.home_url();

			return "<div class='ahachat-widget-preview-content'><div class='ahachat-cartback-widget'><h2 class='ahachat-cartback-widget__title' >$coupon_title</h2>
        <h3 class='ahachat-cartback-widget__subtitle'>$coupon_sub_title</h3><div style='width:360px;' class='ahachat-cartback-widget__box ahachat-cartback-widget-box'><div class='ahachat-cartback-widget-box__icon-container'>
                    <div class='ahachat-cartback-widget-box__icon ahachat-cartback-widget-box__discount-icon'>
                        <svg class='ahachat-cartback-widget-box__discount-icon-bg' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='46px' height='46px'>
                          <path fill-rule='evenodd' d='M23.000,-0.000 L27.203,5.040 L33.234,2.278 L34.779,8.597 L41.439,8.660 L40.020,15.007 L45.993,17.882 L41.890,23.000 L45.993,28.118 L40.020,30.993 L41.439,37.340 L34.779,37.403 L33.234,43.722 L27.203,40.960 L23.000,46.000 L18.797,40.960 L12.766,43.722 L11.221,37.403 L4.561,37.340 L5.980,30.993 L0.007,28.118 L4.110,23.000 L0.007,17.882 L5.980,15.007 L4.561,8.660 L11.221,8.597 L12.766,2.278 L18.797,5.040 L23.000,-0.000 Z'></path>
                        </svg>
                        <span>%</span>
                    </div>
                    <div class='ahachat-cartback-widget-box__icon ahachat-cartback-widget-box__loading-icon cartback-loading-icon cartback-loading-circle'></div>
            </div>
            <div class='ahachat-cartback-widget-box__content'>    
				<!--Stay up to date with order notifications!-->			
                <div id='ahachat-cartback-widget'><div class='fb-send-to-messenger' prechecked='true' origin=$page_url page_id=$page_id messenger_app_id=$app_id data-ref='$ref' color='blue' size='xlarge'></div></div>     
            </div></div></div></div>";
	    }
	    public function ahachat_show_messenger_checkbox_withshortcode($id_shortcode,$text_button,$coupon_title,$coupon_sub_title,$message_type,$message_cb,$list_product){
	    	$page_id=get_option('ahachat_page_id');
                    $page_url=home_url('/');//"https://www.facebook.com/".$page_id;
                    $app_id=get_option('ahachat_app_id');
                    $user_ref=md5(rand(11111111,999999999)).'_'.$id_shortcode;
          	$ahachat_app_message=get_option('ahachat_customize_message');
			if(!get_option('ahachat_customize_message')){
				$ahachat_app_message="Please click the checkbox below to add the item to cart";
			}
	    ?>
	    <div class='ahachat-widget-preview-content'><div class='ahachat-cartback-widget'><h2 class='ahachat-cartback-widget__title' ><?php echo $coupon_title; ?></h2>
        <h3 class='ahachat-cartback-widget__subtitle'><?php echo $coupon_sub_title; ?></h3><div style='width:380px;' class='ahachat-cartback-widget__box'>
                <div class="ahachat_messenger_checkbox ahachat_checkbox_shortcode_1 ahachat_checkbox_shortcode_2 ahachat_checkbox_shortcode_3 ahachat_checkbox_shortcode_4"><button onclick="confirmOptIn('<?php echo $user_ref;?>')" data-user_ref="<?php echo $user_ref;?>" data-message_type="<?php echo $message_type;?>" data-message_cb="<?php echo $message_cb;?>" data-list_product="<?php echo $list_product;?>" type="button" class="ahachat_checkbox_shortcode_1 ahachat_button_shortcode_2 btn_submit_<?php echo $id_shortcode;?>" style="background-color: rgb(0, 132, 255) !important; color: rgba(0, 132, 255, 0.5) !important;"><div class="vHb-ynFjMBIIPShCGRneI"><div style="color: rgb(255, 255, 255); display: inline-block;"><?php echo !empty($text_button) ? $text_button : "Send me coupon"; ?></div></div></button><div class='fb-messenger-checkbox' origin="<?php echo $page_url; ?>" page_id="<?php echo $page_id; ?>" messenger_app_id="<?php echo $app_id; ?>" user_ref='<?php echo $user_ref; ?>' prechecked='true' allow_login='true' size='large'></div><p class="error_shortcode_<?php echo $id_shortcode; ?>" style="color: red;display: none;"><?php echo $ahachat_app_message; ?></p></div></div>
            </div></div>
        <script type="text/javascript">
        		jQuery(document).ready(function($){
							$(document).on('click','.btn_submit_<?php echo $id_shortcode;?>',function(e){
								e.preventDefault();
								//
								var cookie = localStorage.cb_cookie;
							    if(cookie == undefined || cookie == null) {
							      //CREATE COOKIE
							      var day_current = new Date().getTime();
							      localStorage.cb_cookie = day_current;
							      cookie = localStorage.cb_cookie;
							    }
								//
								var _this=$(this);
								var user_ref=_this.data('user_ref');
								//
								console.log(cookie);
								console.log(abd_state);
								//
							 	if(abd_state=="checked"){
							      	var message_type=_this.data("message_type");
							      	console.log(message_type);
									if(message_type=="custom_text"){
									    var message_cb=_this.data('message_cb');
									    var action_data = {
									      action:'ahachat_cartback_width_shortcode_custom_text',
									      cookie_browser:cookie,
									      user_ref:user_ref,
									      message_cb:message_cb
									    };
									    $.post(ajaxurl,action_data,function(result){
									     //console.log(result);
									        if(result=="error"){
									            console.log("error");
									        }else{
									           _this.attr("disabled","disabled");
									            console.log(result);
									        }
									    });
									    return false;
									}else{
									      	var list_product=_this.data('list_product');
									      	var action_data = {
									          action:'ahachat_cartback_width_shortcode_send_reminder',
									          list_product:list_product,
									          cookie_browser:cookie,
									          user_ref:user_ref,
									      	};
									      	$.post(ajaxurl,action_data,function(result){
									              if(result=="error"){
									                  console.log("error");
									              }else{
									              	_this.attr("disabled","disabled");
									              	location.reload();
									              	console.log(result);
									              }
									    	});
									    }
								}else if(abd_state=="unchecked"){
									$(".error_shortcode_<?php echo $id_shortcode;?>").show();
									return false;
								}
							});
						});
        </script>
	    <?php
	    }
	    /**SHOW CHECKBOX WITH SHORTCODE**/
	    /**SHOW MESSENGER**/
	    public function ahachat_show_messenger_coupon(){
	    	$page_id=get_option('ahachat_page_id');
	    	$page_url=home_url('/');
			$app_id=get_option('ahachat_app_id');
			global $product;
			$ref='wp_cart_'.md5(rand(111111111,99999999)).'_'.$product->get_id().'_'.home_url();
			$ahachat_coupon=get_option('ahachat_coupons');
			$coupon_title=(isset($ahachat_coupon) && !empty($ahachat_coupon['title'])) ? $ahachat_coupon['title'] : '15% Discount';
			$coupon_sub_title=(isset($ahachat_coupon) && !empty($ahachat_coupon['sub_title'])) ? $ahachat_coupon['sub_title'] : 'Get your 15% discount now by subscribing to our newsletter in facebook messenger. Just click the blue button below.';
			?>
			<?php
			return "<div class='ahachat-widget-preview-content'><div class='ahachat-cartback-widget'><h2 class='ahachat-cartback-widget__title' >$coupon_title</h2>
        			<h3 class='ahachat-cartback-widget__subtitle'>$coupon_sub_title</h3><div class='ahachat-cartback-widget__box ahachat-cartback-widget-box'><div class='ahachat-cartback-widget-box__icon-container'>
                    <div class='ahachat-cartback-widget-box__icon ahachat-cartback-widget-box__discount-icon'>
                        <svg class='ahachat-cartback-widget-box__discount-icon-bg' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='46px' height='46px'>
                          <path fill-rule='evenodd' d='M23.000,-0.000 L27.203,5.040 L33.234,2.278 L34.779,8.597 L41.439,8.660 L40.020,15.007 L45.993,17.882 L41.890,23.000 L45.993,28.118 L40.020,30.993 L41.439,37.340 L34.779,37.403 L33.234,43.722 L27.203,40.960 L23.000,46.000 L18.797,40.960 L12.766,43.722 L11.221,37.403 L4.561,37.340 L5.980,30.993 L0.007,28.118 L4.110,23.000 L0.007,17.882 L5.980,15.007 L4.561,8.660 L11.221,8.597 L12.766,2.278 L18.797,5.040 L23.000,-0.000 Z'></path>
                        </svg>
                        <span>%</span>
                    </div>
                    <div class='ahachat-cartback-widget-box__icon ahachat-cartback-widget-box__loading-icon cartback-loading-icon cartback-loading-circle'></div>
            </div>
            <div class='ahachat-cartback-widget-box__content'>  
				<!-- Stay up to date with order notifications!-->
                <div id='ahachat-cartback-widget'><div class='fb-send-to-messenger' prechecked='true' origin=$page_url page_id=$page_id messenger_app_id=$app_id data-ref='$ref' color='blue' size='xlarge'></div></div>     
            </div></div></div></div>";
	    }
	    /**SHOW MESSENGER**/

        /**GET COUPON CSS**/
        public function getCouponCss($ahachat_customize_coupon){
            if ($this->hasCouponCss) {
                return '';
            }
            $this->hasCouponCss = true;
            $box_width = isset($ahachat_customize_coupon['box_width']) ? $ahachat_customize_coupon['box_width'] : 410;
            $border_size = isset($ahachat_customize_coupon['border_size']) ? $ahachat_customize_coupon['border_size'] : 2;
            $border_style = isset($ahachat_customize_coupon['border_style']) ? $ahachat_customize_coupon['border_style'] : 'solid';
            $border_color = isset($ahachat_customize_coupon['border_color']) ? $ahachat_customize_coupon['border_color'] : '#f7ef90';
            $background_color = isset($ahachat_customize_coupon['background_color']) ? $ahachat_customize_coupon['background_color'] : '#fffabf';
            $title_color = isset($ahachat_customize_coupon['title_color']) ? $ahachat_customize_coupon['title_color'] : '#444444';
            $subtitle_color = isset($ahachat_customize_coupon['subtitle_color']) ? $ahachat_customize_coupon['subtitle_color'] : '#727272';
            ?>
            <?php
            return "<style type=\"text/css\">
                .ahachat-widget-preview-content {
                    width: " . $box_width. "px;
                    border-width: " . $border_size. "px;
                    border-style: " . $border_style. ";
                    border-color:". $border_color . "!important;
                    background: ". $background_color .";
                }
                .ahachat-cartback-widget__title{
                    color: " . $title_color. "
                }
                .ahachat-cartback-widget__subtitle{
                    color: " . $subtitle_color. "
                }
            </style>";

        }
        /**GET COUPON CSS**/
	}
}
new AHACHAT_WP_PLUGINS();