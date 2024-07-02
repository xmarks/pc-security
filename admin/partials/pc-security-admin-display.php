<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://https://procoders.tech/
 * @since      1.0.0
 *
 * @package    Pc_Security
 * @subpackage Pc_Security/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<div class="wrap">
    <form method="post" action="options.php">
		<?php
		// Output security fields for the registered setting
		settings_fields( 'pc_security_options_group' );
		// Output setting sections and their fields
		do_settings_sections( 'pc-security' );
		// Output save settings button
		submit_button();
		?>
    </form>
</div>