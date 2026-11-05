<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function clb_register_settings() {
	register_setting(
		'clb_settings_group',
		CLB_OPTION_KEY,
		'clb_sanitize_options'
	);
}
add_action( 'admin_init', 'clb_register_settings' );

function clb_add_admin_menu() {
	add_options_page(
		__( 'Custom Login Branding', 'custom-login-branding' ),
		__( 'Custom Login Branding', 'custom-login-branding' ),
		'manage_options',
		'custom-login-branding',
		'clb_render_settings_page'
	);
}
add_action( 'admin_menu', 'clb_add_admin_menu' );

function clb_admin_assets( $hook ) {
	if ( 'settings_page_custom-login-branding' !== $hook ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );

	wp_enqueue_style(
		'clb-admin',
		CLB_PLUGIN_URL . 'assets/admin.css',
		array(),
		CLB_VERSION
	);

	wp_enqueue_script(
		'clb-admin',
		CLB_PLUGIN_URL . 'assets/admin.js',
		array( 'jquery', 'wp-color-picker' ),
		CLB_VERSION,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'clb_admin_assets' );

function clb_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$options = clb_get_options();
	?>
	<div class="wrap clb-settings-wrap">
		<h1><?php esc_html_e( 'Custom Login Branding', 'custom-login-branding' ); ?></h1>

		<form method="post" action="options.php">
			<?php settings_fields( 'clb_settings_group' ); ?>

			<div class="clb-card">
				<h2><?php esc_html_e( 'Branding Images', 'custom-login-branding' ); ?></h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row">
							<label for="clb_logo_url"><?php esc_html_e( 'Logo Image', 'custom-login-branding' ); ?></label>
						</th>
						<td>
							<input type="text" id="clb_logo_url" class="regular-text" name="<?php echo esc_attr( CLB_OPTION_KEY ); ?>[logo_url]" value="<?php echo esc_attr( $options['logo_url'] ); ?>">
							<button type="button" class="button clb-upload-button" data-target="#clb_logo_url"><?php esc_html_e( 'Select Logo', 'custom-login-branding' ); ?></button>
							<button type="button" class="button clb-clear-button" data-target="#clb_logo_url"><?php esc_html_e( 'Clear', 'custom-login-branding' ); ?></button>
							<p class="description"><?php esc_html_e( 'Recommended: transparent PNG or SVG.', 'custom-login-branding' ); ?></p>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="clb_background_url"><?php esc_html_e( 'Background Image', 'custom-login-branding' ); ?></label>
						</th>
						<td>
							<input type="text" id="clb_background_url" class="regular-text" name="<?php echo esc_attr( CLB_OPTION_KEY ); ?>[background_url]" value="<?php echo esc_attr( $options['background_url'] ); ?>">
							<button type="button" class="button clb-upload-button" data-target="#clb_background_url"><?php esc_html_e( 'Select Background', 'custom-login-branding' ); ?></button>
							<button type="button" class="button clb-clear-button" data-target="#clb_background_url"><?php esc_html_e( 'Clear', 'custom-login-branding' ); ?></button>
							<p class="description"><?php esc_html_e( 'Recommended: optimized JPG or WebP.', 'custom-login-branding' ); ?></p>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="clb_background_overlay"><?php esc_html_e( 'Background Overlay', 'custom-login-branding' ); ?></label>
						</th>
						<td>
							<input type="number" step="0.05" min="0" max="1" id="clb_background_overlay" name="<?php echo esc_attr( CLB_OPTION_KEY ); ?>[background_overlay]" value="<?php echo esc_attr( $options['background_overlay'] ); ?>">
							<p class="description"><?php esc_html_e( 'Use 0 for none, or values like 0.25, 0.35, 0.50.', 'custom-login-branding' ); ?></p>
						</td>
					</tr>
				</table>
			</div>

			<div class="clb-card">
				<h2><?php esc_html_e( 'Layout', 'custom-login-branding' ); ?></h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row">
							<label for="clb_form_width"><?php esc_html_e( 'Form Width (px)', 'custom-login-branding' ); ?></label>
						</th>
						<td>
							<input type="number" min="280" max="800" id="clb_form_width" name="<?php echo esc_attr( CLB_OPTION_KEY ); ?>[form_width]" value="<?php echo esc_attr( $options['form_width'] ); ?>">
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="clb_logo_width"><?php esc_html_e( 'Logo Width (px)', 'custom-login-branding' ); ?></label>
						</th>
						<td>
							<input type="number" min="100" max="800" id="clb_logo_width" name="<?php echo esc_attr( CLB_OPTION_KEY ); ?>[logo_width]" value="<?php echo esc_attr( $options['logo_width'] ); ?>">
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="clb_logo_height"><?php esc_html_e( 'Logo Height (px)', 'custom-login-branding' ); ?></label>
						</th>
						<td>
							<input type="number" min="40" max="300" id="clb_logo_height" name="<?php echo esc_attr( CLB_OPTION_KEY ); ?>[logo_height]" value="<?php echo esc_attr( $options['logo_height'] ); ?>">
						</td>
					</tr>
				</table>
			</div>

			<div class="clb-card">
				<h2><?php esc_html_e( 'Colors', 'custom-login-branding' ); ?></h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row">
							<label for="clb_primary_color"><?php esc_html_e( 'Primary Color', 'custom-login-branding' ); ?></label>
						</th>
						<td>
							<input type="text" id="clb_primary_color" class="clb-color-field" name="<?php echo esc_attr( CLB_OPTION_KEY ); ?>[primary_color]" value="<?php echo esc_attr( $options['primary_color'] ); ?>">
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="clb_button_color"><?php esc_html_e( 'Button Color', 'custom-login-branding' ); ?></label>
						</th>
						<td>
							<input type="text" id="clb_button_color" class="clb-color-field" name="<?php echo esc_attr( CLB_OPTION_KEY ); ?>[button_color]" value="<?php echo esc_attr( $options['button_color'] ); ?>">
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="clb_button_hover_color"><?php esc_html_e( 'Button Hover Color', 'custom-login-branding' ); ?></label>
						</th>
						<td>
							<input type="text" id="clb_button_hover_color" class="clb-color-field" name="<?php echo esc_attr( CLB_OPTION_KEY ); ?>[button_hover_color]" value="<?php echo esc_attr( $options['button_hover_color'] ); ?>">
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="clb_link_color"><?php esc_html_e( 'Link Color', 'custom-login-branding' ); ?></label>
						</th>
						<td>
							<input type="text" id="clb_link_color" class="clb-color-field" name="<?php echo esc_attr( CLB_OPTION_KEY ); ?>[link_color]" value="<?php echo esc_attr( $options['link_color'] ); ?>">
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="clb_form_background_color"><?php esc_html_e( 'Form Background', 'custom-login-branding' ); ?></label>
						</th>
						<td>
							<input type="text" id="clb_form_background_color" class="regular-text" name="<?php echo esc_attr( CLB_OPTION_KEY ); ?>[form_background_color]" value="<?php echo esc_attr( $options['form_background_color'] ); ?>">
							<p class="description"><?php esc_html_e( 'Supports hex, rgb(), or rgba(). Example: rgba(255,255,255,0.96)', 'custom-login-branding' ); ?></p>
						</td>
					</tr>
				</table>
			</div>

			<div class="clb-card">
				<h2><?php esc_html_e( 'Display Options', 'custom-login-branding' ); ?></h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><?php esc_html_e( 'Hide "Back to site" Link', 'custom-login-branding' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="<?php echo esc_attr( CLB_OPTION_KEY ); ?>[hide_back_to_blog]" value="1" <?php checked( $options['hide_back_to_blog'], 1 ); ?>>
								<?php esc_html_e( 'Hide the back-to-site link on the login page.', 'custom-login-branding' ); ?>
							</label>
						</td>
					</tr>

					<tr>
						<th scope="row"><?php esc_html_e( 'Hide Language Switcher', 'custom-login-branding' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="<?php echo esc_attr( CLB_OPTION_KEY ); ?>[hide_language_switcher]" value="1" <?php checked( $options['hide_language_switcher'], 1 ); ?>>
								<?php esc_html_e( 'Hide the login page language switcher.', 'custom-login-branding' ); ?>
							</label>
						</td>
					</tr>
				</table>
			</div>

			<div class="clb-card">
				<h2><?php esc_html_e( 'Login Errors', 'custom-login-branding' ); ?></h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><?php esc_html_e( 'Use Generic Error Message', 'custom-login-branding' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="<?php echo esc_attr( CLB_OPTION_KEY ); ?>[generic_error_message]" value="1" <?php checked( $options['generic_error_message'], 1 ); ?>>
								<?php esc_html_e( 'Replace username-specific errors with a generic message.', 'custom-login-branding' ); ?>
							</label>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label for="clb_error_message"><?php esc_html_e( 'Custom Error Message', 'custom-login-branding' ); ?></label>
						</th>
						<td>
							<input type="text" id="clb_error_message" class="regular-text" name="<?php echo esc_attr( CLB_OPTION_KEY ); ?>[error_message]" value="<?php echo esc_attr( $options['error_message'] ); ?>">
						</td>
					</tr>
				</table>
			</div>

			<div class="clb-card">
				<h2><?php esc_html_e( 'Security Options', 'custom-login-branding' ); ?></h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><?php esc_html_e( 'Remove Login Shake', 'custom-login-branding' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="<?php echo esc_attr( CLB_OPTION_KEY ); ?>[remove_login_shake]" value="1" <?php checked( $options['remove_login_shake'], 1 ); ?>>
								<?php esc_html_e( 'Disable the login form shake effect on failed login.', 'custom-login-branding' ); ?>
							</label>
						</td>
					</tr>

					<tr>
						<th scope="row"><?php esc_html_e( 'Block Author Enumeration', 'custom-login-branding' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="<?php echo esc_attr( CLB_OPTION_KEY ); ?>[block_author_enum]" value="1" <?php checked( $options['block_author_enum'], 1 ); ?>>
								<?php esc_html_e( 'Redirect requests using ?author=1 style enumeration.', 'custom-login-branding' ); ?>
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