<?php

/**
 * Displays options on EthPress' options page.
 *
 * @since 0.1.0
 *
 * @package Ethpress_NFT_Access
 */

namespace losnappas\Ethpress_NFT_Access\Admin;

defined('ABSPATH') || die;

use losnappas\Ethpress\Logger;
use losnappas\Ethpress_NFT_Access\BlockchainConnection;

/**
 * Static.
 *
 * @since 0.1.0
 */
class Options
{

	/**
	 * Adds options page. Attached to hook.
	 *
	 * @since 0.1.0
	 */
	public static function admin_menu()
	{
	}

	/**
	 * Creates options page.
	 *
	 * @since 0.1.0
	 */
	public static function create_page()
	{
?>
		<div class="wrap">
			<h1><?php esc_html_e('EthPress NFT Access', 'ethpress_nft_access_addon'); ?></h1>
			<p class="description">[ethpress_nft_access_addon_nft product_id="1337"] -- shortcode available.</p>
			<form action="options.php" method="POST">
				<?php
				settings_fields('ethpress_nft_access_addon');
				do_settings_sections('ethpress_nft_access_addon');
				submit_button();
				?>
			</form>
		</div>
	<?php
	}

	/**
	 * Adds settings for api_url to options page. admin_init hooked.
	 *
	 * @since 0.1.0
	 */
	public static function admin_init()
	{
		// Logger::log('Options::admin_init');
		add_filter('ethpress_settings_tabs',    array(__CLASS__, 'ethpress_nft_access_addon_settings_tabs_hook'), 30, 1);
		add_filter('ethpress_get_save_options', array(__CLASS__, 'ethpress_get_save_options_hook'), 30, 3);
		add_action('ethpress_print_options',    array(__CLASS__, 'ethpress_print_options_hook'), 30, 2);
		add_action('ethpress_before_submit_button',    array(__CLASS__, 'ethpress_before_submit_button_hook'), 30, 2);
	}


	public static function ethpress_nft_access_addon_settings_tabs_hook($possible_screens)
	{
		// Logger::log('Options::ethpress_nft_access_addon_settings_tabs_hook');
		$possible_screens['nft'] = esc_html(__('NFT', 'ethpress_nft_access_addon'));
		return $possible_screens;
	}



	public static function ethpress_before_submit_button_hook($options, $current_screen)
	{
		// Logger::log('Options::ethpress_before_submit_button_hook');
		if ('nft' !== $current_screen) {
			return $options;
		}
	?>
		<?php
		// $failedNetworkIdRequestMessage = sprintf(
		//     __("Failed to request blockchain network ID. Check your \"%s\" setting value.", 'ethpress_nft_access_addon'),
		//     __("Ethereum Node JSON-RPC Endpoint", 'ethpress_nft_access_addon')
		// );
		?>
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				jQuery('#ethpress_admin_form').on('submit', function() {
					// do validation here
					const valid = (
						'undefined' === typeof window.ethpress_nft_access_addon ||
						'undefined' === typeof window.ethpress_nft_access_addon._url_to_network_id_call_success ||
						true === window.ethpress_nft_access_addon._url_to_network_id_call_success
					);
					if (!valid) {
						alert(window.ethpress_nft_access_addon._url_to_network_id_call_success);
					}
					return valid;
				});
			});
		</script>

	<?php
	}

	public static function ethpress_get_save_options_hook($options, $input, $current_screen)
	{
		// Logger::log('Options::ethpress_get_save_options_hook');
		if ('nft' !== $current_screen) {
			return $options;
		}
		// Logger::log('ethpress_get_save_options_hook------options-----:' . print_r($options, true));
		// Logger::log('ethpress_get_save_options_hook------input-----:' . print_r($input, true));
		// Logger::log('ethpress_get_save_options_hook------current_screen-----:' . print_r($current_screen, true));


		$options['blockchain_api_node']   = !empty($input['blockchain_api_node']) ? sanitize_text_field($input['blockchain_api_node']) : (isset($options['web3Endpoint']) && !empty($options['web3Endpoint']) ? 'custom' : 'infuraio');
		switch ($options['blockchain_api_node']) {
			case 'infuraio':
				$options['blockchain_network']    = !empty($input['blockchain_network'])  ? sanitize_text_field($input['blockchain_network'])  : 'mainnet';
				$options['infuraApiKey']          = !empty($input['infuraApiKey'])        ? sanitize_text_field($input['infuraApiKey'])        : '';
				break;
			case 'custom':
				$options['web3Endpoint']          = (!empty($input['web3Endpoint']))      ? sanitize_text_field($input['web3Endpoint'])        : '';
				break;
		}

		$options['redirect_no_login_url'] =
			!empty($input['redirect_no_login_url'])                      ? \esc_url_raw($input['redirect_no_login_url'])                       : '';
		$options['contract_addresses'] =
			!empty($input['contract_addresses'])                         ? sanitize_text_field($input['contract_addresses'])                   : '';
		$options['token_ids'] =
			!empty($input['token_ids'])                                  ? sanitize_text_field($input['token_ids'])                            : '';
		$options['no_token_message'] =
			!empty($input['no_token_message'])                           ? sanitize_text_field($input['no_token_message'])                     : '';

		$options['lp_buy_course_for_nft_message'] =
			!empty($input['lp_buy_course_for_nft_message'])              ? sanitize_text_field($input['lp_buy_course_for_nft_message'])        : '';
		$options['lp_nft_access_granted_message_checkbox'] =
			!empty($input['lp_nft_access_granted_message_checkbox'])     ? 'on'      : '';
		$options['lp_nft_access_granted_message'] =
			!empty($input['lp_nft_access_granted_message'])              ? sanitize_text_field($input['lp_nft_access_granted_message'])        : '';

		$options['tu_buy_course_for_nft_message'] =
			!empty($input['tu_buy_course_for_nft_message'])              ? sanitize_text_field($input['tu_buy_course_for_nft_message'])        : '';
		$options['tu_nft_access_granted_message_checkbox'] =
			!empty($input['tu_nft_access_granted_message_checkbox'])     ? 'on'      : '';
		$options['tu_nft_access_granted_message'] =
			!empty($input['tu_nft_access_granted_message'])              ? sanitize_text_field($input['tu_nft_access_granted_message'])        : '';



		return $options;
	}
	public static function is_learnprress_active()
	{
		if (function_exists('learn_press_get_course')) {
			return true;
		}
		return false;
	}

	public static function is_tutor_active()
	{
		if (function_exists('tutor_lms')) {
			return true;
		}
		return false;
	}

	public static function ethpress_print_options_hook($options, $current_screen)
	{
		// Logger::log('Options::ethpress_print_options_hook');
		if ('nft' !== $current_screen) {
			return $options;
		}
		// Logger::log('ethpress_print_options_hook------options-----:' . print_r($options, true));
		// Logger::log('ethpress_print_options_hook------current_screen-----:' . print_r($current_screen, true));

		$disabled = 'disabled';
		if (\losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->can_use_premium_code__premium_only()) {
			$disabled = '';
		}
	?>

		<tr valign="top">
			<th scope="row" colspan="2">
				<h2>
					<?php _e("Blockchain Settings", 'ethpress_nft_access_addon'); ?>
				</h2>
			</th>
			<td>
			</td>
		</tr>

		<?php
		$blockchain_api_nodes = [
			'infuraio' => __('Infura.io', 'ethpress-nft-access-addon'),
			'custom' => __('Custom', 'ethpress-nft-access-addon'),
		];
		$blockchain_api_node_current = isset($options['blockchain_api_node']) && !empty($options['blockchain_api_node']) ? $options['blockchain_api_node'] : (isset($options['web3Endpoint']) && !empty($options['web3Endpoint']) ? 'custom' : 'infuraio');

		// infura.io supported blockchains
		$blockchains = apply_filters('ethereumico.io/supported-blockchains', []);
		?>
		<script type='text/javascript'>
			if ('undefined' === typeof window['ethpress_nft_access_addon']) {
				window.ethpress_nft_access_addon = {};
			}
			jQuery(document).ready(function() {
				jQuery('#ethpress-blockchain_api_node').on('change', function(e) {
					const blockchain_api_node = jQuery(this).find(":selected").val();
					const blockchain_api_node_class = '.ethpress-nft-access-addon-blockchain-api-node-' + blockchain_api_node;
					jQuery('.ethpress-nft-access-addon-blockchain-api-node').hide();
					jQuery(blockchain_api_node_class).show();
					switch (blockchain_api_node) {
						case 'infuraio':
							jQuery('#ethpress-blockchain_network').change();
							window.ethpress_nft_access_addon._url_to_network_id_call_success = true;
							break;
						case 'custom':
							jQuery('#ethpress-web3Endpoint').change();
							break;
					}
				}).change();
			});
		</script>

		<tr valign="top">
			<th scope="row"><?php _e("Blockchain API Node", 'ethpress-nft-access-addon'); ?></th>
			<td>
				<fieldset>
					<label>
						<select name="ethpress[blockchain_api_node]" id="ethpress-blockchain_api_node" class="select short">
							<?php
							if (is_array($blockchain_api_nodes)) foreach ($blockchain_api_nodes as $blockchain_api_node => $blockchain_api_node_title) {
								$selected = '';
								if ($blockchain_api_node === $blockchain_api_node_current) {
									$selected = 'selected="selected"';
								}
							?>
								<option value="<?php echo esc_attr($blockchain_api_node) ?>" <?php echo $selected ?>><?php echo esc_html($blockchain_api_node_title) ?></option>
							<?php
							}
							?>
						</select>
						<p><?php _e("The blockchain API node used: infura.io or custom", 'ethpress-nft-access-addon') ?></p>
					</label>
				</fieldset>
			</td>
		</tr>

		<tr valign="top" class="ethpress-nft-access-addon-blockchain-api-node ethpress-nft-access-addon-blockchain-api-node-infuraio">
			<th scope="row"><?php _e("Blockchain", 'ethpress_nft_access_addon'); ?></th>
			<td>
				<fieldset>
					<label>
						<select name="ethpress[blockchain_network]" id="ethpress-blockchain_network" class="select short">
							<?php
							if (is_array($blockchains)) foreach ($blockchains as $blockchain => $blockchain_title) {
								$selected = '';
								if (isset($options['blockchain_network']) && $blockchain === $options['blockchain_network']) {
									$selected = 'selected="selected"';
								}
							?>
								<option value="<?php echo esc_attr($blockchain) ?>" <?php echo $selected ?>><?php echo esc_html($blockchain_title) ?></option>
							<?php
							}
							?>
						</select>
						<p><?php _e("The blockchain used: mainnet, goerli or sepolia. Use mainnet in production, and goerli or sepolia in test mode. See plugin documentation for the testing guide.", 'ethpress-nft-access-addon') ?></p>
						<p><strong><?php _e("NOTE: The Polygon, Optimism, Arbitrum and Avalanche C-Chain chains require special registration on the infura side.", 'ethpress-nft-access-addon') ?></strong></p>
						<?php
						if (\losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->is_not_paying()) {
							if (\losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->is_trial()) {
						?>
								<h2 class="description"><?php echo '<a href="' . \losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->get_upgrade_url() . '">' . __('Upgrade to keep using this feature!', 'ethpress_nft_access_addon') . '</a>'; ?></h2>
							<?php
							} else {
							?>
								<h2 class="description"><?php echo '<a href="' . \losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->get_upgrade_url() . '">' . __('Upgrade to use this feature!', 'ethpress_nft_access_addon') . '</a>'; ?></h2>
						<?php
							}
						}
						?>
					</label>
				</fieldset>
			</td>
		</tr>

		<tr valign="top" class="ethpress-nft-access-addon-blockchain-api-node ethpress-nft-access-addon-blockchain-api-node-infuraio">
			<th scope="row"><?php _e("Infura.io API Key", 'ethpress_nft_access_addon'); ?></th>
			<td>
				<fieldset>
					<label>
						<input <?php echo $disabled ?> class="text" name="ethpress[infuraApiKey]" id="ethpress-infuraApiKey" type="text" maxlength="35" placeholder="<?php _e("Put your Infura.io API Key here", 'ethpress_nft_access_addon'); ?>" value="<?php echo !empty($options['infuraApiKey']) ? esc_attr($options['infuraApiKey']) : ''; ?>">
						<p class="description">
							<?php echo sprintf(
								__('The API key for the %1$s. You need to register on this site to obtain it. Use this guide please: %2$s.', 'ethpress_nft_access_addon'),
								'<a target="_blank" href="https://infura.io/register">https://infura.io/</a>',
								'<a target="_blank" href="https://ethereumico.io/knowledge-base/infura-api-key-guide/">Get infura API Key</a>'
							) ?>
						</p>
						<p class="description"><strong>
								<?php echo sprintf(
									__('Note that this setting is ignored if the "%1$s" setting is set', 'ethpress_nft_access_addon'),
									__("Ethereum Node JSON-RPC Endpoint", 'ethpress_nft_access_addon')
								) ?>
							</strong></p>
						<?php
						if (\losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->is_not_paying()) {
							if (\losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->is_trial()) {
						?>
								<h2 class="description"><?php echo '<a href="' . \losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->get_upgrade_url() . '">' . __('Upgrade to keep using this feature!', 'ethpress_nft_access_addon') . '</a>'; ?></h2>
							<?php
							} else {
							?>
								<h2 class="description"><?php echo '<a href="' . \losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->get_upgrade_url() . '">' . __('Upgrade to use this feature!', 'ethpress_nft_access_addon') . '</a>'; ?></h2>
						<?php
							}
						}
						?>
					</label>
				</fieldset>
			</td>
		</tr>

		<?php
		$blockchainInfos = apply_filters('ethereumico.io/supported-blockchains-info', []);
		$chainId = BlockchainConnection::getInstance()->getChainId();
		$blockchainInfo = apply_filters('ethereumico.io/blockchain-info', null, $chainId);

		$template = __('The API key for the %1$s. You need to %2$sregister%3$s on this site to obtain it.', 'ethpress-nft-access-addon');
		$explorer_api_url          = $blockchainInfo ? $blockchainInfo['explorer_api_url']          : null;
		$explorer_register_url     = $blockchainInfo ? $blockchainInfo['explorer_register_url']     : null;
		$base_explorer_display_url = $blockchainInfo ? $blockchainInfo['base_explorer_display_url'] : null;

		$blockchain_api_node_current = isset($options['blockchain_api_node']) && !empty($options['blockchain_api_node']) ? $options['blockchain_api_node'] : (isset($options['web3Endpoint']) && !empty($options['web3Endpoint']) ? 'custom' : 'infuraio');
		$failedNetworkIdRequestMessage = sprintf(
			__("Failed to request blockchain network ID. Check your \"%s\" setting value.", 'ethpress-nft-access-addon'),
			__("Ethereum Node JSON-RPC Endpoint", 'ethpress-nft-access-addon')
		);
		?>
		<script type='text/javascript'>
			if ('undefined' === typeof window['ethpress_nft_access_addon']) {
				window.ethpress_nft_access_addon = {};
			}
			if ('undefined' === typeof window.ethpress_nft_access_addon['_url_to_network_id_cache']) {
				window.ethpress_nft_access_addon._url_to_network_id_cache = {};
			}
			if ('undefined' === typeof window.ethpress_nft_access_addon['_url_to_network_id_call_started']) {
				window.ethpress_nft_access_addon._url_to_network_id_call_started = {};
			}

			window.ethpress_nft_access_addon.ethereum_wallet_get_blockchain_network_id = function(web3Endpoint, blockchainInfos, callback) {
				let alerts = {};

				function process_alerts() {
					Object.keys(alerts).forEach(function(message) {
						alert(message);
					});
				}

				if ('' == web3Endpoint) {
					callback.call(null, null, null, alerts);
					process_alerts();
					return;
				}
				if ('undefined' !== typeof window.ethpress_nft_access_addon._url_to_network_id_cache[web3Endpoint]) {
					window.ethpress_nft_access_addon._url_to_network_id_call_success = true;
					callback.call(null, null, window.ethpress_nft_access_addon._url_to_network_id_cache[web3Endpoint], alerts);
					process_alerts();
					return;
				}
				if ('undefined' === typeof window.ethpress_nft_access_addon._url_to_network_id_call_started[web3Endpoint]) {
					window.ethpress_nft_access_addon._url_to_network_id_call_started[web3Endpoint] = [];
				}
				window.ethpress_nft_access_addon._url_to_network_id_call_started[web3Endpoint].push(callback);
				if (window.ethpress_nft_access_addon._url_to_network_id_call_started[web3Endpoint].length > 1) {
					return;
				}

				window.ethpress_nft_access_addon._url_to_network_id_call_success = '<?php echo $failedNetworkIdRequestMessage ?>';

				if ('undefined' !== typeof window.ethpress_nft_access_addon['_url_to_network_id_timeout_id'] &&
					null !== window.ethpress_nft_access_addon._url_to_network_id_timeout_id
				) {
					clearTimeout(window.ethpress_nft_access_addon._url_to_network_id_timeout_id);
					window.ethpress_nft_access_addon._url_to_network_id_timeout_id = null;
				}
				window.ethpress_nft_access_addon._url_to_network_id_timeout_id = setTimeout(function() {
					if (null !== window.ethpress_nft_access_addon._url_to_network_id_timeout_id) {
						clearTimeout(window.ethpress_nft_access_addon._url_to_network_id_timeout_id);
						window.ethpress_nft_access_addon._url_to_network_id_timeout_id = null;
					}
					const dataRequest = '{"jsonrpc":"2.0","method":"net_version","params":[],"id":1}';
					jQuery.ajax({
						url: web3Endpoint,
						type: "POST",
						data: dataRequest,
						contentType: "application/json; charset=utf-8",
						dataType: "json",
						success: function(data, textStatus, jqXHR) {
							// data: {"jsonrpc":"2.0","id":1,"result":"56"}
							if (!data) {
								console.log('Empty data returned for network', web3Endpoint);
								window.ethpress_nft_access_addon._url_to_network_id_call_started[web3Endpoint].forEach(function(callback) {
									callback.call(null, 'Empty data returned for network ' + web3Endpoint, null, alerts);
								});
								process_alerts();
								return;
							}
							if ('undefined' === typeof data['id']) {
								console.log('No "id" field in the data returned for network', web3Endpoint);
								window.ethpress_nft_access_addon._url_to_network_id_call_started[web3Endpoint].forEach(function(callback) {
									callback.call(null, 'No "id" field in the data returned for network ' + web3Endpoint, null, alerts);
								});
								process_alerts();
								return;
							}
							if (1 !== parseInt(data['id'])) {
								console.log('Wrong "id" field in the data returned for network', web3Endpoint);
								window.ethpress_nft_access_addon._url_to_network_id_call_started[web3Endpoint].forEach(function(callback) {
									callback.call(null, 'Wrong "id" field in the data returned for network ' + web3Endpoint, null, alerts);
								});
								process_alerts();
								return;
							}
							if ('undefined' === typeof data['result']) {
								console.log('No "result" field in the data returned for network', web3Endpoint);
								window.ethpress_nft_access_addon._url_to_network_id_call_started[web3Endpoint].forEach(function(callback) {
									callback.call(null, 'No "result" field in the data returned for network ' + web3Endpoint, null, alerts);
								});
								process_alerts();
								return;
							}
							window.ethpress_nft_access_addon._url_to_network_id_call_success = true;
							const blockchainId = 'a' + data['result'];
							if ('undefined' === typeof blockchainInfos[blockchainId]) {
								console.log('Unsupported blockchainId(' + blockchainId + ') returned for', web3Endpoint, blockchainInfos);
								window.ethpress_nft_access_addon._url_to_network_id_call_started[web3Endpoint].forEach(function(callback) {
									callback.call(null, 'Unsupported blockchainId(' + blockchainId + ') returned for ' + web3Endpoint, null, alerts);
								});
								process_alerts();
								return;
							}
							if ('undefined' === typeof window.ethpress_nft_access_addon._url_to_network_id_cache[web3Endpoint]) {
								window.ethpress_nft_access_addon._url_to_network_id_cache[web3Endpoint] = blockchainId;
							}
							window.ethpress_nft_access_addon._url_to_network_id_call_started[web3Endpoint].forEach(function(callback) {
								callback.call(null, null, blockchainId, alerts);
							});
							process_alerts();
						},
						// @see https://stackoverflow.com/a/37311074/4256005
						error: function(xhr, status, error) {
							window.ethpress_nft_access_addon._url_to_network_id_call_success = '<?php echo $failedNetworkIdRequestMessage ?>';
							// handle error
							console.log([xhr.status, xhr.responseText, status, error]);
							window.ethpress_nft_access_addon._url_to_network_id_call_started[web3Endpoint].forEach(function(callback) {
								callback.call(null, '<?php echo $failedNetworkIdRequestMessage ?>', null, alerts);
							});
							process_alerts();
						}
					})
				}, 1000);
			}

			window.ethpress_nft_access_addon.ethereum_wallet_getBalance = function(web3Endpoint, callback) {
				let alerts = {};

				function process_alerts() {
					Object.keys(alerts).forEach(function(message) {
						alert(message);
					});
				}

				if ('' == web3Endpoint) {
					callback.call(null, null, alerts);
					process_alerts();
					return;
				}
				const dataRequest = '{"jsonrpc":"2.0","method":"eth_getBalance","params":["0x476bb28bc6d0e9de04db5e19912c392f9a76535d", "latest"],"id":1}';

				function processData(data) {
					// data: {"jsonrpc":"2.0","id":1,"result":"0x28bf65e9896a69840"}
					if (!data) {
						console.log('Empty data returned for network', web3Endpoint);
						callback.call(null, 'Empty data returned for network ' + web3Endpoint, alerts);
						process_alerts();
						return;
					}
					if ('undefined' === typeof data['id']) {
						console.log('No "id" field in the data returned for network', web3Endpoint);
						callback.call(null, 'No "id" field in the data returned for network ' + web3Endpoint, alerts);
						process_alerts();
						return;
					}
					if (1 !== parseInt(data['id'])) {
						console.log('Wrong "id" field in the data returned for network', web3Endpoint);
						callback.call(null, 'Wrong "id" field in the data returned for network ' + web3Endpoint, alerts);
						process_alerts();
						return;
					}
					if ('undefined' !== typeof data['error']) {
						if ('undefined' === typeof data['error']['message']) {
							console.log('No "message" field in the error data returned for network', web3Endpoint);
							callback.call(null, 'No "message" field in the error data returned for network ' + web3Endpoint, alerts);
							process_alerts();
							return;
						}
						console.log('The error message returned for network', web3Endpoint, ':', data['error']['message']);
						callback.call(null, data['error']['message'], alerts);
						process_alerts();
						return;
					}
					if ('undefined' === typeof data['result']) {
						console.log('No "result" field in the data returned for network', web3Endpoint);
						callback.call(null, 'No "result" field in the data returned for network ' + web3Endpoint, alerts);
						process_alerts();
						return;
					}
					callback.call(null, null, alerts);
					process_alerts();
				}
				jQuery.ajax({
					url: web3Endpoint,
					type: "POST",
					data: dataRequest,
					contentType: "application/json; charset=utf-8",
					dataType: "json",
					success: processData,
					// @see https://stackoverflow.com/a/37311074/4256005
					error: function(xhr, status, error) {
						// handle error
						console.log([xhr.status, xhr.responseText, status, error]);
						if ('' !== xhr.responseText) {
							const data = JSON.parse(xhr.responseText);
							processData(data);
							return
						}
						callback.call(null, 'Failed to check selected infura.io blockchain availability', alerts);
						process_alerts();
					}
				})
			}

			jQuery(document).ready(function() {
				const blockchainInfos = JSON.parse('<?php echo json_encode($blockchainInfos) ?>');

				function ethereum_wallet_blockchain_getWeb3Endpoint() {
					const blockchain_api_node = jQuery('#ethpress-blockchain_api_node').find(":selected").val();
					switch (blockchain_api_node) {
						case 'infuraio':
							const infuraApiKey = jQuery('#ethpress-infuraApiKey').val();
							const blockchain = jQuery('#ethpress-blockchain_network').find(":selected").val();
							return "https://" + blockchain + ".infura.io/v3/" + infuraApiKey;
						case 'custom':
							return jQuery('#ethpress-web3Endpoint').val();
					}
					return null;
				}
				window.ethpress_nft_access_addon.ethereum_wallet_blockchain_getWeb3Endpoint = ethereum_wallet_blockchain_getWeb3Endpoint;

				jQuery('#ethpress-blockchain_network').on('change', function(e) {
					const blockchain = jQuery(this).find(":selected").val();
					const web3Endpoint = ethereum_wallet_blockchain_getWeb3Endpoint();
					window.ethpress_nft_access_addon.ethereum_wallet_getBalance.call(null, web3Endpoint, function(error, alerts) {
						if (null !== error) {
							if (-1 !== error.indexOf('project ID does not have access')) {
								error = '<?php _e('Premium Infura.io account is required to use this network with the Infura.io service', 'ethpress-nft-access-addon') ?>';
							}
							alerts[error] = 1;
							window.ethpress_nft_access_addon._url_to_network_id_call_success = error;
							return;
						}
						window.ethpress_nft_access_addon._url_to_network_id_call_success = true;
					});
				});
				<?php
				if ('infuraio' === $blockchain_api_node_current) {
				?>
					jQuery('#ethpress-blockchain_network').change();
				<?php
				}
				?>

				function ethereum_wallet_refresh_blockchain(e) {
					const web3Endpoint = jQuery('#ethpress-web3Endpoint').val();
					window.ethpress_nft_access_addon.ethereum_wallet_get_blockchain_network_id.call(null, web3Endpoint, blockchainInfos, function(error, blockchainId, alerts) {
						if (null !== error) {
							alerts['<?php echo $failedNetworkIdRequestMessage ?>'] = 1;
							return;
						}
					});
				}
				jQuery('#ethpress-web3Endpoint').on('change', ethereum_wallet_refresh_blockchain);
				<?php
				if ('custom' === $blockchain_api_node_current) {
				?>
					jQuery('#ethpress-web3Endpoint').change();
				<?php
				}
				?>
			});
		</script>

		<tr valign="top" class="ethpress-nft-access-addon-blockchain-api-node ethpress-nft-access-addon-blockchain-api-node-custom">
			<th scope="row" colspan="2">
				<strong><?php _e("Use these settings only if you want to use Ethereum node other than infura.io, or completely another EVM-compatible blockchain like Quorum, BSC, etc.", 'ethpress-nft-access-addon'); ?></strong>
			</th>
		</tr>

		<?php
		$blockchainInfos = apply_filters('ethereumico.io/supported-blockchains-info', []);
		$failedNetworkIdRequestMessage = sprintf(
			__("Failed to request blockchain network ID. Check your \"%s\" setting value.", 'ethpress-nft-access-addon'),
			__("Ethereum Node JSON-RPC Endpoint", 'ethpress-nft-access-addon')
		);
		?>
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				const blockchainInfos = JSON.parse('<?php echo json_encode($blockchainInfos) ?>');

				function ethereum_wallet_refresh_advanced_blockchain(e) {
					const blockchain_api_node = jQuery('#ethpress-blockchain_api_node').find(":selected").val();
					if ('infuraio' === blockchain_api_node) {
						return;
					}
					const web3Endpoint = jQuery('#ethpress-web3Endpoint').val();
					window.ethpress_nft_access_addon.ethereum_wallet_get_blockchain_network_id.call(null, web3Endpoint, blockchainInfos, function(error, blockchainId, alerts) {
						if (null !== error) {
							alerts['<?php echo $failedNetworkIdRequestMessage ?>'] = 1;
							return;
						}
					});
				}
				jQuery('#ethpress-web3Endpoint').on('change', ethereum_wallet_refresh_advanced_blockchain);
			});
		</script>

		<tr valign="top" class="ethpress-nft-access-addon-blockchain-api-node ethpress-nft-access-addon-blockchain-api-node-custom">
			<th scope="row"><?php _e("Ethereum Node JSON-RPC Endpoint", 'ethpress_nft_access_addon'); ?></th>
			<td>
				<fieldset>
					<label>
						<input <?php echo $disabled ?> class="text" name="ethpress[web3Endpoint]" id="ethpress-web3Endpoint" type="text" maxlength="1024" placeholder="<?php _e("Put your Ethereum Node JSON-RPC Endpoint here", 'ethpress_nft_access_addon'); ?>" value="<?php echo !empty($options['web3Endpoint']) ? esc_attr($options['web3Endpoint']) : ''; ?>">
						<p class="description">
							<?php echo sprintf(
								__('The Ethereum Node JSON-RPC Endpoint URI. This is an advanced setting. Use with care. This setting supercedes the "%1$s" setting.', 'ethpress_nft_access_addon'),
								__("Infura.io API Key", 'ethpress_nft_access_addon')
							) ?>
						</p>
						<?php
						if (\losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->is_not_paying()) {
							if (\losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->is_trial()) {
						?>
								<h2 class="description"><?php echo '<a href="' . \losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->get_upgrade_url() . '">' . __('Upgrade to keep using this feature!', 'ethpress_nft_access_addon') . '</a>'; ?></h2>
							<?php
							} else {
							?>
								<h2 class="description"><?php echo '<a href="' . \losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->get_upgrade_url() . '">' . __('Upgrade to use this feature!', 'ethpress_nft_access_addon') . '</a>'; ?></h2>
						<?php
							}
						}
						?>
					</label>
				</fieldset>
			</td>
		</tr>

		<?php
		$lp_disabled = $disabled;
		if (!self::is_learnprress_active()) {
			$lp_disabled = 'disabled';
		}
		?>

		<tr valign="top">
			<th scope="row" colspan="2">
				<h2>
					<?php _e("Learnpress course NFT Login Access Settings", 'ethpress_nft_access_addon'); ?>
				</h2>
			</th>
			<td>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><?php _e("Learnpress course NFT login message", 'ethpress_nft_access_addon'); ?></th>
			<td>
				<fieldset>
					<label>
						<input <?php echo $lp_disabled ?> class="components-form-token-field__label" name="ethpress[lp_buy_course_for_nft_message]" type="text" placeholder="<?php _e("Put your message here", 'ethpress_nft_access_addon'); ?>" value="<?php echo !empty($options['lp_buy_course_for_nft_message']) ? esc_attr($options['lp_buy_course_for_nft_message']) : ''; ?>">
						<p class="description">
							<?php echo
							__('The message is show if NFT access is configured for the Learnpress course', 'ethpress_nft_access_addon')
							?>
						</p>

						<?php
						if (!self::is_learnprress_active()) {
						?>
							<h2 class="description"><?php echo '<a target = "_blank" href="https://thimpress.com/product/wordpress-lms-plugin-learnpress/?ref=support%40ethereumico.io">' . __('LearnPress is WordPress LMS Plugin which can be used to easily create & sell courses online.', 'ethpress'); ?></h2>
						<?php
						}
						?>
					</label>
				</fieldset>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><?php _e("Show NFT Access Granted Message", 'ethpress_nft_access_addon'); ?></th>
			<td>
				<fieldset>
					<label for="ethpress_nft_access_addon_lp_nft_access_granted_message_checkbox">
						<input <?php echo $lp_disabled ?> class="components-form-token-field__label" id="ethpress_nft_access_addon_lp_nft_access_granted_message_checkbox" name="ethpress[lp_nft_access_granted_message_checkbox]" type="checkbox" value="yes" <?php echo (!empty($options['lp_nft_access_granted_message_checkbox']) ? 'checked' : '') ?> />
						<p class="description">
							<?php _e('Show message "NFT Access Granted" on progress page?', 'ethpress_nft_access_addon') ?>
						</p>

						<?php
						if (!self::is_learnprress_active()) {
						?>
							<h2 class="description"><?php echo '<a target = "_blank" href="https://thimpress.com/product/wordpress-lms-plugin-learnpress/?ref=support%40ethereumico.io">' . __('LearnPress is WordPress LMS Plugin which can be used to easily create & sell courses online.', 'ethpress'); ?></h2>
						<?php
						}
						?>

					</label>
				</fieldset>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><?php _e("NFT Access Granted Message", 'ethpress_nft_access_addon'); ?></th>
			<td>
				<fieldset>
					<label>
						<input <?php echo $lp_disabled ?> class="components-form-token-field__label" name="ethpress[lp_nft_access_granted_message]" type="text" placeholder="<?php _e("Put your message here", 'ethpress_nft_access_addon'); ?>" value="<?php echo !empty($options['lp_nft_access_granted_message']) ? esc_attr($options['lp_nft_access_granted_message']) : ''; ?>">
						<p class="description">
							<?php echo
							__('The message is show if NFT access is configured for the Learnpress course', 'ethpress_nft_access_addon')
							?>
						</p>
						<?php
						?>

						<?php
						if (!self::is_learnprress_active()) {
						?>
							<h2 class="description"><?php echo '<a target = "_blank" href="https://thimpress.com/product/wordpress-lms-plugin-learnpress/?ref=support%40ethereumico.io">' . __('LearnPress is WordPress LMS Plugin which can be used to easily create & sell courses online.', 'ethpress'); ?></h2>
						<?php
						}
						?>
					</label>
				</fieldset>
			</td>
		</tr>




		<?php
		$tu_disabled = $disabled;
		if (!self::is_tutor_active()) {
			$tu_disabled = 'disabled';
		}
		?>

		<tr valign="top">
			<th scope="row" colspan="2">
				<h2>
					<?php _e("Tutor course NFT Login Access Settings", 'ethpress_nft_access_addon'); ?>
				</h2>
			</th>
			<td>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><?php _e("Tutor course NFT login message", 'ethpress_nft_access_addon'); ?></th>
			<td>
				<fieldset>
					<label>
						<input <?php echo $tu_disabled ?> class="components-form-token-field__label" name="ethpress[tu_buy_course_for_nft_message]" type="text" placeholder="<?php _e("Put your message here", 'ethpress_nft_access_addon'); ?>" value="<?php echo !empty($options['tu_buy_course_for_nft_message']) ? esc_attr($options['tu_buy_course_for_nft_message']) : ''; ?>">
						<p class="description">
							<?php echo
							__('The message is show if NFT access is configured for the Tutor course', 'ethpress_nft_access_addon')
							?>
						</p>

						<?php
						if (!self::is_tutor_active()) {
						?>
							<h2 class="description"><?php echo '<a target = "_blank" href="https://www.themeum.com/product/tutor-lms/?ref=olegabr&campaign=ethereumico.io">' . __('Tutor LMS is a complete, feature-packed, and robust WordPress LMS plugin to easily create & sell courses online. ', 'ethpress'); ?></h2>
						<?php
						}
						?>
					</label>
				</fieldset>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><?php _e("Show NFT Access Granted Message", 'ethpress_nft_access_addon'); ?></th>
			<td>
				<fieldset>
					<label for="ethpress_nft_access_addon_tu_nft_access_granted_message_checkbox">
						<input <?php echo $tu_disabled ?> class="components-form-token-field__label" id="ethpress_nft_access_addon_tu_nft_access_granted_message_checkbox" name="ethpress[tu_nft_access_granted_message_checkbox]" type="checkbox" value="yes" <?php echo (!empty($options['tu_nft_access_granted_message_checkbox']) ? 'checked' : '') ?> />
						<p class="description">
							<?php _e('Show message "NFT Access Granted" on progress page?', 'ethpress_nft_access_addon') ?>
						</p>

						<?php
						if (!self::is_tutor_active()) {
						?>
							<h2 class="description"><?php echo '<a target = "_blank" href="https://www.themeum.com/product/tutor-lms/?ref=olegabr&campaign=ethereumico.io">' . __('Tutor LMS is a complete, feature-packed, and robust WordPress LMS plugin to easily create & sell courses online. ', 'ethpress'); ?></h2>
						<?php
						}
						?>

					</label>
				</fieldset>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><?php _e("NFT Access Granted Message", 'ethpress_nft_access_addon'); ?></th>
			<td>
				<fieldset>
					<label>
						<input <?php echo $tu_disabled ?> class="components-form-token-field__label" name="ethpress[tu_nft_access_granted_message]" type="text" placeholder="<?php _e("Put your message here", 'ethpress_nft_access_addon'); ?>" value="<?php echo !empty($options['tu_nft_access_granted_message']) ? esc_attr($options['tu_nft_access_granted_message']) : ''; ?>">
						<p class="description">
							<?php echo
							__('The message is show if NFT access is configured for the Learnpress course', 'ethpress_nft_access_addon')
							?>
						</p>
						<?php
						?>

						<?php
						if (!self::is_tutor_active()) {
						?>
							<h2 class="description"><?php echo '<a target = "_blank" href="https://www.themeum.com/product/tutor-lms/?ref=olegabr&campaign=ethereumico.io">' . __('Tutor LMS is a complete, feature-packed, and robust WordPress LMS plugin to easily create & sell courses online. ', 'ethpress'); ?></h2>
						<?php
						}
						?>
					</label>
				</fieldset>
			</td>
		</tr>







		<tr valign="top">
			<th scope="row" colspan="2">
				<h2>
					<?php _e("Site wide NFT Login Access Settings", 'ethpress_nft_access_addon'); ?>
				</h2>
			</th>
			<td>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><?php _e("Redirect URL", 'ethpress_nft_access_addon'); ?></th>
			<td>
				<fieldset>
					<label>
						<input <?php echo $disabled ?> class="text" name="ethpress[redirect_no_login_url]" type="text" placeholder="<?php _e("Put your redirect url here", 'ethpress_nft_access_addon'); ?>" value="<?php echo !empty($options['redirect_no_login_url']) ? esc_attr($options['redirect_no_login_url']) : ''; ?>">
						<p class="description">
							<?php _e('Redirect user here if they do not own ONE OF the required tokens defined below.', 'ethpress_nft_access_addon') ?>
						</p>
						<?php
						if (\losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->is_not_paying()) {
							if (\losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->is_trial()) {
						?>
								<h2 class="description"><?php echo '<a href="' . \losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->get_upgrade_url() . '">' . __('Upgrade to keep using this feature!', 'ethpress_nft_access_addon') . '</a>'; ?></h2>
							<?php
							} else {
							?>
								<h2 class="description"><?php echo '<a href="' . \losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->get_upgrade_url() . '">' . __('Upgrade to use this feature!', 'ethpress_nft_access_addon') . '</a>'; ?></h2>
						<?php
							}
						}
						?>
					</label>
				</fieldset>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><?php _e("No NFT token for login message", 'ethpress_nft_access_addon'); ?></th>
			<td>
				<fieldset>
					<label>
						<input <?php echo $disabled ?> class="components-form-token-field__label" name="ethpress[no_token_message]" type="text" placeholder="<?php _e("Put your message here", 'ethpress_nft_access_addon'); ?>" value="<?php echo !empty($options['no_token_message']) ? esc_attr($options['no_token_message']) : ''; ?>">
						<p class="description">
							<?php echo
							__('The message to show if no required NFT is found in user wallet.', 'ethpress_nft_access_addon')
							?>
						</p>
						<p class="description">
							<?php echo
							sprintf(__('Example: %s', 'ethpress_nft_access_addon'), __('You do not have the NFT required for access. You\'ll be redirected to a page where you can get it.', 'ethpress_nft_access_addon'))
							?>
						</p>
						<?php
						if (\losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->is_not_paying()) {
							if (\losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->is_trial()) {
						?>
								<h2 class="description"><?php echo '<a href="' . \losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->get_upgrade_url() . '">' . __('Upgrade to keep using this feature!', 'ethpress_nft_access_addon') . '</a>'; ?></h2>
							<?php
							} else {
							?>
								<h2 class="description"><?php echo '<a href="' . \losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->get_upgrade_url() . '">' . __('Upgrade to use this feature!', 'ethpress_nft_access_addon') . '</a>'; ?></h2>
						<?php
							}
						}
						?>
					</label>
				</fieldset>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><?php _e("NFT contract addresses", 'ethpress_nft_access_addon'); ?></th>
			<td>
				<fieldset>
					<label>
						<input <?php echo $disabled ?> class="text" name="ethpress[contract_addresses]" type="text" placeholder="<?php _e("Put your NFT contract addresses here", 'ethpress_nft_access_addon'); ?>" value="<?php echo !empty($options['contract_addresses']) ? esc_attr($options['contract_addresses']) : ''; ?>">
						<p class="description">
							<?php _e('A comma separated list of NFT smart contract addresses.', 'ethpress_nft_access_addon') ?>
						</p>
						<p class="description">
							<?php _e('At least one token from this list will be required to login to your site', 'ethpress_nft_access_addon') ?>
						</p>
						<?php
						if (\losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->is_not_paying()) {
							if (\losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->is_trial()) {
						?>
								<h2 class="description"><?php echo '<a href="' . \losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->get_upgrade_url() . '">' . __('Upgrade to keep using this feature!', 'ethpress_nft_access_addon') . '</a>'; ?></h2>
							<?php
							} else {
							?>
								<h2 class="description"><?php echo '<a href="' . \losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->get_upgrade_url() . '">' . __('Upgrade to use this feature!', 'ethpress_nft_access_addon') . '</a>'; ?></h2>
						<?php
							}
						}
						?>
					</label>
				</fieldset>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><?php _e("NFT Token ID", 'ethpress_nft_access_addon'); ?></th>
			<td>
				<fieldset>
					<label>
						<input <?php echo $disabled ?> class="components-form-token-field__label" name="ethpress[token_ids]" type="text" placeholder="<?php _e("Put your token ids here", 'ethpress_nft_access_addon'); ?>" value="<?php echo !empty($options['token_ids']) ? esc_attr($options['token_ids']) : ''; ?>">
						<p class="description">
							<?php _e('A comma separated list of NFT token IDs.', 'ethpress_nft_access_addon') ?>
						</p>
						<p class="description">
							<?php _e('At least one token from this list will be required to login to your site', 'ethpress_nft_access_addon') ?>
						</p>
						<p class="description">
							<?php echo sprintf(
								__('Note that this list should be empty or the count of elements in this list should be the same as in the "%1$s" setting.', 'ethpress_nft_access_addon'),
								__("NFT contract addresses", 'ethpress_nft_access_addon')
							) ?>
						</p>
						<p class="description">
							<?php _e('Use contract address dublicates if several IDs are needed for the same contract, and empty element ",," if any token ID accepted for a corresponding token contract.', 'ethpress_nft_access_addon') ?>
						</p>
						<?php
						if (\losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->is_not_paying()) {
							if (\losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->is_trial()) {
						?>
								<h2 class="description"><?php echo '<a href="' . \losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->get_upgrade_url() . '">' . __('Upgrade to keep using this feature!', 'ethpress_nft_access_addon') . '</a>'; ?></h2>
							<?php
							} else {
							?>
								<h2 class="description"><?php echo '<a href="' . \losnappas\Ethpress_NFT_Access\ethpress_nft_access_addon_freemius_init()->get_upgrade_url() . '">' . __('Upgrade to use this feature!', 'ethpress_nft_access_addon') . '</a>'; ?></h2>
						<?php
							}
						}
						?>
					</label>
				</fieldset>
			</td>
		</tr>

		</table>

		<h2><?php _e("Need help to configure this plugin?", 'ethpress_nft_access_addon'); ?></h2>
		<p><?php echo sprintf(
				__('Feel free to %1$shire me!%2$s', 'ethpress_nft_access_addon'),
				'<a target="_blank" href="https://ethereumico.io/product/configure-wordpress-plugins/" rel="noreferrer noopener sponsored nofollow">',
				'</a>'
			) ?></p>

		<h2><?php _e("Need help to develop a ERC20 or NFT token?", 'ethpress_nft_access_addon'); ?></h2>
		<p><?php echo sprintf(
				__('Feel free to %1$shire me!%2$s', 'ethpress_nft_access_addon'),
				'<a target="_blank" href="https://ethereumico.io/product/smart-contract-development-services/" rel="noreferrer noopener sponsored nofollow">',
				'</a>'
			) ?></p>

		<h2><?php _e("Want to perform an ICO Crowdsale from your Wordpress site?", 'ethpress_nft_access_addon'); ?></h2>
		<p><?php echo sprintf(
				__('Install the %1$sEthereum ICO WordPress plugin%2$s!', 'ethpress_nft_access_addon'),
				'<a target="_blank" href="https://ethereumico.io/product/ethereum-ico-wordpress-plugin/" rel="noreferrer noopener sponsored nofollow">',
				'</a>'
			) ?></p>

		<h2><?php _e("Want to create Ethereum wallets on your Wordpress site?", 'ethpress_nft_access_addon'); ?></h2>
		<p><?php echo sprintf(
				__('Install the %1$sWordPress Ethereum Wallet plugin%2$s!', 'ethpress_nft_access_addon'),
				'<a target="_blank" href="https://ethereumico.io/product/wordpress-ethpress-nft-access-addon-plugin/" rel="noreferrer noopener sponsored nofollow">',
				'</a>'
			) ?></p>

<?php

		return $options;
	}

	/**
	 * Adds settings link. Hooked to filter.
	 *
	 * @since 0.1.0
	 *
	 * @param array $links Existing links.
	 */
	public static function plugin_action_links($links)
	{
		if (is_multisite()) {
			Logger::log('Options::plugin_action_links: is_multisite');
			if (current_user_can('manage_network_options')) {
				$url = esc_attr(
					esc_url(
						add_query_arg(
							[
								'page' => 'ethpress',
								'tab' => 'nft',
							],
							network_admin_url() . 'settings.php'
						)
					)
				);
			} else {
				return $links;
			}
		} else {
			Logger::log('Options::plugin_action_links: !is_multisite');
			$url = esc_attr(
				esc_url(
					add_query_arg(
						[
							'page' => 'ethpress',
							'tab' => 'nft',
						],
						get_admin_url() . 'options-general.php'
					)
				)
			);
		}
		$label         = esc_html__('Settings', 'ethpress_nft_access_addon');
		$settings_link = "<a href='$url'>$label</a>";

		array_unshift($links, $settings_link);
		Logger::log('Options::plugin_action_links: links = ' . print_r($links, true));
		return $links;
	}
}
