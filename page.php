<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s
 */
?>
<?php get_header(); ?>
<main id="primary" class="site-main">
	<!--HEADER / PROGRESS BAR-->
	<?php get_template_part( 'template-parts/content-breadcrumbs', get_post_type() );?>

	<!--SIDEBAR -->
	<?php get_template_part( 'template-parts/content-sidebar', get_post_type() );?>

	 <!--ARTICLE -->
	 <div class="article">


	<!--ARTICLE BODY -->
	<div class="article-body">

		<?php
			if ( have_posts() ) :
				if ( is_home() && ! is_front_page() ) :
					?>
					<?php
				endif;
				/* Start the Loop */
				while ( have_posts() ) :
					?><a class="new-window-link" href="<?php echo the_permalink(); ?>" target="_blank">Open in New Window</a><?php

					the_post();
					/*
					* Include the Post-Type-specific template for the content.
					* If you want to override this in a child theme, then include a file
					* called content-___.php (where ___ is the Post Type name) and that will be used instead.
					*/

					get_template_part( 'template-parts/content', get_post_type() );
					get_template_part( 'template-parts/content-voting', get_post_type() );

				endwhile;
				the_posts_navigation();
			else :
				get_template_part( 'template-parts/content', 'none' );


			endif;

			get_footer();
			?>
		</div>
		<!--HEADING TOC AND SIDENOTES -->
		<?php get_template_part( 'template-parts/content-headernav', get_post_type() ); ?>

	</div>
</main><!-- #main -->


