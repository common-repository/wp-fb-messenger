<?php

/**
 * @since      1.0.0
 * @package    Wp_Fb_Messenger
 * @subpackage Wp_Fb_Messenger/includes
 * @author     Anurag Sharma
 */

class Wp_Fb_Messenger {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wp_Fb_Messenger    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'wp-fb-messenger';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_globals();
		$this->define_public_hooks();
		$this->define_shortcodes();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		
        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wp-fb-messenger-i18n.php';
		
		/**
		 * This class is responsible for orchestrating the actions and filters of the admin area
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-fb-messenger-admin.php';
		
		/**
		 * This class is responsible for orchestrating the actions and filters of the public area
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-fb-messenger-public.php';
		
		/**
		 * This class is responsible for orchestrating the shortcodes used in plugin
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-fb-messenger-shortcodes.php';
		
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-fb-messenger-loader.php';
		
		$this->loader = new Wp_Fb_Messenger_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wp_Fb_Messenger_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		
		$plugin_i18n = new Wp_Fb_Messenger_i18n();
        $plugin_i18n->set_domain($this->get_plugin_name());

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
		
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		
		$plugin_admin = new Wp_Fb_Messenger_Admin( $this->get_plugin_name(), $this->get_version() );
		
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		$this->loader->add_action( 'admin_init', $plugin_admin, 'wp_fb_messenger_register_settings' );
		
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'wp_fb_messenger_add_settings_page' );
		
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

        $plugin_public = new Wp_Fb_Messenger_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
		
        $this->loader->add_action('wp_footer', $plugin_public, 'wp_fb_messenger_widget');
		
	}

	/**
	 * Registers a global variable of the plugin - wp-fb-messenger
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function define_globals() {
		
	}
	
	/**
	 * Registers shortcodes of the plugin - wp-fb-messenger
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function define_shortcodes() {
		
		$plugin_shortcodes = new Wp_Fb_Messenger_Shortcodes( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_shortcodes, 'wp_fb_messenger_shortcodes' );
		
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Bp_Add_Group_Types_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
