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
	<!--SIDEBAR -->
	 <nav class="left-toc">
	 
		 <?php 
		 if ( is_page() ) {
			echo '<div id="toc-list">';
			
			$bookRoot = getRootForPage($post);
			
			
			echo '<h1><a id="home-icon" href="'.get_home_url().'"><span class="dashicons dashicons-admin-home"></span></a><a href='.get_permalink($bookRoot).'>'.get_the_title($bookRoot).'</a></h1>';//Book Title
			?>
			<form id="search-form" action="/" method="get">
			<!-- <label for="search">Search in <?php echo home_url( '/' ); ?></label> -->
			<span class="dashicons dashicons-search"></span>
			<input type="text" name="s" id="search" placeholder="Search" value="<?php the_search_query(); ?>" />
			</form><?php
			get_template_part( 'template-parts/content-toc', get_post_type() );
			get_template_part( 'template-parts/content-switches', get_post_type() );
		}
		 ?>
		 <!-- Rounded switch -->


	 </nav>

	 <!--ARTICLE -->
	 <div class="article">

	<!--ARTICLE TITLE / HEADER -->
	<?php get_template_part( 'template-parts/content-breadcrumbs', get_post_type() );?>
	
	
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
				the_post();
				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_type() );

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


