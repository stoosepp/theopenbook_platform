<?php 


/* ---------------ADD CUSTOM POST TYPES TO THEME--------------- */

/* Books */
function book_post_type(){
	$args = array (
		'labels' =>array(
			'name' => 'Books',
			'singular_name' => 'Book',
			'menu_name'           => 'Books',
			'parent_item_colon'   => 'Parent Book',
			'all_items'           => 'All Books',
			'view_item'           => 'View Book',
			'add_new_item'        => 'Add New Book',
			'add_new'             => 'Add New',
			'edit_item'           => 'Edit Book',
			'update_item'         => 'Update Book', 
			'search_items'        => 'Search Book',
		),
        "capability_type" => "page",
		'hierarchical' =>true,
		'menu_icon' => 'dashicons-book-alt',
		'public' => true,
		'has_archive' => true,
		'show_in_rest' => true,
		'supports' => array('title','editor','thumbnail', 'page-attributes'),
		'rewrite' => array('slug'=>'books'),
    
	);

	register_post_type('books',$args);
}
add_action('init','book_post_type');

/* Parts */
function part_post_type(){
	$args = array (
		'labels' =>array(
			'name' => 'Parts & Chapters',
			'singular_name' => 'Part',
			'menu_name'           => 'Parts & Chapters',
			'parent_item_colon'   => 'Parent Part',
			'all_items'           => 'All Parts',
			'view_item'           => 'View Part',
			'add_new_item'        => 'Add New Part',
			'add_new'             => 'Add New Part',
			'edit_item'           => 'Edit Part',
			'update_item'         => 'Update Part', 
			'search_items'        => 'Search Part',
      'parent'              => 'Parent mytest Interview',
		),
    'hierarchical' =>true,
    'supports' => array('title','editor','thumbnail', 'page-attributes','revisions','custom-fields'),
    'capability_type' => 'page',
		
		'menu_icon' => 'dashicons-open-folder',
		'public' => true,
		'has_archive' => true,
		'show_in_rest' => true,
    
		'rewrite' => array('slug'=>'parts'),
   
	);

	register_post_type('parts',$args);
}
add_action('init','part_post_type');

/* Chapter */
function chapter_post_type(){
	$args = array (
		'labels' =>array(
			'name' => 'Chapters',
			'singular_name' => 'Chapter',
			'menu_name'           => 'Chapters',
			'parent_item_colon'   => 'Parent Chapter',
			'all_items'           => 'All Chapters',
			'view_item'           => 'View Chapter',
			'add_new_item'        => 'Add New Chapter',
			'add_new'             => 'Add New',
			'edit_item'           => 'Edit Chapter',
			'update_item'         => 'Update Chapter', 
			'search_items'        => 'Search Chapter',
		),
		'hierarchical' =>true,
		'menu_icon' => 'dashicons-text-page',
		'public' => true,
		'has_archive' => true,
		'show_in_rest' => true,
		'supports' => array('title','editor','thumbnail', 'page-attributes','revisions','custom-fields'),
		'rewrite' => array('slug'=>'chapters'),
    'show_ui'              => true,
    'show_in_menu'         => 'edit.php?post_type=parts',
	);

	register_post_type('chapters',$args);
}
add_action('init','chapter_post_type');


/* ---------------ADD META BOXES--------------- */


function bookSelectMetaBoxCreator($post){
  wp_nonce_field(basename(__FILE__), "bookSelectMetaBox-nonce");//nonce fields are required to protect against CSRF attacks
  $allBooks = get_posts([
    'post_type' => 'books',
    'post_status' => 'publish',
    'numberposts' => -1,
    'order'    => 'ASC'
  ]);

  if ($allBooks) {
      ?>
      <table>
        <tr>
          <td>
            <label for="bookSelectorDropdown">Select Book: </label>
          </td>
          <td>
            <select name="bookSelectorDropdown" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">
            <?php foreach($allBooks as $thisBook){
              $bookTitle = get_the_title($thisBook);
              $thisBookID = $thisBook->ID;
                $savedBookID = get_post_meta( $post->ID, 'partsBook', true );
                //consolePrint('Saved Book ID: '.$savedBookID.'  |  The ID of this book: '.$thisBookID);
                    if ($savedBookID){//If there's something saved
                      if ($savedBookID == $thisBookID){
                        ?><option selected value="<?php echo $thisBookID?>"><?php echo $bookTitle?></option><?php
                       }
                       else{
                        ?><option value="<?php echo $thisBookID?>"><?php echo $bookTitle?></option><?php
                      }
                    } 
                    else{
                      ?><option value="<?php echo $thisBookID?>"><?php echo $bookTitle?></option><?php
                    }
              } ?>
            </select>
          </td>
        </tr>
      </table><?php
}
  else{
      echo '<p>There are no books. Add one!</p>';
  }
  // Don't forget about this, otherwise you will mess up with other data on the page
  wp_reset_postdata();
}

function addPartMetaBox(){
  add_meta_box(//Must be in the below order
    'book_select_box',//ID for the Box
    'Book Select',//Title:what will show in the top of the box
    'bookSelectMetaBoxCreator',//Callback: Method called that contains what's inside the box
    'parts',//Screen - post types that this appears on
    'side',//where it appears 
    'high',//priority of where the box appears (high or low)
    null//Callback args: provides arguments to callback function
  );
}
add_action('add_meta_boxes','addPartMetaBox');


function saveBooktoPart($post_id,$post,$update){
  if (!isset($_POST["bookSelectMetaBox-nonce"]) || !wp_verify_nonce($_POST["bookSelectMetaBox-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "parts";
    if($slug != $post->post_type)//make sure this is the right post type
        return $post_id;
    
    $bookSelectDropdownValue = "";
    if(isset($_POST["bookSelectorDropdown"]))
    {
        $meta_box_dropdown_value = $_POST["bookSelectorDropdown"];
    }   
    update_post_meta($post_id, "partsBook", $meta_box_dropdown_value);

}
add_action("save_post", "saveBooktoPart", 10, 3);



/* --------------- ADD CUSTOM COLUMNS TO PARTS --------------- */
add_filter( 'manage_parts_posts_columns', 'addColumnsToParts' );
function addColumnsToParts($columns) {
    //unset( $columns['date'] );//Gets rid of this Column! YIKES!
    $new = array();
  foreach($columns as $key => $title) {
    
    if ($key=='date') {// Put the Thumbnail column before the Author column
      $new['book_id'] = 'Book';
      $new['order'] = 'Order';
    }
    $new[$key] = $title;
  }
  return $new;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_parts_posts_custom_column' , 'custom_parts_column', 10, 2 );
function custom_parts_column( $column, $post_id ) {
    switch ( $column ) {
        case 'book_id' :
            $bookID = get_post_meta( $post_id , 'partsBook' , true ); 
            echo get_post_field( 'post_title', $bookID);
            break;
          case 'order' :
            $thisOrder = get_post($post_id);
            echo $thisOrder->menu_order;
            break;

    }
}


/* --------------- ADD FILTER TO PARTS --------------- */
add_action( 'restrict_manage_posts', 'filterPartsList' );

function filterPartsList(){
    $type = 'parts';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }

    //only add filter to post type you want
    if ('parts' == $type){
        //get all the books
        $allBooks = get_posts([
          'post_type' => 'books',
          'post_status' => 'publish',
          'numberposts' => -1,
          'order'    => 'ASC'
        ]);

        $allBooks = getTopLevelPages()
        ?>
        <select name="bookSelector">
        <option value=""><?php _e('Filter By Book', 'wose45436'); ?></option>
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
add_filter( 'parse_query', 'partsFilter' );

function partsFilter( $query ){
    global $pagenow;
    $type = 'parts';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }
    if ( 'parts' == $type && is_admin() 
        && $pagenow=='edit.php' 
        && isset($_GET['bookSelector']) 
        && $_GET['bookSelector'] != ''
        && $query->is_main_query()
        ) {
        $query->query_vars['meta_key'] = 'partsBook';
        $query->query_vars['meta_value'] = $_GET['bookSelector'];
    }
}

?>