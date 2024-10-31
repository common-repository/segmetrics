<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://segmetrics.io
 * @since      1.0.0
 *
 * @package    Segmetrics
 * @subpackage Segmetrics/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Segmetrics
 * @subpackage Segmetrics/admin
 * @author     Keith Perhac <support@segmetrics.io>
 */
class Segmetrics_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->service = new SegmetricsService();

	}


    /**
     * Create the menu item in the admin menu
     */
	public function create_menu_item() {
        add_options_page(
            'SegMetrics Settings',
            'SegMetrics',
            'manage_options',
            'segmetrics_settings',
            [$this, 'settings_page']        // Display the page
        );
    }

    /**
     * Register the Settings for the connection
     */
    public function register_settings() {

        register_setting('segmetrics_auth', $this->service->auth_key, ['sanitize_callback' => [$this, 'seg_auth_sanitize']]);
        register_setting('segmetrics_snippet', $this->service->snippet_key);

        add_settings_section(
            'seg_auth_section',
            'Account Authorization',
            [$this, 'seg_auth_section_cb'],  // Show the description for the Section
            'segmetrics_auth'
        );

        add_settings_field(
            'account_hash',
            __( 'Account Id', 'wordpress' ),
            [$this, 'render_account_hash'],
            'segmetrics_auth',
            'seg_auth_section'
        );

        add_settings_field(
            'api_key',
            __( 'API Key', 'wordpress' ),
            [$this, 'render_api_key'],
            'segmetrics_auth',
            'seg_auth_section'
        );
    }

    /**
     * Show the Settings Page
     */
    public function settings_page() {
        require_once(__DIR__ . '/partials/segmetrics-admin-display.php');
    }

    /**
     * Show the Section Description
     */
    public function seg_auth_section_cb() {
        echo '<p>You can find your account information under <a href="https://app.segmetrics.io/a/account/edit" target="_blank">Account Settings</a> in your SegMetrics account.</p>';
    }

    /**
     * Rendering option functions
     */
    public function render_account_hash() {
        $options = get_option( $this->service->auth_key );
        echo "<input type='text' name='seg_auth[account_hash]' value='{$options['account_hash']}'>";
    }

    public function render_api_key() {
        $options = get_option( $this->service->auth_key );
        echo "<input type='text' name='seg_auth[api_key]' value='{$options['api_key']}'>";
    }

    /**
     * Trim the values
     * @param $options
     * @return array
     */
    public function seg_auth_sanitize($options) {

        // Break the cache on every save
        $this->service->break_cache();

        // Trim the values
        return [
            'account_hash' => trim($options['account_hash']),
            'api_key'      => trim($options['api_key']),
        ];

        // Check if the previous options are the same as the new values.
        // If they've changed, then delete the transients
//        if($new != get_option( $this->service->auth_key )){ $this->service->break_cache(); }
//
//        return $new;
    }




	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Segmetrics_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Segmetrics_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/segmetrics-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Segmetrics_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Segmetrics_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/segmetrics-admin.js', array( 'jquery' ), $this->version, false );

	}

}
