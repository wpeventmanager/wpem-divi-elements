<?php
/*
Plugin Name: WP Event Manager Divi Elements
Plugin URI:  www.wp-eventmanager.com
Description: WP Event Manager Divi elements for divi builder
Version:     1.0.0
Author:      WPEM Team
Author URI:  www.wp-eventmanager.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wpem-wp-event-manager-divi-elements
Domain Path: /languages

WP Event Manager Divi Elements is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

WP Event Manager Divi Elements is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with WP Event Manager Divi Elements. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/


if ( ! function_exists( 'wpem_initialize_extension' ) ):
/**
 * Creates the extension's main class instance.
 *
 * @since 1.0.0
 */
function wpem_initialize_extension() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/WpEventManagerDiviElements.php';
}
add_action( 'divi_extensions_init', 'wpem_initialize_extension' );
endif;


