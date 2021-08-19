<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package _s
 */

get_header();
?>

	<main id="search-results" class="site-main">

	<nav class="left-toc">
		 <?php 
			echo '<div id="toc-list">';
			echo '<a id="home-icon" href="'.get_home_url().'"><i class="fas fa-home"></i></a>'; 
			
			// $bookRoot = getRootForPage($post);
			// //PUT PHOTO HERE
			// $featured_img_url = get_the_post_thumbnail_url($bookRoot);
			echo '<div class="book-image">';
			
			echo '<img src="'.get_template_directory_uri().'/images/magnify.jpg" rel="lightbox">'; 	
			
			echo '</div>';
			?> <h1 style="color:darkgray; line-height: 1.4em;"><?php
			printf( esc_html__( 'Search Results for: %s', '_s' ), '<span id="search-title">' . get_search_query() . '</span>' );
			?> </h1><?php
		get_template_part( 'template-parts/content-switches', get_post_type() );?>
		 <!-- Rounded switch -->
	</nav>
	<div class="article-body">
		<?php if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				
				$bookRoot = getRootForPage($post);
				$root = get_post($bookRoot);
				?>
				<div class="search-result">

					<div class="entry-title"><h2><a href="<?php the_permalink() ?>"><?php
				//get_template_part( 'template-parts/content', 'search' );
				if (the_post() != $root){
					echo ''.the_title().'';
				
					?></a></h2><?php
					echo '<p>'.get_the_excerpt().'</p>';
					?><div class="site-info"><p>Last Modified on <?php 
					$u_time = get_the_time('U'); 
					$u_modified_time = get_the_modified_time('U'); 
					//if ($u_modified_time >= $u_time + 86400) { 
					the_modified_time('F jS, Y'); 
					echo " at "; 
					the_modified_time(); 
						echo ' by ';
					$author_id = get_the_author_meta( 'ID' );
					echo get_the_author_meta('display_name', $author_id);  
				}
				
			
				
				?></p></div></div> </div><?php
			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		get_footer();
		?>
		
</div>
	</main><!-- #main -->


