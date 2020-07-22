<?php 
function esc_noescape($data){
    return wp_kses_post($data);
}

function esc_kses($data){
    return wp_filter_post_kses($data);
}