<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function clb_get_default_options() {
	return array(
		'logo_url'               => '',
		'background_url'         => '',
		'background_overlay'     => '0.35',
		'form_width'             => '400',
		'logo_width'             => '280',
		'logo_height'            => '90',
		'primary_color'          => '#b91c1c',
		'button_color'           => '#b91c1c',
		'button_hover_color'     => '#991b1b',
		'link_color'             => '#ffffff',
		'form_background_color'  => 'rgba(255,255,255,0.96)',
		'hide_back_to_blog'      => 0,
		'hide_language_switcher' => 1,
		'generic_error_message'  => 1,
		'error_message'          => 'Login failed. Please check your credentials and try again.',
		'remove_login_shake'     => 1,
		'block_author_enum'      => 1,
	);
}

function clb_get_options() {
	$saved = get_option( CLB_OPTION_KEY, array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	return wp_parse_args( $saved, clb_get_default_options() );
}

function clb_sanitize_checkbox( $value ) {
	return ! empty( $value ) ? 1 : 0;
}

function clb_sanitize_decimal_string( $value, $default = '0.35', $min = 0, $max = 1 ) {
	$value = is_scalar( $value ) ? (string) $value : (string) $default;
	$value = trim( $value );

	if ( $value === '' || ! is_numeric( $value ) ) {
		return (string) $default;
	}

	$float = (float) $value;

	if ( $float < $min ) {
		$float = $min;
	}

	if ( $float > $max ) {
		$float = $max;
	}

	return (string) $float;
}

function clb_sanitize_px_number( $value, $default ) {
	$value = absint( $value );
	if ( $value <= 0 ) {
		$value = absint( $default );
	}
	return (string) $value;
}

function clb_sanitize_rgba_or_fallback( $value, $fallback = 'rgba(255,255,255,0.96)' ) {
	$value = is_scalar( $value ) ? trim( (string) $value ) : '';

	// Allow hex.
	if ( preg_match( '/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/', $value ) ) {
		return $value;
	}

	// Allow rgb() / rgba()
	if ( preg_match( '/^rgba?\(\s*\d{1,3}\s*,\s*\d{1,3}\s*,\s*\d{1,3}(?:\s*,\s*(?:0|1|0?\.\d+))?\s*\)$/', $value ) ) {
		return $value;
	}

	return $fallback;
}

function clb_sanitize_options( $input ) {
	$defaults = clb_get_default_options();
	$output   = array();

	$output['logo_url']               = isset( $input['logo_url'] ) ? esc_url_raw( $input['logo_url'] ) : $defaults['logo_url'];
	$output['background_url']         = isset( $input['background_url'] ) ? esc_url_raw( $input['background_url'] ) : $defaults['background_url'];
	$output['background_overlay']     = isset( $input['background_overlay'] ) ? clb_sanitize_decimal_string( $input['background_overlay'], $defaults['background_overlay'], 0, 1 ) : $defaults['background_overlay'];
	$output['form_width']             = isset( $input['form_width'] ) ? clb_sanitize_px_number( $input['form_width'], $defaults['form_width'] ) : $defaults['form_width'];
	$output['logo_width']             = isset( $input['logo_width'] ) ? clb_sanitize_px_number( $input['logo_width'], $defaults['logo_width'] ) : $defaults['logo_width'];
	$output['logo_height']            = isset( $input['logo_height'] ) ? clb_sanitize_px_number( $input['logo_height'], $defaults['logo_height'] ) : $defaults['logo_height'];

	$output['primary_color']          = isset( $input['primary_color'] ) ? sanitize_hex_color( $input['primary_color'] ) : $defaults['primary_color'];
	$output['button_color']           = isset( $input['button_color'] ) ? sanitize_hex_color( $input['button_color'] ) : $defaults['button_color'];
	$output['button_hover_color']     = isset( $input['button_hover_color'] ) ? sanitize_hex_color( $input['button_hover_color'] ) : $defaults['button_hover_color'];
	$output['link_color']             = isset( $input['link_color'] ) ? sanitize_hex_color( $input['link_color'] ) : $defaults['link_color'];
	$output['form_background_color']  = isset( $input['form_background_color'] ) ? clb_sanitize_rgba_or_fallback( $input['form_background_color'], $defaults['form_background_color'] ) : $defaults['form_background_color'];

	$output['hide_back_to_blog']      = isset( $input['hide_back_to_blog'] ) ? clb_sanitize_checkbox( $input['hide_back_to_blog'] ) : 0;
	$output['hide_language_switcher'] = isset( $input['hide_language_switcher'] ) ? clb_sanitize_checkbox( $input['hide_language_switcher'] ) : 0;
	$output['generic_error_message']  = isset( $input['generic_error_message'] ) ? clb_sanitize_checkbox( $input['generic_error_message'] ) : 0;
	$output['remove_login_shake']     = isset( $input['remove_login_shake'] ) ? clb_sanitize_checkbox( $input['remove_login_shake'] ) : 0;
	$output['block_author_enum']      = isset( $input['block_author_enum'] ) ? clb_sanitize_checkbox( $input['block_author_enum'] ) : 0;

	$output['error_message']          = isset( $input['error_message'] ) ? sanitize_text_field( $input['error_message'] ) : $defaults['error_message'];

	// Fallbacks if color sanitization returns null.
	if ( empty( $output['primary_color'] ) ) {
		$output['primary_color'] = $defaults['primary_color'];
	}
	if ( empty( $output['button_color'] ) ) {
		$output['button_color'] = $defaults['button_color'];
	}
	if ( empty( $output['button_hover_color'] ) ) {
		$output['button_hover_color'] = $defaults['button_hover_color'];
	}
	if ( empty( $output['link_color'] ) ) {
		$output['link_color'] = $defaults['link_color'];
	}
	if ( empty( $output['error_message'] ) ) {
		$output['error_message'] = $defaults['error_message'];
	}

	return $output;
}