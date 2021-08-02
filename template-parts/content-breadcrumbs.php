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
        <span> <!-- This is the animated hamburger menu --></span>
            <label>
                <input type="checkbox" id="hamburger-hidden" onclick="saveCheckbox(document.getElementById('hamburger-hidden'));">
                <span style="display:none;"> <!-- This is the animated hamburger menu --></span>
            <label>
            </div>
            
            <!--NEXT PREVIOUS BUTTONS -->
                <?php 
                $bookRoot = getRootForPage($post);
                $root = get_post($bookRoot);     
                if ( is_page() && ($post != $root)) {
                    //Not root
                    $postParentID = wp_get_post_parent_id($post);
                    $postParent = get_post($postParentID);
                    if ($postParent->post_title != $root->post_title){
                        echo '<a href='.get_permalink($postParent).'>'.$postParent->post_title.'</a>';
                        echo '<i class="fas fa-chevron-right"></i>';
                    }
                    echo '<a href='.get_permalink($post).'>'.$post->post_title.'</a>';
                } 
            else if ($post == $bookRoot){
            //echo 'Welcome!'; 
            }

            ?>
        </div>
        <div id="header-right">
            <div id="header-options">
            <!--<i class="fas fa-comment-smile"></i>
            <i class="far fa-thumbs-up"></i>
            <i class="far fa-thumbs-down"></i>
            <i class="far fa-download"></i>-->
            <a class="hidden" href="#" onclick="window.toggleFullscreen(this);"><i class="fas fa-compress"></i></a>
            <a class ="" href="#" onclick="window.toggleFullscreen(this);"><i class="fas fa-expand"></i></a>
            <a id="print" href="#" onclick="window.print();"><i class="fas fa-print"></i></a>
             </div>

        <?php
        //GET ALL LINKS IN LEFT HAND MENU
        $bookRoot = getRootForPage($post);//Get the book for the current page
        $isRoot = false;
        $childPages = getKids($bookRoot);
        $allPages = array();
        if (( $childPages) && $isRoot == false){
            foreach ( $childPages as $child ) {
               array_push($allPages,$child);
                $grandChildren = getKids($child->ID);
                foreach ($grandChildren as $grandChild){
                    $postParentID = wp_get_post_parent_id($post);
                    $postParent = get_post($postParentID);
                    if ( ($child->ID == $postParentID) || ($child->ID == $post->ID)){
                        array_push($allPages,$grandChild);
                    }
                    //Check to see if you're at Root of this book
                    $pages = get_pages('child_of='.$post->ID.'&sort_column=post_date&sort_order=asc&parent='.$post->ID);
                    if ( $pages ) {
                        $first_page = current( $pages );
                        if ($first_page == $child){
                            array_push($allPages,$grandChild);
                        }
                    } 
                }
            }
        }
        $allPagesCount = count($allPages)-1;
        foreach ($allPages as $key=>$pageLink){
            if ($pageLink == $post){
                if ($key > 0){
                    $prev_link = get_permalink($allPages[$key-1]);
                    echo '<a class="next-prev" href="'.$prev_link.'"><i class="fas fa-chevron-left"></i></a>';
                }
                else{
                    echo '<i class="fas fa-chevron-left disabled-arrow next-prev"></i>';
                }
                if ($key < $allPagesCount){
                    $next_link = get_permalink($allPages[$key+1]);
                    echo '<a class="next-prev" href="'.$next_link.'"><i class="fas fa-chevron-right"></i></a>';
                }
                else{
                    echo '<i class="fas fa-chevron-right disabled-arrow next-prev"></i>';
                }
            }

        }
        ?>
        </div>
    </div>
    <div class="progress-container">
        <div class="progress" id="progress"></div>
    </div> 
</div>

