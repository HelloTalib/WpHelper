<?php

namespace BdWebNinja\WPHelper\Modules;
use BdWebNinja\WPHelper\OutputProcessors\TaxonomyOutputProcessor;

class SinglePost {

    private static function get_post_id( $post_id = null ) {
        global $post;
        if ( is_null( $post_id ) ) {
            return $post->ID;
        }

        return $post_id;
    }

    static function meta( $post_id = null, $key = 'key', $default = '' ) {
        $post_id = self::get_post_id( $post_id );
        echo self::get_meta( $key, $default );
    }

    static function get_meta( $post_id = null, $key = 'key', $default = '' ) {
        $post_id = self::get_post_id( $post_id );
        $_meta_value = get_post_meta( $post_id, $key, true );

        return $_meta_value ? $_meta_value : $default;
    }

    static function get_categories( $post_id = null, $count = 0, $return_type = WPHELPER_TAXONOMY_NAME ) {
        $post_id = self::get_post_id( $post_id );
        $_categories = wp_get_post_categories( $post_id, array( 'fields' => 'all', 'number' => $count ) );

        return TaxonomyOutputProcessor::category_output( $_categories, $return_type );
    }

    static function get_terms( $taxonomy, $post_id = null, $count = 0, $return_type = WPHELPER_TAXONOMY_NAME ) {
        $post_id = self::get_post_id( $post_id );
        $_terms= get_the_terms($post_id,$taxonomy);
        return TaxonomyOutputProcessor::category_output( $_terms, $return_type );
    }

    static function get_tags( $post_id = null, $return_type = WPHELPER_TAXONOMY_NAME ) {
        $post_id = self::get_post_id( $post_id );
        $_tags = get_the_tags( $post_id );

        return TaxonomyOutputProcessor::category_output( $_tags, $return_type );
    }

    static function get_single_category( $post_id = null, $return_type = WPHELPER_TAXONOMY_NAME ) {
        $post_id = self::get_post_id( $post_id );
        $_categories = wp_get_post_categories( $post_id, array( 'fields' => 'all' ) );
        $_single_category = array_shift( $_categories );

        return TaxonomyOutputProcessor::single_category_output( $_single_category, $return_type );
    }

    static function get_single_tag( $post_id = null, $return_type = WPHELPER_TAXONOMY_NAME ) {
        $post_id = self::get_post_id( $post_id );
        $_tags = get_the_tags( $post_id );
        $_single_tag = array_shift( $_tags );

        return TaxonomyOutputProcessor::single_category_output( $_single_tag, $return_type );
    }

    static function get_author_name( $post_id = null ) {
        $post_id = self::get_post_id( $post_id );
        $_post = get_post( $post_id );
        $_author_id = $_post->post_author;
        $_author_name = get_the_author_meta( 'display_name', $_author_id );
        return $_author_name;
    }
}
