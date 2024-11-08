<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;


$nav_content = '';
$time_content = '';
$settings = $this->get_settings();

$tabs = $this->get_settings_for_display('tabs');
$id_int = rand(10, 100);
$align = '';
if ($settings['iqonic_has_box_shadow'] == 'yes') {
    $align .= ' iq-box-shadow';
}

$this->add_render_attribute('iq_container', 'class', 'events-content'); ?>


<?php 
if($settings['tab_layout'] == 'style1') {
    ?>
    <div class="iq-timeline iq-timeline-horizontal-2 <?php echo esc_attr($align); ?>">
    <div class="timeline" id="iq-timeline-horizontal-2">
        <div class="timeline__wrap">
            <div class="timeline__items">
                <?php
                foreach ($tabs as $index => $item) {
                    $date = date_create($item['timeline_date']);
                    $d = date_format($date, "d/m/Y");
                ?>
                    <div class="timeline__item">
                        <div class="timeline__content ">
                            <h2 class="timeline_content_date"><?php echo $d; ?></h2>
                            <?php
                            if(!empty($item['tab_title'])){
                                ?>
                            <<?php echo esc_attr($settings['title_tag']) ?> class="timeline-title"><?php echo esc_html($item['tab_title']); ?> </<?php echo esc_attr($settings['title_tag']) ?>>
                            <?php
                            }
                            ?>
                            <p class="timeline-content"><?php echo esc_html($item['tab_content']); ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
    <?php

} elseif($settings['tab_layout'] == 'style2'){
    ?>
    <div class="iq-timeline iq-timeline-horizontal-2 style-2 <?php echo esc_attr($align); ?>">
    <div class="timeline" id="iq-timeline-horizontal-2">
        <div class="timeline__wrap">
            <div class="timeline__items">
                <?php
                foreach ($tabs as $index => $item) {
                    $date = date_create($item['timeline_date']);
                    $d = date_format($date, "d F");
                    $y = date_format($date, "Y");
                ?>
                    <div class="timeline__item">
                        <div class="timeline__content ">
                            <h2 class="timeline_content_date"><?php echo $d; ?></h2>
                            <h2 class="timeline_content_date year"><?php echo $y; ?></h2>
                            <?php
                            if(!empty($item['tab_title'])){
                                ?>
                            <<?php echo esc_attr($settings['title_tag']) ?> class="timeline-title"><?php echo esc_html($item['tab_title']); ?> </<?php echo esc_attr($settings['title_tag']) ?>>
                            <?php
                            }
                            ?>
                            <p class="timeline-content"><?php echo esc_html($item['tab_content']); ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
    <?php

}
?>
