<?php $umetric_option = get_option('umetric_options'); ?>
<?php the_content(); ?>
<?php
if(isset($umetric_option['display_pre_next']))
{
    $options = $umetric_option['display_pre_next'];
    if($options == "yes"){
    ?>
    <?php if ( is_singular( 'portfolio' ) ) {
        the_post_navigation( array(
            'next_text' => '<span class="meta-nav button-gradient" aria-hidden="true">' . __( 'Next', 'umetric' ) . '</span> ' .
                '<span class="screen-reader-text">' . __( 'Next post:', 'umetric' ) . '</span> ' ,

            'prev_text' => '<span class="meta-nav button-gradient" aria-hidden="true">' . __( 'Previous', 'umetric' ) . '</span> ' .
                '<span class="screen-reader-text">' . __( 'Previous post:', 'umetric' ) . '</span> ',
        ) );
    }
    ?>
        <?php if ( is_singular( 'post' ) ) { ?>
            <a class="blog-user" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>"><i class="fa fa-th-large"></i></a>
        <?php
        }
    }
}
