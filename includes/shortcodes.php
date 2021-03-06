<?php

function pw_spe_shortcode( $atts, $content = null ) {

	$atts = shortcode_atts( array(
		'expires_on'  => __( 'This item expires on: %s', 'pw-spe' ),
		'expired'     => __( 'This item expired on %s', 'pw-spe' ),
		'date_format' => get_option( 'date_format', 'F j, Y' ),
		'class'       => 'pw-spe-post-expiration',
		'id'          => 'pw-spe-post-expiration-%d' 
	), $atts, 'pw_spe' );

	$date = get_post_meta( get_the_ID(), 'pw_spe_expiration', true );

	$expires = '<div id="' . esc_attr( sprintf( $atts['id'], get_the_ID() ) ) . '" class="' . esc_attr( $atts['class'] ) . '">';

		if( pw_spe_is_expired( get_the_ID() ) ) {

			$text = $atts['expired'];

		} else {

			$text = $atts['expires_on'];

		}

		$expires .= sprintf( $text, date_i18n( $atts['date_format'], strtotime( $date ) ) );

	$expires .= '</div>';

	return $expires;

}
add_shortcode( 'expires', 'pw_spe_shortcode' );