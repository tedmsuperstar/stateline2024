<?php
/**
 * Template Name: Home Template
 *
 * Template for Home Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package deals
 */



get_header();
$post_cache_key = "cached-post-".$post->ID;
global $query_string;
wp_parse_str( $query_string, $page_query );

$cached_post = wp_cache_get( $post_cache_key, "state-made");
if($cached_post && !isset($page_query["preview"])){
 	echo "<!-- displaying post $post_cache_key from cache-->";
	echo $cached_post;
} else {
	echo "<!-- displaying post $post_cache_key from db-->";
	
	ob_start();
	



 ?>
	
	<?php
		// Start the Loop.
		while ( have_posts() ) : the_post();
			/*
			 * Include the post format-specific template for the content. If you want to
			 * use this in a child theme, then include a file called called content-___.php
			 * (where ___ is the post format) and that will be used instead.
			 */
			get_template_part( 'parts/content-home', get_post_format() );	
		endwhile;
	?>
	<div class="clearfix"></div>
<?php 
	
	if(!isset($page_query["preview"])) {
		
		$post_to_cache = ob_get_contents();
		wp_cache_add( $post_cache_key, $post_to_cache, "state-made", 180);
		ob_end_flush();
		echo "<!-- stored post $post_cache_key to cache -->";
		
	} 
}
get_footer();
?>
