<?php

/**
 * Controls login flow.
 *
 * @package ethpress
 * @since 0.1.0
 */

namespace losnappas\Ethpress;

defined('ABSPATH') || die;

use losnappas\Ethpress\Address;
use losnappas\Ethpress\Signature;
use losnappas\Ethpress\Nonce;

/**
 * In php, wp_enqueue_script( 'ethpress-login' ); and then you can call ethpress.metamask.connect in javascript.
 *
 * @since 0.1.0
 */
class Login
{

	/**
	 * Ajax: verifies signed message by re-creating the message again and extracting the address.
	 *
	 * @since 0.1.0
	 */
	public static function verify_login()
	{
		check_ajax_referer('ethpress_log_in');

		$message = '';

		if (!isset($_POST['coinbase'], $_POST['signature'])) {
			wp_send_json_error(esc_html__('Invalid input', 'ethpress'));
			return;
		}

		// Sanitize.
		// These two show up as linter errors, but that is a bug in the linter itself.
		$coinbase              = Address::sanitize(wp_unslash($_POST['coinbase']));
		$signature             = Address::sanitize(wp_unslash($_POST['signature']));

		$requested_redirect_to = '';
		if (!empty($_POST['redirect_to'])) {
			$redirect_to           = wp_sanitize_redirect(wp_unslash($_POST['redirect_to']));
			$requested_redirect_to = $redirect_to;
		} else {
			$redirect_to = admin_url();
			// This IF block will be auto removed from the Free version.
			// This IF will be executed only if the user in a trial mode or have a valid license.
			if (\losnappas\Ethpress\ethpress_fs()->can_use_premium_code__premium_only()) {
				// ... premium only logic ...
				$defopts = [
					'redirect_url' => $redirect_to,
				];
				$options = \get_site_option('ethpress', $defopts);
				$redirect_to  = isset($options['redirect_url']) && !empty($options['redirect_url']) ? $options['redirect_url'] : $redirect_to;
			}
		}
		// Verify.
		$login_message  = self::get_login_message($coinbase);
		list($verified, $verify_error) = Signature::verify2($login_message, $signature, $coinbase);

		/**
		 * @var \WP_User|\WP_Error|null $user WP_User object
		 */
		$user = null;
		if (!$verified) {
			$user = new \WP_Error('ethpress', $verify_error);
		}

		// Log in.
		try {
			$address = new Address($coinbase);
			/**
			 * For additional checks in addons
			 *
			 * @since 1.6.0
			 *
			 * @param \losnappas\Ethpress\Address $address.
			 * @return \losnappas\Ethpress\Address|\WP_Error Return \WP_Error if address doesn't fulfill some condition.
			 */
			$address = apply_filters('ethpress_login_address', $address);
			if (!is_wp_error($address)) {
				if (get_option('users_can_register')) {
					$user = $address->register_and_log_in();
				} else {
					$user = $address->log_in();
				}
				$message = esc_html__('Logged in', 'ethpress');
			} else {
				$user = $address;
			}
			// phpcs:ignore -- This is using wp original hook.
			$redirect_to = apply_filters('login_redirect', $redirect_to, $requested_redirect_to, $user);
		} catch (\WP_Error $e) {
			$user = $e;
		}

		if (isset($_POST['provider'])) {
			$provider = \sanitize_key(\wp_unslash((string) $_POST['provider']));
		} else {
			$provider = false;
		}

		/**
		 * For additional checks in addons
		 *
		 * @since 1.6.0
		 *
		 * @param string           $redirect_to           The redirect destination URL.
		 * @param string           $requested_redirect_to The requested redirect destination URL passed as a parameter.
		 * @param \WP_User|\WP_Error $user                  WP_User object if login was successful, WP_Error object otherwise.
		 */
		$redirect_to = apply_filters('ethpress_login_redirect', $redirect_to, $requested_redirect_to, $user);
		/**
		 * Fires after every login attempt.
		 *
		 * @since 0.1.0
		 *
		 * @param \WP_User|\WP_Error $user WP_User on success, WP_Error on failure.
		 * @param (string|false) $provider One of 'metamask', 'walletconnect', false.
		 */
		do_action('ethpress_login', $user, $provider);

		if (is_wp_error($user)) {
			$message = $user->get_error_message();
			wp_send_json_error([
				'redirect' => $redirect_to,
				'message'  => $message,
			]);
			return;
		}

		if ((empty($redirect_to) || 'wp-admin/' === $redirect_to || admin_url() === $redirect_to)) {
			/**
			 * @var \WP_User
			 */
			$user = $user;
			// Redirect.
			// Copied from wp-login.php.
			// If the user doesn't belong to a blog, send them to user admin. If the user can't edit posts, send them to their profile.
			if (is_multisite() && !get_active_blog_for_user($user->ID) && !is_super_admin($user->ID)) {
				$redirect_to = user_admin_url();
			} elseif (is_multisite() && !$user->has_cap('read')) {
				$redirect_to = get_dashboard_url($user->ID);
			} elseif (!$user->has_cap('edit_posts')) {
				$redirect_to = $user->has_cap('read') ? admin_url('profile.php') : home_url();
			}
		}
		wp_send_json_success([
			'redirect' => $redirect_to,
			'message'  => $message,
		]);
	}

	/**
	 * Gets login message to be signed for address.
	 *
	 * @since 0.1.0
	 *
	 * @param string $coinbase Address.
	 * @return string Message.
	 */
	public static function get_login_message($coinbase)
	{
		$message = sprintf(
			/* translators: blog name. */
			__(
				'Log in to %1$s',
				'ethpress'
			),
			get_bloginfo('name', 'display')
		) . "\n\n" . get_home_url();
		$nonce = Nonce::get($coinbase);

		/**
		 * Filters the message to show in the login dialog.
		 *
		 * The message needs to be the same when it is signed and when it is verified.
		 * Nonce will be added on a new line.
		 *
		 * @since 0.1.0
		 * @since 0.7.0 Has wallet address as 2nd argument: $coinbase. Client ip is now hashed with nonce.
		 *
		 * @param string $message Message.
		 * @param string $coinbase User's address.
		 */
		$message  = apply_filters('ethpress_login_message', $message, $coinbase);
		$message .= "\n\n" . $nonce;
		return $message;
	}

	/**
	 * Ajax: sends login message. Used to use GET, but now using POST, thus using _REQUEST.
	 *
	 * @since 0.1.0
	 */
	public static function get_message()
	{
		$referer_ok = check_ajax_referer('ethpress_get_message', false, false);
		if (!$referer_ok) {
			// User had probably logged in without cookies enabled.
			wp_send_json_error(esc_html__('Bad nonce, please refresh.', 'ethpress'));
		} elseif (!empty($_REQUEST['coinbase'])) {
			// This shows up as lint error, but that is a bug in the linter itself.
			$coinbase = Address::sanitize(wp_unslash($_REQUEST['coinbase']));
			$message  = self::get_login_message($coinbase);
			wp_send_json_success($message);
		} else {
			wp_send_json_error(esc_html__('No address specified.', 'ethpress'));
		}
	}

	/**
	 * Deletes table row when user is deleted.
	 *
	 * @since 0.1.0
	 *
	 * @param int $user_id Id of the user being deleted.
	 */
	public static function destroy($user_id)
	{
		$address = Address::find_by_user($user_id);
		if (!is_wp_error($address)) {
			$address->delete();
		}
		/**
		 * Fires after address table row was attempted deleted.
		 *
		 * @since 0.1.0
		 *
		 * @param int $user_id User id of address that was attempted deleted.
		 * @param Address|WP_Error $address Address if deletiong success, WP_Error otherwise.
		 */
		do_action('ethpress_destroyed', $user_id, $address);
	}

	/**
	 * Attaches user to blog.
	 *
	 * @since 0.2.4
	 *
	 * @param WP_User $user User to add.
	 * @return true|void|\WP_Error True if success. Nothing if not multisite. WP_Error if error.
	 */
	public static function attach_user_to_blog($user)
	{
		if (!empty($user) && !is_wp_error($user) && is_multisite()) {
			$blog_id          = get_current_blog_id();
			$existing_user_id = $user->ID;
			if (!is_user_member_of_blog($existing_user_id, $blog_id)) {

				// @see https://stackoverflow.com/a/12178249/4256005
				$role = get_option('default_role');
				if (empty($role)) {
					// https://wordpress.org/support/article/multisite-network-administration/
					// "By design, all users who are added to your network will have subscriber access to all sites on your network".
					$role = 'subscriber';
				}
				$result = add_user_to_blog($blog_id, $existing_user_id, $role);

				return $result;
			}
		}
	}
}
