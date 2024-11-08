<!-- signal_template.php -->
<div class="slider_wrapper">
    <div class="loader_wrap d-none">
        <img src="<?php echo content_url();?>/uploads/2024/01/tradefish-preloader.gif"/>
    </div>
    <div class="elementor-widget-container Signlstpbx-main owl-carousel owl-theme">

        <?php
        if ( $posts->have_posts() ) {
            while ( $posts->have_posts() ) {
                $posts->the_post();
                $coin_post_id  = get_post_meta( get_the_ID(), '_post_title', true );
                $post_tumbnail = get_the_post_thumbnail_url( $coin_post_id, array( 20, 20 ) );
                $signal_vale   = get_post_meta( get_the_ID(), 'signal_value', true );
                $opening_price = get_post_meta( get_the_ID(), 'opening_price', true );
                $ticker_type   = get_post_meta( get_the_ID(), 'ticker_type', true );
                $symbol        = get_post_meta( $coin_post_id, '_coin_symbol', true );
                // Get the date of the current post or a specific post in 'Y-m-d' format
                $date = get_post_time('Y-m-d', false, get_the_ID());
                // Get the time of the current post or a specific post in 'h:i:s' format
                $time = get_post_time('H:i:s', false, get_the_ID());
                $currency = get_post_meta(get_the_ID(), 'currency', true);
                $datetime = new DateTime($date.''.$time);
                $timeago = $this->getTimeAgo($datetime);
	            $symbol_currency = $currency == 'EUR' ? '€' : '$';
                ?>
                  <div>
                    <div class="elementor-image-box-wrapper <?php echo $signal_vale == 'short' ? 'short_signal' : 'long_signal' ?>  p-2">
						<div class="top-part">	
							<div class="img-and-title">
					   <figure class="elementor-image-box-img">
                            <img src="<?php echo $post_tumbnail; ?>"
                            	class="thumbnail-image"
                                 style="height:50px;width:50px"/>
                        </figure>
						 <h4 class="elementor-image-box-title"><?php echo ( $symbol != '' ) ? $symbol : the_title(); ?></h4><br>
							</div>
							<div class="signal-indicator">
						    <?php if ( $signal_vale === 'short' ) { ?>
                                    <span style="color:#fc0902; display:flex; align-items: center; justify-content: center;">

							<i class="ion-android-arrow-down mr-2"
                               style="transform: rotate(42deg); font-size: 28px;"
                               aria-hidden="true"></i>
							<span style="color:#fc0902; font-size: 20px; font-family: Inter; font-weight: 500;  text-transform:capitalize;"><?php echo $signal_vale ?></span>
						</span>
                                <?php } else { ?>
                                    <span style="color:#0FBAA5; display:flex; align-items: center; justify-content: center;">
							<i class="ion-android-arrow-up mr-2" style="transform: rotate(42deg); font-size: 28px;"
                               aria-hidden="true"></i>
							<span
                                    style="color:#0FBAA5; font-size: 20px; font-family: Inter; font-weight: 500;  text-transform:capitalize;"><?php echo $signal_vale ?></span>
						</span>
                                <?php } ?>
								</div>
								</div>
									<div class="signal-name">
							 <span style="color:#ABACAD;" class="mb-2 d-inline-block"><?php the_title(); ?></span>
							</div>
                        <div class="elementor-image-box-content">
								<div class="ticker-wrap">
							<h1 class="ticker-type">Type</h1> 
							<span class="ticker_type"><?php echo $ticker_type == 'fx' ? strtoupper( $ticker_type ) : ucfirst( $ticker_type ); ?></span>
								</div>
								<div class="price-wrap">
								 <h1 class="Price-title">Price</h1>
								 <h5>
						<span
                                style="color: #FFFFFF; margin-top: 10px; background: #1D2421; padding: 6px 12px; border-radius: 20px; font-size: 14px">
							<?php echo $get_currencies[$currency]; ?>
							<?php echo $opening_price; ?></span>
                            </h5>
							</div>
                            
							
                            <h6 style="margin-bottom: 10px">
							<div class="time-wrap">
								<h1 class="time-title">Opened</h1>
						<span class="main-time-span">
							<svg class="svg-inline--fa fa-calendar-days" style="color: #FFFFFF;" aria-hidden="true"
                                 focusable="false" data-prefix="far" data-icon="calendar-days" role="img"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
								<path fill="currentColor"
                                      d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192h80v56H48V192zm0 104h80v64H48V296zm128 0h96v64H176V296zm144 0h80v64H320V296zm80-48H320V192h80v56zm0 160v40c0 8.8-7.2 16-16 16H320V408h80zm-128 0v56H176V408h96zm-144 0v56H64c-8.8 0-16-7.2-16-16V408h80zM272 248H176V192h96v56z"></path>
							</svg>
                            <span style="text-align:right" class="time-date"><?php echo get_the_date( 'j M. Y' ) . ", ";
                                echo the_time( 'H:i:s' ).' UTC';
                                ?></span>
                            <span style="text-align:right;margin-left: 28px; " class="days-ago">
                                <?php
                                echo $timeago;
                                ?>
                            </span>
						</span>
						</div>
                            </h6>
                            <hr>
                        </div>
                    </div>
                </div>
                <?php
            }
            wp_reset_postdata();
        } else {
            echo '<div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-611fd49 layouts-column-align-inherit layouts-section-position-none ob-is-e3 animated fadeInLeft" data-id="611fd49" data-element_type="column" data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;animation&quot;:&quot;fadeInLeft&quot;,&quot;_ob_bbad_is_stalker&quot;:&quot;no&quot;,&quot;_ob_teleporter_use&quot;:false,&quot;_ob_column_hoveranimator&quot;:&quot;no&quot;,&quot;_ob_column_has_pseudo&quot;:&quot;no&quot;}">
<div class="elementor-widget-wrap elementor-element-populated">
<div class="hf-elementor-layout elementor-element elementor-element-38e2a77 hght-bx bg-clr-bx br-20 mving-bx-img elementor-position-top ob-has-background-overlay elementor-widget elementor-widget-image-box" data-id="38e2a77" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;none&quot;,&quot;_ob_perspektive_use&quot;:&quot;no&quot;,&quot;_ob_poopart_use&quot;:&quot;yes&quot;,&quot;_ob_shadough_use&quot;:&quot;no&quot;,&quot;_ob_allow_hoveranimator&quot;:&quot;no&quot;,&quot;_ob_widget_stalker_use&quot;:&quot;no&quot;}" data-widget_type="image-box.default">
<div class="elementor-widget-container">
<div class="elementor-image-box-wrapper"><figure class="elementor-image-box-img"><img decoding="async" src="https://tradefish.app/wp-content/uploads/2024/01/Frame-48096599.png" title="Frame 48096599" alt="Frame 48096599" loading="lazy"></figure><div class="elementor-image-box-content"><h4 class="elementor-image-box-title">AI Is Looking</h4><p class="elementor-image-box-description"><span style="color:#ABACAD;" class="mb-2 d-inline-block">For New Signals...</span>
</p><div>
<img decoding="async" src="/wp-content/uploads/2024/01/Frame-48096589.png" class="movingimg">
</div><br><p></p></div></div> </div>
</div>
</div>
</div>';
        } ?>
    </div>
</div>