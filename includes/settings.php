<?php

function pw_spe_register_settings() {

	register_setting( 'reading', 'pw_spe_prefix', 'sanitize_text_field' );
	add_settings_field( 'pw_spe_prefix', __( 'Expired Item Prefix', 'pw-spe' ), 'pw_spe_settings_field', 'reading', 'default' );

}
add_action( 'admin_init', 'pw_spe_register_settings' );

function pw_spe_settings_field() {
	$prefix = get_option( 'pw_spe_prefix', __( 'Expired:', 'pw-spe' ) );
	echo '<input type="text" name="pw_spe_prefix" value="' . esc_attr( $prefix ) . '" class="regular-text"/><br/>';
	echo '<p class="description">' . __( 'Enter the text you would like prepended to expired items.', 'pw-spe' ) . '</p>';
}