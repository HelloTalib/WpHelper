<?php

namespace BdWebNinja\WPHelper\Modules;

use WP_Query;

class Posts {
    private static $offset = 0;
    public static function set_offset( $offset = 0 ) {
        self::$offset = $offset;
    }
    protected static function get_posts( $wp_query, $return_type = WPHELPER_POSTS_FETCH_OBJECT ) {
        $_posts = array();
        $post_query = $wp_query;
        while ( $post_query->have_posts() ) {
            $post_query->the_post();
            if ( $return_type == WPHELPER_POSTS_FETCH_OBJECT ) {
                $_posts[get_the_ID()] = get_post();
            } elseif ( $return_type == WPHELPER_POSTS_FETCH_ARRAY ) {
                $_posts[get_the_ID()] = (array) get_post();
            } elseif ( $return_type == WPHELPER_POSTS_FETCH_ID_AND_TITLE ) {
                $_posts[get_the_ID()] = get_the_title();
            }
        }
        wp_reset_query();
        return $_posts;
    }
    public static function get_latest_posts( $count = 10, $order = 'desc', $excluded_post_ids = array(), $return_type = WPHELPER_POSTS_FETCH_OBJECT ) {
        $_posts = array();
        $post_query = new WP_Query( array(
            'posts_per_page' => $count,
            'order'          => $order,
            'offset'         => self::$offset,
            'post__not_in'   => $excluded_post_ids,
        ) );
        $_posts = static::get_posts( $post_query, $return_type );
        return $_posts;
    }

    public static function get_posts_by_meta( $meta_key, $meta_value, $meta_compare = '=', $excluded_post_ids = array(), $order = WPHELPER_POSTS_ORDER_ASC, $return_type = WPHELPER_POSTS_FETCH_OBJECT ) {
        $_posts = array();
        $post_query = new WP_Query( array(
            'meta_key'     => $meta_key,
            'meta_value'   => $meta_value,
            'meta_compare' => $meta_compare,
            'order'        => $order,
            'post__not_in' => $excluded_post_ids,
            'offset'       => self::$offset,
        ) );
        $_posts = static::get_posts( $post_query, $return_type );
        return $_posts;
    }

    public static function get_posts_by_multiple_meta( $meta = array(), $excluded_post_ids = array(), $order = WPHELPER_POSTS_ORDER_ASC, $return_type = WPHELPER_POSTS_FETCH_OBJECT ) {
        $_posts = array();
        $post_query = new WP_Query( array(
            'meta_query'   => array( $meta ),
            'meta_value'   => 'on',
            'meta_compare' => '!=',
            'order'        => $order,
            'post__not_in' => $excluded_post_ids,
            'offset'       => self::$offset,
        ) );
        $_posts = static::get_posts( $post_query, $return_type );
        return $_posts;
    }

    public static function get_posts_by_ids( $post_ids = array(), $skip_sticky = 1, $return_type = WPHELPER_POSTS_FETCH_OBJECT ) {
        $_posts = array();
        $post_query = new WP_Query( array(
            'post__in'            => $post_ids,
            'ignore_sticky_posts' => $skip_sticky,
            'orderby'             => 'post__in',
        ) );
        $_posts = static::get_posts( $post_query, $return_type );
        return $_posts;
    }

    public static function get_posts_by_category_name( $category_name, $count = 10, $order = 'desc', $excluded_post_ids = array(), $return_type = WPHELPER_POSTS_FETCH_OBJECT ) {
        $_posts = array();
        $post_query = new WP_Query( array(
            'posts_per_page' => $count,
            'order'          => $order,
            'category_name'  => $category_name,
            'offset'         => self::$offset,
            'post__not_in'   => $excluded_post_ids,
        ) );
        $_posts = static::get_posts( $post_query, $return_type );
        return $_posts;
    }

    public static function get_posts_by_category_names( $category_names, $count = 10, $order = 'desc', $excluded_post_ids = array(), $return_type = WPHELPER_POSTS_FETCH_OBJECT ) {
        $_posts = array();
        $post_query = new WP_Query( array(
            'posts_per_page' => $count,
            'order'          => $order,
            'category_name'  => join( ',', $category_names ),
            'offset'         => self::$offset,
            'post__not_in'   => $excluded_post_ids,
        ) );
        $_posts = static::get_posts( $post_query, $return_type );
        return $_posts;
    }

    public static function get_posts_by_category_id( $category_id, $count = 10, $order = 'desc', $excluded_post_ids = array(), $return_type = WPHELPER_POSTS_FETCH_OBJECT ) {
        $_posts = array();
        $post_query = new WP_Query( array(
            'posts_per_page' => $count,
            'order'          => $order,
            'cat'            => $category_id,
            'offset'         => self::$offset,
            'post__not_in'   => $excluded_post_ids,
        ) );
        $_posts = static::get_posts( $post_query, $return_type );
        return $_posts;
    }

    public static function get_posts_by_category_ids( $category_ids, $count = 10, $order = 'desc', $excluded_post_ids = array(), $return_type = WPHELPER_POSTS_FETCH_OBJECT ) {
        $_posts = array();
        $post_query = new WP_Query( array(
            'posts_per_page' => $count,
            'order'          => $order,
            'cat'            => join( ',', $category_ids ),
            'offset'         => self::$offset,
            'post__not_in'   => $excluded_post_ids,
        ) );
        $_posts = static::get_posts( $post_query, $return_type );
        return $_posts;
    }

    public static function get_posts_by_tag_name( $tag_name, $count = 10, $order = 'desc', $excluded_post_ids = array(), $return_type = WPHELPER_POSTS_FETCH_OBJECT ) {
        $_posts = array();
        $post_query = new WP_Query( array(
            'posts_per_page' => $count,
            'order'          => $order,
            'tag'            => $tag_name,
            'offset'         => self::$offset,
            'post__not_in'   => $excluded_post_ids,
        ) );
        $_posts = static::get_posts( $post_query, $return_type );
        return $_posts;
    }

    public static function get_posts_by_tag_names( $tag_names, $count = 10, $order = 'desc', $excluded_post_ids = array(), $return_type = WPHELPER_POSTS_FETCH_OBJECT ) {
        $_posts = array();
        $post_query = new WP_Query( array(
            'posts_per_page' => $count,
            'order'          => $order,
            'tag'            => join( ',', $tag_names ),
            'offset'         => self::$offset,
            'post__not_in'   => $excluded_post_ids,
        ) );
        $_posts = static::get_posts( $post_query, $return_type );
        return $_posts;
    }

    public static function get_posts_by_tag_id( $tag_id, $count = 10, $order = 'desc', $excluded_post_ids = array(), $return_type = WPHELPER_POSTS_FETCH_OBJECT ) {
        $_posts = array();
        $post_query = new WP_Query( array(
            'posts_per_page' => $count,
            'order'          => $order,
            'tag_id'         => $tag_id,
            'offset'         => self::$offset,
            'post__not_in'   => $excluded_post_ids,
        ) );
        $_posts = static::get_posts( $post_query, $return_type );
        return $_posts;
    }

    public static function get_posts_by_tag_ids( $tag_ids, $count = 10, $order = 'desc', $excluded_post_ids = array(), $return_type = WPHELPER_POSTS_FETCH_OBJECT ) {
        $_posts = array();
        $post_query = new WP_Query( array(
            'posts_per_page' => $count,
            'order'          => $order,
            'tag__in'        => join( ',', $tag_ids ),
            'offset'         => self::$offset,
            'post__not_in'   => $excluded_post_ids,
        ) );
        $_posts = static::get_posts( $post_query, $return_type );
        return $_posts;
    }

}
