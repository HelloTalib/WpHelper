<?php

namespace BdWebNinja\WPHelper;

use BdWebNinja\WPHelper\OutputProcessors\PostTemplateProcessor;

class WPHelper {

    private static $textdomain;
    private static function get_processors() {
        return array( PostTemplateProcessor::getInstance() );
    }
    static function dump( $data ) {
        echo "<pre>";
        print_r( $data );
        echo "</pre>";
    }

    static function set_current_post( $post_id ) {
        global $post;
        $post = get_post( $post_id );
    }

    static function reset_current_post() {
        wp_reset_postdata();
    }

    static function array_to_csv( $array, $field = '' ) {
        if ( !empty( $field ) ) {
            return join( ',', array_column( $array, $field ) );
        }
        return join( ',', $array );
    }

    static function get_template_part( $template, $post_id = false ) {
        ob_start();
        get_template_part( $template );
        $template_data = ob_get_clean();
        foreach ( self::get_processors() as $processor ) {
            $template_data = $processor::process( $template_data, $post_id );
        }
        echo $template_data;
    }

    public static function get_textdomain() {
        return self::$textdomain;
    }

    public static function set_textdomain( $textdomain ) {
        self::$textdomain = $textdomain;
    }
}