<?php
namespace Elementor;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;


$html = '';
$settings = $this->get_settings();
$tabs = $this->get_settings_for_display('tabs');
$align = '';
if ($settings['iqonic_has_box_shadow'] == 'yes') {

   $align .= ' iq-box-shadow';
}
$image_style = '';
 
if ($settings['section_style'] == 'style-1') {
       ?>
   <div class="iq-feature-circle <?php echo esc_attr($align); ?>">
      <div class="iq-img">
         <ul class="list-inline mb-0">
            <?php
            foreach ($tabs as $key => $val) {
      
               if($key < 8){

                  $url = '';

                  if ($val['image_style'] == 2) {
                     if (!empty($val['tab_image']['url'])) {
                        $this->add_render_attribute('tab_image', 'src', $val['tab_image']['url']);
                        $this->add_render_attribute('tab_image', 'srcset', $val['tab_image']['url']);
                        $image_style = Group_Control_Image_Size::get_attachment_image_html($val, 'thumbnail', 'tab_image');
                     }
                  }
                     ?>
                  <li class="list-inline-item">
                     <div class="feature-info">
                        <a href='<?php echo esc_url($val['link']['url']);?>' <?php if(!empty($val['link']['is_external'])){ ?> target="_blank" <?php } ?><?php if ($val['link']['nofollow']){ ?> rel="nofollow" <?php } ?>>
                           <div class="inner">
                              <div class="feature-img" style="<?php if (!empty($val['circle_icon_color'])) { ?> color: <?php echo $val['circle_icon_color']; ?> ; <?php } if (!empty($val['circle_icon_background'])) { ?>  background: <?php echo $val['circle_icon_background']; ?> ; <?php } ?>">
                                 <?php
                                 echo $image_style;

                                 if ($val['image_style'] == 1) {
                                    Icons_Manager::render_icon($val['tab_icon'], ['aria-hidden' => 'true']);
                                 }
                                 ?>
                              </div>
                              <?php if(!empty($val['tab_title'])){ ?>
                                 <<?php echo esc_attr($settings['title_tag']);  ?> class="iq-feature-title">
                                    <?php echo esc_html($val['tab_title']); ?>
                                 </<?php echo esc_attr($settings['title_tag']);  ?>>
                              <?php } ?>
                           </div>
                        </a>
                     </div>
                  </li>
                  <?php 
               } 
            } ?>

         </ul>
         <div class="dot-circle">
            <div class="effect-circle"></div>
         </div>
         <div class="main-circle">
            <div class="circle-bg">
               <?php if (!empty($settings['image']['url'])) { ?>
                  <img src="<?php echo esc_url($settings['image']['url']) ?>" alt="iqonic-image">
               <?php } ?>
            </div>
         </div>
      </div>
   </div>
      <?php     

} elseif ($settings['section_style'] == 'style-2') {

   ?>
 <div class="iq-feature-circle <?php echo esc_attr($settings['section_style']); ?>">
         <div class="iq-img">
            <ul class="list-inline mb-0">
               <?php
               foreach ($tabs as $key => $val) {
         
                  if($key < 8){

                     $url = '';
                  
                     if ($val['image_style'] == 1) {
                        $image_style =  sprintf('<i aria-hidden="true" class="%1$s"></i>', esc_attr($val['tab_icon']['value']));
                     }
                     if ($val['image_style'] == 2) {
                        if (!empty($val['tab_image']['url'])) {
                           $this->add_render_attribute('tab_image', 'src', $val['tab_image']['url']);
                           $this->add_render_attribute('tab_image', 'srcset', $val['tab_image']['url']);
                           $image_style = Group_Control_Image_Size::get_attachment_image_html($val, 'thumbnail', 'tab_image');
                        }
                     }
                        ?>
                     <li class="list-inline-item">
                        <div class="feature-info">
                           <a href='<?php echo esc_url($val['link']['url']);?>' <?php if(!empty($val['link']['is_external'])){ ?> target="_blank" <?php } ?><?php if ($val['link']['nofollow']){ ?> rel="nofollow" <?php } ?>>
                              <div class="inner">
                                 <div class="feature-img" style="<?php
                                                                  if (!empty($val['circle_icon_color'])) { ?> 
                                    color: <?php echo $val['circle_icon_color']; ?> ; <?php
                                                                                    }
                                                                                    if (!empty($val['circle_icon_background'])) { ?> 
                                    background: <?php echo $val['circle_icon_background']; ?> ; <?php
                                                                                                } ?>">
                                    <?php
                                    echo $image_style;
                                    ?>
                                 </div>
                                 <?php if(!empty($val['tab_title'])){ ?>
                                    <<?php echo esc_attr($settings['title_tag']);  ?> class="iq-feature-title">
                                       <?php echo esc_html($val['tab_title']); ?>
                                    </<?php echo esc_attr($settings['title_tag']);  ?>>
                                 <?php } ?>
                              </div>
                           </a>
                        </div>
                     </li>
                     <?php 
                  } 
               } ?>

            </ul>
         </div>
         <div class="main-circle">
               <div class="circle-bg-main">
                     <div class="circle-bg">
                        <?php
                        if (!empty($settings['image']['url'])) {
                        ?>
                           <img src="<?php echo esc_url($settings['image']['url']) ?>" alt="iqonic-image">
                        <?php }

                        ?>
                     </div>
                     <div class="line-main">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                     </div>
               </div>
               <div class="iq-waves">
                     <div class="waves wave-1"></div>
                     <div class="waves wave-2"></div>
                     <div class="waves wave-3"></div>
               </div>
            </div>
      </div>
   <?php

} elseif ($settings['section_style'] == 'style-3') {

   $tabs = $this->get_settings_for_display('tabs_style-3');
       ?>
   <div class="iq-feature-circle <?php echo esc_attr($settings['section_style']); ?>">
      <div class="iq-img">
         <ul class="list-inline mb-0">
            <?php
            foreach ($tabs as $key => $val) {
               if($key < 8){

                  $url = '';

                  if ($val['image_style'] == 1) {
                     $image_style =  sprintf('<i aria-hidden="true" class="%1$s"></i>', esc_attr($val['tab_icon']['value']));
                  }
                  if ($val['image_style'] == 2) {
                     if (!empty($val['tab_image']['url'])) {
                        $this->add_render_attribute('tab_image', 'src', $val['tab_image']['url']);
                        $this->add_render_attribute('tab_image', 'srcset', $val['tab_image']['url']);
                        $image_style = Group_Control_Image_Size::get_attachment_image_html($val, 'thumbnail', 'tab_image');
                     }
                  }
                     ?>
                  <li class="list-inline-item">
                     <div class="feature-info">
                        <a href='<?php echo esc_url($val['link']['url']);?>' <?php if(!empty($val['link']['is_external'])){ ?> target="_blank" <?php } ?><?php if ($val['link']['nofollow']){ ?> rel="nofollow" <?php } ?>>
                           <div class="inner">
                              <div class="feature-img" style="<?php
                                                               if (!empty($val['circle_icon_color'])) { ?> 
                                 color: <?php echo $val['circle_icon_color']; ?> ; <?php
                                                                                 }
                                                                                 if (!empty($val['circle_icon_background'])) { ?> 
                                 background: <?php echo $val['circle_icon_background']; ?> ; <?php
                                                                                             } ?>">
                                 <?php
                                 echo $image_style;
                                 ?>
                              </div>      
                              <?php if(!empty($val['tab_title'])){ ?>
                                 <<?php echo esc_attr($settings['title_tag']);  ?> class="iq-feature-title">
                                    <?php echo esc_html($val['tab_title']); ?>
                                 </<?php echo esc_attr($settings['title_tag']);  ?>>
                              <?php } ?>
                           </div>
                        </a>
                     </div>
                  </li>
                  <?php 
               } 
            } ?>
         </ul>
         <div class="dot-circle">
            <div class="effect-circle"></div>
         </div>
         <div class="main-circle">
            <div class="circle-bg">
               <?php
               if (!empty($settings['image']['url'])) {
               ?>
                  <img src="<?php echo esc_url($settings['image']['url']) ?>" alt="iqonic-image">
               <?php }
               ?>
            </div>
         </div>
      </div>
   </div>
      <?php     
}
