<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://dunskii.com
 * @since      0.6.0-beta
 *
 * @package    Bookingx
 * @subpackage Bookingx/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.6.0-beta
 * @package    Bookingx
 * @subpackage Bookingx/includes
 * @author     Dunskii Web Services <divyang@dunskii.com>
 */
class Bookingx {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.6.0-beta
	 * @access   protected
	 * @var      Bookingx_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.6.0-beta
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.6.0-beta
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

    /**
     * The Directory Path of the plugin.
     *
     * @since    0.6.0-beta
     * @access   protected
     * @var      string    $dir_path    The Directory Path of the plugin.
     */

	protected $dir_path;

    /**
     * The Directory Url of the plugin.
     *
     * @since    0.6.0-beta
     * @access   protected
     * @var      string    $dir_url    The Directory Url of the plugin.
     */

    protected $dir_url;

    /**
     * The Public Url of the plugin.
     *
     * @since    0.6.0-beta
     * @access   protected
     * @var      string    $public_url    The Public Url of the plugin.
     */

    protected $public_url;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    0.6.0-beta
	 */
	public function __construct() {
		if ( defined( 'BOOKINGX_VERSION' ) ) {
			$this->version = BOOKINGX_VERSION;
		} else {
			$this->version = '0.6.0-beta';
		}

		$this->dir_path = plugin_dir_path(__DIR__);
		$this->dir_url  = plugin_dir_url(__DIR__);
        $this->public_url  = $this->dir_url."public";

       // define('BKX_PLUGIN_VER', rand(1,999999999999));


		$this->plugin_name = 'bookingx';

		$this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Bookingx_Loader. Orchestrates the hooks of the plugin.
	 * - Bookingx_i18n. Defines internationalization functionality.
	 * - Bookingx_Admin. Defines all hooks for the admin area.
	 * - Bookingx_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.6.0-beta
	 * @access   private
	 */
	private function load_dependencies() {

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-bookingx-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-bookingx-public.php';

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bookingx-loader.php';

		/**
		 *  Bkx Short code Load
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/shortcode/class-bkx-booking-form-shortcode.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/shortcode/class-shortcode-editor.php';

        /**
         *  Load Seat Post Type
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/seat/class-bkx-seat.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/seat/class-bkx-seat-meta-box.php';

        /**
         *  Load Base Post Type
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/base/class-bkx-base.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/base/class-bkx-base-meta-box.php';

        /**
         *  Load Extra Post Type
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/extra/class-bkx-extra.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/extra/class-bkx-extra-meta-box.php';

        /**
         *  Load Booking Post Type
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/booking/class-bkx-booking.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/booking/class-order-meta-box.php';

        /**
         *  Load Payment Gateways
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/payment-gateways/class-bkx-payment-core.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/payment-gateways/bkx-class-paypal-gateway.php';

        /**
         *  Load Export - Import
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/export-import/class-bkx-export.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/export-import/class-bkx-import.php';

        /**
         *  BKX Core Functions
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/functions/bkx-core-functions.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/ajax/call_ajax_functions.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/functions/filter-actions-functions.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/functions/template-hooks.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/functions/template-functions.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/functions/multisite-functions.php';

        /**
         *  BKX Admin Files
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/setting-functions.php';
		$this->loader = new Bookingx_Loader();
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.6.0-beta
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.6.0-beta
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.6.0-beta
	 * @return    Bookingx_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    0.6.0-beta
     * @access   private
     */
    private function define_admin_hooks() {

        $plugin_admin = new Bookingx_Admin( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'init', $plugin_admin, 'bkx_create_seat_post_type' );
        $this->loader->add_action( 'init', $plugin_admin, 'bkx_create_base_post_type' );
        $this->loader->add_action( 'init', $plugin_admin, 'bkx_create_addition_post_type' );
        $this->loader->add_action( 'init', $plugin_admin, 'bkx_create_booking_post_type' );
        $this->loader->add_action( 'init', $plugin_admin, 'register_bookingx_post_status' );
        $this->loader->add_action( 'manage_bkx_booking_posts_custom_column', $plugin_admin, 'render_bkx_booking_columns' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'bkx_notification_bubble_menu');

        $this->loader->add_action( 'admin_footer', $plugin_admin, 'bkx_booking_bulk_admin_footer', 10 );
        $this->loader->add_action( 'restrict_manage_posts', $plugin_admin, 'bkx_booking_search_by_dates', 2, 10 );
        $this->loader->add_action( 'restrict_manage_posts', $plugin_admin, 'bkx_booking_seat_view' , 2, 10 );
        $this->loader->add_action( 'restrict_manage_posts', $plugin_admin, 'bkx_booking_listing_view' , 2, 10 );

        $this->loader->add_filter( 'manage_bkx_booking_posts_columns', $plugin_admin, 'bkx_booking_columns',  99, 2 );
        $this->loader->add_filter( 'post_type_link', $plugin_admin, 'bkx_change_view_link',  10, 2 );
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    0.6.0-beta
     * @access   private
     */
    private function define_public_hooks() {

        $plugin_public = new Bookingx_Public( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

    }

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     0.6.0-beta
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}