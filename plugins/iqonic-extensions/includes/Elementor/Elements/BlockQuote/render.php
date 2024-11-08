<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;


$settings = $this->get_settings();
$align = $settings['align'];
if ($settings['iqonic_has_box_shadow'] == 'yes') {
    $align .= ' iq-box-shadow';
}

?>

<div class="iq-blockquote <?php echo esc_attr($align); ?>">
    <blockquote cite="<?php echo esc_attr($settings['source_url']); ?>">
        <div class="iq-quote">
            <?php
            if (!empty($settings['quote'])) {
            ?>
                <span class="iq-symbol"><?php echo esc_html($settings['quote']); ?></span>
            <?php } ?>

            <p class="iq-quote-content"> <?php echo $this->parse_text_editor($settings['description']); ?>

                <span class="iq-blockquote-author">
                    <cite><?php echo esc_html($settings['author']); ?></cite>
                </span>
            </p>

        </div>


    </blockquote>
</div>