<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://segmetrics.io
 * @since      1.0.0
 *
 * @package    Segmetrics
 * @subpackage Segmetrics/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Segmetrics
 * @subpackage Segmetrics/public
 * @author     Keith Perhac <support@segmetrics.io>
 */
class Segmetrics_Public {

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
     * Service Connector for SegMetrics
     *
     * @since    1.0.0
     * @access   private
     * @var      SegmetricsService    $service    Service connector for SegMetrics
     */
    private $service;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->service = new SegmetricsService();
	}

    /**
     * Insert the tracking script into the page
     */
	public function insert_script() {
        $settings = $this->service->snippet();
        if(!$settings){ return; }
        require(__DIR__ . '/partials/segmetrics-public-display.php');
    }
}
