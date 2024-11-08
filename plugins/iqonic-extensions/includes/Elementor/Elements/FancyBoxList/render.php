<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;
$html = '';
$settings = $this->get_settings();
$tabs = $this->get_settings_for_display('tabs');
$align = $settings['align'];
if ($settings['iqonic_has_box_shadow'] == 'yes') {
    $align .= ' iq-box-shadow';
}

$list_column = ' iq-' . $settings['list_column'] . '-column';
$active = $settings['active_onoff'];
if ($active === "yes") {
    $align .= ' active';
}
$shadow = $settings['has_box_shadow'];
if ($shadow === "yes") {
    $align .= ' iq-shadow';
}
$image_html = '';
if ($settings['media_style'] == 'image') {
    if (!empty($settings['image']['url'])) {
        $this->add_render_attribute('image', 'src', $settings['image']['url']);
        $this->add_render_attribute('image', 'srcset', $settings['image']['url']);
        $this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($settings['image']));
        $this->add_render_attribute('image', 'title', Control_Media::get_image_title($settings['image']));
        $image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image');
    }
}




if ($settings['design_style'] == '1') {
?>
    <div class="iq-fancy-box-list iq-fancy-box-list-1  <?php echo esc_attr($align); ?>">
        <div class="iq-fancy-box-content">
            <div class="iq-img-area">
          
                <?php echo $image_html;
                if ($settings['media_style'] == 'icon') {
                  Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
                    }
        
                 ?>
            </div>
            <div class="iq-fancy-details">
                <?php if ($settings['section_title']) { ?>
                    <<?php echo esc_attr($settings['title_tag']);  ?> class="iq-fancy-title"> <?php echo sprintf('%1$s', esc_html($settings['section_title'], 'iqonic')); ?></<?php echo esc_attr($settings['title_tag']);  ?>>
                <?php } ?>
                <?php if ($settings['description']) { ?>
                    <div class="special-content">
                        <p class="fancy-box-content"> <?php echo sprintf('%1$s', esc_html($settings['description'])); ?> </p>
                    </div>
                <?php }

                if ($settings['list_style'] == 'unorder') {
                ?>
                    <div class="iq-list <?php echo esc_attr($list_column); ?>">
                        <ul class="iq-unoreder-list">
                            <?php

                            foreach ($tabs as $index => $item) {
                            ?>
                                <li>
                                    <?php echo esc_html($item['tab_title']); ?>
                                </li>

                            <?php  }
                            ?>
                        </ul>
                    </div>
                <?php }
                if ($settings['list_style'] == 'order') {
                ?>
                    <div class="iq-list <?php echo esc_attr($list_column); ?>">
                        <ol class="iq-order-list">
                            <?php
                            foreach ($tabs as $index => $item) {
                            ?>
                                <li>
                                    <?php echo esc_html($item['tab_title']); ?>
                                </li>
                            <?php  }
                            ?>
                        </ol>
                    </div>
                <?php }
                if ($settings['list_style'] == 'icon') {
                ?>
                    <div class="iq-list <?php echo esc_attr($list_column); ?>">
                        <ul class="iq-list-with-icon">
                            <?php
                            foreach ($tabs as $index => $item) {
                            ?>
                                <li>
                                    <i class="<?php echo esc_attr($settings['list_icon']['value']); ?>"></i>
                                    <?php echo esc_html($item['tab_title']); ?>
                                </li>
                            <?php  }
                            ?>
                        </ul>
                    </div>
                <?php }
                if ($settings['list_style'] == 'image') {
                ?>
                    <div class="iq-list <?php echo esc_attr($list_column); ?>">
                        <ul class="iq-list-with-img">
                            <?php
                            foreach ($tabs as $index => $item) {
                            ?>
                                <li>
                                    <img src="<?php echo esc_url($settings['list_image']['url']); ?>">
                                    <?php echo esc_html($item['tab_title']); ?>
                                </li>
                            <?php  }
                            ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php }

if ($settings['design_style'] == '2') {
?>
    <div class="iq-fancy-box-list iq-fancy-box-list-2  <?php echo esc_attr($align); ?>">
        <div class="iq-fancy-box-content">
            <div class="iq-img-area">
                <?php echo $image_html; 
                  if ($settings['media_style'] == 'icon') {
                    Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
                      }
               ?>
            </div>
            <div class="iq-fancy-details">
                <?php if ($settings['section_title']) { ?>
                    <<?php echo esc_attr($settings['title_tag']);  ?> class="iq-fancy-title"> <?php echo sprintf('%1$s', esc_html($settings['section_title'])); ?></<?php echo esc_attr($settings['title_tag']);  ?>>
                <?php } ?>
                <?php if ($settings['description']) { ?>
                    <div class="special-content">
                        <p class="fancy-box-content"> <?php echo sprintf('%1$s', esc_html($settings['description'])); ?> </p>
                    </div>
                <?php }

                if ($settings['list_style'] == 'unorder') {
                ?>
                    <div class="iq-list <?php echo esc_attr($list_column); ?>">
                        <ul class="iq-unoreder-list">
                            <?php
                            foreach ($tabs as $index => $item) {
                            ?>
                                <li>
                                    <?php echo esc_html($item['tab_title']); ?>
                                </li>
                            <?php  }
                            ?>
                        </ul>
                    </div>
                <?php }
                if ($settings['list_style'] == 'order') {
                ?>
                    <div class="iq-list <?php echo esc_attr($list_column); ?>">
                        <ol class="iq-order-list">
                            <?php
                            foreach ($tabs as $index => $item) {
                            ?>
                                <li>
                                    <?php echo esc_html($item['tab_title']); ?>
                                </li>

                            <?php  }
                            ?>
                        </ol>
                    </div>
                <?php }
                if ($settings['list_style'] == 'icon') {
                ?>
                    <div class="iq-list <?php echo esc_attr($list_column); ?>">
                        <ul class="iq-list-with-icon">
                            <?php
                            foreach ($tabs as $index => $item) {
                            ?>
                                <li>
                                    <i class="<?php echo esc_attr($settings['list_icon']['value']); ?>"></i>
                                    <?php echo esc_html($item['tab_title']); ?>
                                </li>
                            <?php  }
                            ?>
                        </ul>
                    </div>
                <?php }
                if ($settings['list_style'] == 'image') {
                ?>
                    <div class="iq-list <?php echo esc_attr($list_column); ?>">
                        <ul class="iq-list-with-img">
                            <?php
                            foreach ($tabs as $index => $item) {
                            ?>
                                <li>
                                    <img src="<?php echo esc_url($settings['list_image']['url']); ?>">
                                    <?php echo esc_html($item['tab_title']); ?>
                                </li>
                            <?php  }
                            ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

<?php } ?>