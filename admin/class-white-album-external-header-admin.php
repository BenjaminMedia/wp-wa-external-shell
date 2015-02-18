<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    White_Album_External_Header
 * @subpackage White_Album_External_Header/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    White_Album_External_Header
 * @subpackage White_Album_External_Header/admin
 * @author     Casper Klenz-Kitenge, Duke UX <hello@duke.io>
 */
class White_Album_External_Header_Admin {

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

  private $options_group_name;

  /**
   * Initialize the class and set its properties.
   *
   * @since    1.0.0
   * @var      string    $plugin_name       The name of this plugin.
   * @var      string    $version    The version of this plugin.
   */
  public function __construct( $plugin_name, $version, $options_group_name ) {

    $this->plugin_name = $plugin_name;
    $this->version = $version;
    $this->options_group_name = $options_group_name;

  }

  /**
   * Register the stylesheets for the Dashboard.
   *
   * @since    1.0.0
   */
  public function enqueue_styles() {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in White_Album_External_Header_Admin_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The White_Album_External_Header_Admin_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    // wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/white-album-external-header-admin.css', array(), $this->version, 'all' );

  }

  /**
   * Register the JavaScript for the dashboard.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts() {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in White_Album_External_Header_Admin_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The White_Album_External_Header_Admin_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    // wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/white-album-external-header-admin.js', array( 'jquery' ), $this->version, false );

  }

  public function add_admin_menu() {
    add_options_page(
      'Bonnier co-branding settings',
      'Bonnier',
      'manage_options',
      $this->plugin_name,
      array(&$this, 'options_page')
    );
  }

  public function init_admin_settings(  ) {
    register_setting( $this->plugin_name, $this->options_group_name );

    add_settings_section(
      ($this->plugin_name . '_section'),
      __( 'Your section description', $this->plugin_name ),
      array(&$this, 'settings_section_callback'),
      $this->plugin_name
    );

    add_settings_field(
      'co_branding_domain',
      __( 'Co-branding domain <br><small>(domain only, eg. costume.no)</small>', $this->plugin_name ),
      array(&$this, 'co_branding_domain_render'),
      $this->plugin_name,
      ($this->plugin_name . '_section')
    );

    add_settings_field(
      'content_unit_category',
      __( 'Emediate content unit category <br><small>(sometimes referred to as "<i>shortname</i>")</small>', $this->plugin_name ),
      array(&$this, 'content_unit_category_render'),
      $this->plugin_name,
      ($this->plugin_name . '_section')
    );

    add_settings_field(
      'tns_tracking_path',
      __( 'TNS path for tracking', $this->plugin_name ),
      array(&$this, 'tns_tracking_path_render'),
      $this->plugin_name,
      ($this->plugin_name . '_section')
    );
  }

  public function co_branding_domain_render(  ) {
    echo $this->build_settings_field('co_branding_domain');
  }

  public function content_unit_category_render(  ) {
    echo $this->build_settings_field('content_unit_category');
  }

  public function tns_tracking_path_render(  ) {
    echo $this->build_settings_field('tns_tracking_path');
  }

  public function settings_section_callback(  ) {
    echo __( 'This section description', $this->plugin_name );
  }

  public function options_page(  ) {
    include_once plugin_dir_path( dirname( __FILE__ ) ) . "admin/partials/$this->plugin_name-admin-display.php";
  }

  private function build_settings_field($option_key) {
    $options = get_option( $this->options_group_name );
    $value = (isset($options[$option_key]) ? $options[$option_key] : '');

    return '<input type="text" name="' . $this->options_group_name . '['. $option_key .']" value="' . $value . '">';
  }

}
