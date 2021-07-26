<?php 


/* ADD CUSTOM POST TYPES TO THEME */

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
		'hierachical' =>true,
		'menu_icon' => 'dashicons-book-alt',
		'public' => true,
		'has_archive' => true,
		'show_in_rest' => true,
		'supports' => array('title','editor','thumbnail'),
		'rewrite' => array('slug'=>'books'),
	);

	register_post_type('books',$args);
}
add_action('init','book_post_type');

/* Parts */
function part_post_type(){
	$args = array (
		'labels' =>array(
			'name' => 'Parts',
			'singular_name' => 'Part',
			'menu_name'           => 'Parts',
			'parent_item_colon'   => 'Parent Part',
			'all_items'           => 'All Parts',
			'view_item'           => 'View Part',
			'add_new_item'        => 'Add New Part',
			'add_new'             => 'Add New',
			'edit_item'           => 'Edit Part',
			'update_item'         => 'Update Part', 
			'search_items'        => 'Search Part',
		),
        "capability_type" => "page",
		'hierachical' =>true,
		'menu_icon' => 'dashicons-open-folder',
		'public' => true,
		'has_archive' => true,
		'show_in_rest' => true,
		'supports' => array('title','editor','thumbnail'),
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
		'hierachical' =>true,
		'menu_icon' => 'dashicons-text-page',
		'public' => true,
		'has_archive' => true,
		'show_in_rest' => true,
		'supports' => array('title','editor','thumbnail'),
		'rewrite' => array('slug'=>'chapters'),
	);

	register_post_type('chapters',$args);
}
add_action('init','chapter_post_type');



/**
 * Adds a box to "advanced" part on the Part edit screen.
 * - See the different screens defined in $screens array.
 */
function addMetaBoxToPart() {
   
    //$screens = array('part');
    //foreach ( $screens as $screen ) {
      add_meta_box(
        'book_select_box',         // HTML 'id' attribute of the edit screen section
        'Book Select',              // Title of the edit screen section, visible to user
        'showBookSelectMetaBox',    // Function that prints out the HTML for the edit screen section.
        //$screen  
        'parts',
        'side'                    // Which writing screen ('post','page','dashboard','link','attachment','custom_post_type','comment')
      );
  
    //}
  }
  add_action( 'add_meta_boxes', 'addMetaBoxToPart' );


  /**
 * Prints the box content.
 */

function showBookSelectMetaBox( $post, $box ) {
    // Add a nonce field so we can check for it later.
    //wp_nonce_field( 'selectedBook', 'book-selector-nonce' );
  
    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $value = get_post_meta( $post->ID, 'selectedBook', true );
    consolePrint('Selected Book Saved:'.$value);

    if ($value) {
      $selectedBook = json_decode($value, true);
    }
  
    // Get available parts so we can show them in select box
    $args = [
      'post_type' => 'books',
      'numberposts' => -1,
      'orderby' => 'id',
      'order' => 'ASC'
    ];
  
    $theBookQuery = new WP_Query($args);//Get's all the books
    if ( $theBookQuery->have_posts() ) {
        ?>
        <table>
          <tr>
            <td>
              <label for="book-selector">Select Book: </label>
            </td>
            <td>
              <select name="book-selector" id="book-selector" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">
              <?php while ( $theBookQuery->have_posts() ) {
                  $theBookQuery->the_post();?>
                  <option value="<?php the_ID() ?>"><?php the_title()?></option>
                <?php } ?>
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

  /**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */

function saveSelectedBook( $post_id) {
    global $post;
   	// verify nonce
       if ( !wp_verify_nonce( $_POST['book-selector'], basename(__FILE__) ) ) {
        return $post_id;
    }
    // check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }
    // check permissions
    if ( 'page' === $_POST['post_type'] ) {
        if ( !current_user_can( 'edit_page', $post_id ) ) {
            return $post_id;
        } elseif ( !current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
    }

    $old = get_post_meta( $post_id, 'selectedBook', true );
    consolePrint($old);
    $new = $_POST['selectedBook'];

    if ( $new && $new !== $old ) {
        update_post_meta( $post_id, 'selectedBook', $new );
    } elseif ( '' === $new && $old ) {
        delete_post_meta( $post_id, 'selectedBook', $old );
    }
  }
  add_action( 'save_post', 'saveSelectedBook');//, 10, 2 );

  //THIS WORKED
// add_action('save_post','save_post_callback');
// function save_post_callback($post_id){
//     global $post; 
//     if ($post->post_type != 'parts'){
//         return;
//     }
//     //if you get here then it's your post type so do your thing.
//     consolePrint('Woohoo!');
//     echo 'YES!';
// }
 
// Add the custom columns to the book post type:
add_filter( 'manage_parts_posts_columns', 'addColumnsToParts' );
function addColumnsToParts($columns) {
    unset( $columns['date'] );//Gets rid of this Column! YIKES!
    //$columns['book_author'] = __( 'Author', 'your_text_domain' );
    $columns['book_id'] = 'Book';//__( 'Book', 'your_text_domain' );

    return $columns;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_parts_posts_custom_column' , 'custom_parts_column', 10, 2 );
function custom_parts_column( $column, $post_id ) {
    switch ( $column ) {

        case 'book_author' :
            $terms = get_the_term_list( $post_id , 'book_author' , '' , ',' , '' );
            if ( is_string( $terms ) )
                echo $terms;
            else
                _e( 'Unable to get author(s)', 'your_text_domain' );
            break;

        case 'book_id' :
            $bookID = get_post_meta( $post_id , 'selectedBook' , true ); 
            echo get_post_field( 'post_title', $bookID);
            //echo 'Test Column!';
            consolePrint('POST META'.get_post_meta( $post_id , 'saveSelectedBook' , true));
            break;

    }
}


?>