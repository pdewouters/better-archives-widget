<?php
/*
Plugin Name: Better archives widget
Plugin URI: http://wpconsult.net
Description: Archives widget that groups by year and month
Version: 2.1
Author: Paul de Wouters
Author URI: http://wpconsult.net
License: GPLv2
*/

/*  Copyright 2011  Paul de Wouters - WpConsult

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Set constant path to the Better Archives Widget plugin directory. */
define( 'BAW_DIR', plugin_dir_path( __FILE__ ) );

/* Set constant path to the Better Archives Widget plugin URL. */
define( 'BAW_URL', plugin_dir_url( __FILE__ ) );
require_once( BAW_DIR . '/widget-archives.php' );
require_once( BAW_DIR . '/load-scripts.php' );
/* Set up the plugin. */
add_action( 'plugins_loaded', 'baw_setup' );

/**
 * Sets up the Better Archives Widget and loads files at the appropriate time.
 *
 * @since 0.8.0
 */
function baw_setup() {
	if ( is_admin() ) {
		/* Load translations. */
		load_plugin_textdomain( 'better-archives-widget', false, 'better-archives-widget/languages' );
	}
}
