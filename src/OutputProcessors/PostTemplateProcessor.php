<?php
namespace BdWebNinja\WPHelper\OutputProcessors;
/**
 * @todo Escape Data
 */
use BdWebNinja\WPHelper\WPHelper;
use WP_User;

class PostTemplateProcessor {
    private static $instance;
    public static function getInstance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    private static $tags = array(
        'permalink',
        'title',
        'excerpt',
        'date',
        'author_name',
        'author_link',
        'thumbnail',
        'thumbnail_url',
        'author',
        'next_post_link',
        'previous_post_link',
    );

    private static $post_id;
    private static $post;

    public static function process( $template, $post_id = false ) {

        self::$post_id = $post_id ? $post_id : get_the_ID();
        self::$post = get_post( self::$post_id );

        return preg_replace_callback( '/%(\w+):(\w+):?([^%]+)?%/i', function ( $match ) {
            $escape_function = "esc_{$match[1]}";
            $tag = trim( $match[2] );
            if ( in_array( $tag, self::$tags ) ) {
                $params = isset( $match[3] ) ? explode( ":", $match[3] ) : array();
                $replaced_data = apply_filters( "wphelper_tag_{$tag}", $escape_function( self::$tag( ...$params ) ) );
                //$replaced_data = $escape_function( self::$tag( ...$params ) ) ;
                return $replaced_data;
            } else {
                return $match[0];
            }
        }, $template );

    }

    private static function title() {
        return get_the_title( self::$post_id );
    }

    private static function permalink() {
        return get_the_permalink( self::$post_id );
    }

    private static function excerpt() {
        return get_the_excerpt( self::$post_id );
    }

    private static function date( $format = 'M d, Y' ) {
        $date_format = apply_filters( 'post_template_date_format', $format );
        return get_the_date( $date_format, self::$post_id );
    }

    private static function author_name() {
        $author = get_the_author_meta( 'display_name', self::$post->post_author );
        return $author;
    }

    private static function author_link() {
        return get_author_posts_url( self::$post->post_author );
    }

    private static function thumbnail( $size = 'thumbnail' ) {
        return get_the_post_thumbnail( self::$post, $size );
    }

    private static function thumbnail_url( $size = 'thumbnail' ) {
        return get_the_post_thumbnail_url( self::$post, $size );
    }

    static function author( $property = 'display_name' ) {
        $author = new WP_User( self::$post->post_author );
        return $author->$property;
    }

    function next_post_link( $format = '%link &raquo;' ) {
        return get_next_post_link( $format );
    }

    function previous_post_link( $format = '%link &raquo;' ) {
        return get_previous_post_link( $format );
    }

}