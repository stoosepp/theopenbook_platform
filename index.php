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

get_header();?>
<div id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><!--<a href="<?php /*echo esc_url( home_url( '/' ) );*/ ?>" rel="home">--><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><!--<a href="<?php /*echo esc_url( home_url( '/' ) );*/ ?>" rel="home">--><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			/*$_s_description = get_bloginfo( 'description', 'display' );*/
			if ( $_s_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $_s_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->
	</div><!-- #masthead -->
	<?php
$topLevelPages = getTopLevelPages();
echo '<ul class="book-list">';
if ($topLevelPages){
	foreach($topLevelPages as $topLevelPage){
	
		echo '<a href="'.get_permalink($topLevelPage).'">';
		echo '<li><div class="book-cover"><div class="book-gradient"></div>';
		echo '<div class="book-title"><h2>'.$topLevelPage->post_title.'</h2>';
		$post_author_id = get_post_field( 'post_author', $topLevelPage);
		echo '<h3>'.get_the_author_meta('display_name', $post_author_id).'</h3></div>';
		$featured_img_url = get_the_post_thumbnail_url($topLevelPage);
		if ($featured_img_url){
			echo '<img src="'.esc_url($featured_img_url).'" rel="lightbox">'; 
            the_post_thumbnail('thumbnail');
		}
		else{
			echo '<img src="'.get_template_directory_uri().'/images/book-cover.jpg" rel="lightbox">'; 
		}
		
		echo '</div></li>';
		echo '</a>';
	}
}
echo '</ul>';
?>

	</main><!-- #main -->

<?php
get_footer();
