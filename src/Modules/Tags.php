<?php
namespace BdWebNinja\WPHelper\Modules;

use BdWebNinja\WPHelper\OutputProcessors\TaxonomyOutputProcessor;

class Tags {
    static function get_all_tags( $hide_empty = true, $orderby = 'name', $order = 'desc', $return_type = WPHELPER_TAXONOMY_NAME ) {
        $_tags = get_tags( array(
            'hide_empty' => $hide_empty,
            'orderby'    => $orderby,
            '$order'     => $order,
        ) );

        return TaxonomyOutputProcessor::category_output( $_tags, $return_type );
    }
    
    static function get_top_tags( $count = 0, $hide_empty = true, $return_type = WPHELPER_TAXONOMY_NAME ) {
        $_tags = get_tags( array(
            'hide_empty' => $hide_empty,
            'orderby'    => 'count',
            'order'      => 'desc',
            'number'     => $count,
        ) );

        return TaxonomyOutputProcessor::category_output( $_tags, $return_type );
    }

}