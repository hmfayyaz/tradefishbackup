<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;


$settings = $this->get_settings_for_display();
$tabs = $this->get_settings_for_display('tabs');
$align = $settings['align'];

if ($settings['iqonic_has_box_shadow'] == 'yes') {

    $align .= ' iq-box-shadow';
}

if ($settings['list_style'] == 'unorder') {
?>

    <div class="iq-list">
        <ul class="iq-unoreder-list <?php echo esc_attr($align); ?>">
            <?php
            foreach ($tabs as $index => $item) {
            ?>
                <li>
                    <?php echo esc_html($item['tab_title'], 'iqonic'); ?>
                </li>
            <?php  }
            ?>
        </ul>
    </div>

<?php }
if ($settings['list_style'] == 'order') {
?>
    <div class="iq-list <?php echo esc_attr($align); ?>">
        <ol class="iq-order-list">
            <?php
            foreach ($tabs as $index => $item) {
            ?>
                <li>
                    <?php echo esc_html($item['tab_title'], 'iqonic'); ?>
                </li>

            <?php  }
            ?>
        </ol>
    </div>
<?php }
if ($settings['list_style'] == 'icon') {
?>

    <div class="iq-list <?php echo esc_attr($align); ?>">
        <ul class="iq-list-with-icon">
            <?php
            foreach ($tabs as $index => $item) {
            ?>
                <li>
                    <?php Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']); ?>
                    <?php echo esc_html($item['tab_title'], 'iqonic'); ?>
                </li>

            <?php  }
            ?>
        </ul>
        
    </div>

<?php }
if ($settings['list_style'] == 'image') {
?>
    <div class="iq-list <?php echo esc_attr($align); ?>">
        <ul class="iq-list-with-img">
            <?php
            foreach ($tabs as $index => $item) {
            ?>
                <li>
                    <img src="<?php echo esc_url($settings['image']['url']); ?>">
                    <?php echo esc_html($item['tab_title'], 'iqonic'); ?>
                </li>
            <?php  }
            ?>
        </ul>
    </div>

<?php } ?>