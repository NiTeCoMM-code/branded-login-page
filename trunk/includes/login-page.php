<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function clb_login_logo_url() {
	return home_url( '/' );
}
add_filter( 'login_headerurl', 'clb_login_logo_url' );

function clb_login_logo_title() {
	return get_bloginfo( 'name' );
}
add_filter( 'login_headertext', 'clb_login_logo_title' );

function clb_login_page_styles() {
	$options = clb_get_options();

	$logo_url              = ! empty( $options['logo_url'] ) ? esc_url( $options['logo_url'] ) : '';
	$background_url        = ! empty( $options['background_url'] ) ? esc_url( $options['background_url'] ) : '';
	$background_overlay    = esc_attr( $options['background_overlay'] );
	$form_width            = absint( $options['form_width'] );
	$logo_width            = absint( $options['logo_width'] );
	$logo_height           = absint( $options['logo_height'] );
	$primary_color         = esc_attr( $options['primary_color'] );
	$button_color          = esc_attr( $options['button_color'] );
	$button_hover_color    = esc_attr( $options['button_hover_color'] );
	$link_color            = esc_attr( $options['link_color'] );
	$form_background_color = esc_attr( $options['form_background_color'] );
	$hide_back_to_blog     = ! empty( $options['hide_back_to_blog'] );
	$hide_lang_switcher    = ! empty( $options['hide_language_switcher'] );
	?>
	<style id="clb-login-styles">
		body.login {
			min-height: 100vh;
			<?php if ( ! empty( $background_url ) ) : ?>
				background:
					linear-gradient(rgba(0,0,0,<?php echo $background_overlay; ?>), rgba(0,0,0,<?php echo $background_overlay; ?>)),
					url('<?php echo $background_url; ?>') no-repeat center center fixed;
				background-size: cover;
			<?php else : ?>
				background: #f3f4f6;
			<?php endif; ?>
		}

		body.login div#login {
			width: 100%;
			max-width: <?php echo $form_width; ?>px;
			padding: 4% 20px 20px;
		}

		.login h1 {
			margin-bottom: 20px;
		}

		.login h1 a {
			display: block;
			width: 100%;
			max-width: <?php echo $logo_width; ?>px;
			height: <?php echo $logo_height; ?>px;
			margin: 0 auto 10px;
			background-position: center center !important;
			background-repeat: no-repeat !important;
			background-size: contain !important;
			text-indent: -9999px;
			overflow: hidden;
			outline: none;
			box-shadow: none;
			<?php if ( ! empty( $logo_url ) ) : ?>
				background-image: url('<?php echo $logo_url; ?>') !important;
			<?php else : ?>
				background-image: none !important;
			<?php endif; ?>
		}

		.login form {
			background: <?php echo $form_background_color; ?>;
			border: 0;
			border-radius: 14px;
			box-shadow: 0 18px 45px rgba(0,0,0,0.18);
			padding: 28px 28px 24px;
		}

		.login label {
			color: #1f2937;
			font-size: 14px;
			font-weight: 600;
		}

		.login input[type="text"],
		.login input[type="password"],
		.login input[type="email"] {
			border: 1px solid #cbd5e1;
			border-radius: 8px;
			min-height: 46px;
			padding: 10px 12px;
			box-shadow: none;
		}

		.login input[type="text"]:focus,
		.login input[type="password"]:focus,
		.login input[type="email"]:focus {
			border-color: <?php echo $primary_color; ?>;
			box-shadow: 0 0 0 3px rgba(0,0,0,0.08);
		}

		.wp-core-ui .button-primary {
			background: <?php echo $button_color; ?>;
			border-color: <?php echo $button_color; ?>;
			border-radius: 8px;
			min-height: 42px;
			padding: 0 18px;
			font-weight: 700;
			box-shadow: none;
			text-shadow: none;
		}

		.wp-core-ui .button-primary:hover,
		.wp-core-ui .button-primary:focus {
			background: <?php echo $button_hover_color; ?>;
			border-color: <?php echo $button_hover_color; ?>;
		}

		.login .button.wp-hide-pw {
			color: <?php echo $primary_color; ?>;
		}

		.login #nav,
		.login #backtoblog {
			text-align: center;
			margin-top: 14px;
		}

		.login #nav a,
		.login #backtoblog a {
			color: <?php echo $link_color; ?>;
			text-decoration: none;
			font-weight: 600;
		}

		.login #nav a:hover,
		.login #backtoblog a:hover {
			opacity: 0.85;
		}

		.login .message,
		.login .notice,
		.login .success {
			border-left: 4px solid <?php echo $primary_color; ?>;
			border-radius: 8px;
		}

		.login .error,
		.login #login_error {
			border-left: 4px solid #dc2626;
			border-radius: 8px;
		}

		<?php if ( $hide_back_to_blog ) : ?>
		.login #backtoblog {
			display: none !important;
		}
		<?php endif; ?>

		<?php if ( $hide_lang_switcher ) : ?>
		.language-switcher {
			display: none !important;
		}
		<?php endif; ?>

		@media (max-width: 480px) {
			.login form {
				padding: 22px 18px 18px;
			}
		}
	</style>
	<?php
}
add_action( 'login_enqueue_scripts', 'clb_login_page_styles' );

function clb_filter_login_errors( $error ) {
	$options = clb_get_options();

	if ( empty( $options['generic_error_message'] ) ) {
		return $error;
	}

	return ! empty( $options['error_message'] )
		? $options['error_message']
		: 'Login failed. Please check your credentials and try again.';
}
add_filter( 'login_errors', 'clb_filter_login_errors' );