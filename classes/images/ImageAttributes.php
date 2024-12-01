<?php


 
if( !defined( 'ABSPATH' ) )
		exit;

/**
 * Custom HTML/attributes for images
 *
 *
 * @package state-made
 */

class ImageAttributes {



	public static function handleThumbnailHtml( $html, $post_id, $post_image_id ) {
        $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
        $html = preg_replace( "/<img /", "<img loading='lazy'", $html );
        return $html;
    }

}

add_filter( 'post_thumbnail_html', 'ImageAttributes::handleThumbnailHtml', 10, 3 );
