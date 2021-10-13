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
			?> <p style="color:darkgray; line-height: 1.4em; text-align:center; margin-bottom:10px;">Search Results for:<?php
			//printf( esc_html__( 'Search Results for: %s', '_s' ), '<span id="search-title">' . get_search_query() . '</span>' );
			?> </p>
			<h2 id="search-title"><?php echo get_search_query(); ?></h2>
			<form class="search-form" action="/" method="get">
			<!-- <label for="search">Search in <?php echo home_url( '/' ); ?></label> -->
			<i class="far fa-search"></i>
			<input type="text" name="s" id="search" placeholder="Search" value="<?php the_search_query(); ?>" />
			</form><?php
			
		get_template_part( 'template-parts/content-switches', get_post_type() );?>
		 <!-- Rounded switch -->
	</nav>
	<div class="article">
	<?php get_template_part( 'template-parts/content-breadcrumbs', get_post_type() );?>
	<div class="article-body">
		<?php if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				
				?>
				<div class="search-result">

				<div class="entry-title"><h2><a href="<?php the_permalink() ?>"><?php
				//get_template_part( 'template-parts/content', 'search' );
				
					echo ''.the_title().'';
					?></a></h2>
					<p class="content-type-p">
						<?php if(get_post_type() === 'page'){
							?>BOOK CHAPTER<?php //Is a book chapter
							$bookRoot = getRootForPage(the_post());
							$root = get_post($bookRoot);
							echo ' in ';
							$string = strtoupper($root->post_title);
							echo $string;

						}
						else{
							?> DOCUMENT<?php //is a document
							$categories = get_the_category();
							if ($categories){
								//point to end of the array
								$lastElement = end($categories);
								echo ' in ';
								foreach($categories as $category){
									echo $category->name;
									if($category != $lastElement) {
										echo ', ';
									}
								}
							}
							
							
						}?>
					</p><?php
					echo '<p>'.get_the_excerpt().'</p>';
					?><div class="site-info search-info"><p>Last Modified on <?php 
					$u_time = get_the_time('U'); 
					$u_modified_time = get_the_modified_time('U'); 
					//if ($u_modified_time >= $u_time + 86400) { 
					the_modified_time('F jS, Y'); 
					echo " at "; 
					the_modified_time(); 
						echo ' by ';
					$author_id = get_the_author_meta( 'ID' );
					echo get_the_author_meta('display_name', $author_id);  

				?></p></div></div> </div><?php
			endwhile;

			the_posts_navigation();

		else :
			//get_template_part( 'template-parts/content', 'none' );
		
				echo '<h2 style="text-align:center;">Sorry, nothing was found <span>&#129402</span></h2>';
				echo '<img src="'.get_template_directory_uri().'/images/pug.jpg" style="width:100%; height:auto;">';
				echo '<p style="text-align:center;">Try searching again or exploring the content on this site by <a href="'.get_home_url().'">visiting the  home page</p>';
			
		endif;
		get_footer();
		?>
		
</div>
	</div>
	</main><!-- #main -->


