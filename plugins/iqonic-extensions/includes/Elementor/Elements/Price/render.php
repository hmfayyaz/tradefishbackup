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

$active = $settings['active'];
if ($active === "yes") {
    $align .= ' active';
}

//price header render attribute
$this->add_render_attribute('iq-price-header', 'class', 'iq-price-header');
if (!empty($settings['image']['url'])) {
    $this->add_render_attribute('iq-price-header', 'style', 'background:url(' . $settings['image']['url'] . ')');
}


if ($settings['iqonic_has_box_shadow'] == 'yes') {

    $this->add_render_attribute('iq_price_class', 'class', 'iq-price-shadow');
}

if ($settings['design_style'] == "4" || $settings['design_style'] == "5") {

    if ($settings['design_style'] == "4"){
        $class = "iq-price-table-4";
    } elseif ($settings['design_style'] == "5"){
        $class = "iq-price-table-3";
    }

?>
    <div class="iq-price-container <?php echo esc_attr($class);?> <?php echo esc_attr($align); ?>">
        <div <?php echo $this->get_render_attribute_string('iq-price-header'); ?>>
            <span class="iq-price-label"><?php echo esc_html($settings['price_label']); ?></span>

            <?php
            if (!empty($settings['description'])) {
                echo '<p class="iq-price-description">' . esc_html($settings['description']) . '</p>';
            }
            $ex = explode(' ', $settings['currency_symbol']);
            ?>
            <<?php echo esc_attr($settings['title_tag']); ?> class="iq-price"><?php echo esc_html($settings['price']); ?><small><?php echo $ex[0]; ?></small></<?php echo esc_attr($settings['title_tag']); ?>>
            <p class="iq-price-desc"><?php echo esc_html($settings['time_period']); ?></p>
        </div>

        <div class="iq-price-body">
            <ul class="iq-price-service">
                <?php
                foreach ($tabs as $index => $item) {
                    if ($item['has_service_active'] == 'yes') {
                        $class = 'active';
                    } else {
                        $class = 'inactive';
                    }
                ?>
                    <li class="<?php echo esc_attr($class); ?>">
                            
                        <span><?php echo esc_html($item['tab_title']) ?></span>
                        <?php   
                        if ($item['has_service_icon'] == 'yes') {
                            if(!empty($item['service_icon']) == 'default'){
                                Icons_Manager::render_icon($item['service_icon'], ['aria-hidden' => 'true']); 
                            }
                        }
                          ?>
                      
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>

        <div class="iq-price-footer">
            <?php if ($settings['button_text'] && $settings['link']) {
                require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Button/render.php';
            } ?>
        </div>


    </div>

<?php } else {
?>
    <div class="iq-price-container iq-price-table <?php echo esc_attr($align); ?>">
        <div <?php echo $this->get_render_attribute_string('iq-price-header'); ?>>
            <?php
            $ex = explode(' ', $settings['currency_symbol']);
            ?>

            <<?php echo esc_attr($settings['title_tag']); ?> class="iq-price"><small><?php echo $ex[0]; ?></small><?php echo esc_html($settings['price']); ?><small><?php echo esc_html($settings['time_period']); ?></small></<?php echo esc_attr($settings['title_tag']); ?>>
            <span class="iq-price-label"><?php echo esc_html($settings['price_label']); ?></span>

            <?php
            if (!empty($settings['description'])) {
                echo '<p class="iq-price-description">' . esc_html($settings['description']) . '</p>';
            }
            ?>


        </div>

        <div class="iq-price-body">
            <ul class="iq-price-service">
                <?php
                foreach ($tabs as $index => $item) {
                    if ($item['has_service_active'] == 'yes') {
                        $class = 'active';
                    } else {
                        $class = 'inactive';
                    }
                ?>
                    <li class="<?php echo esc_attr($class); ?>">
                        <span><?php echo esc_html($item['tab_title']) ?>
                          <?php
                        if ($item['has_service_icon'] == 'yes') {
                            if(!empty($item['service_icon']) == 'default'){
                                Icons_Manager::render_icon($item['service_icon'], ['aria-hidden' => 'true']); 
                           }
                        }
                          ?>
                    </span>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>

        <div class="iq-price-footer">
            <?php if ($settings['button_text'] && $settings['link']) {
                require IQONIC_EXTENSION_PLUGIN_PATH . 'includes/Elementor/Elements/Button/render.php';
            } ?>
        </div>


    </div>

<?php } ?>