<?php
/**
 * Register the 'Product' post type and associated ACF fields.
 */

namespace Statemade\Classes\PostTypes;

defined( 'ABSPATH' ) || die();

class Product {

	public static function register()
	{
		add_action( 'init', [ __CLASS__, 'registerProductPostType' ] );

	}


	public static function registerProductPostType()
	{

		$labels = array(
			'name' => _x('Products', 'post type general name'),
			'singular_name' => _x('Product', 'post type singular name'),
			'add_new' => _x('Add New', 'product'),
			'add_new_item' => __('Add New product'),
			'edit_item' => __('Edit product'),
			'new_item' => __('New product'),
			'view_item' => __('View product'),
			'search_items' => __('Search product'),
			'not_found' =>  __('Nothing found'),
			'not_found_in_trash' => __('Nothing found in Trash'),
			'parent_item_colon' => ''
		);

		$args = array(
			'labels' => $labels,
			'public' => true,

			'publicly_queryable' => true,
			'show_in_rest' => true,
			'show_ui' => true,
			'query_var' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'supports' => array('title','thumbnail','author','editor','revisions','excerpt'),
			'menu_position' => null,
			'taxonomies'  => array('category','post_tag'),
			'has_archive' => true,
			'rewrite' => array(
				'slug' => '/product',
				'with_front' =>false
			),
		);

		register_post_type( 'product' , $args );
	}


}

Product::register();