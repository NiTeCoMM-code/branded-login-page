<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function clb_remove_login_shake() {
	$options = clb_get_options();

	if ( ! empty( $options['remove_login_shake'] ) ) {
		remove_action( 'login_head', 'wp_shake_js', 12 );
	}
}
add_action( 'login_head', 'clb_remove_login_shake' );

function clb_block_author_enumeration() {
	$options = clb_get_options();

	if ( empty( $options['block_author_enum'] ) ) {
		return;
	}

	if ( is_admin() ) {
		return;
	}

	// Block ?author=N enumeration. get_query_var() returns 0 when absent,
	// avoiding direct access to $_GET and the need for a nonce.
	if ( (int) get_query_var( 'author' ) > 0 ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'clb_block_author_enumeration' );