<?php

if (!defined('ABSPATH')) {
    exit;
}

include_once ABSPATH . 'wp-admin/includes/plugin.php';

require_once COINMC_PATH . 'includes/data.php';
require_once COINMC_PATH . 'includes/pages.php';
require_once COINMC_PATH . 'includes/watchlist.php';
require_once COINMC_PATH . 'includes/shortcodes.php';
require_once COINMC_PATH . 'includes/updater.php';
require_once COINMC_PATH . 'includes/admin-notice-display.php';

?>