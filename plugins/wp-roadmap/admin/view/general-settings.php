<?php
$options = get_option('wp_feedback_roadmap_general_settings');

$page_list = get_pages();

$pages_list1 = (isset($options['pages'])) ? $options['pages'] : array();

$suggestion = (isset($options['suggestion'])) ? esc_html($options['suggestion']) : '';

$request_feature_link = (isset($options['request_feature_link'])) ? esc_html($options['request_feature_link']) : '';
?>


<div class="wrap">
    <form method="post">
        <table class="form-table" role="presentation">
            <tr>
                <th scope="row"><label for="title">
                        <?php esc_html_e('Title', 'wp-roadmap'); ?>
                    </label></th>
                <td>
                    <input name="title" type="text" id="title" value="<?php echo esc_html($options['title']); ?>"
                        class="wp-feedback-input" />
                    <p class="description">
                        <?php esc_html_e('Leave empty if you dont want show in the frontend ', 'wp-roadmap'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="description">
                        <?php esc_html_e('Description', 'wp-roadmap'); ?>
                    </label></th>
                <td>
                    <textarea name="description" id="description" aria-describedby="description"
                        class="wp-feedback-input"
                        rows="5"><?php echo sanitize_textarea_field($options['description']); ?></textarea>
                    <p class="description">
                        <?php esc_html_e('Leave empty if you dont want show in the frontend ', 'wp-roadmap'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="activetab">
                        <?php esc_html_e('Set Active Tab', 'wp-roadmap'); ?>
                    </label></th>
                <td>
                    <select name="wp_roadmap_status" id="wp_roadmap_status" class="wp-feedback-input">
                        <option <?php if ($options['wp_roadmap_status'] === 'roadmap')
                            echo "selected"; ?> value="roadmap">
                            <?php esc_html_e('Road Map', 'wp-roadmap'); ?>
                        </option>
                        <option <?php if ($options['wp_roadmap_status'] === 'newest')
                            echo "selected"; ?> value="newest">
                            <?php esc_html_e('Newest', 'wp-roadmap'); ?>
                        </option>
                        <option <?php if ($options['wp_roadmap_status'] === 'mostvoted')
                            echo "selected"; ?>
                            value="mostvoted">
                            <?php esc_html_e('Most Voted', 'wp-roadmap'); ?>
                        </option>
                    </select>
                    <p class="description">
                        <?php esc_html_e('Set Active Tab', 'wp-roadmap'); ?>
                    </p>
                <td>
            </tr>
            <tr>
                <th scope="row"><label for="suggestion">
                        <?php esc_html_e('Suggestion', 'wp-roadmap'); ?>
                    </label></th>
                <td>
                    <input name="suggestion" type="text" id="suggestion" value="<?php echo $suggestion; ?>"
                        class="wp-feedback-input" />
                    <p class="description">
                        <?php esc_html_e('Leave empty if you dont want show in the frontend ', 'wp-roadmap'); ?>
                    </p>
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="request_feature_link">
                        <?php esc_html_e('Request Feature Link', 'wp-roadmap'); ?>
                    </label></th>
                <td>
                    <input name="request_feature_link" type="text" id="request_feature_link"
                        value="<?php echo $request_feature_link; ?>" class="wp-feedback-input" />
                    <p class="description">
                        <?php esc_html_e('Leave empty if you dont want show in the frontend', 'wp-roadmap'); ?>
                    </p>
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="selected_pages">
                        <?php esc_html_e('Select Pages', 'wp-roadmap'); ?>
                    </label></th>
                <td>
                    <select name="selected_pages" id="selected_pages" class="wp-feedback-input" multiple>
                        <?php
                        foreach ($page_list as $key => $value) {

                            if (in_array("$value->post_name", $pages_list1)) {
                                echo '<option value="' . $value->post_name . '" selected>' . $value->post_title . '</option>';
                            } else {
                                echo '<option value="' . $value->post_name . '">' . $value->post_title . '</option>';
                            }

                        }
                        ?>
                    </select>
                    <p class="description">
                        <?php esc_html_e('Select pages on which you want to use the roadmap', 'wp-roadmap'); ?>
                    </p>
                </td>
            </tr>
        </table>
        <button type="button" class="feedback-button feedback-general-setting-save">
            <?php esc_html_e('Save Changes', 'wp-roadmap'); ?>
        </button>
    </form>
</div>