<?php

  function addPageMetaBox(){
    add_meta_box(//Must be in the below order
  'license_select_box',//ID for the Box
  'Select a License',//Title:what will show in the top of the box
  'licenseSelectMetaBoxCreator',//Callback: Method called that contains what's inside the box
  'page',//Screen - post types that this appears on
  'side',//where it appears 
  'high',//priority of where the box appears (high or low)
  null//Callback args: provides arguments to callback function
);
}
add_action('add_meta_boxes','addPageMetaBox');

function licenseSelectMetaBoxCreator($post){
    wp_nonce_field( 'licenseSelectMetaBox', 'licenseSelectMetaBox-nonce' );
    //wp_nonce_field(basename(__FILE__), "licenseSelectMetaBox-nonce");//nonce fields are required to protect against CSRF attacks
    $allBooks = getTopLevelPages();
    if (in_array($post, $allBooks)) {
        $value = get_post_meta( $post->ID, 'bookLicense', true );
        if ($value == null){
            $value = 'allrightsreserved';
            consolePrint('License for this book: '.$value);
        }
        else{
            consolePrint('License for this book: '.$value);
        }
        //Add metabox for CC Licenses
        $licenseArray = array(
            'allrightsreserved',
            'by',
            'by-sa',
            'by-nc',
            'by-nc-sa',
            'by-nd',
            'by-nc-nd',
            'cc-zero',
        );?>
        <table>
          <tr>
            <td>
            <p>Select a License for this Book: </p>
            </td>
            <?php
            foreach($licenseArray as $CCLicense){
            echo '<tr><td>';
            //consolePrint('Checking '.$CCLicense.' and '.$value);
            $isChecked = '';
            if(strcmp($CCLicense, $value) == 0)
            {
                $isChecked = 'checked';
            } 
            if ($CCLicense == 'allrightsreserved'){
                echo '<input type="radio" name="licenseSelector" value="'.$CCLicense.'" '.$isChecked.'>All Rights Reserved</input>';
            }
            else{
                $CCimage = get_template_directory_uri().'/inc/images/'.$CCLicense.'.png';
                $CCDescription = '<a target="_blank" href="https://creativecommons.org/licenses/'.$CCLicense.'/4.0/">CC '.strtoupper ($CCLicense).'</a>';
                $CCImageTag = '<img style="width:30%; height:auto;" src="'.$CCimage.'" />';
                echo '<input style="position: relative; bottom: 0.5em;" type="radio" name="licenseSelector" value="'.$CCLicense.'" '.$isChecked.'>'.$CCImageTag.' '.$CCDescription;
            }
            echo '</td></tr>';
        }?>
    
        </table>
      
     <?php 
    }
    else{
        echo('This is a subpage of a Book. To select a license go to a top-level page that serves as a book.');
        ?>
    <?php
    } 
    // Don't forget about this, otherwise you will mess up with other data on the page
    wp_reset_postdata();
  }

  function saveLicense( $post_id ) {
    // Check if our nonce is set.
    if ( !isset( $_POST['licenseSelectMetaBox-nonce'] ) ) {
            return;
    }
    // Verify that the nonce is valid.
    if ( !wp_verify_nonce( $_POST['licenseSelectMetaBox-nonce'], 'licenseSelectMetaBox' ) ) {
            return;
    }
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
    }
    // Check the user's permissions.
    if ( !current_user_can( 'edit_post', $post_id ) ) {
            return;
    }
    // Sanitize user input.
    $new_meta_value = ( isset( $_POST['licenseSelector'] ) ? sanitize_html_class( $_POST['licenseSelector'] ) : '' );
    // Update the meta field in the database.
    consolePrint('Saving '.$new_meta_value);
    update_post_meta( $post_id, 'bookLicense', $new_meta_value );

}
add_action( 'save_post', 'saveLicense' );


/* --------------- ADD CUSTOM COLUMNS TO PARTS --------------- */
add_filter( 'manage_page_posts_columns', 'addColumnsToParts' );
function addColumnsToParts($columns) {
    unset( $columns['author'] );//Gets rid of this Column! YIKES!
    unset( $columns['comments'] );//Gets rid of this Column! YIKES!
    $new = array();
  foreach($columns as $key => $title) {
    if ($key=='date') {// Put the Thumbnail column before the Author column
      $new['book_id'] = 'Book';
      $new['order'] = 'Order';
      $new['license'] = 'License';
    }
    $new[$key] = $title;
  }
  return $new;
}



// Add the data to the custom columns for the book post type:
    add_action( 'manage_page_posts_custom_column' , 'custom_page_column', 10, 2 );
    function custom_page_column( $column, $post_id ) {
        $allBooks = getTopLevelPages();
        $thePage = get_post($post_id);
            switch ( $column ) {
                case 'book_id' :
                    if (in_array($thePage, $allBooks)) {
                        //consolePrint($thePage->post_title.' is a root book.');
                        echo 'This is a Book';
                    }
                    else{
                        $bookID = get_post_meta( $post_id , 'pageBook' , true ); 
                        echo get_post_field( 'post_title', $bookID).' (id:'.$bookID.')';
                    }
                    break;
                  case 'order' :
                    $thisOrder = get_post($post_id);
                    echo $thisOrder->menu_order;
                    break;
                case 'license' :
                    if (in_array($thePage, $allBooks)) {
                        $CCLicense = get_post_meta( $post_id, 'bookLicense', true );
                        if ($CCLicense == 'allrightsreserved'){
                            echo 'All Rights Reserved &copy;'.the_modified_time('Y').'</p>';
                        }
                        else{
                            $CCLink = 'https://creativecommons.org/licenses/'.$CCLicense.'/4.0/';
                            $CCimage = '/inc/images/'.$CCLicense.'.png';
                            echo '<a target="_blank" href="'.$CCLink.'"><img style="height:30px; width:auto; padding-top:5px;" src="'.get_template_directory_uri().$CCimage.'"/></a>';
                        }
                        
                    }
                    break;
               
        
            }
    }

    /* --------------- ADD FILTER TO PAGES --------------- */
   
add_action( 'restrict_manage_posts', 'filterPageList' );
function filterPageList(){
    $type = 'page';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }

    //only add filter to post type you want
    if ('page' == $type){
        //get all the books
        $allBooks = get_posts([
          'post_type' => 'books',
          //'post_status' => 'publish',
          'numberposts' => -1,
          'order'    => 'ASC'
        ]);

        $allBooks = getTopLevelPages()
        ?>
        <select name="bookSelector">
        <option value=""><?php _e('All Books', 'wose45436'); ?></option>
        <?php
            $currentBook = isset($_GET['bookSelector'])? $_GET['bookSelector']:'';
            foreach ($allBooks as $thisBook) {
              $bookTitle = get_the_title($thisBook);
              $thisBookID = $thisBook->ID;
                printf
                    (
                        '<option value="%s"%s>%s</option>',
                        $thisBookID,
                        $thisBookID == $currentBook? ' selected="selected"':'',
                        $bookTitle
                    );
                }
        ?>
        </select>
        <?php
    }
}

function find_descendants($post_id) {
  $descendant_ids = array();
  array_push($descendant_ids, $post_id);//Add the main book to show that
  $pages = get_pages("child_of=$post_id");
  foreach ($pages as $page) { 
    consolePrint('Adding to array: '.$page->page_title);
    array_push($descendant_ids, $page->ID); }
  return $descendant_ids;
}

function SearchFilter($query) {
  global $pagenow;
  $type = 'page';
  if (isset($_GET['post_type'])) {
      $type = $_GET['post_type'];
  }
  if ( 'page' == $type && is_admin() 
      && $pagenow=='edit.php' 
      && isset($_GET['bookSelector']) 
      && $_GET['bookSelector'] != ''
      && $query->is_main_query()
      ) {
  if ($query->is_search) {
    $selectedBook = $_GET['bookSelector'];
    //consolePrint('The book:'.$selectedBook);
      $query->set ( 'post__in', find_descendants($selectedBook) );
  }
  }
  return $query;
}
add_filter('pre_get_posts','SearchFilter');


//Adds text above title
add_action( 'load-edit.php', function(){
    $screen = get_current_screen(); 
     // Only edit post screen:
    if( 'edit-page' === $screen->id )
    {
         // Before:
         add_action( 'all_admin_notices', function(){
             echo '<p>To make re-ordering pages easier, feel free to use a plugin like <a href="https://wordpress.org/plugins/simple-page-ordering/" target="_blank">Simple Page Ordering</a></strong>!</p>';
         });
 
         // After:
        //  add_action( 'in_admin_footer', function(){
        //      echo '<p>Goodbye from <strong>in_admin_footer</strong>!</p>';
        //  });
     }
 });
?>