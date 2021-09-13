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
			<?php if ( is_page()  || is_single()) {
				?>
				
			Last Modified on <?php 
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
			$bookSSTheme = wp_get_theme();
			$themeName = esc_html( $bookSSTheme->get( 'Name' ));
			$themeURI = esc_html( $bookSSTheme->get( 'ThemeURI' ));
			$themeAuthor =  esc_html( $bookSSTheme->get( 'Author' ));
			$authorURI =  esc_html( $bookSSTheme->get( 'AuthorURI' ));
			

			
			if (is_front_page() || is_search()){
				//Don't show license stuff on home page
				echo '<a href="'.$themeURI.'" target="_blank">'.$themeName.' Theme</a> developed by '.$themeAuthor.', 2021. </p>';
			}
			else{
				//LOAD THIS FROM BOOK META
				echo '  |  <a href="'.$themeURI.'" target="_blank">'.$themeName.' Theme</a> developed by '.$themeAuthor.', 2021. </p>';
				if (is_page()){
			
					$bookRoot = getRootForPage($post);
					$root = get_post($bookRoot);
					$CCLicense = get_post_meta( $root->ID, 'bookLicense', true );
					//consolePrint('License for '.$root->post_title.' is '.$CCLicense);
					if (($CCLicense == 'allrightsreserved') || ($CCLicense == null)){?>
						<p>All original content in this book is All Rights Reserved &copy;<?php the_modified_time('Y'); ?></p>
					<?php
					}
					else{
						$CCimage = '/inc/images/'.$CCLicense.'.png';
						$CCDescription = '<a href="https://creativecommons.org/licenses/'.$CCLicense.'/4.0/">CC '.strtoupper ($CCLicense).' 4.0 License</a>';
						?>
						<p><img src="<?php echo get_template_directory_uri().$CCimage;?>"></p><p>All original content in this book is licenced under the <?php echo $CCDescription ?> unless otherwise noted. </p>
						<?php $footerText = get_post_meta( $root->ID, 'footerText', true );
						echo '<p>'.$footerText.'</p>';
					}
			}
				
				
			}?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
