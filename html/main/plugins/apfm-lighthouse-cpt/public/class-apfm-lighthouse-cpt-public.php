<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       apfm
 * @since      1.0.0
 *
 * @package    Apfm_Lighthouse_Cpt
 * @subpackage Apfm_Lighthouse_Cpt/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Apfm_Lighthouse_Cpt
 * @subpackage Apfm_Lighthouse_Cpt/public
 * @author     Gonzalo Garcia <gonzalo.garcia@aplaceformom.com>
 */

class Apfm_Lighthouse_Cpt_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $lighthouse_cpt    The ID of this plugin.
	 */
	private $lighthouse_cpt;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
     * The view of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      Apfm_Lighthouse_Cpt_View    $version    Apfm_Lighthouse_Cpt_View instance created to render all views.
     */
    private $view; // Our view manager

	/**
     * The lead proxy for this plugin.
     *
     * @since    1.2.0
     * @access   private
     * @var      $proxy    1.0.0    Path to the lead proxy file.
     */
    private $proxy; // WS3 Lead Submission Proxy (lp.php)


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $lighthouse_cpt       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $lighthouse_cpt, $version, $view ) {

		$this->lighthouse_cpt 			= $lighthouse_cpt;
		$this->version 		= $version;
		$this->view 		= $view;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->lighthouse_cpt, plugin_dir_url( __FILE__ ) . 'css/apfm-lighthouse-cpt-public.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->lighthouse_cpt,  plugin_dir_url( __FILE__ ) . 'js/apfm-lighthouse-cpt-public.min.js', array( 'jquery' ), $this->version, true );
	}
}
