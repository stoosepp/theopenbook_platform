<?php
/**
 * Template part for displaying Header-based nav within content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * 
 */?>

<aside>
			
			
			<?php 
			$content = apply_filters( 'the_content', get_the_content());
			if ( strpos( $content, 'h2' ) == TRUE) {
				//echo 'There are H2 tags';
				?><nav class="aside-nav"><?php
				if ($content){
					$headers = getTextBetweenTags($content,'h2');
					if (count($headers) > 0){
						echo '<p style="padding-left:10px; margin:0px;"><i class="fal fa-list"></i>  Contents</p>
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
			?></nav><?php
			}
		?>	
		
	</aside>