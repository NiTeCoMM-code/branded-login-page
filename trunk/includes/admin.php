<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function blp_register_settings() {
	register_setting(
		'blp_settings_group',
		BLP_OPTION_KEY,
		'blp_sanitize_options'
	);
}
add_action( 'admin_init', 'blp_register_settings' );

function blp_add_admin_menu() {
	add_options_page(
		__( 'Branded Login Page', 'branded-login-page' ),
		__( 'Branded Login Page', 'branded-login-page' ),
		'manage_options',
		'branded-login-page',
		'blp_render_settings_page'
	);
}
add_action( 'admin_menu', 'blp_add_admin_menu' );

function blp_admin_assets( $hook ) {
	if ( 'settings_page_branded-login-page' !== $hook ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );

	wp_enqueue_style(
		'blp-admin',
		BLP_PLUGIN_URL . 'assets/admin.css',
		array(),
		BLP_VERSION
	);

	wp_enqueue_script(
		'blp-admin',
		BLP_PLUGIN_URL . 'assets/admin.js',
		array( 'jquery', 'wp-color-picker' ),
		BLP_VERSION,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'blp_admin_assets' );

function blp_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$options = blp_get_options();
	?>
	<div class="wrap blp-settings-wrap">
		<h1><?php esc_html_e( 'Branded Login Page', 'branded-login-page' ); ?></h1>

		<form method="post" action="options.php">
			<?php settings_fields( 'blp_settings_group' ); ?>

			<div class="blp-card">
				<h2><?php esc_html_e( 'Branding Images', 'branded-login-page' ); ?></h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row">
							<label for="blp_logo_url"><?php esc_html_e( 'Logo Image', 'branded-login-page' ); ?></label>
						</th>
						<td>
							<input type="text" id="blp_logo_url" class="regular-text" name="<?php echo esc_attr( BLP_OPTION_KEY ); ?>[logo_url]" value="<?php echo esc_attr( $options['logo_url'] ); ?>">
							<button type="button" class="button blp-upload-button" data-target="#blp_logo_url"><?php esc_html_e( 'Select Logo', 'branded-login-page' ); ?></button>
							<button type="button" class="button blp-clear-button" data-target="#blp_logo_url"><?php esc_html_e( 'Clear', 'branded-login-page' ); ?></button>
							<p class="description"><?php esc_html_e( 'Recommended: transparent PNG or SVG.', 'branded-login-page' ); ?></p>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="blp_background_url"><?php esc_html_e( 'Background Image', 'branded-login-page' ); ?></label>
						</th>
						<td>
							<input type="text" id="blp_background_url" class="regular-text" name="<?php echo esc_attr( BLP_OPTION_KEY ); ?>[background_url]" value="<?php echo esc_attr( $options['background_url'] ); ?>">
							<button type="button" class="button blp-upload-button" data-target="#blp_background_url"><?php esc_html_e( 'Select Background', 'branded-login-page' ); ?></button>
							<button type="button" class="button blp-clear-button" data-target="#blp_background_url"><?php esc_html_e( 'Clear', 'branded-login-page' ); ?></button>
							<p class="description"><?php esc_html_e( 'Recommended: optimized JPG or WebP.', 'branded-login-page' ); ?></p>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="blp_background_overlay"><?php esc_html_e( 'Background Overlay', 'branded-login-page' ); ?></label>
						</th>
						<td>
							<input type="number" step="0.05" min="0" max="1" id="blp_background_overlay" name="<?php echo esc_attr( BLP_OPTION_KEY ); ?>[background_overlay]" value="<?php echo esc_attr( $options['background_overlay'] ); ?>">
							<p class="description"><?php esc_html_e( 'Use 0 for none, or values like 0.25, 0.35, 0.50.', 'branded-login-page' ); ?></p>
						</td>
					</tr>
				</table>
			</div>

			<div class="blp-card">
				<h2><?php esc_html_e( 'Layout', 'branded-login-page' ); ?></h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row">
							<label for="blp_form_width"><?php esc_html_e( 'Form Width (px)', 'branded-login-page' ); ?></label>
						</th>
						<td>
							<input type="number" min="280" max="800" id="blp_form_width" name="<?php echo esc_attr( BLP_OPTION_KEY ); ?>[form_width]" value="<?php echo esc_attr( $options['form_width'] ); ?>">
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="blp_logo_width"><?php esc_html_e( 'Logo Width (px)', 'branded-login-page' ); ?></label>
						</th>
						<td>
							<input type="number" min="100" max="800" id="blp_logo_width" name="<?php echo esc_attr( BLP_OPTION_KEY ); ?>[logo_width]" value="<?php echo esc_attr( $options['logo_width'] ); ?>">
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="blp_logo_height"><?php esc_html_e( 'Logo Height (px)', 'branded-login-page' ); ?></label>
						</th>
						<td>
							<input type="number" min="40" max="300" id="blp_logo_height" name="<?php echo esc_attr( BLP_OPTION_KEY ); ?>[logo_height]" value="<?php echo esc_attr( $options['logo_height'] ); ?>">
						</td>
					</tr>
				</table>
			</div>

			<div class="blp-card">
				<h2><?php esc_html_e( 'Colors', 'branded-login-page' ); ?></h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row">
							<label for="blp_primary_color"><?php esc_html_e( 'Primary Color', 'branded-login-page' ); ?></label>
						</th>
						<td>
							<input type="text" id="blp_primary_color" class="blp-color-field" name="<?php echo esc_attr( BLP_OPTION_KEY ); ?>[primary_color]" value="<?php echo esc_attr( $options['primary_color'] ); ?>">
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="blp_button_color"><?php esc_html_e( 'Button Color', 'branded-login-page' ); ?></label>
						</th>
						<td>
							<input type="text" id="blp_button_color" class="blp-color-field" name="<?php echo esc_attr( BLP_OPTION_KEY ); ?>[button_color]" value="<?php echo esc_attr( $options['button_color'] ); ?>">
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="blp_button_hover_color"><?php esc_html_e( 'Button Hover Color', 'branded-login-page' ); ?></label>
						</th>
						<td>
							<input type="text" id="blp_button_hover_color" class="blp-color-field" name="<?php echo esc_attr( BLP_OPTION_KEY ); ?>[button_hover_color]" value="<?php echo esc_attr( $options['button_hover_color'] ); ?>">
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="blp_link_color"><?php esc_html_e( 'Link Color', 'branded-login-page' ); ?></label>
						</th>
						<td>
							<input type="text" id="blp_link_color" class="blp-color-field" name="<?php echo esc_attr( BLP_OPTION_KEY ); ?>[link_color]" value="<?php echo esc_attr( $options['link_color'] ); ?>">
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="blp_form_background_color"><?php esc_html_e( 'Form Background', 'branded-login-page' ); ?></label>
						</th>
						<td>
							<input type="text" id="blp_form_background_color" class="regular-text" name="<?php echo esc_attr( BLP_OPTION_KEY ); ?>[form_background_color]" value="<?php echo esc_attr( $options['form_background_color'] ); ?>">
							<p class="description"><?php esc_html_e( 'Supports hex, rgb(), or rgba(). Example: rgba(255,255,255,0.96)', 'branded-login-page' ); ?></p>
						</td>
					</tr>
				</table>
			</div>

			<div class="blp-card">
				<h2><?php esc_html_e( 'Display Options', 'branded-login-page' ); ?></h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><?php esc_html_e( 'Hide "Back to site" Link', 'branded-login-page' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="<?php echo esc_attr( BLP_OPTION_KEY ); ?>[hide_back_to_blog]" value="1" <?php checked( $options['hide_back_to_blog'], 1 ); ?>>
								<?php esc_html_e( 'Hide the back-to-site link on the login page.', 'branded-login-page' ); ?>
							</label>
						</td>
					</tr>

					<tr>
						<th scope="row"><?php esc_html_e( 'Hide Language Switcher', 'branded-login-page' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="<?php echo esc_attr( BLP_OPTION_KEY ); ?>[hide_language_switcher]" value="1" <?php checked( $options['hide_language_switcher'], 1 ); ?>>
								<?php esc_html_e( 'Hide the login page language switcher.', 'branded-login-page' ); ?>
							</label>
						</td>
					</tr>
				</table>
			</div>

			<div class="blp-card">
				<h2><?php esc_html_e( 'Login Errors', 'branded-login-page' ); ?></h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><?php esc_html_e( 'Use Generic Error Message', 'branded-login-page' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="<?php echo esc_attr( BLP_OPTION_KEY ); ?>[generic_error_message]" value="1" <?php checked( $options['generic_error_message'], 1 ); ?>>
								<?php esc_html_e( 'Replace username-specific errors with a generic message.', 'branded-login-page' ); ?>
							</label>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="blp_error_message"><?php esc_html_e( 'Custom Error Message', 'branded-login-page' ); ?></label>
						</th>
						<td>
							<input type="text" id="blp_error_message" class="regular-text" name="<?php echo esc_attr( BLP_OPTION_KEY ); ?>[error_message]" value="<?php echo esc_attr( $options['error_message'] ); ?>">
						</td>
					</tr>
				</table>
			</div>

			<div class="blp-card">
				<h2><?php esc_html_e( 'Security Options', 'branded-login-page' ); ?></h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><?php esc_html_e( 'Remove Login Shake', 'branded-login-page' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="<?php echo esc_attr( BLP_OPTION_KEY ); ?>[remove_login_shake]" value="1" <?php checked( $options['remove_login_shake'], 1 ); ?>>
								<?php esc_html_e( 'Disable the login form shake effect on failed login.', 'branded-login-page' ); ?>
							</label>
						</td>
					</tr>

					<tr>
						<th scope="row"><?php esc_html_e( 'Block Author Enumeration', 'branded-login-page' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="<?php echo esc_attr( BLP_OPTION_KEY ); ?>[block_author_enum]" value="1" <?php checked( $options['block_author_enum'], 1 ); ?>>
								<?php esc_html_e( 'Redirect requests using ?author=1 style enumeration.', 'branded-login-page' ); ?>
							</label>
						</td>
					</tr>
				</table>
			</div>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
