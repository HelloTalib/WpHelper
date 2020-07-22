<?php
namespace BdWebNinja\WPHelper\OutputProcessors;
class TaxonomyOutputProcessor {
    public static function category_output( $resultset, $return_type = WPHELPER_TAXONOMY_NAME ) {
        $_categories = array();
        if ( is_array( $resultset ) ) {
            foreach ( $resultset as $result ) {
                if ( $return_type == WPHELPER_TAXONOMY_NAME ) {
                    $_categories[$result->term_id] = $result->name;
                } elseif ( $return_type == WPHELPER_TAXONOMY_LIST ) {
                    $_categories[$result->term_id] = sprintf( "<li>%s</li>", $result->name );
                } elseif ( $return_type == WPHELPER_TAXONOMY_LIST_LINK ) {
                    $_categories[$result->term_id] = sprintf( "<li><a href='%s'>%s</a></li>", get_term_link( $result->term_id ), $result->name );
                } elseif ( $return_type == WPHELPER_TAXONOMY_LINK ) {
                    $_categories[$result->term_id] = sprintf( "<a href='%s'>%s</a>", get_term_link( $result->term_id ), $result->name );
                } elseif ( $return_type == WPHELPER_TAXONOMY_OBJECT ) {
                    $_categories[$result->term_id] = $result;
                } elseif ( $return_type == WPHELPER_TAXONOMY_ARRAY ) {
                    $_categories[$result->term_id] = (array) $result;
                }
            }
        }
        return $_categories;
    }

    public static function single_category_output( $result, $return_type = WPHELPER_TAXONOMY_NAME ) {
        if ( $return_type == WPHELPER_TAXONOMY_NAME ) {
            return $result->name;
        } elseif ( $return_type == WPHELPER_TAXONOMY_LIST ) {
            return sprintf( "<li>%s</li>", $result->name );
        } elseif ( $return_type == WPHELPER_TAXONOMY_LIST_LINK ) {
            return sprintf( "<li><a href='%s'>%s</a></li>", get_term_link( $result->term_id ), $result->name );
        } elseif ( $return_type == WPHELPER_TAXONOMY_LINK ) {
            return sprintf( "<a href='%s'>%s</a>", get_term_link( $result->term_id ), $result->name );
        } elseif ( $return_type == WPHELPER_TAXONOMY_OBJECT ) {
            return (object) array(
                'term_id' => $result->term_id,
                'name'    => $result->name,
            );
        } elseif ( $return_type == WPHELPER_TAXONOMY_ARRAY ) {
            return array(
                'term_id' => $result->term_id,
                'name'    => $result->name,
            );
        }

    }
}