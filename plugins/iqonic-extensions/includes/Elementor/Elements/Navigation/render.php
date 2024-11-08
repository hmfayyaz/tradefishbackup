<?php

namespace Elementor;

use Iqonic_Layouts\Classes\Iqonic_Walker_Nav_Menu;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings_for_display();
$settings = $this->get_settings();

$vertical_menu = $align = '';

$id_int = rand(10, 100);
$menu = ["theme_location" => "primary"];
if ($settings['location'] === 'select' && !empty($settings['menu'])) {
    $menu = ["menu" => $settings['menu']];
} else {
    $menu = ["theme_location" => $settings['location']];
}

if ($settings['layout'] === 'default' && $settings['direction'] === 'vertical') {
    $vertical_menu = ' vertical-menu-layout';
    $vertical_menu .= !empty($settings['design_style']) ? ' menu-' . $settings['design_style'] : '';
}

if ($settings['layout'] == 'default' && $settings['direction'] === 'horizontal') {
    $align .= 'menu-hover-' . $settings['hover_effect'];
    if ($settings['use_more'] === 'yes') {
        $align .= ' has-more-menu-attr';
        $this->add_render_attribute('more', 'data-text', $settings['more_text']);
        $this->add_render_attribute('more', 'data-items', $settings['more_item']);
    }
}

$umetric_options = get_option('iqonic-options');
$align .= ($settings['menu_align'] == 'center') ? ' menu-align-center' : ''
?>

<div class="widget-nav-menu <?php echo esc_attr($align); ?>">
    <?php
    if ($settings['layout'] === 'burger') {
    ?>
        <button class="navbar-toggler custom-toggler ham-toggle" type="button">
            <span class="menu-btn d-inline-block">
                <?php if ($settings['use_custom_icon'] == 'yes') {
                    Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
                } else { ?>
                    <span class="lines one"></span>
                    <span class="lines two"></span>
                    <span class="lines three"></span>
                <?php } ?>
            </span>
        </button>
        <div class="umetric-mobile-menu umetric-navigation-burger menu-style-one">
            <nav class="umetric-menu-wrapper mobile-menu">
                <div class="navbar">
                    <?php
                    if (isset($umetric_options['header_radio']) && $umetric_options['header_radio'] == 1) { ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <?php if (!empty($umetric_options['header_text'])) { ?>
                                <h1 class="logo-text">
                                    <?php echo esc_html($umetric_options['header_text']); ?></h1>
                            <?php } ?>
                        </a>
                    <?php
                    } else {
                        $logo = ''; ?>
                        <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
                            <?php
                            if (function_exists('get_field') || class_exists('ReduxFramework')) {
                                $umetric_options = get_option('iqonic-options');
                                $key = function_exists('get_field') ? get_field('key_header') : '';
                                if (!empty($key['header_logo']['url'])) {
                                    $options = $key['header_logo']['url'];
                                } else if (isset($umetric_options['header_radio'])) {
                                    if ($umetric_options['header_radio'] == 1) {
                                        $logo_text = $umetric_options['header_text'];
                                        echo esc_html($logo_text);
                                    }
                                    if ($umetric_options['header_radio'] == 2) {
                                        $options = $umetric_options['umetric_mobile_logo']['url'];
                                    }
                                }
                            }
                            if (isset($options) && !empty($options)) {
                                echo '<img class="img-fluid logo" src="' . esc_url($options) . '" alt="' . esc_attr__('iqonic', 'iqonic') . '">';
                            } elseif (has_header_image()) {
                                $image = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
                                if (has_custom_logo()) {
                                    echo '<img class="img-fluid logo" src="' . esc_url($image) . '" alt="' . esc_attr__('iqonic', 'iqonic') . '">';
                                } else {
                                    bloginfo('name');
                                }
                            } else {
                                $logo_url = get_template_directory_uri() . '/assets/images/logo.svg';
                                echo '<img class="img-fluid logo" src="' . esc_url($logo_url) . '" alt="' . esc_attr__('iqonic', 'iqonic') . '">';
                            }
                            ?>
                        </a>
                    <?php
                    } ?>

                    <button class="navbar-toggler custom-toggler ham-toggle" type="button">
                        <span class="close_btn">
                            <span class="menu_close_icon"><i class="fa fa-times" aria-hidden="true"></i></span>
                        </span>
                    </button>
                </div>

                <div class="c-collapse">
                    <div class="menu-new-wrapper row align-items-center">
                        <div class="menu-scrollbar verticle-mn yScroller col-lg-12">
                            <div class="umetric-full-menu vertical-menu-layout">
                                <?php
                                $args = array_merge($menu, array(
                                    'menu_class' => 'navbar-nav top-menu',
                                    'container_class'   => 'menu-full-menu-container'
                                ));
                                wp_nav_menu($args);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </nav><!-- #site-navigation -->
        </div>
        <?php } else {
        if ($settings['direction'] === 'vertical') { ?>
            <div class="umetric-mobile-menu umetric-navigation-burger  menu-open <?php echo esc_attr($vertical_menu); ?>">
                <nav class="umetric-menu-wrapper mobile-menu">
                    <div class="navbar">
                        <div class="menu-new-wrapper row align-items-center">
                            <div class="menu-scrollbar verticle-mn yScroller col-lg-12">
                                <div class="umetric-full-menu vertical-menu-layout">
                                    <?php
                                    $args = array_merge($menu, array(
                                        'menu_class'    => 'top-menu',

                                    ));
                                    wp_nav_menu($args);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav><!-- #site-navigation -->
            </div>
        <?php } else {  ?>
            <nav class="deafult-header nav-widget  p-0 header-default-menu<?php echo esc_attr($vertical_menu); ?>" aria-label="<?php esc_attr_e('Widget menu', 'iqonic'); ?>" <?php echo $this->get_render_attribute_string('more'); ?>>
                <div>
                    <div class="menu-all-pages-container widget-menu-container">
                        <?php
                        $args = array_merge($menu, array(
                            'menu_class'    => 'sf-menu',
                            'walker'        => new Iqonic_Walker_Nav_Menu(),
                            'link_before' => '<span class="menu-line">',
                            'link_after' => '</span>'
                        ));
                        wp_nav_menu($args);
                        ?>
                    </div>
                </div>
            </nav>
    <?php }
    }
    ?>
</div>
<?php
