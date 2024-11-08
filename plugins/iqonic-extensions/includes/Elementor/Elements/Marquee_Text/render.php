<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;
$html = '';
$align = '';
$settings = $this->get_settings();


    if ($settings['has_direction'] == 'left') {
        $align .= ' left-direction';
    }

    if ($settings['has_direction'] == 'right') {
        $align .= ' right-direction';
    }

$tabs = $this->get_settings_for_display('tabs');
?>
<div class="iqonic-marquee-text style-one marquee-text<?php echo esc_attr($align); ?>">
    <div class="mrq-text">
        <ul class="marquees-list">
            <?php
            foreach ($tabs as $index => $item) {                
                $title = '';
                $target = '';
                $url = '#';
                $nofollow = '';
                if (!empty($item['title'])) {
                    $title = esc_html($item['title']);
                }
                
                if (!empty($item['title_link']['url']) && !empty($title)) {
                    $target = $item['title_link']['is_external'] ? ' target="_blank"' : '';
                    $nofollow = $item['title_link']['nofollow'] ? ' rel="nofollow"' : '';
                    $url = !empty($item['title_link']['url']) ? $item['title_link']['url']  : '';
                }
            ?>
                <li class="hovered-marquee-text">
                    <div class="image-title-link">
                        <<?php echo esc_attr($settings['title_tag']); ?> class="marquee-title">
                            <?php echo $title; ?>
                        </<?php echo esc_attr($settings['title_tag']); ?>>
                    </div>
                </li>
            <?php
            }
            ?>
        </ul>       
    </div>  
</div>