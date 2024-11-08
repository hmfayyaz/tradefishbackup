<?php
/**
 * Adds Youtube_Subs widget.
 */
class RMPF_Widget extends WP_Widget
{
    protected $scripts = array();
    protected $style = array();

    function __construct()
    {
        parent::__construct(
            // Base ID of your widget
            'rmpf_widget',
            // Widget name will appear in UI
            __('WP_Roadmap Widget', 'rmpf_widget'),
            // Widget description
            array('description' => __('Sample Feedback Roadmap Widget', 'rmpf_widget'), )
        );

        $options = get_option('wp_feedback_roadmap_general_settings');
        $request_feature_link = (!empty($options['request_feature_link'])) ? esc_html($options['request_feature_link']) : '';


        if (!empty($options) && !empty($options['pages'])) {
            $url = $_SERVER['REQUEST_URI'];
            $url_parts = explode('/', $url);
            $matches = array_intersect($options['pages'], $url_parts);
            if ((count($matches) > 0)) {
                wp_enqueue_script('widget_script', RMPF_URL . 'public/js/rmpf-public-widget.js', array('jquery'), RMPF_VERSION, true);
                wp_localize_script('widget_script', 'wp_roadmap_widget_localize', array('ajaxurl' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce()));
                wp_enqueue_style('widget_css', RMPF_URL . 'public/css/rmpf-public-widget.css', array(), RMPF_VERSION);
                wp_enqueue_style('bootstrap', RMPF_URL . 'admin/css/bootstrap.min.css', array(), RMPF_VERSION, 'all');
            }
        } else {
            wp_enqueue_style('bootstrap', RMPF_URL . 'admin/css/bootstrap.min.css', array(), RMPF_VERSION, 'all');
            wp_enqueue_script('widget_script', RMPF_URL . 'public/js/rmpf-public-widget.js', array('jquery'), RMPF_VERSION, true);
            wp_localize_script('widget_script', 'wp_roadmap_widget_localize', array('ajaxurl' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce()));
            wp_enqueue_style('widget_css', RMPF_URL . 'public/css/rmpf-public-widget.css', array(), RMPF_VERSION);
        }
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
    }
    public function widget_style()
    {
        global $wpdb;
        $feedback_table = $wpdb->prefix . 'feedback';
        $feedback_status = $wpdb->prefix . 'feedback_status';
        $feedback_upvote = $wpdb->prefix . 'feedback_upvote';

        $ip = $_SERVER['REMOTE_ADDR'];
        $wp_feedback_status = $wpdb->get_results("SELECT * from {$feedback_status} WHERE id IN( SELECT DISTINCT(status_id) FROM `{$feedback_table}`) ORDER BY sequence_order DESC");
        $wp_board_feedback_data = $wpdb->get_results("SELECT s.id AS id, s.title, s.active_status, f.*" . "FROM {$feedback_status} AS s " . "LEFT JOIN {$feedback_table} AS f ON s.id = f.status_id ");
        $wp_most_voted_data = $wpdb->get_results("SELECT * FROM {$feedback_table} ORDER BY total_upvote DESC");
        $wp_newest_feedback_data = $wpdb->get_results("SELECT * FROM {$feedback_table} ORDER BY id DESC");
        $wp_get_active_tab = get_option('wp_feedback_roadmap_general_settings');

        $link = !empty($wp_get_active_tab['request_feature_link']) ? $wp_get_active_tab['request_feature_link'] : '';
        $display_button = !empty($link) ? '' : 'display:none';


        ?>
        <div class="wp-roadmap">
            <div class="container">
                <div class="row">
                    <div class="box-content wp-roadmap-box">
                        <div class="header">
                            <h1 class="title wp-roadmap-title">
                                <?php esc_html_e($wp_get_active_tab['title']) ?>
                            </h1>
                            <p class="mb-0 wp-roadmap-description">
                                <?php esc_html_e($wp_get_active_tab['description']) ?>
                            </p>
                        </div>
                        <div class="content-page">
                            <div class="tab-info d-flex align-items-center justify-content-between">
                                <ul class="tab list-inline m-0 p-0 d-flex align-items-center">
                                    <li class="tablinks <?php if ($wp_get_active_tab['wp_roadmap_status'] === 'roadmap')
                                        echo 'active'; ?>"
                                        onclick="openTab(event, 'tab-timeline')">
                                        <?php esc_html_e('Road map', 'wp-roadmap'); ?>
                                    </li>
                                    <li class="tablinks <?php if ($wp_get_active_tab['wp_roadmap_status'] === 'mostvoted')
                                        echo 'active'; ?>"
                                        onclick="openTab(event, 'tab-mostvoted')">
                                        <?php esc_html_e('Most voted', 'wp-roadmap'); ?>
                                    </li>
                                    <li class="tablinks <?php if ($wp_get_active_tab['wp_roadmap_status'] === 'newest')
                                        echo 'active' ?>"
                                            onclick="openTab(event, 'tab-newest')">
                                        <?php esc_html_e('Newest', 'wp-roadmap'); ?>
                                    </li>
                                </ul>
                                <a href="<?php esc_html_e($wp_get_active_tab['request_feature_link']) ?>" type="button"
                                    class="button" id="feature_link" target="_blank" style=<?= $display_button; ?>><?php esc_html_e('Feature Request', 'wp-roadmap'); ?></a>
                            </div>
                            <div id="tab-timeline"
                                class="tabcontent tab-roadmap <?php if ($wp_get_active_tab['wp_roadmap_status'] === 'roadmap')
                                    echo 'tabfade'; ?>">
                                <ul class="iq-timeline list-inline p-0 m-0 position-relative">
                                    <?php foreach ($wp_feedback_status as $data) {
                                        $i = 0;
                                        ?>
                                        <li class="mb-5">
                                            <div class="mb-5">
                                                <div class="timeline-dots timeline-dot-title"
                                                    style="border-color: <?php echo $data->color ?>;"></div>
                                                <small class="title">
                                                    <?php esc_html_e($data->title) ?>
                                                </small>
                                            </div>
                                            <div id="wp-roadmap-loadmore-<?php echo $data->id ?>">
                                                <?php foreach ($wp_board_feedback_data as $feedback) {
                                                    if ($feedback->status_id == $data->id) {
                                                        $i++;
                                                        ?>
                                                        <div class="mb-3 timeline-title">
                                                            <div class="timeline-dots timeline-dot1"
                                                                style="background: <?php echo esc_attr($data->color) ?>;"></div>
                                                            <div id="wp-roadmap-loadmore-board-feedback-<?php echo esc_attr($feedback->id) ?>"
                                                                class="wp-roadmap-loadmore "
                                                                style="<?php echo ($i > 5) ? 'display:none' : ''; ?>"
                                                                data-value="<?php echo esc_attr($data->id) ?>">
                                                                <h6>
                                                                    <?php echo esc_html($feedback->title); ?><span>#
                                                                        <?php esc_html_e($feedback->id); ?>
                                                                    </span>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    <?php }
                                                } ?>
                                            </div>
                                            <?php if ($i > 5) { ?>
                                                <div class="view-more" data-value="<?php echo esc_attr($data->id) ?>">
                                                    <?php esc_html_e('View More', 'wp-roadmap'); ?>
                                                </div>
                                            <?php } ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div id="tab-mostvoted"
                                class="tabcontent task-list tab-most-voted <?php if ($wp_get_active_tab['wp_roadmap_status'] === 'mostvoted')
                                    echo 'tabfade'; ?> ">
                                <ul class="list-inline p-0 m-0">
                                    <?php foreach ($wp_most_voted_data as $voted) {
                                        $is_user_voted = $wpdb->get_results("SELECT * FROM {$feedback_upvote} WHERE visitor_ip_address = '" . $ip . "' and feedback_id = '" . $voted->id . "' ");
                                        $is_voted = count($is_user_voted) > 0;
                                        $checked = ($is_voted > 0) ? 'btn-active' : '';
                                        ?>
                                        <li>
                                            <div class="d-flex align-items-top justify-content-between">
                                                <div class="col-10">
                                                    <h4 class="task-title">
                                                        <?php echo $voted->title; ?><span
                                                            id="wp_feedback_total_vote_<?php echo esc_attr($voted->id); ?>">#
                                                            <?php echo esc_html_e($voted->id); ?>
                                                        </span>
                                                    </h4>
                                                    <p class="m-0 task-description">
                                                        <?php echo esc_html_e($voted->description); ?>
                                                    </p>
                                                </div>
                                                <div class="col-2 feedback-vote-btn text-right">
                                                    <button type="button" id="wp_feedback_total_<?php echo esc_attr($voted->id); ?>"
                                                        class="button-box wp_roadmap_add_upvote  <?php echo esc_attr($checked); ?>"
                                                        data-ip="<?php echo esc_attr($ip) ?>" data-feedback-id=<?php echo esc_attr($voted->id); ?>>
                                                        <i class="dashicons dashicons-arrow-up pr-2"></i>
                                                        <i class="dashicons dashicons-saved pr-2"></i>
                                                        <span id="feedback-upvote-count-vote-<?php echo esc_attr($voted->id); ?>">
                                                            <?php echo esc_html_e($voted->total_upvote); ?>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div id="tab-newest"
                                class="tabcontent task-list tab-newest <?php if ($wp_get_active_tab['wp_roadmap_status'] === 'newest')
                                    echo 'tabfade' ?>">
                                    <ul class="list-inline p-0 m-0">
                                    <?php foreach ($wp_newest_feedback_data as $newest) {
                                    $is_user_voted = $wpdb->get_results("SELECT * FROM {$feedback_upvote} WHERE visitor_ip_address = '" . $ip . "' and feedback_id = '" . $newest->id . "' ");
                                    $is_voted = count($is_user_voted) > 0;
                                    $checked = ($is_voted > 0) ? 'btn-active' : '';
                                    ?>
                                        <li>
                                            <div class="d-flex align-items-top justify-content-between">
                                                <div class="col-10">
                                                    <h4 class="task-title">
                                                        <?php esc_attr_e($newest->title); ?><span
                                                            id="wp_feedback_total_vote_new_<?php echo esc_attr($newest->id); ?>">#
                                                            <?php esc_html_e($newest->id); ?>
                                                        </span>
                                                    </h4>
                                                    <p class="m-0 task-description">
                                                        <?php esc_html_e($newest->description); ?>
                                                    </p>
                                                </div>
                                                <div class="col-2 feedback-vote-btn text-right">
                                                    <button type="button"
                                                        id="wp_feedback_total_new_<?php echo esc_attr($newest->id); ?>"
                                                        class="button-box wp_roadmap_add_upvote <?php echo esc_attr($checked); ?>"
                                                        data-ip="<?php echo esc_attr($ip) ?>" data-feedback-id=<?php echo esc_attr($newest->id); ?>>
                                                        <i class="dashicons dashicons-arrow-up pr-2"></i>
                                                        <i class="dashicons dashicons-saved pr-2"></i>
                                                        <span id="feedback-upvote-count-<?php echo esc_attr($newest->id); ?>">
                                                            <?php esc_html_e($newest->total_upvote); ?>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}