<?php

/**
 * @since      1.0.0
 * @package    Wp_Fb_Messenger
 * @subpackage Wp_Fb_Messenger/includes
 * @author     Anurag Sharma
 */
class Wp_Fb_Messenger_Shortcodes {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
	
	/**
	 * Register all shortcodes generated using plugin
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function wp_fb_messenger_shortcodes( $attributes, $content = null ) {
		
		add_shortcode( 'wp_fb_messenger', array($this,'wp_fb_messenger_chat_shortcode' ));
	}
	
	/**
	 * Generates Chat Widget with shortcode
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function wp_fb_messenger_chat_shortcode( $attributes, $content = null ) {
		
		extract( shortcode_atts( array(
			'class' => '',
		), $attributes ) );
		
		if (get_option('wfm_global') == false && !empty(get_option('wfm_page_url')) ) {
			
			$pageurl = get_option('wfm_page_url');
			$pageid = str_replace("https://www.facebook.com/","",$pageurl);
			$pageid = str_replace("/","",$pageid);
			
			
			
			return '<div class="fb-livechat">
				<div class="ctrlq fb-overlay"></div>
				<div class="fb-widget">
					<div class="ctrlq fb-close"></div>
					<div class="fb-page" data-href="<?php echo $pageurl;?>" data-tabs="messages" data-width="300" data-height="400" data-small-header="true" data-hide-cover="true" data-show-facepile="false">
						<blockquote cite="<?php echo $pageurl;?>" class="fb-xfbml-parse-ignore"> </blockquote>
					</div>
					<div class="fb-credit"> 
						<a href="#" target="_blank"></a>
					</div>
					<div id="fb-root"></div>
				</div>
				<a href="https://m.me/<?php echo $pageid; ?>" title="Send us a message on Facebook" class="ctrlq fb-button"></a>
			</div>
				
			<script src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9"></script>';
		}
	}
}