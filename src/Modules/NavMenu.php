<?php

namespace BdWebNinja\WPHelper\Modules;

class NavMenu {
    static function set_li_class( $class = '', $location = 'primary' ) {
        add_filter( 'nav_menu_css_class', function ( $classes, $item, $args ) use ( $class, $location ) {
            if ( $args->theme_location == $location ) {
                $classes[] = $class;
            }
            return $classes;
        }, 1, 3 );
    }
    static function set_anchor_class( $class = '', $location = 'primary', $append = false ) {
        add_filter( 'nav_menu_link_attributes', function ( $atts, $item, $args ) use ( $class, $append, $location ) {
            if ( $args->theme_location == $location ) {
                if ( !$append ) {
                    $atts['class'] = $class;
                } else {
                    $atts['class'] .= " " . $class;
                }
            }
            return $atts;
        }, 10, 3 );
    }
}
