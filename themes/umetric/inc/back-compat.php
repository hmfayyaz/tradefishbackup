<?php
/**
 * Backward-compatibility functions for when theme requirements are not met
 *
 * This file must be parseable by PHP 5.2.
 *
 * @package umetric
 */

/**
 * Gets the message to warn the user about the theme requirements not being met.
 *
 * @global string $wp_version WordPress version.
 *
 * @return string Message to show to the user.
 */
function umetric_get_insufficient_requirements_message() {
	global $wp_version;

	$insufficient_wp  = version_compare( $wp_version, UMETRIC_MINIMUM_WP_VERSION, '<' );
	$insufficient_php = version_compare( phpversion(), UMETRIC_MINIMUM_PHP_VERSION, '<' );

	if ( $insufficient_wp && $insufficient_php ) {
		/* translators: 1: required WP version number, 2: required PHP version number, 3: available WP version number, 4: available PHP version number */
		return sprintf( __( 'Umetric requires at least WordPress version %1$s and PHP version %2$s. You are running versions %3$s and %3$s respectively. Please update and try again.', 'umetric' ), UMETRIC_MINIMUM_WP_VERSION, UMETRIC_MINIMUM_PHP_VERSION, $wp_version, phpversion() );
	}

	if ( $insufficient_wp ) {
		/* translators: 1: required WP version number, 2: available WP version number */
		return sprintf( __( 'Umetric requires at least WordPress version %1$s. You are running version %2$s. Please update and try again.', 'umetric' ), UMETRIC_MINIMUM_WP_VERSION, $wp_version );
	}

	if ( $insufficient_php ) {
		/* translators: 1: required PHP version number, 2: available PHP version number */
		return sprintf( __( 'Umetric requires at least PHP version %1$s. You are running version %2$s. Please update and try again.', 'umetric' ), UMETRIC_MINIMUM_PHP_VERSION, phpversion() );
	}

	return '';
}

/**
 * Displays an error message if WP-CLI is used when requirements are not met.
 *
 * Exits script.
 */
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::error( umetric_get_insufficient_requirements_message() );
}

/**
 * Prevents switching to the theme when requirements are not met.
 *
 * Switches to the default theme.
 */
function umetric_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );

	add_action( 'admin_notices', 'umetric_upgrade_notice' );
}
add_action( 'after_switch_theme', 'umetric_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to the theme
 * when requirements are not met.
 */
function umetric_upgrade_notice() {
	printf( '<div class="error"><p>%s</p></div>', esc_html( umetric_get_insufficient_requirements_message() ) );
}

/**
 * Prevents the Customizer from being loaded when requirements are not met.
 */
function umetric_customize() {
	wp_die(
		esc_html( umetric_get_insufficient_requirements_message() ),
		'',
		array(
			'back_link' => true,
		)
	);
}
add_action( 'load-customize.php', 'umetric_customize' );

/**
 * Prevents the Theme Preview from being loaded when requirements are not met.
 */
function umetric_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( esc_html( umetric_get_insufficient_requirements_message() ) );
	}
}
add_action( 'template_redirect', 'umetric_preview' );
