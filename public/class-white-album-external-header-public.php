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

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

  private $stylesheet;
  private $header;
  private $footer;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

    $wa_content = $this->get_white_album_content();

    $this->stylesheet = print_r($wa_content->head, true);
    $this->header = print_r($wa_content->header, true);
    $this->footer = print_r($wa_content->footer, true);

	}

  public function wp_head() {
    /*
    echo "
      $this->stylesheet
    ";
    */

    if($this->header !== '') ob_start(array(&$this, 'insert_header'));
  }

  public function wp_footer() {
    if($this->header !== '') {
      ob_end_flush();
      // echo $this->footer;
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

		// wp_enqueue_style( $this->plugin_name, $this->stylesheet, array(), $this->version, 'all' );
    wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/white-album-external-header-public.css', array(), $this->version, 'all' );

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
    $response = wp_remote_retrieve_body( wp_remote_get('http://costume.no/api/v1/shell') );

    if (is_wp_error($response)) return;

    return json_decode($response);
  }

  private function insert_header($buffer) {
    return preg_replace("/<!-- WAHEADER -->/", "<div class=\"bonnier-header-wrapper\">" . $this->header . "</div>", $buffer);
  }

}
