<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;


$settings = $this->get_settings();
$tabs = $this->get_settings_for_display('tabs');
$align = '';
if ($settings['iqonic_has_box_shadow'] == 'yes') {
    $align .= ' iq-box-shadow';
}
?>

<textarea name="iq-map-data" id="iq-map-data" style="display: none;"><?php echo json_encode($tabs); ?></textarea>
<input type="hidden" id="map_color" value="<?php echo sanitize_hex_color($settings['map_color']) ?>">

<div class="iq-map-chart <?php echo esc_attr($align); ?>">
    <div class="iq-map-lable">
        <h2 class="iq-map-location-value"><?php echo esc_html(count($tabs)); ?></h2>
        <p class="iq-map-info"><?php echo $settings['map_label']; ?></p>
    </div>
    <div id="chartdiv"></div>
</div>