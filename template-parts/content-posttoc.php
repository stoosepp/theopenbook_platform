<?php

/**
 * Template part for displaying left hand table of contents
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * 
 */

$category = get_the_category()[0];
consolePrint('Cat ID: '.$category->term_id);

$post_list = get_posts( array(
    'orderby'    => 'date',
    'sort_order' => 'desc',
    'category' => $category->term_id
) );

foreach($post_list as $thisPost) { 
    echo '<ul class="toc-section">';
    echo '<li><a href='.get_permalink($thisPost).'>'.$thisPost->post_title.'</a><input type="checkbox" id="'.$thisPost->ID.'" onclick="saveCheckbox(document.getElementById('.$thisPost->ID.'));"></li>';
    echo '</ul>';
 } 





  
        
    
    

?>