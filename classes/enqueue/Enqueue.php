<?php
/**
 * Theme functions and definitions, wp queries etc
 *
 *
 * @package enqueue
 */


if( !defined( 'ABSPATH' ) )
		exit;

//see also /templatesTemplateName.php for enqueueing for specific templates.
class Enqueue {

	

	public static function enqueue(){
		Enqueue::enqueueScripts();
		Enqueue::enqueueStyles();
	}

	public static function adminEnqueue(){
		Enqueue::adminEnqueueScripts();
	}

	public static function enqueueScripts(){
		if (!is_admin()) {
			wp_deregister_script('jquery');
			wp_deregister_script('jquery-core-js');
			wp_deregister_script('jquery-migrate-js');
		}
	}

	public static function adminEnqueueScripts(){
		wp_enqueue_script( 'products-importer',get_template_directory_uri() .'/assets/js/admin/productsUpdater.js', array(), '1.0' );
	}

	public static function addPageConfigJsonToHead(){
		global $post;
		if(!empty($post)){
			$pageConfig = new stdClass();
			$pageConfig->location_abbreviation = get_field("location_abbreviation") ?: '';
			$pageConfig->page_template = basename(get_page_template()) ?: '';
			if(basename(get_page_template()) != 'single-listicle.php'){
				$pageConfig->lists= ["new_arrivals", "just_for_you","explore"];
			}
			$output = json_encode( $pageConfig, JSON_UNESCAPED_SLASHES );
			?>
				<script id="page-config" type="application/ld+json">
				<?= $output; ?>
				</script>

			<?php
		}
		
	}

	public static function enqueueStyles(){

		//remove the css for gutenberg blocks
		wp_dequeue_style( 'wp-block-library' );
		//we are not a classic theme
		wp_dequeue_style( 'classic-theme-styles');

		
		// empty css
		wp_dequeue_style( 'reactpress-css');

		//add our main stylesheet
		wp_enqueue_style( 'state-made-theme-style', get_stylesheet_uri(), array(), STATE_MADE_RELEASE_STRING );  
		

	}



}

add_action( 'wp_enqueue_scripts', 'Enqueue::enqueue',999 );
add_action( 'wp_head', 'Enqueue::addPageConfigJsonToHead' );
add_action( 'admin_enqueue_scripts', 'Enqueue::adminEnqueue' );