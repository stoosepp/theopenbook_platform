<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="site-info"><p>
			<?php if ( is_page() ) {
				?>
			This page created by <?php echo get_the_author_meta('display_name', $author_id); 

			$u_time = get_the_time('U'); 
			$u_modified_time = get_the_modified_time('U'); 
			//if ($u_modified_time >= $u_time + 86400) { 
			echo "   |   Last modified on "; 
			the_modified_time('F jS, Y'); 
			echo " at "; 
			the_modified_time(); 
				echo '   |   ';
			}
			$bookSSTheme = wp_get_theme();
			$themeName = esc_html( $bookSSTheme->get( 'Name' ));
			$themeURI = esc_html( $bookSSTheme->get( 'ThemeURI' ));
			$themeAuthor =  esc_html( $bookSSTheme->get( 'Author' ));
			$authorURI =  esc_html( $bookSSTheme->get( 'AuthorURI' ));
			echo '<a href="'.$themeURI.'" target="_blank">'.$themeName.' </a>developed by '.$themeAuthor.', 2021. </p>';
?> 
			<p><img src="<?php echo get_template_directory_uri();?>/inc/images/by-nc-sa.png"></p><p>All content is licenced under the <a href="https://creativecommons.org/licenses/by-nc-sa/4.0/">CC BY-NC-SA 4.0 License</a> </p>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
