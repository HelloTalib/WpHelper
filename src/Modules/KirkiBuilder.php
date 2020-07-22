<?php
namespace BdWebNinja\WPHelper\Modules;

use BdWebNinja\WPHelper\Modules\Categories;
use BdWebNinja\WPHelper\WPHelper;

class KirkiBuilder {

    private static $theme_config;

    static function set_theme_config( $theme_config ) {
        self::$theme_config = $theme_config;
    }

    static function get_theme_config() {
        return self::$theme_config;
    }

    static function initialize( $theme_config, $capability = 'edit_theme_options', $option_type = 'theme_mod' ) {
        \Kirki::add_config( $theme_config, array(
            'capability'  => $capability,
            'option_type' => $option_type,
        ) );
        self::set_theme_config( $theme_config );
    }

    static function add_panel( $panel_id, $title, $description = '', $priority = 10, $active_callback = null ) {
        if ( class_exists( 'Kirki' ) ) {
            $textdomain = WPHelper::get_textdomain();
            $config = array(
                'priority'    => $priority,
                'title'       => esc_html__( $title, $textdomain ),
                'description' => esc_html__( $description, $textdomain ),
            );
            if ( $active_callback ) {
                $config['active_callback'] = $active_callback;
            }
            \Kirki::add_panel( $panel_id, $config );
        }
    }

    static function add_section( $section_id, $panel_id, $title, $description = '', $priority = 20, $active_callback = null ) {
        if ( class_exists( 'Kirki' ) ) {
            $textdomain = WPHelper::get_textdomain();
            $config = array(
                'title'       => esc_html__( $title, $textdomain ),
                'description' => esc_html__( $description, $textdomain ),
                'panel'       => $panel_id,
                'priority'    => $priority,
            );
            if ( $active_callback ) {
                $config['active_callback'] = $active_callback;
            }
            \Kirki::add_section( $section_id, $config );
        }
    }

    static function add_simple_field( $type, $field_id, $section_id, $title, $default = '', $priority = 10, $active_callback = null ) {
        if ( class_exists( 'Kirki' ) ) {
            $textdomain = WPHelper::get_textdomain();
            $config = array(
                'type'     => $type,
                'settings' => $field_id,
                'label'    => esc_html__( $title, $textdomain ),
                'section'  => $section_id,
                'default'  => $default,
                'priority' => $priority,
            );
            if ( $active_callback ) {
                $config['active_callback'] = $active_callback;
            }
            \Kirki::add_field( self::get_theme_config(), $config );
        }
    }

    static function add_select_field( $field_id, $section_id, $title, $multiple = 0, $choices = array(), $default = '', $priority = 10, $active_callback = null ) {
        if ( class_exists( 'Kirki' ) ) {
            $textdomain = WPHelper::get_textdomain();
            $choices = count( $choices ) == 0 ? \Kirki_Helper::get_posts( array( 'posts_per_page' => -1 ) ) : $choices;
            $config = array(
                'type'     => 'select',
                'settings' => $field_id,
                'label'    => esc_html__( $title, $textdomain ),
                'section'  => $section_id,
                'default'  => $default,
                'priority' => $priority,
                'choices'  => $choices,
                'multiple' => $multiple,
            );
            if ( $active_callback ) {
                $config['active_callback'] = $active_callback;
            }
            \Kirki::add_field( self::get_theme_config(), $config );
        }
    }

    static function add_choice_field( $type, $field_id, $section_id, $title, $choices = array(), $default = '', $priority = 10, $active_callback = null ) {
        if ( class_exists( 'Kirki' ) ) {
            $textdomain = WPHelper::get_textdomain();
            $config = array(
                'type'     => $type,
                'settings' => $field_id,
                'label'    => esc_html__( $title, $textdomain ),
                'section'  => $section_id,
                'default'  => $default,
                'priority' => $priority,
                'choices'  => $choices,
            );
            if ( $active_callback ) {
                $config['active_callback'] = $active_callback;
            }
            \Kirki::add_field( self::get_theme_config(), $config );
        }
    }

    static function add_category_select_field( $field_id, $section_id, $title, $choices = array(), $default = '', $priority = 10, $active_callback = null ) {
        if ( class_exists( 'Kirki' ) ) {
            $textdomain = WPHelper::get_textdomain();
            $choices = count( $choices ) == 0 ? Categories::get_all_categories() : $choices;
            $config = array(
                'type'     => 'select',
                'settings' => $field_id,
                'label'    => esc_html__( $title, $textdomain ),
                'section'  => $section_id,
                'default'  => $default,
                'priority' => $priority,
                'choices'  => $choices,
            );
            if ( $active_callback ) {
                $config['active_callback'] = $active_callback;
            }
            \Kirki::add_field( self::get_theme_config(), $config );
        }
    }

    static function add_posts_repeater_field( $field_id, $section_id, $title, $row_title = 'Select Item', $button_label = 'Add Item', $choices = array(), $limit = 3, $priority = 10, $active_callback = null ) {
        if ( class_exists( 'Kirki' ) ) {
            $textdomain = WPHelper::get_textdomain();
            $choices = count( $choices ) == 0 ? \Kirki_Helper::get_posts( array( 'posts_per_page' => -1 ) ) : $choices;
            $config = array(
                'type'         => 'repeater',
                'settings'     => $field_id,
                'label'        => esc_html__( $title, $textdomain ),
                'section'      => $section_id,
                'priority'     => $priority,
                'row_label'    => array(
                    'type'  => 'field',
                    'value' => esc_html__( $row_title, $textdomain ),
                    'field' => 'posts',
                ),
                'button_label' => esc_html__( $button_label, $textdomain ),
                'settings'     => $field_id,
                'choices'      => array(
                    'limit' => $limit,
                ),
                'fields'       => array(
                    'posts' => array(
                        'type'    => 'select',
                        'label'   => esc_html__( 'Item', 'kirki' ),
                        'choices' => $choices,
                    ),
                ),
            );
            if ( $active_callback ) {
                $config['active_callback'] = $active_callback;
            }
            \Kirki::add_field( self::get_theme_config(), $config );

        }
    }
    static function add_simple_repeater( $field_id, $section_id, $title, $row_title = 'Select Item', $button_label = 'Add Item', $fields=[], $limit = 3, $priority = 10, $active_callback = null ) {
        if ( class_exists( 'Kirki' ) ) {
            $textdomain = WPHelper::get_textdomain();
            $config = array(
                'type'         => 'repeater',
                'settings'     => $field_id,
                'label'        => esc_html__( $title, $textdomain ),
                'section'      => $section_id,
                'priority'     => $priority,
                'row_label'    => array(
                    'type'  => 'field',
                    'value' => esc_html__( $row_title, $textdomain ),
                ),
                'default'=>[],
                'button_label' => esc_html__( $button_label, $textdomain ),
                'settings'     => $field_id,
                'choices'      => array(
                    'limit' => $limit,
                ),
                'fields'       => array_column($fields,null,'id'),
            );
            if ( $active_callback ) {
                $config['active_callback'] = $active_callback;
            }
            \Kirki::add_field( self::get_theme_config(), $config );

        }
    }

    static function add_category_repeater_field( $field_id, $section_id, $title, $row_title = 'Select Item', $button_label = 'Add Item', $choices = array(), $limit = 3, $priority = 10, $active_callback = null ) {
        if ( class_exists( 'Kirki' ) ) {
            $textdomain = WPHelper::get_textdomain();
            $choices = count( $choices ) == 0 ? Categories::get_all_categories() : $choices;
            $config = array(
                'type'         => 'repeater',
                'settings'     => $field_id,
                'label'        => esc_html__( $title, $textdomain ),
                'section'      => $section_id,
                'priority'     => $priority,
                'row_label'    => array(
                    'type'  => 'field',
                    'value' => esc_html__( $row_title, $textdomain ),
                    'field' => 'posts',
                ),
                'button_label' => esc_html__( $button_label, $textdomain ),
                'settings'     => $field_id,
                'choices'      => array(
                    'limit' => $limit,
                ),
                'fields'       => array(
                    'posts' => array(
                        'type'    => 'select',
                        'label'   => esc_html__( 'Item', 'kirki' ),
                        'choices' => $choices,
                    ),
                ),
            );
            if ( $active_callback ) {
                $config['active_callback'] = $active_callback;
            }
            \Kirki::add_field( self::get_theme_config(), $config );

        }
    }

}