<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://procoders.tech/
 * @since      1.0.0
 *
 * @package    Pc_Security
 * @subpackage Pc_Security/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pc_Security
 * @subpackage Pc_Security/admin
 * @author     ProCoders <info@procoders.tech>
 */
class Pc_Security_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private string $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private string $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param string      $version     The version of this plugin.
	 *
	 *@since    1.0.0
	 */
	public function __construct( string $plugin_name, string $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

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
		 * defined in Pc_Security_Loader as all the hooks are defined
		 * in that particular class.
		 *
		 * The Pc_Security_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pc-security-admin.css', array(), $this->version, 'all' );

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
		 * defined in Pc_Security_Loader as all the hooks are defined
		 * in that particular class.
		 *
		 * The Pc_Security_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pc-security-admin.js', array( 'jquery' ), $this->version, false );

	}


	/**
     * Create admin menu
     *
	 * @return void
	 */
	public function register_menu() {
		add_menu_page(
			'PC Security Settings', // Page title
			'PC Security',          // Menu title
			'manage_options',       // Capability
			'pc-security',          // Menu slug
			[ $this, 'display_admin_page' ], // Callback function
			'dashicons-shield-alt', // Icon
			80                      // Position
		);
	}

	/**
	 * Load Admin Template
	 *
	 * @return void
	 */
	public function display_admin_page() {
		// Verify the file exists before including it
		$template_file = plugin_dir_path(__FILE__) . 'partials/pc-security-admin-display.php';
		if (file_exists($template_file)) {
			include $template_file;
		} else {
			// Handle error if the file doesn't exist
			echo '<div class="wrap"><h1>Template file missing</h1></div>';
		}
	}

	/**
	 * Admin Template Form Fields
	 *
	 * @return void
	 */
	public function register_settings() {
		register_setting(
			'pc_security_options_group', // Option group
			'pcs_rest_users_get_disable' // Option name
		);

		add_settings_section(
			'pc_security_settings_section', // Section ID
			'PC Security Settings', // Section title
			null, // Section callback (could be a function to output description)
			'pc-security' // Page slug
		);

		add_settings_field(
			'pcs_rest_users_get_disable', // Field ID
			'Disable Users REST API?', // Field title
			[ $this, 'render_checkbox' ], // Callback function to render the field
			'pc-security', // Page slug
			'pc_security_settings_section' // Section ID
		);
	}

	/**
	 * Checkbox input field
	 *
	 * @return void
	 */
	public function render_checkbox() {
		$option = get_option('pcs_rest_users_get_disable', '1'); // Default is checked
		?>
		<input type="checkbox" name="pcs_rest_users_get_disable" value="1" <?php checked($option, '1'); ?> />
		<?php
	}

	/**
	 * Main Logic
	 *  - disable REST 'users' Endpoint API
	 *  - only for GET requests
	 *
	 * @param $endpoints
	 *
	 * @return mixed
	 */
	public function disable_rest_users_get( $endpoints ) {
		$is_disabled = get_option('pcs_rest_users_get_disable', '1'); // Default is checked

		if ($is_disabled === '1') {
			$routes = array( '/wp/v2/users', '/wp/v2/users/(?P<id>[\d]+)' );

			foreach ( $routes as $route ) {
				if ( empty( $endpoints[ $route ] ) ) {
					continue;
				}

				foreach ( $endpoints[ $route ] as $i => $handlers ) {
					if (
						is_array( $handlers )
						&& isset( $handlers['methods'] )
						&& 'GET' === $handlers['methods']
					) {
						unset( $endpoints[ $route ][ $i ] );
					}
				}
			}
		}

		return $endpoints;
	}

}
