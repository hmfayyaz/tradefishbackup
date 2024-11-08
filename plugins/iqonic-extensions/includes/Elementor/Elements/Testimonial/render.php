<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

$settings = $this->get_settings();
$align = $settings['align'];

if ($settings['iqonic_has_box_shadow'] == 'yes') {
    $align .= ' iq-box-shadow';
}
$args = array(
    'post_type'         => 'testimonial',
    'post_status'       => 'publish',
    'suppress_filters'  => 0,
    'posts_per_page'    => -1,
);

$wp_query = new \WP_Query($args);
$out = '';
global $post;

$desk = $settings['desk_number'];
$lap = $settings['lap_number'];
$tab = $settings['tab_number'];
$mob = $settings['mob_number'];

$this->add_render_attribute('slider', 'data-dots', $settings['dots']);
$this->add_render_attribute('slider', 'data-nav', $settings['nav-arrow']);
$this->add_render_attribute('slider', 'data-items', $settings['desk_number']);
$this->add_render_attribute('slider', 'data-items-laptop', $settings['lap_number']);
$this->add_render_attribute('slider', 'data-items-tab', $settings['tab_number']);
$this->add_render_attribute('slider', 'data-items-mobile', $settings['mob_number']);
$this->add_render_attribute('slider', 'data-items-mobile-sm', $settings['mob_number']);
$this->add_render_attribute('slider', 'data-autoplay', $settings['autoplay']);
$this->add_render_attribute('slider', 'data-loop', $settings['loop']);
$this->add_render_attribute('slider', 'data-margin', $settings['margin']['size']);

if ($settings['design_style'] == 1) {
    $align .= ' iq-testimonial-1';
}
if ($settings['design_style'] == 2) {
    $align .= ' iq-testimonial-2';
}
if ($settings['design_style'] == 3) {
    $align .= ' iq-testimonial-3';
}
if ($settings['design_style'] == 4) {
    $align .= ' iq-testimonial-4';
}

remove_filter('the_content', 'wpautop');
$image_html = '';

if ($settings['media_style'] == 'image') {
    if (!empty($settings['image']['url'])) {
        $this->add_render_attribute('image', 'src', $settings['image']['url']);
        $this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($settings['image']));
        $this->add_render_attribute('image', 'title', Control_Media::get_image_title($settings['image']));
        $image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image');
    }
}


?>
<div class="iq-testimonial <?php echo esc_attr($align);  ?>">
    <?php
    ?>
    <div class="owl-carousel" <?php echo $this->get_render_attribute_string('slider') ?>>
        <?php
        if ($wp_query->have_posts()) {
            while ($wp_query->have_posts()) {
                $wp_query->the_post();
                $designation  = get_post_meta($post->ID, 'iqonic_testimonial_designation', true);
                $company  = get_post_meta($post->ID, 'iqonic_testimonial_company', true);
                $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($wp_query->ID), "full");
        ?>
                <?php
                if ($settings['design_style'] == 1) {
                ?>
                    <div class="iq-testimonial-info">
                        <div class="iq-testimonial-content">
                            <p><?php the_content($wp_query->ID); ?></p>
                            <?php if ($settings['display_quote'] == 'yes') { ?>
                                <div class="iq-testimonial-quote">
                                    <?php 
                                    if ($settings['media_style'] == 'icon') 
                                    {
                                        if(!empty($settings['selected_icon']) == 'default')
                                        {
                                            $image_html = Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
                                        }
                                    }
                                    else
                                    { 
                                        echo $image_html;
                                     }
                                    ?>
                                </div>
                            <?php    } ?>
                        </div>
                        <div class="iq-testimonial-member">
                            <div class="iq-testimonial-avtar">
                                <img alt="image-testimonial" class="img-fluid center-block" src="<?php echo esc_url($full_image[0]); ?>">
                            </div>
                            <div class="avtar-name">
                                <div class="iq-lead">
                                    <?php the_title($wp_query->ID); ?>
                                </div>
                                <span class="iq-post-meta"><?php echo esc_html($designation); ?>, <?php echo esc_html($company); ?></span>
                            </div>

                        </div>
                    </div>
                <?php
                }
                if ($settings['design_style'] == 2) {
                ?>
                    <div class="iq-testimonial-info">
                        <div class="iq-testimonial-avtar">
                            <img alt="#" class="img-fluid rounded-circle" src="<?php echo esc_url($full_image[0]); ?>">
                        </div>
                        <div class="iq-testimonial-member">
                            <?php if ($settings['display_quote'] == 'yes') { ?>
                                <div class="iq-testimonial-quote">
                                <?php 
                                    if ($settings['media_style'] == 'icon') 
                                    {
                                        if(!empty($settings['selected_icon']) == 'default')
                                        {
                                            $image_html = Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
                                        }
                                    }
                                    else
                                    { 
                                        echo $image_html;
                                     }
                                    ?>
                                </div>
                            <?php    } ?>
                            <h5 class="content"><?php the_title($wp_query->ID); ?></h5>
                            <span class="sub-title"><span class="content-sub mr-2 ml-2">-</span><?php echo esc_html($designation); ?>, <?php echo esc_html($company); ?></span>
                        </div>

                        <p><?php the_content($wp_query->ID);  ?></p>
                    </div>
                <?php
                }
                if ($settings['design_style'] == 3) {
                 ?>
                  <div class="iq-testimonial-info">
                        <div class="iq-testimonial-content">
                            <p><?php the_content($wp_query->ID); ?></p>
                            <?php if ($settings['display_quote'] == 'yes') { ?>
                                <div class="iq-testimonial-quote">
                                <?php 
                                    if ($settings['media_style'] == 'icon') 
                                    {
                                        if(!empty($settings['selected_icon']) == 'default')
                                        {
                                            $image_html = Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
                                        }
                                    }
                                    else
                                    { 
                                        echo $image_html;
                                     }
                                    ?>
                                </div>
                            <?php    } ?>
                        </div>
                        <div class="shape">
                            <svg  width="50" height="50" viewBox="-50 -50 300 300"><polygon class="triangle" stroke-linejoin="round" points="100,0 0,200 200,200"/></svg>
                        </div>
                        <div class="iq-testimonial-member">
                            <div class="iq-testimonial-avtar">
                                <img alt="image-testimonial" class="img-fluid center-block" src="<?php echo esc_url($full_image[0]); ?>">
                            </div>
                            <div class="avtar-name">
                                <div class="iq-lead">
                                    <?php the_title($wp_query->ID); ?>
                                </div>
                                <span class="iq-post-meta"><?php echo esc_html($designation); ?>, <?php echo esc_html($company); ?></span>
                            </div>

                        </div>
                    </div>
                 <?php
                }
                if ($settings['design_style'] == 4) {
                    ?>
                        <div class="iq-testimonial-info">
                            <div class="iq-testimonial-content">
                                <p><?php the_content($wp_query->ID); ?></p>
                                <?php if ($settings['display_quote'] == 'yes') { ?>
                                    <div class="iq-testimonial-quote">
                                        <?php 
                                        if ($settings['media_style'] == 'icon') 
                                        {
                                            if(!empty($settings['selected_icon']) == 'default')
                                            {
                                                $image_html = Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
                                            }
                                        }
                                        else
                                        { 
                                            echo $image_html;
                                         }
                                        ?>
                                    </div>
                                <?php    } ?>
                            </div>
                            <div class="shape">
                                <svg  width="50" height="50" viewBox="-50 -50 300 300"><polygon class="triangle" stroke-linejoin="round" points="100,0 0,200 200,200"/></svg>
                            </div>
                            <div class="iq-testimonial-member">
                                <div class="iq-testimonial-avtar">
                                    <img alt="image-testimonial" class="img-fluid center-block" src="<?php echo esc_url($full_image[0]); ?>">
                                </div>
                                <div class="avtar-name">
                                    <div class="iq-lead">
                                        <?php the_title($wp_query->ID); ?>
                                    </div>
                                    <span class="iq-post-meta"><?php echo esc_html($designation); ?>, <?php echo esc_html($company); ?></span>
                                </div>
    
                            </div>
                        </div>
                    <?php
                    }
                
            }
            wp_reset_postdata();
        }
        ?>
    </div>
</div>