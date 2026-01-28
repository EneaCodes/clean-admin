<?php

/**
 * Plugin Name:       Bros Clean Admin – Hide Dashboard Ads
 * Plugin URI:        https://github.com/EneaCodes/Bros-Clean-Admin
 * Description:       Clean up your WordPress admin area by hiding most ads, review nags and promo banners.
 * Version:           1.1.1
 * Requires at least: 5.6
 * Requires PHP:      7.4
 * Author:            Enea
 * Author URI:        https://github.com/EneaCodes
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       bros-clean-admin-hide-dashboard-ads
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default options.
 */
function brosclad_get_default_options() {
	return array(
		'hide_dashboard_ads'     => 1,
		'hide_review_nags'       => 1,
		'hide_plugin_promos'     => 1,
		'custom_promo_keywords'  => '',
		'custom_review_keywords' => '',
	);
}

/**
 * Get saved options merged with defaults.
 */
function brosclad_get_options() {
	$defaults = brosclad_get_default_options();
	$options  = get_option( 'brosclad_options', array() );

	if ( ! is_array( $options ) ) {
		$options = array();
	}

	return wp_parse_args( $options, $defaults );
}

/**
 * Add settings link on Plugins page.
 */
function brosclad_plugin_action_links( $links ) {
	$settings_link = '<a href="' . esc_url( admin_url( 'options-general.php?page=brosclad-settings' ) ) . '">' . esc_html__( 'Settings', 'bros-clean-admin-hide-dashboard-ads' ) . '</a>';
	array_unshift( $links, $settings_link );
	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'brosclad_plugin_action_links' );

/**
 * Show activation notice with settings hint.
 */
function brosclad_admin_notice_activation() {
	if ( ! get_option( 'brosclad_show_activation_notice', true ) ) {
		return;
	}

	$message = __( 'Clean Admin – Hide Dashboard Ads is now active. Find it under Settings → Clean Admin.', 'bros-clean-admin-hide-dashboard-ads' );

	echo '<div class="notice notice-success is-dismissible"><p>' . esc_html( $message ) . '</p></div>';

	update_option( 'brosclad_show_activation_notice', false );
}
add_action( 'admin_notices', 'brosclad_admin_notice_activation' );

/**
 * Add settings page.
 */
add_action(
	'admin_menu',
	function () {
		add_options_page(
			__( 'Clean Admin', 'bros-clean-admin-hide-dashboard-ads' ),
			__( 'Clean Admin', 'bros-clean-admin-hide-dashboard-ads' ),
			'manage_options',
			'brosclad-settings',
			'brosclad_render_settings_page'
		);
	}
);

/**
 * Register settings.
 */
function brosclad_register_settings() {
	register_setting(
		'brosclad_options_group',
		'brosclad_options',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'brosclad_sanitize_options',
			'default'           => brosclad_get_default_options(),
		)
	);
}
add_action( 'admin_init', 'brosclad_register_settings' );

/**
 * Sanitize options.
 */
function brosclad_sanitize_options( $input ) {
	$defaults = brosclad_get_default_options();
	$clean    = array();

	$clean['hide_dashboard_ads']     = empty( $input['hide_dashboard_ads'] ) ? 0 : 1;
	$clean['hide_review_nags']       = empty( $input['hide_review_nags'] ) ? 0 : 1;
	$clean['hide_plugin_promos']     = empty( $input['hide_plugin_promos'] ) ? 0 : 1;
	$clean['custom_promo_keywords']  = isset( $input['custom_promo_keywords'] ) ? sanitize_text_field( $input['custom_promo_keywords'] ) : '';
	$clean['custom_review_keywords'] = isset( $input['custom_review_keywords'] ) ? sanitize_text_field( $input['custom_review_keywords'] ) : '';

	return wp_parse_args( $clean, $defaults );
}

/**
 * Render settings page.
 */
function brosclad_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( isset( $_POST['brosclad_save'] ) && check_admin_referer( 'brosclad_save_options', 'brosclad_nonce' ) ) {
		$options = array(
			'hide_dashboard_ads'     => isset( $_POST['hide_dashboard_ads'] ) ? 1 : 0,
			'hide_review_nags'       => isset( $_POST['hide_review_nags'] ) ? 1 : 0,
			'hide_plugin_promos'     => isset( $_POST['hide_plugin_promos'] ) ? 1 : 0,
			'custom_promo_keywords'  => isset( $_POST['custom_promo_keywords'] ) ? sanitize_text_field( wp_unslash( $_POST['custom_promo_keywords'] ) ) : '',
			'custom_review_keywords' => isset( $_POST['custom_review_keywords'] ) ? sanitize_text_field( wp_unslash( $_POST['custom_review_keywords'] ) ) : '',
		);

		update_option( 'brosclad_options', brosclad_sanitize_options( $options ) );

		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Settings saved.', 'bros-clean-admin-hide-dashboard-ads' ) . '</p></div>';
	}

	if ( isset( $_POST['brosclad_reset'] ) && check_admin_referer( 'brosclad_reset_options', 'brosclad_reset_nonce' ) ) {
		update_option( 'brosclad_options', brosclad_get_default_options() );
		echo '<div class="notice notice-warning is-dismissible"><p>' . esc_html__( 'Settings reset to defaults.', 'bros-clean-admin-hide-dashboard-ads' ) . '</p></div>';
	}

	$options = brosclad_get_options();
	?>
	<div class="wrap brosclad-wrap">
		<h1><?php esc_html_e( '🧹 Clean Admin', 'bros-clean-admin-hide-dashboard-ads' ); ?></h1>
		<p class="description">
			<?php esc_html_e( 'Keep your wp-admin focused. We hide marketing / promo clutter while keeping core notices.', 'bros-clean-admin-hide-dashboard-ads' ); ?>
		</p>

		<form method="post">
			<?php wp_nonce_field( 'brosclad_save_options', 'brosclad_nonce' ); ?>

			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Hide dashboard promo widgets', 'bros-clean-admin-hide-dashboard-ads' ); ?></th>
					<td>
						<label>
							<input type="checkbox" name="hide_dashboard_ads" <?php checked( $options['hide_dashboard_ads'], 1 ); ?> />
							<?php esc_html_e( 'Hide most dashboard ads, sales boxes and upsell widgets.', 'bros-clean-admin-hide-dashboard-ads' ); ?>
						</label>
					</td>
				</tr>

				<tr>
					<th scope="row"><?php esc_html_e( 'Hide review / rating nags', 'bros-clean-admin-hide-dashboard-ads' ); ?></th>
					<td>
						<label>
							<input type="checkbox" name="hide_review_nags" <?php checked( $options['hide_review_nags'], 1 ); ?> />
							<?php esc_html_e( 'Hide common "Please rate us 5-stars" or "Leave a review" notices.', 'bros-clean-admin-hide-dashboard-ads' ); ?>
						</label>
					</td>
				</tr>

				<tr>
					<th scope="row"><?php esc_html_e( 'Hide plugin settings promos', 'bros-clean-admin-hide-dashboard-ads' ); ?></th>
					<td>
						<label>
							<input type="checkbox" name="hide_plugin_promos" <?php checked( $options['hide_plugin_promos'], 1 ); ?> />
							<?php esc_html_e( 'Hide upsell boxes on plugin settings pages (Go Pro, sale banners, etc).', 'bros-clean-admin-hide-dashboard-ads' ); ?>
						</label>
					</td>
				</tr>
			</table>

			<h2><?php esc_html_e( 'Advanced Keywords', 'bros-clean-admin-hide-dashboard-ads' ); ?></h2>
			<p class="description">
				<?php esc_html_e( 'Comma-separated list of phrases. Matching is case-insensitive and based on text content.', 'bros-clean-admin-hide-dashboard-ads' ); ?>
			</p>

			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Custom promo keywords', 'bros-clean-admin-hide-dashboard-ads' ); ?></th>
					<td>
						<textarea name="custom_promo_keywords" rows="4" cols="50"><?php echo esc_textarea( $options['custom_promo_keywords'] ); ?></textarea>
						<p class="description">
							<?php esc_html_e( 'Example: black friday, cyber monday, limited time, early bird', 'bros-clean-admin-hide-dashboard-ads' ); ?>
						</p>
					</td>
				</tr>

				<tr>
					<th scope="row"><?php esc_html_e( 'Custom review keywords', 'bros-clean-admin-hide-dashboard-ads' ); ?></th>
					<td>
						<textarea name="custom_review_keywords" rows="4" cols="50"><?php echo esc_textarea( $options['custom_review_keywords'] ); ?></textarea>
						<p class="description">
							<?php esc_html_e( 'Example: rate this plugin, leave a review, share your feedback, beta tester', 'bros-clean-admin-hide-dashboard-ads' ); ?>
						</p>
					</td>
				</tr>
			</table>

			<p>
				<button type="submit" name="brosclad_save" class="button button-primary">
					<?php esc_html_e( 'Save Changes', 'bros-clean-admin-hide-dashboard-ads' ); ?>
				</button>
			</p>
		</form>

		<form method="post" style="margin-top: 20px;">
			<?php wp_nonce_field( 'brosclad_reset_options', 'brosclad_reset_nonce' ); ?>
			<p>
				<button type="submit" name="brosclad_reset" class="button button-secondary" onclick="return confirm('<?php echo esc_attr__( 'Reset settings to defaults?', 'bros-clean-admin-hide-dashboard-ads' ); ?>');">
					<?php esc_html_e( 'Reset to Defaults', 'bros-clean-admin-hide-dashboard-ads' ); ?>
				</button>
			</p>
		</form>
	</div>
	<?php
}

/**
 * Enqueue admin styles for settings page.
 */
function brosclad_enqueue_admin_styles( $hook ) {
	// Only enqueue on our settings page
	if ( 'settings_page_brosclad-settings' !== $hook ) {
		return;
	}

	$custom_css = "
		.brosclad-wrap h1 {
			display: flex;
			align-items: center;
			gap: 10px;
		}
		.brosclad-wrap .description {
			max-width: 640px;
		}
	";
	
	wp_register_style( 'brosclad-admin-settings', false, array(), '1.1.1' );
	wp_enqueue_style( 'brosclad-admin-settings' );
	wp_add_inline_style( 'brosclad-admin-settings', $custom_css );
}
add_action( 'admin_enqueue_scripts', 'brosclad_enqueue_admin_styles' );

/**
 * Enqueue admin script.
 */
add_action(
	'admin_enqueue_scripts',
	function ( $hook ) {
		// Don't load on our own settings page (no ads there to hide)
		if ( 0 === strpos( $hook, 'settings_page_brosclad-settings' ) ) {
			return;
		}
		
		// Load on all other admin pages (dashboard, plugins, other plugin settings, etc.)
		wp_enqueue_script(
			'brosclad-admin-clean',
			plugin_dir_url( __FILE__ ) . 'brosclad-admin-clean.js',
			array(),
			'1.1.1',
			true
		);

		$options = brosclad_get_options();

		$promo_words = apply_filters(
			'brosclad_promo_words',
			array(
				'black friday',
				'cyber monday',
				'limited time',
				'sale',
				'discount',
				'upgrade to pro',
				'go pro',
				'limited offer',
				'deal ends',
			)
		);

		$review_words = apply_filters(
			'brosclad_review_words',
			array(
				'rate this plugin',
				'leave a review',
				'please review',
				'star rating',
				'feedback',
			)
		);

		if ( ! empty( $options['custom_promo_keywords'] ) ) {
			$extra_promo = array_map( 'trim', explode( ',', $options['custom_promo_keywords'] ) );
			$promo_words = array_merge( $promo_words, $extra_promo );
		}

		if ( ! empty( $options['custom_review_keywords'] ) ) {
			$extra_review = array_map( 'trim', explode( ',', $options['custom_review_keywords'] ) );
			$review_words = array_merge( $review_words, $extra_review );
		}

		$promo_words  = array_filter( array_map( 'sanitize_text_field', $promo_words ) );
		$review_words = array_filter( array_map( 'sanitize_text_field', $review_words ) );

		wp_localize_script(
			'brosclad-admin-clean',
			'BROSCLAD_SETTINGS',
			array(
				'hideDashboardAds' => ! empty( $options['hide_dashboard_ads'] ),
				'hideReviewNags'   => ! empty( $options['hide_review_nags'] ),
				'hidePluginPromos' => ! empty( $options['hide_plugin_promos'] ),
				'promoWords'       => array_values( $promo_words ),
				'reviewWords'      => array_values( $review_words ),
			)
		);
	},
	99
);
