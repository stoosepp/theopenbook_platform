<?php
/**
 * Template part for displaying Header-based nav within content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * 
 */?>

<aside>
			<nav class="aside-nav">
			
			<?php 
			$content = apply_filters( 'the_content', get_the_content());
			if ( strpos( $content, 'h2' ) == FALSE) {
				//echo 'There are NO H2 tags';
				echo '<script>updateArticleMargin();</script>';
			}
			else{
				//echo 'There are H2 tags';
				if ($content){
					$headers = getTextBetweenTags($content,'h2');
					if (count($headers) > 0){
						echo '<p style="padding-left:10px; margin:0px;"><span class="dashicons dashicons-editor-ul"></span> Contents</p>
						<ul class="page-sidebar-list">';
						foreach($headers as &$header){
							$headername = sanitize_title($header);
							echo '<li class="header-margin-link"><a href="#'.$headername.'">'.$header.'</a></li>';
						}
					//<li class="header-gradient"></li>-->
					echo '</ul>';
					}
				}
				else{
					//No content - fix the right margin
				}
			}
		?>	
		</nav>
	</aside>