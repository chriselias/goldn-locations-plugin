<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    MLB_LOCATIONS
 * @subpackage MLB_LOCATIONS/includes
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
 * @since      1.0.0
 * @package    MLB_LOCATIONS
 * @subpackage MLB_LOCATIONS/includes
 * @author     Your Name <email@example.com>
 */
class MLB_LOCATIONS {

  /**
   * The loader that's responsible for maintaining and registering all hooks that power
   * the plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      MLB_LOCATIONS_Loader    $loader    Maintains and registers all hooks for the plugin.
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

    $this->plugin_name = 'mlb-locations';
    $this->version = '0.0.1';

    $this->load_dependencies();
    $this->define_shortcode_actions();
    $this->define_widget_actions();

  }

  /**
   * Load the required dependencies for this plugin.
   *
   * Include the following files that make up the plugin:
   *
   * - MLB_LOCATIONS_Loader. Orchestrates the hooks of the plugin.
   *
   * Create an instance of the loader which will be used to register the hooks
   * with WordPress.
   *
   * @since    1.0.0
   * @access   private
   */
  private function load_dependencies() {

    /**
     * The class responsible for orchestrating the actions and filters of the
     * core plugin.
     */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mlb-locations-loader.php';

    $this->loader = new MLB_LOCATIONS_Loader();

  }

  /**
   * Register shortcode actions
   *
   * @since    1.0.0
   * @access   private
   */
  private function define_shortcode_actions() {
    $mlb_shortcodes = new MLB_Locations_Shortcodes( $this->get_plugin_name(), $this->get_version() );
    $this->loader->add_shortcode( 'phone-number', $mlb_shortcodes, 'create_phone_number_shortcode' );
    $this->loader->add_shortcode( 'business-name', $mlb_shortcodes, 'create_business_name_shortcode' );
    $this->loader->add_shortcode( 'common-name', $mlb_shortcodes, 'create_common_name_shortcode' );
    $this->loader->add_shortcode( 'city', $mlb_shortcodes, 'create_city_shortcode' );
    $this->loader->add_shortcode( 'state', $mlb_shortcodes, 'create_state_shortcode' );
    $this->loader->add_shortcode( 'address', $mlb_shortcodes, 'create_address_shortcode' );
    $this->loader->add_shortcode( 'zip', $mlb_shortcodes, 'create_zip_shortcode' );
    $this->loader->add_shortcode( 'lat', $mlb_shortcodes, 'create_lat_shortcode' );
    $this->loader->add_shortcode( 'lon', $mlb_shortcodes, 'create_lon_shortcode' );
    $this->loader->add_shortcode( 'industry', $mlb_shortcodes, 'create_industry_shortcode' );
    $this->loader->add_shortcode( 'hours', $mlb_shortcodes, 'create_hours_shortcode' );
    $this->loader->add_shortcode('schema', $mlb_shortcodes, 'create_schema_shortcode');
    $this->loader->add_shortcode('schema-industry', $mlb_shortcodes, 'create_schema_industry_shortcode');
    $this->loader->add_shortcode( 'optio', $mlb_shortcodes, 'create_optio_shortcode' );
    $this->loader->add_shortcode( 'ohi', $mlb_shortcodes, 'create_ohi_shortcode' );
    $this->loader->add_shortcode( 'viewmedica', $mlb_shortcodes, 'create_viewmedica_shortcode' );
    $this->loader->add_shortcode( 'facebook-url', $mlb_shortcodes, 'create_facebook_shortcode' );
    $this->loader->add_shortcode( 'social-icon', $mlb_shortcodes, 'create_social_icon_shortcode' );
    $this->loader->add_shortcode( 'twitter-url', $mlb_shortcodes, 'create_twitter_shortcode' );
    $this->loader->add_shortcode( 'page-title', $mlb_shortcodes, 'create_page_title_shortcode' );
    $this->loader->add_shortcode( 'locations', $mlb_shortcodes, 'create_locations_shortcode' );
    $this->loader->add_action( 'media_buttons', $mlb_shortcodes, 'add_video_button', 25 );
    $this->loader->add_action( 'wp_enqueue_media', $mlb_shortcodes, 'include_video_button_js' );
    $this->loader->add_action( 'media_buttons', $mlb_shortcodes, 'add_locations_button', 25 );
    $this->loader->add_action( 'wp_enqueue_media', $mlb_shortcodes, 'include_locations_button_js' );
  }

  /**
   * Register widget actions
   *
   * @since    1.0.0
   * @access   private
   */
  private function define_widget_actions() {
    $mlb_staff_widget = new MLB_Locations_Widget( $this->get_plugin_name(), $this->get_version() );
    $this->loader->add_action( 'widgets_init', $mlb_staff_widget, 'register_widget' );
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
   * @return    MLB_API_Loader    Orchestrates the hooks of the plugin.
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
