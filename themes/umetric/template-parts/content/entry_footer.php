<?php

/**
 * Template part for displaying a post's footer
 *
 * @package umetric
 */

namespace Umetric\Utility;

?>
<div class="blog-footer">
    <?php
    get_template_part('template-parts/content/entry_taxonomies', get_post_type());
    if (!is_single()) {
        get_template_part('template-parts/content/entry_actions', get_post_type());
        echo "</div>";
    }
    ?>
</div>