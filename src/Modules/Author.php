<?php
namespace BdWebNinja\WPHelper\Modules;

use WP_User;

class Author {
    public static function get_author_posts_url( $author_id, $css_class = '' ) {
        $author = new WP_User( $author_id );
        $author->display_name = apply_filters( 'the_author', $author->display_name );
        $link = sprintf(
            '<a class="%4$s" href="%1$s" title="%2$s" rel="author">%3$s</a>',
            esc_url( get_author_posts_url( $author->ID, $author->user_nicename ) ),
            /* translators: %s: Author's display name. */
            esc_attr( sprintf( __( 'Posts by %s' ), $author->display_name ) ),
            $author->display_name,
            $css_class
        );
        return apply_filters( 'the_author_posts_link', $link );
    }
}