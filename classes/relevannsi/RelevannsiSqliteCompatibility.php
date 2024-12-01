<?php


 
if( !defined( 'ABSPATH' ) )
		exit;

/**
 * Converts Relavannsi's SQL for use with SQLite
 *
 *
 * @package state-made
 */

class RelavannsiSqliteCompatibility {



	public static function handle_relevanssi_queries($values, $post ){

        // Regular expression to match REVERSE() function with the string argument
        $pattern = '/REVERSE\((\'[^\']+\')\)/';
    
        // Callback function to reverse the string inside the REVERSE() function
        $callback = function($matches) {
            // $matches[1] contains the string inside the REVERSE() function (e.g., 'ideas')
            $string_to_reverse = trim($matches[1], "'"); // Remove the surrounding quotes
            $reversed_string = strrev($string_to_reverse); // Reverse the string
            return "'" . $reversed_string . "'"; // Return the reversed string in quotes
        };
    
        // Perform the replacement using the pattern and callback
        $values = preg_replace_callback($pattern, $callback, $values);
        error_log("handle_relevanssi_indexing_values".json_encode($values));
    
        return $values;
    }

}

add_filter('relevanssi_indexing_values', 'RelavannsiSqliteCompatibility::handle_relevanssi_queries', 10, 2);
add_filter('relevanssi_fuzzy_query', 'RelavannsiSqliteCompatibility::handle_relevanssi_queries', 10, 2);