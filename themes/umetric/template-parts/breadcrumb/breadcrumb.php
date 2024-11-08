<?php

/**
 * Template part for displaying the Breadcrumb 
 *
 * @package umetric
 */

namespace Umetric\Utility;

if (is_front_page()) {
        if (is_home()) { ?>
            <div class="umetric-breadcrumb text-center green-bg">
                <div class="container">
                    <div class="row flex-row-reverse">
                        <div class="col-sm-12">
                            <div class="heading-title white umetric-breadcrumb-title">
                                <h1 class="title mt-0"><?php esc_html_e('Home', 'umetric'); ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php }
}
umetric()->umetric_inner_breadcrumb();
?>