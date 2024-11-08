<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings_for_display();
$settings = $this->get_settings();



/* Swiper dynamic id */
$nav_next = $nav_prev = $pagination = $id = '';
$id = rand(10, 100);
if ($settings['want_nav'] == "true" || $settings['want_pagination'] == "true") {
    $nav_next   = 'navnext_' . $id;
    $nav_prev   = 'navprev_' . $id;
    $pagination = 'pagination_' . $id;
}
if ($settings['show_drug_cursor']) {
    $class = 'cursor-drag not-hide-cursor';
}

$this->add_render_attribute('slider', 'data-slide', $settings['sw_slide']);
$this->add_render_attribute('slider', 'data-loop', $settings['sw_loop']);
$this->add_render_attribute('slider', 'data-speed', $settings['sw_speed']);
$this->add_render_attribute('slider', 'data-spacebtslide', $settings['sw_space_slide']);
$this->add_render_attribute('slider', 'data-autoplay', $settings['sw_autoplay']);
$this->add_render_attribute('slider', 'data-laptop', $settings['sw_laptop_no']);
$this->add_render_attribute('slider', 'data-tab', $settings['sw_tab_no']);
$this->add_render_attribute('slider', 'data-mobile', $settings['sw_mob_no']);
$this->add_render_attribute('slider', 'data-navnext', $nav_next);
$this->add_render_attribute('slider', 'data-navprev', $nav_prev);
$this->add_render_attribute('slider', 'data-pagination', $pagination);
$this->add_render_attribute('slider', 'data-simulate-touch', $settings['show_drug_cursor']);
?>

<div class="ele-widget-swiper swiper umetric-image-carousel <?php echo esc_attr($class); ?>" <?php echo $this->get_render_attribute_string('slider') ?>>
    <div class="swiper-wrapper">
        <?php
        // loop
        if ($settings['img_car_list']) {
            foreach ($settings['img_car_list'] as $item) {

                // image link static & dynamic
                if ($item['link_type'] == 'dynamic') {
                    $url = "href=" . get_permalink(get_page_by_path($item['dynamic_link']));
                    if ($item['open_dynamic_link_in']) {
                        $url .= ' target=_blank';
                    }
                } else {
                    if (!empty(trim($item['link']['url']))) {
                        $url = "href=" . $item['link']['url'];
                        if ($item['link']['is_external']) {
                            $url .= ' target=_blank';
                        }

                        if ($item['link']['nofollow']) {
                            $url .= ' rel=nofollow';
                        }
                    }
                }
        ?>
                <div class="swiper-slide umetric-image-box">
                    <a <?php echo $url; ?> <?php echo esc_attr($settings['use_ajax'] == 'yes' ? 'class=ajax-effect-link' : ''); ?>>
                        <div class="umetric-content">
                            <!-- TITLE START -->
                            <?php if (!empty($item['img_car_title'])) { ?>
                                <<?php echo esc_attr($settings['title_tag']);  ?> class="umetric-image-title">
                                    <?php
                                    if ($settings['is_highlight'] == 'yes') {
                                        $umetric_words = explode(" ", $item['img_car_title']);
                                        $umetric_split = explode(' ', $item['img_car_title']);
                                        $umetric_lastword = array_pop($umetric_split);
                                        array_splice($umetric_words, -1);
                                        $umetric_string = implode(" ", $umetric_words);
                                        echo esc_html($umetric_string) . ' <span class="highlighted-text-wrap wow">' . $umetric_lastword . '</span>';
                                    }
                                    ?>

                                </<?php echo esc_attr($settings['title_tag']); ?>>
                            <?php } ?>
                            <!-- TITLE END -->
                        </div>
                        <div class="slider-img">
                            <!-- IMAGE START -->
                            <?php echo sprintf('<img src="%1$s"  alt="iqonic-user"/>', $item['img_car_image']['url']); ?>
                            <!-- IMAGE END -->
                        </div>
                    </a>
                </div>
        <?php
            }
        } ?>
    </div>
</div>

<!-- Navigation start -->
<?php if ($settings['want_nav'] == "true") { ?>
    <div class="iqonic-navigation">
        <div class="swiper-button-prev" id="<?php echo esc_attr($nav_prev); ?>">
            <span class="text-btn">
                <span class="text-btn-line-holder">
                    <span class="text-btn-line-top"></span>
                    <span class="text-btn-line"></span>
                    <span class="text-btn-line-bottom"></span>
                </span>
            </span>
        </div>
        <div class="swiper-button-next" id="<?php echo esc_attr($nav_next); ?>">
            <span class="text-btn">
                <span class="text-btn-line-holder">
                    <span class="text-btn-line-top"></span>
                    <span class="text-btn-line"></span>
                    <span class="text-btn-line-bottom"></span>
                </span>
            </span>
        </div>
    </div>
<?php } ?>
<!-- Navigation end -->

<!-- Pagination start -->
<?php if ($settings['want_pagination'] == "true") { ?>
    <div class="swiper-pagination css-prefix-pagination-align" id="<?php echo esc_attr($pagination); ?>"></div>
<?php } ?>
<!-- Pagination end -->