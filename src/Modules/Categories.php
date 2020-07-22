<?php
namespace BdWebNinja\WPHelper\Modules;

use BdWebNinja\WPHelper\OutputProcessors\TaxonomyOutputProcessor;

class Categories {
    static function get_all_categories( $hide_empty = true, $orderby = 'name', $order = 'desc', $return_type = WPHELPER_TAXONOMY_NAME ) {
        $_categories = get_categories( array(
            'hide_empty' => $hide_empty,
            'orderby'    => $orderby,
            '$order'     => $order,
        ) );

        return TaxonomyOutputProcessor::category_output( $_categories, $return_type );
    }
    static function get_child_categories( $parent_category_id, $hide_empty = true, $orderby = 'name', $order = 'desc', $return_type = WPHELPER_TAXONOMY_NAME ) {
        $_categories = get_categories( array(
            'parent'     => $parent_category_id,
            'hide_empty' => $hide_empty,
            'orderby'    => $orderby,
            '$order'     => $order,
        ) );

        return TaxonomyOutputProcessor::category_output( $_categories, $return_type );
    }

    static function get_top_categories( $count = 0, $hide_empty = true, $return_type = WPHELPER_TAXONOMY_NAME ) {
        $_categories = get_categories( array(
            'hide_empty' => $hide_empty,
            'orderby'    => 'count',
            'order'      => 'desc',
            'number'     => $count,
        ) );

        return TaxonomyOutputProcessor::category_output( $_categories, $return_type );
    }

}