<?php
/**
 * Plugin Name: Expired
 * Description: A plugin that allows you to set an expiration date on posts.
 * Version: 1.2.3
 * Author: James Hammack
 * Author URI: http://james.hammack.us
 * Text Domain: pw-spe
 * Domain Path: languages
 *
 * Expired is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Expired is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with expired. If not, see <http://www.gnu.org/licenses/>.
*/

define( 'PW_SPE_ASSETS_URL', plugin_dir_url( __FILE__ ) . 'assets' );

if( is_admin() ) {

	require_once dirname( __FILE__ ) . '/includes/metabox.php';
	require_once dirname( __FILE__ ) . '/includes/settings.php';

}
require_once dirname( __FILE__ ) . '/includes/widgets.php';
require_once dirname( __FILE__ ) . '/includes/shortcodes.php';
require_once dirname( __FILE__ ) . '/updater/github-updater.php';


function pw_spe_text_domain() {

	load_plugin_textdomain( 'pw-spe' );

}
add_action( 'init', 'pw_spe_text_domain' );

function pw_spe_is_expired( $post_id = 0 ) {

	$expires = get_post_meta( $post_id, 'pw_spe_expiration', true );

	if( ! empty( $expires ) ) {

		// Get the current time and post's expiration date
		$current_time = current_time( 'timestamp' );
		$expiration   = strtotime( $expires, $current_time );

		if( $current_time >= $expiration ) {

			return true;

		}

	}

	return false;

}



/*
$post_id - The ID of the post you'd like to change.
$status -  The post status publish|pending|draft|private|static|object|attachment|inherit|future|trash.
*/
function change_post_status($post_id,$status){
    $current_post = get_post( $post_id, 'ARRAY_A' );
    $current_post['post_status'] = $status;
    wp_update_post($current_post);
}

function pw_spe_filter_title( $title = '', $post_id = 0 ) {

	if( pw_spe_is_expired( $post_id ) ) {

		$prefix = get_option( 'pw_spe_prefix', __( 'Expired:', 'pw-spe' ) );
		$title  = $prefix . '&nbsp;' . $title;
		$term = term_exists('Expired', 'category');
		if ($term == 0 && $term == null) {
		  $arg = array('description' => "Expired");
		  $new_cat_id = wp_insert_term("Expired", "category", $arg);
		}
		change_post_status($post_id,'draft');
		$jh_cat_id = get_cat_ID('Expired');
		wp_set_object_terms( $post_id, $jh_cat_id, 'category', true );

	}

	return $title;

}
add_filter( 'the_title', 'pw_spe_filter_title', 100, 2 );