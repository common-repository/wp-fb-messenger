<?php

/**
 * @package    Wp_Fb_Messenger
 * @subpackage Wp_Fb_Messenger/public
 * @author     Anurag Sharma
 */
class Wp_Fb_Messenger_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
		
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wfm.css', array(), $this->version, 'all');
		
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
       
	   wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wfm.js', array('jquery'), $this->version, false);
	   
    }

    /**
     * Display Messenger widget on public side.
     *
     * @since    1.0.0
     */
    public function wp_fb_messenger_widget() {
       
		if (get_option('wfm_global') == true && !empty(get_option('wfm_page_url')) ) {
			
			$pageurl = get_option('wfm_page_url');
			$pageid = str_replace("https://www.facebook.com/","",$pageurl);
			$pageid = str_replace("/","",$pageid);
			?>
			
			
			<div class="fb-livechat">
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
				
			<script src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9"></script>
			
			<?php
		}
    }

}
