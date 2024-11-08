<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;
$settings = $this->get_settings();

$nav_content = '';
$time_content = '';

$tabs = $this->get_settings_for_display('tabs');
$id_int = rand(10, 100);

$align = $settings['align'];
if ($settings['iqonic_has_box_shadow'] == 'yes') {

  $align .= ' iq-box-shadow';
}

?>
  <div class="iq-timeline iq-timeline-vertical-1 <?php echo esc_attr($align); ?>">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-timeline-section ">
          <div class="conference-center-line"></div>
          <div class="conference-timeline-content">
            <?php
            foreach ($tabs as $index => $item) {
              $date = date_create($item['timeline_date']);
              $d = date_format($date, "d/m/Y");
            ?>
              <div class="timeline-article">
                <div class="meta-date"></div>
                <div class="content-box">
                  <<?php echo esc_attr($settings['title_tag']) ?> class="timeline-title"><?php echo esc_html($item['tab_title']); ?> </<?php echo esc_attr($settings['title_tag']) ?>>
                  <h6 class="timeline-date"><?php echo $d; ?></h6>
                  <p class="timeline-content"><?php echo esc_html($item['tab_content']); ?></p>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
