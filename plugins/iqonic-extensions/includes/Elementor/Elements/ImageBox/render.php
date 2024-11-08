<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;
$html = '';
$image_scroll = '';
$settings = $this->get_settings_for_display();
if ($settings['design_style'] == 'grid') {
    $has_content = !Utils::is_empty($settings['title_text']) || !Utils::is_empty($settings['description_text']);
}
if ($settings['use_image_scroll'] == 'yes') {
    $image_scroll = ' hover-image-scroll';
}

if ($settings['design_style'] == 'slider') {
    $this->add_render_attribute('slider', 'data-dots', $settings['dots']);
    $this->add_render_attribute('slider', 'data-nav', $settings['nav-arrow']);
    $this->add_render_attribute('slider', 'data-items', $settings['desk_number']);
    $this->add_render_attribute('slider', 'data-items-laptop', $settings['lap_number']);
    $this->add_render_attribute('slider', 'data-items-tab', $settings['tab_number']);
    $this->add_render_attribute('slider', 'data-items-mobile', $settings['mob_number']);
    $this->add_render_attribute('slider', 'data-items-mobile-sm', $settings['mob_number']);
    $this->add_render_attribute('slider', 'data-autoplay', $settings['autoplay']);
    $this->add_render_attribute('slider', 'data-loop', $settings['loop']);
    $this->add_render_attribute('slider', 'data-margin', $settings['margin']['size']);
    $this->add_render_attribute('slider', 'data-center', 'false');
    $this->add_render_attribute('slider', 'data-touchdrag', 'true');
    $this->add_render_attribute('slider', 'data-mousedrag', 'true');
    if ($settings['slider_imagebox_list']) {
        echo '<div class="owl-general owl-carousel" ' . $this->get_render_attribute_string('slider') . '>';

        foreach ($settings['slider_imagebox_list'] as $item) {
            $has_content = !Utils::is_empty($item['slider_title_text']) || !Utils::is_empty($item['slider_description_text']);

            echo '<div class="scroll-img  umetric-image-box ' . $image_scroll . '">';

            if (!empty($item['slider_image']['url'])) {
                $this->add_render_attribute('image', 'src', $item['slider_image']['url']);
                $this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($item['slider_image']));
                $this->add_render_attribute('image', 'title', Control_Media::get_image_title($item['slider_image']));

                if ($settings['hover_animation']) {
                    $this->add_render_attribute('image', 'class', 'elementor-animation-' . $item['hover_animation']);
                }

                $image_html = Group_Control_Image_Size::get_attachment_image_html($item, 'slider_thumbnail', 'slider_image');

?>
                <figure class="umetric-image-box-img">
                    <?php

                    if ($item['slider_image_has_link'] == 'yes') {
                    ?>
                        <a href="<?php
                                    if ($item['slider_imagebox_link_type'] == 'dynamic') {
                                        //static link
                                        echo esc_url(get_permalink(get_page_by_path($item['slider_imagebox_dynamic_link'])));
                                    } else {
                                        echo esc_url($item['slider_image_box_link']['url']);
                                    } ?>" target="_blank" rel="nofollow">
                            <?php echo $image_html; ?>
                        </a>
                    <?php
                    } else {
                        echo $image_html;
                    }
                    ?>
                </figure>

                <?php }
            if ($has_content) {
                echo '<div class="elementor-image-box-content">';

                if (!Utils::is_empty($item['slider_title_text'])) {
                    $this->add_render_attribute('title_text', 'class', 'umetric-image-box-title');
                    $this->add_inline_editing_attributes('title_text', 'none');
                    $title_html = $item['slider_title_text'];

                    if ($item['slider_image_has_link'] == 'yes') {
                ?>
                        <a href="<?php
                                    if ($item['slider_imagebox_link_type'] == 'dynamic') {
                                        //static link
                                        echo esc_url(get_permalink(get_page_by_path($item['slider_imagebox_dynamic_link'])));
                                    } else {
                                        echo esc_url($item['slider_image_box_link']['url']);
                                    } ?>" target="_blank" rel="nofollow">
                            <?php echo sprintf('<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag($settings['title_size']), $this->get_render_attribute_string('title_text'), $title_html);
                            ?>
                        </a>
<?php
                    } else {
                        echo sprintf('<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag($settings['title_size']), $this->get_render_attribute_string('title_text'), $title_html);
                    }
                }

                if (!Utils::is_empty($item['slider_description_text'])) {
                    $this->add_render_attribute('description_text', 'class', 'umetric-image-box-description');

                    $this->add_inline_editing_attributes('description_text');

                    echo sprintf('<p %1$s>%2$s</p>', $this->get_render_attribute_string('description_text'), $item['slider_description_text']);
                }

                echo '</div>';
            }

            echo '</div>';
        }
        echo '</div>';
    }
} else {
    $html .= '<div class="scroll-img  umetric-image-box ' . $image_scroll . '">';
    if ($settings['image_has_link'] == 'yes') {
        if ($settings['imagebox_link_type'] == 'dynamic') {
            $url =  get_permalink(get_page_by_path($settings['imagebox_dynamic_link']));
            $this->add_render_attribute('link_attr', 'href', esc_url($url));
            $this->add_render_attribute('link_attr', 'target', '_blank');
            $this->add_render_attribute('link_attr', 'rel', 'nofollow');
        } else {
            if ($settings['image_box_link']['url']) {
                $url = $settings['image_box_link']['url'];
                $this->add_render_attribute('link_attr', 'href', esc_url($url));

                if ($settings['image_box_link']['is_external']) {
                    $this->add_render_attribute('link_attr', 'target', '_blank');
                }

                if ($settings['image_box_link']['nofollow']) {
                    $this->add_render_attribute('link_attr', 'rel', 'nofollow');
                }
            }
        }
        $url = '';
    }
    if (!empty($settings['image']['url'])) {
        $this->add_render_attribute('image', 'src', $settings['image']['url']);
        $this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($settings['image']));
        $this->add_render_attribute('image', 'title', Control_Media::get_image_title($settings['image']));

        if ($settings['hover_animation']) {
            $this->add_render_attribute('image', 'class', 'elementor-animation-' . $settings['hover_animation']);
        }

        $image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image');

        if ($settings['image_has_link'] == 'yes') {
            $image_html = '<a ' . $this->get_render_attribute_string('link_attr') . '>' . $image_html . '</a>';
        }

        $html .= '<figure class="umetric-image-box-img">' . $image_html . '</figure>';
    }

    if ($has_content) {
        $html .= '<div class="elementor-image-box-content">';

        if (!Utils::is_empty($settings['title_text'])) {
            $this->add_render_attribute('title_text', 'class', 'umetric-image-box-title');
            $this->add_inline_editing_attributes('title_text', 'none');
            $title_html = $settings['title_text'];
            if ($settings['image_has_link'] == 'yes') {
                $title_html = '<a ' . $this->get_render_attribute_string('link_attr') . '>' . $title_html . '</a>';
            }

            $html .= sprintf('<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag($settings['title_size']), $this->get_render_attribute_string('title_text'), $title_html);
        }

        if (!Utils::is_empty($settings['description_text'])) {
            $this->add_render_attribute('description_text', 'class', 'umetric-image-box-description');

            $this->add_inline_editing_attributes('description_text');

            $html .= sprintf('<p %1$s>%2$s</p>', $this->get_render_attribute_string('description_text'), $settings['description_text']);
        }

        $html .= '</div>';
    }

    $html .= '</div>';
    echo $html;
}
