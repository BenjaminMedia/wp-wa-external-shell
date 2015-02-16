<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
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

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $version    The current version of this plugin.
   */
  private $version;

  /**
   * The key used to save and load required options from the WordPress database.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $version    The key used for the array that serializes the options in the database.
   */
  private $options_group_name;

  private $white_album_css_namespace,
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
   * @var      string    $plugin_name           The name of the plugin.
   * @var      string    $version               The version of this plugin.
   * @var      string    $options_group_name    The key used to save/load plugin-specifc options from the database.
   */
  public function __construct( $plugin_name, $version, $options_group_name ) {
    $this->plugin_name = $plugin_name;
    $this->version =     $version;
    $this->options_group_name = $options_group_name;
    $this->white_album_css_namespace = 'bonnier-wrapper';

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
    $content_unit_category =  $this->user_config['content_unit_category'];
    $tns_path =               $this->user_config['tns_tracking_path'];

    if ($tns_path) {
      $this->analytics = $this->replace_tns_tracking($tns_path);
    }

    echo "
      <meta name=\"banner-category\" content=\"$content_unit_category\">

      $this->stylesheet\n
      $this->javascript\n
      $this->analytics\n
    ";

    if($this->header !== '') ob_start(array(&$this, 'insert_header'));
  }

  public function wp_footer() {
    if($this->header !== '') {
      ob_end_flush();

      echo <<< HTML
        <div class="$this->white_album_css_namespace">
          $this->footer
        </div>
HTML;
    }
  }

  /**
   * Load FontAwesome here, instead of grabbing it from the WhiteAlbum API.
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

    wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), $this->version, 'all' );
  }


  private function get_white_album_content() {
    $url = $this->get_white_album_api_url();
    $response = wp_remote_retrieve_body( wp_remote_get($url) );

    if (is_wp_error($response)) return;

    return json_decode($response);
  }

  private function get_white_album_api_url() {
    $domain = $this->user_config['co_branding_domain'];
    $host = "http://$domain";

    $api_url = "$host/api/v1/external_headers/partial";

    return $api_url;
  }

  private function replace_tns_tracking($new_path) {
    return preg_replace(
      "/<meta.*?name=\"tns-path\"[\s\/]+>/",
      "<meta content=\"$new_path\" name=\"tns-path\">",
      $this->analytics
    );
  }

  private function insert_header($buffer) {
    $header = <<< HTML
      <div class="$this->white_album_css_namespace">
        $this->promobar_top
      </div>

      <div class="$this->white_album_css_namespace">
        $this->header
      </div>
HTML;

    return preg_replace("/<body(.*?)>/", "<body$1>" . $header, $buffer);
  }

  private function get_plugin_configuration() {
    return get_option( $this->options_group_name );
  }

}
