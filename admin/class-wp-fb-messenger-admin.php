<?php

/**
 * @since      1.0.0
 * @package    Wp_Fb_Messenger
 * @subpackage Wp_Fb_Messenger/includes
 * @author     Anurag Sharma
 */
class Wp_Fb_Messenger_Admin {

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
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wfm-admin.js', array( 'jquery' ), $this->version, false );
		
	}

	public function wp_fb_messenger_register_settings() {
		register_setting( 'wp-fb-messenger-options', 'wfm_page_url' );
		register_setting( 'wp-fb-messenger-options', 'wfm_global' );
	}
	
	/**
	 * Register a settings page to handle Plugin Admin Page
	 *
	 * @since    1.0.0
	 */
	public function wp_fb_messenger_add_settings_page() {
		
		add_options_page(__( 'WP FB Messenger Settings', WFM_TEXT_DOMAIN ), __( 'WP FB Messenger', WFM_TEXT_DOMAIN ), 'administrator', 'wp-fb-messenger-settings', array( $this, 'wp_fb_messenger_settings_page'), 'dashicons-admin-generic');
		
	}
	
	public function wp_fb_messenger_settings_page() {?>
		
		<div class="wrap">
			<h2>FB Messenger Settings</h2>
			<p>You can change following settings to manage your widget.</p>
			<form method="post" action="options.php">
			<?php
			settings_fields( 'wp-fb-messenger-options' );
			?>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><label for="wfm_page_url">Facebook Page URL</label></th>
						<td>
							<input type="text" size="50" name="wfm_page_url" value="<?php echo esc_attr( get_option('wfm_page_url') ); ?>" /> <small>e.g. https://www.facebook.com/xyz/<br />It should be your facebook page url. It will only work for facebook pages.<br /></small>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="wfm_global">Enable Globally</label></th>
						<td>
							<input type="checkbox" name="wfm_global" value="true" <?php echo ( get_option('wfm_global') == true ) ? ' checked="checked" ' : ''; ?> /><br/>
							<small>If this field is checked then widget will appear on every page. If you need to display this widget only on a specific page where the ShortCode is added then uncheck this field. </small>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="wfm_global">ShortCode</label></th>
						<td>
							<input class="wfm-shortcode" type="text" value="[wp_fb_messenger]"/><br/>
							<small>Copy this and add to page. You can use this on specific page or widget if you're not using Global option</small>
						</td>
					</tr>
				</table>
			<?php submit_button(); ?>
			</form>
		</div>
		
		
	<?php }
}