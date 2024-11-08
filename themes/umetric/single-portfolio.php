<?php
/*
Template Name: Portfolio
*/
get_header(); 
?>
<div id="portfolio" class="content-area">
	<main id="portfolio-main" class="site-main main-portfolio">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<?php
					while ( have_posts() ) : the_post(); 
						get_template_part( 'template-parts/content/entry_single', get_post_type() );
					endwhile; // End of the loop. ?>
				</div>
			</div>
		</div>
	</main><!-- #main -->
</div><!-- .container -->
<?php get_footer();
