<?php
namespace BdWebNinja\WPHelper\Modules;
use BdWebNinja\WPHelper\OutputProcessors\TaxonomyOutputProcessor;

class Taxonomy {
    static function get_all_terms( $taxonomy, $hide_empty = true, $orderby = 'name', $order = 'desc', $return_type = WPHELPER_TAXONOMY_NAME ) {
        $_terms = get_terms( array(
            'hide_empty' => $hide_empty,
            'orderby'    => $orderby,
            'order'      => $order,
            'taxonomy'   => $taxonomy,
        ) );

        return TaxonomyOutputProcessor::category_output( $_terms, $return_type );
    }
}