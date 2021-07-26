<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>

<title>Readings in Learning Technology: <?php /*wp_title();*/ echo $post->post_title; ?>   |   Printed on <?php echo date('F jS, Y');  ?></title>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php 
	if ( is_front_page() ) :
		wp_enqueue_style( 'style', getcustomStylesheet('homepage') );
	else :
		
	endif;?>
	<!-- <link rel="stylesheet" id="print-css" href="<?php echo get_template_directory_uri();?>/css/print.css"  media="print"/> -->
	<link rel="stylesheet" id="bookSS-css" href="<?php echo get_template_directory_uri();?>/css/bookSS.css" media="all">
	<link rel="stylesheet" id="default-css" href="<?php echo get_template_directory_uri();?>/css/default.css" media="all">
	<link rel="stylesheet" id="fontawesome-css" href="<?php echo get_template_directory_uri();?>/css/fontawesome-all.css" media="all">
	<?php //wp_enqueue_style( 'style', getcustomStylesheet('bookSS') );
	wp_register_script( 'bookSS', get_template_directory_uri() . '/js/bookSS.js' );
	wp_enqueue_script( 'bookSS' );

	//Pass template URL over to the JS file
	$translation_array = array( 'templateUrl' => get_stylesheet_directory_uri() );
	wp_enqueue_style( 'style-switch', getcustomStylesheet('toggleswitch') ); 
	wp_enqueue_script( 'js-file', get_template_directory_uri() . '/js/bookSS.js'); 
	wp_localize_script( 'bookSS', 'bookSSURL', $translation_array );
	//wp_enqueue_style( 'style', getcustomStylesheet('bookSS') );//Load Custom Style Sheet
	?>
	<?php 
		$chromeless = sanitize_text_field( get_query_var( 'chromeless' ) );
		if( strtoupper( $chromeless) === 'TRUE' ){
		//echo "Loading with Chromeless CSS";
			//wp_enqueue_style( 'style', getcustomStylesheet('chromeless') );
			echo '<style>nav.left-toc{
				display:none !important;} .article-body{margin-top:0px !important;}.article-header{display:none !important;} .article{margin-left:0em !important;}
			</style>';
		}
		else{
			//echo "Loading with Regular CSS";
		}
	?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', '_s' ); ?></a>