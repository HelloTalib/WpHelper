<?php
namespace BdWebNinja\WPHelper\OutputProcessors;

class ArbitraryProcessor {
    static function process( $template, $payload ) {
        return preg_replace_callback( '/%(\w+):(\w+):?([^%]+)?%/i', function ( $match ) use ( $payload ) {
            $escape_function = "esc_{$match[1]}";
            $tag = trim( $match[2] );
            $data = is_object( $payload ) ? $payload->$tag : $payload[$tag];
            $replaced_data = $escape_function( $data );
            return $replaced_data;
        }, $template );
    }
}