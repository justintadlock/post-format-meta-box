<?php
/**
 * Plugin Name: Post Format Meta Box
 * Plugin URI: http://themehybrid.com/plugins/post-format-meta-box
 * Description: Replaces the WordPress 3.6+ post format <abbr title="User Interface">UI</abbr> with the pre-3.6 meta box for selecting a post format.
 * Version: 0.1.0
 * Author: Justin Tadlock
 * Author URI: http://justintadlock.com
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free Software Foundation; either version 2 of the License, 
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package   PostFormatMetaBox
 * @version   0.1.0
 * @author    Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2013, Justin Tadlock
 * @link      http://themehybrid.com/plugins/post-format-meta-box
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

class PFMB_Plugin_Load {

	/**
	 * Sets up the plugin actions and filters.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public static function setup() {
		add_filter( 'enable_post_format_ui', '__return_false' );
		add_action( 'plugins_loaded',        array( __CLASS__, 'i18n' ) );
		add_action( 'load-post.php',         array( __CLASS__, 'load_meta_boxes' ) );
		add_action( 'load-post-new.php',     array( __CLASS__, 'load_meta_boxes' ) );
	}

	/**
	 * Loads the translation files.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public static function i18n() {
		load_plugin_textdomain( 
			'post-format-meta-box', 
			false, 
			trailingslashit( dirname( __FILE__ ) ) . 'languages' 
		);
	}

	/**
	 * Hooks the meta box functionality to 'add_meta_boxes' on the edit post screen.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public static function load_meta_boxes() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_box' ) );
	}

	/**
	 * Adds the post format meta box if the post type supports post formats.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public static function add_meta_box( $post_type ) {

		if ( function_exists( 'post_format_meta_box' ) && post_type_supports( $post_type, 'post-formats' ) )
			add_meta_box( 'pfmb-meta-box', __( 'Format', 'post-format-meta-box' ), 'post_format_meta_box', $post_type, 'side', 'core' );
	}
}

PFMB_Plugin_Load::setup();

?>