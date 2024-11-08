<?php
require_once(RMPF_PATH . 'admin/view/feedback-detail.php');
global $wpdb;
$feedback_table = $wpdb->prefix . 'feedback';
$feedback_status = $wpdb->prefix . 'feedback_status';


$wp_feedback_status = $wpdb->get_results("SELECT *,(SELECT COUNT(id) FROM {$feedback_table} WHERE status_id=fs.id) as total_feedback FROM {$feedback_status} fs ORDER BY `sequence_order` ASC");
$wp_board_feedback_data = $wpdb->get_results("SELECT s.id AS id, s.title, s.active_status, f.*" . "FROM {$feedback_status} AS s " . "LEFT JOIN  {$feedback_table} AS f ON s.id = f.status_id " . " ORDER BY `sequence_order` ASC"); ?>
<div class="wp-feedback-roadmap">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="box-content">
                    <div class="header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="logo-detail d-flex align-items-center">
                                <div class="logo-title ml-2">
                                    <h3 class="header-title">
                                        <?php esc_html_e("WP Roadmap - Product Feedback Board", "wp-roadmap"); ?>
                                    </h3>
                                </div>
                            </div>
                            <div class="d-flex align-items-center feedback-add">
                                <a href="<?php echo esc_url(site_url()); ?>/wp-admin/admin.php?page=wp_roadmap_settings#status"
                                    class="header-button feedback-button float-right ">
                                    <?php esc_html_e('Add Status', 'wp-roadmap'); ?>
                                </a>
                                <div class=""><a
                                        href="<?php echo esc_url(site_url()); ?>/wp-admin/admin.php?page=wp_roadmap_settings"
                                        class="settings"><i class="dashicons dashicons-admin-generic"></i></a></div>
                            </div>
                        </div>
                    </div>
                    <div class="content-page">
                        <div class="row">
                            <div class="col-md-12 track-info">
                                <?php foreach ($wp_feedback_status as $k => $item) { ?>
                                    <div class="box-detail mb-3">
                                        <div class="box-header d-flex align-items-center justify-content-between text-white"
                                            style="border-top: 3px solid <?php echo esc_attr($item->color) ?>">
                                            <div class="board-title">
                                                <?php echo esc_html($item->title) ?> <span class="board-count"
                                                    id="count-<?php echo esc_attr($item->id) ?>">
                                                    <?php esc_html_e($item->total_feedback) ?>
                                                </span>
                                            </div>
                                            <div class="header-icon"
                                                onclick="openFeedBackModal(<?php echo esc_html($item->id) ?>)"> <span
                                                    class="dashicons dashicons-plus"></span></div>
                                        </div>
                                        <ul class="feedback-board" id="feedback-board<?php echo esc_attr($k++) ?>"
                                            data-board_id="<?php echo esc_html($item->id) ?>">
                                            <?php foreach ($wp_board_feedback_data as $data) {
                                                if ($data->status_id == $item->id) {
                                                    ?>
                                                    <li class="box-info" data-boardtask_id="<?php echo esc_html($data->id) ?>">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="feedback-title">
                                                                <?php echo esc_html($data->title); ?>
                                                            </div>
                                                            <div class="dropdown action-btn">
                                                                <span class="wp-feedback-data-detail icon" href="#wp-detail"
                                                                    data-toggle="modal" data-value=<?php echo esc_html($data->id) ?>><i class="dashicons dashicons-visibility"></i></span>
                                                                <span class="wp-feedback-data-edit icon" href="#myModal"
                                                                    data-toggle="modal" data-value=<?php echo esc_html($data->id) ?>><i class="dashicons dashicons-edit"></i></span>
                                                                <span class="wp-feedback-data-delete icon" href="#" data-value=<?php echo esc_html($data->id) ?>><i
                                                                        class="dashicons dashicons-trash"></i></span>
                                                            </div>
                                                        </div>
                                                        <p class="feedback-desc">
                                                            <?php esc_html_e($data->description); ?>
                                                        </p>
                                                        <div class="icon d-flex align-items-center justify-content-between">
                                                            <div class="date">
                                                                <span><i class="dashicons dashicons-calendar-alt"></i></span>
                                                                <span>
                                                                    <?php esc_html_e(date("d M", strtotime($data->created_date))); ?>
                                                                </span>
                                                            </div>
                                                            <div class="">
                                                                <span class="wp-feedback-data-reset icon" href="#"
                                                                    title="reset votes" data-value=<?php echo esc_html($data->id) ?>><i class="dashicons dashicons-update"></i></span>
                                                                <span><i class="dashicons dashicons-thumbs-up"></i></span>
                                                                <span>
                                                                    <?php esc_html_e($data->total_upvote) ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php }
                                            } ?>
                                        </ul>
                                        <div class="">
                                            <span><a class="add-task" onclick="openFeedBackModal(<?php echo $item->id ?>)">
                                                    <?php esc_html_e('+ Add New', 'wp-roadmap'); ?>
                                                </a></span>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>