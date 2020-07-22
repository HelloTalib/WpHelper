<?php

namespace BdWebNinja\WPHelper\Modules;

use WP_Query;

class CustomPosts extends Posts {

    private static $post_type;

    static function set_post_type( $post_type ) {
        self::$post_type = $post_type;
    }

    protected static function get_posts( $wp_query, $return_type = WPHELPER_POSTS_FETCH_OBJECT ) {
        $_new_args = array_merge( $wp_query->query_vars, array('post_type' => self::$post_type) );
        $wp_query= new WP_Query($_new_args);
        return parent::get_posts($wp_query, $return_type);
    }

}
