<?php

/**
 * Template part for displaying left hand table of contents
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * 
 */

$bookRoot = getRootForPage($post);
//$childPages = new stdClass();
if ( is_page() && $post->post_parent ) {
    //echo 'This is a subpage';
} else {
    //echo 'This is NOT a subpage';
    $pages = get_pages('child_of='.$post->ID.'&sort_column=post_date&sort_order=asc&parent='.$post->ID);
    if ( $pages ) {
        $first_page = current( $pages );
        //echo '<h4>First Child: '.get_the_title($first_page).'</h4>';
        $bookRoot = getRootForPage($first_page);
        //echo 'Getting first childs subpages';
    }
   
}
$childPages = getKids($bookRoot);
if ( $childPages) {
    echo '<ul class="toc-section">';
    foreach ( $childPages as $child ) {
        //echo '<li><a href='.get_permalink($child).'>'.$child->post_title.'</a></li>';
        echo '<li><a href='.get_permalink($child).'>'.$child->post_title.'</a><input type="checkbox" id="'.$child->ID.'" onclick="saveCheckbox(document.getElementById('.$child->ID.'));"></li>';
        $grandChildren = getKids($child->ID);
        foreach ($grandChildren as $grandChild){
            echo '<ul class="toc-subsection">';
            $postParentID = wp_get_post_parent_id($post);
            $postParent = get_post($postParentID);
            if ( ($child->ID == $postParentID) || ($child->ID == $post->ID)){
                //echo '<li>PARENT OF THIS PAGE IS <a href='.get_permalink($postParent).'>'.$postParent->post_title.'</a></li>';
                //echo '<li><a href='.get_permalink($grandChild).'>'.$grandChild->post_title.'</a></li>';
                echo '<li><a href='.get_permalink($grandChild).'>'.$grandChild->post_title.'</a><input type="checkbox" id="'.$grandChild->ID.'"  onclick="saveCheckbox(document.getElementById('.$grandChild->ID.'));"></li>';
            }
            //Check to see if you're at Root of this book
            $pages = get_pages('child_of='.$post->ID.'&sort_column=post_date&sort_order=asc&parent='.$post->ID);
            if ( $pages ) {
                $first_page = current( $pages );
                if ($first_page == $child){
                    echo '<li><a href='.get_permalink($grandChild).'>'.$grandChild->post_title.'</a><input type="checkbox" id="'.$grandChild->ID.'"  onclick="saveCheckbox(document.getElementById('.$grandChild->ID.'));"></li>';
                }
            } 
            $greatGrandChildren = getKids($grandChild->ID);
            if (count($greatGrandChildren) != 0){
                echo '<li style="font-size:0.75em; color:red;">You have pages that may be deeper than allowed by this theme and will not appear. Make sure that pages only go 2 levels</li>';
            }
            echo '</ul>';
        }
    }
    echo '</ul>';
}
?>