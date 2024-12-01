<?php
/**
 * Theme functions and definitions, wp queries etc
 *
 *
 * @package deals
 */


if( !defined( 'ABSPATH' ) )
		exit;

class ProductApi {


	static function getLists($requestData){

			$parameters = $requestData->get_params();


			$cache_key = "cached-product-lists-".hash('md5', json_encode($parameters));;
			$cached_json = wp_cache_get( $cache_key, "state-made");

			if($cached_json){
				return $cached_json;
			}

			header( "Access-Control-Allow-Origin: *" );

            $search_list_config = new stdClass();
            if(!empty($parameters["search"])){
                if($parameters["search"] != 'undefined'){
                    $search_list_config->name="Search: ".$parameters["search"];
                    $search_list_config->query = new WP_Query( [
                        'post_type' => 'product',
                        'posts_per_page' => 20,
                        's' => $parameters["search"],
                        'relevanssi' => true,
                    ]);
                }
            }
            $location_list_config = new stdClass();
            if(!empty($parameters["location_abbreviation"])){
                $location_list_config->name="Latest Local Items";
                $location_list_config->query = new WP_Query([
                    'post_type' => 'product',
                    'meta_key' => 'location_abbreviation',
                    'meta_value' => $parameters["location_abbreviation"],
                    'meta_compare' => '=', // Use '=' to compare exact values
                    'posts_per_page' => 20, // Use -1 to retrieve all matching posts, or set a specific number
                    'order' => 'DESC',
                    'orderby' => 'ID',
                ]);
            }

            //TODO: make queries configurable from CMS
            //TODO: cache the query responses where it makes sense
            $new_arrivals_config = new stdClass();
            $new_arrivals_config->name = "New Arrivals";
            $new_arrivals_config->query =new WP_Query([
                'post_type' => 'product',
                'order' => 'ASC',
                'orderby' => 'title',
				'posts_per_page' => 20, 
            ]);

            $just_for_you_config = new stdClass();
            $just_for_you_config->name = "Just For You";
            $just_for_you_config->query =new WP_Query([
                'post_type' => 'product',
                'order' => 'ASC',
                'orderby' => 'ID',
				'posts_per_page' => 20, 
            ]);

            $explore_config = new stdClass();
            $explore_config->name = "Explore";
            $explore_config->query =new WP_Query([
                'post_type' => 'product',
                'order' => 'DESC',
                'orderby' => 'ID',
				'posts_per_page' => 20, 
            ]);


            //return value
            $lists = array();
        
            $requested_lists = array();

            // state query if we're on a state apge
            if(!empty($parameters["location_abbreviation"])){
                array_push($requested_lists,"location_list");
            }

            // state query if we're on a state apge
            if(!empty($parameters["search"])){
                if($parameters["search"] != 'undefined'){
                    array_push($requested_lists,"search_list");
                }
            }
            
            $listNames = "";
            //add the lists from request parameters
          
            $available_lists = array("location_list"=>$location_list_config,"search_list"=>$search_list_config,"new_arrivals"=>$new_arrivals_config, "just_for_you"=>$just_for_you_config,"explore"=>$explore_config);
            if(!empty($parameters["lists"])){
                $requested_lists = array_merge($requested_lists,explode(",",$parameters["lists"]));
            }
                foreach ($requested_lists as $key => $requested_list) {
                    $query = $available_lists[$requested_list]->query;
                    $posts = $query->get_posts();
                    $listJson = self::getListJson($posts, $available_lists[$requested_list]->name);
                    array_push($lists, $listJson);
                }
            //}
            



            wp_cache_add( $cache_key, array("lists"=>$lists), "state-made", 300);
            $date = new DateTimeImmutable();
            return array("lists"=>$lists,"cached"=>$date->getTimestamp(),"listNames"=>$listNames,"requested"=>$requested_lists,"search_list_config"=>$search_list_config);

		//return array("error"=>"That doesn't exist");

	}

    private static function getListJson($posts, $name) {
        $items = [];
        foreach ($posts as $post) {
            $item = new stdClass();
            $item->post = $post;
            $item->wp_id = $post->ID;
            $item->name = get_field('name',$post->ID);
            $item->url = get_field('url',$post->ID);
            $item->display_price = get_field('display_price',$post->ID);
            $item->display_location = get_field('display_location',$post->ID);
            $item->location_abbreviation = get_field('location_abbreviation',$post->ID);
            $item->image1x = get_field('image1x',$post->ID);
            $item->image2x = get_field('image2x',$post->ID);
            $item->post_url = get_permalink($post->ID);
            array_push($items,$item);
        }
        
        $list = new stdClass();
        $list->products = $items;
        $list->name = $name;

        return $list;
    }

    static function upsertProduct ($requestData){
        $parameters = $requestData->get_params();
        $product = $parameters["product"];
        $existingProductQuery = new WP_Query([
            'post_type' => 'product',
            'meta_key' => 'third_party_id',
            'meta_value' => $product['third_party_id'],
            'meta_compare' => '=', // Use '=' to compare exact values
            'posts_per_page' => 1, // Use -1 to retrieve all matching posts, or set a specific number
        ]);

        $posts = $existingProductQuery->get_posts();
        $action = "none";
        $postId = 0;
        $success = false;
        if(!empty($posts[0])){
            //update
            $postId = $posts[0]->ID;
            $action = "update";
            foreach($product as $property => $value)
                {
                    update_field($property,$value,$postId);
                }
                $success = true;
        } else{
            //insert
            $action = "insert";
            $newProduct = array(
                'post_title'    => wp_strip_all_tags( $product["name"] ),
                'post_status'   => 'publish',
                'post_author'   => 1,
                'post_type' => 'product'
                );
                
                // Insert the post into the database
               $postId = wp_insert_post( $newProduct );
               if(!empty($newPostId)){
                
               }

               foreach($product as $property => $value)
                {
                    update_field($property,$value,$postId);
                }$success = true;
              
        }

        return array("success"=>$success,"product_posted"=>$product,"action"=>$action, "post_id"=>$postId);
    }
}



add_action( 'rest_api_init', function () {
	register_rest_route( 'state-made/v1', '/product/lists', array(
	    'methods' => array('GET'),
	    'callback' => 'ProductApi::getLists',
        'permission_callback' =>  function () {
            return true;
          }

  ) );
  register_rest_route( 'state-made/v1', '/product', array(
    'methods' => array('POST'),
    'callback' => 'ProductApi::upsertProduct',
    'permission_callback' =>  function () {
        return current_user_can( 'edit_posts' );
      }

) );
} );


