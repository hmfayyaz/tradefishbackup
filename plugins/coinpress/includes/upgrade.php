<?php

if (!defined('ABSPATH')) {
    exit;
}

$coinmc_version = get_transient('coinmc_version');

if ($coinmc_version && version_compare($coinmc_version, '1.5.0', '<')) {

    $coinmc_posts = get_posts(array(
        'post_type' => 'coinmc',
        'posts_per_page' => -1,
        'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash')
    ));

    foreach($coinmc_posts as $post) {
        $postcontent = json_decode($post->post_content, true);
        $postcontent['table_columns'] = array_diff($this->options['table_columns'], array('max_supply', 'percent_change_1h', 'percent_change_7d'));
        wp_update_post(array(
            'ID' => $post->ID,
            'post_content' => wp_json_encode($postcontent),
        ));
    }
}

if ($coinmc_version && version_compare($coinmc_version, '1.7.4', '<')) {
    $this->wpdb->query("ALTER TABLE `{$this->dtablename}` ADD `meta_description` TEXT AFTER `description`");
    $this->wpdb->query("UPDATE `{$this->dtablename}` SET `meta_description` = `description`");
}

if ($coinmc_version && version_compare($coinmc_version, '2.0.3', '<')) {
    $this->wpdb->get_results("SHOW COLUMNS FROM `{$this->dtablename}` LIKE 'meta_description'");

    if ($this->wpdb->num_rows == 0) {
        $this->wpdb->query("ALTER TABLE `{$this->dtablename}` ADD `meta_description` TEXT AFTER `description`");
        $this->wpdb->query("UPDATE `{$this->dtablename}` SET `meta_description` = `description`");
    }
}

if ($coinmc_version && version_compare($coinmc_version, '2.0.5', '<')) {
    $this->wpdb->get_results("SHOW COLUMNS FROM `{$this->tablename}` LIKE 'keywords'");

    if ($this->wpdb->num_rows == 0) {
        $this->wpdb->query("ALTER TABLE `{$this->tablename}` ADD `keywords` varchar(255) AFTER `weekly_expire`");
    }
}

// Last version which requires table structure change
if ($coinmc_version && version_compare($coinmc_version, '2.0.2', '<')) {
    $this->wpdb->query("DROP TABLE IF EXISTS `{$this->tablename}`");
    delete_transient('mcw-datatime');
    delete_transient('coinmc-global');
    $this->create_tables();
}

if ($coinmc_version && version_compare($coinmc_version, '2.2.5', '<')) {
    $config = get_option('coinmc_config', true);

    if ($config && isset($config['slug']) && $config['slug'] !== '' && $config['slug'] !== 'currencies') {
        $config['link'] = $config['slug'] . '/[symbol]';
        update_option('coinmc_config', $config);
    }
}

if ($coinmc_version && version_compare($coinmc_version, '2.2.6', '<')) {
    $this->wpdb->query("ALTER TABLE `{$this->tablename}` MODIFY `price_usd` decimal(24,14) NOT NULL");
}

if (version_compare($coinmc_version, COINMC_VERSION, '<')) {
    set_transient('coinmc_version', COINMC_VERSION);
}