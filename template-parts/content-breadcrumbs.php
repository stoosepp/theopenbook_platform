<?php

/**
 * Template part for displaying breadcrumbs
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * 
 */?>
<div class="header-bar">
<div class="article-header">
<div id="header-left">
    <div class="bt-menu-trigger bt-menu-open">
        <span><!-- This is the animated hamburger menu --></span>
    </div>
<!--NEXT PREVIOUS BUTTONS -->
    <?php $bookRoot = getRootForPage($post);
      $root = get_post($bookRoot);     
if ( is_page() && ($post != $bookRoot)) {
    //Not root
    $postParentID = wp_get_post_parent_id($post);
    $postParent = get_post($postParentID);
    if ($postParent->post_title != $root->post_title){
        echo '<a href='.get_permalink($postParent).'>'.$postParent->post_title.'</a>';
        echo '<span class="dashicons dashicons-arrow-right-alt2"></span>';
    }
    echo '<a href='.get_permalink($post).'>'.$post->post_title.'</a>';
} 
else if ($post == $bookRoot){
   echo 'Welcome!'; 
}

?>
</div>
<div id="header-right">
<a href="#"><span class="dashicons dashicons-arrow-left-alt2"></span></a>  
    <?php 
        $prev_link = get_previous_posts_link(__('&laquo; Older Entries'));
        $next_link = get_next_posts_link(__('Newer Entries &raquo;'));
        // as suggested in comments
        if ($prev_link || $next_link) {
        echo '<ul class="navigation">';
        if ($prev_link){
           // echo '<li>'.$prev_link .'</li>';
            echo '<a href="'.$prev_link .'"><span class="dashicons dashicons-arrow-left-alt2"></span></a>';
        }
        if ($next_link){
            //echo '<li>'.$next_link .'</li>';
            echo '<a href="'.$next_link.'"><span class="dashicons dashicons-arrow-right-alt2"></span></a>';
        }
        echo '</ul>';
}
    ?>
     
    
    
</div>
</div>
<div class="progress-container">
    <div class="progress" id="progress"></div>
  </div>
  
</div>

