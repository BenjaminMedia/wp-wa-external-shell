<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    White_Album_External_Header
 * @subpackage White_Album_External_Header/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    White_Album_External_Header
 * @subpackage White_Album_External_Header/public
 * @author     Casper Klenz-Kitenge, Duke UX <hello@duke.io>
 */
class White_Album_External_Header_Public {

  /**
   * The ID of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $plugin_name    The ID of this plugin.
   */
  private $plugin_name;

  private $options_group_name;

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $version    The current version of this plugin.
   */
  private $version,
          $stylesheet,
          $javascript,
          $header,
          $footer,
          $analytics,
          $promobar_top,
          $user_config;

  /**
   * Initialize the class and set its properties.
   *
   * @since    1.0.0
   * @var      string    $plugin_name       The name of the plugin.
   * @var      string    $version    The version of this plugin.
   */
  public function __construct( $plugin_name, $version, $options_group_name ) {
    $this->plugin_name = $plugin_name;
    $this->version =     $version;
    $this->options_group_name = $options_group_name;

    $this->user_config = $this->get_plugin_configuration();

    $wa_content = $this->get_white_album_content();

    $this->stylesheet =   print_r($wa_content->stylesheet, true);
    $this->javascript =   print_r($wa_content->javascript, true);
    $this->header =       print_r($wa_content->header, true);
    $this->footer =       print_r($wa_content->footer, true);
    $this->analytics =    print_r($wa_content->analytics, true);
    $this->promobar_top = print_r($wa_content->promobar_top, true);
  }

  public function wp_head() {
    echo "
      $this->stylesheet\n
      $this->javascript\n
      $this->analytics\n
    ";

    if($this->header !== '') ob_start(array(&$this, 'insert_header'));
  }

  public function wp_footer() {
    if($this->header !== '') {
      ob_end_flush();
      echo "<div class=\"bonnier-wrapper\">" . $this->footer . "</div>";
    }
  }

  /**
   * Register the stylesheets for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_styles() {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in White_Album_External_Header_Public_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The White_Album_External_Header_Public_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    // wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/white-album-external-header-public.css', array(), $this->version, 'all' );
    wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), $this->version, 'all' );
  }

  /**
   * Register the stylesheets for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts() {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in White_Album_External_Header_Public_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The White_Album_External_Header_Public_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    // wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/white-album-external-header-public.js', array( 'jquery' ), $this->version, false );

  }

  private function get_white_album_content() {
    $url = $this->get_white_album_api_url();
    $response = wp_remote_retrieve_body( wp_remote_get($url) );

    if (is_wp_error($response)) return;

    return json_decode($response);
  }

  private function get_white_album_api_url() {
    if (defined('WPBP_ENV') && (WPBP_ENV == 'development')):
      $host = 'http://127.0.0.1:3000';
      $site_id = '79';

    else:
      $domain = $this->user_config['co_branding_domain'];
      $host = "http://$domain";

    endif;

    $api_url = "$host/api/v1/external_headers/partial";
    if (isset($site_id)) $api_url .= "?current_site=$site_id";

    return $api_url;
  }

  private function insert_header($buffer) {
    $header = <<< HTML
      <div class="bonnier-wrapper">
        $this->promobar_top
      </div>

      <div class="bonnier-wrapper">
        $this->header
      </div>
HTML;

    return preg_replace("/<body(.*?)>/", "<body$1>" . $header, $buffer);
  }

  private function write_log ( $log )  {
    if ( true === WP_DEBUG ) {
      if ( is_array( $log ) || is_object( $log ) ):
        error_log( print_r( $log, true ) );
      else:
        error_log( $log );
      endif;
    }
  }

  private function get_plugin_configuration() {
    return get_option( $this->options_group_name );
  }

}
