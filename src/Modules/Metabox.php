<?php

namespace BdWebNinja\WPHelper\Modules;
class Metabox {

	private static $title;
	private static $description;
	private static $fields;
	private static $post_types = array( 'post' );
	private static $textdomain = '';
	private static $context = '';
	private static $priority = '';

	private static function get_title() {
		return self::$title;
	}

	private static function get_description() {
		return self::$description;
	}

	private static function get_fields() {
		return self::$fields;
	}

	private static function get_post_types() {
		return self::$post_types;
	}

	private static function get_textdomain() {
		return self::$textdomain;
	}

	private static function get_context() {
		return self::$context;
	}

	private static function get_priority() {
		return self::$priority;
    }
    
    public static function get_meta_value($post_id, $key, $default=''){
        if($key!=''){
            $_key = "wphelper_{$key}";
			$_value = get_post_meta($post_id, $_key, true);
            if($_value){
                return $_value;
            }
        }
        return $default;
    }

	/**
	 * Meta box initialization.
	 */
	public static function init_metabox() {
		add_action( 'add_meta_boxes', array( Metabox::class, 'add_metabox' ) );
		add_action( 'save_post', array( Metabox::class, 'save_metabox' ), 10, 2 );
	}

	/**
	 * Adds the meta box.
	 */
	public static function add_metabox() {
		add_meta_box(
			'wphelper' . md5( self::get_title() . time() ),
			__( self::get_title(), self::get_textdomain() ),
			array( Metabox::class, 'render_metabox' ),
			array( self::get_post_types() ),
			self::get_context(),
			self::get_priority()
		);

	}

	/**
	 * Renders the meta box.
	 */
	public static function render_metabox( $post ) {
		// Add nonce for security and authentication.
		wp_nonce_field( 'wphelper_meta', 'wphelper_meta_nonce' );
		?>

        <p><?php echo self::get_description(); ?></p>
		<?php
		foreach ( self::get_fields() as $field ) {
			$_id    = $field['id'];
			$_title = $field['title'];
			$_type  = $field['type'];
			if ( 'text' == $_type ) {
				self::render_text_field( $_id, $_title );
			} elseif ( 'select' == $_type ) {
				$_choices = $field['choices'];
				self::render_select_field( $_id, $_title, $_choices );
			} elseif ( 'checkbox' == $_type ) {
				self::render_checkbox_field( $_id, $_title );
			}
		}
	}

	private static function render_text_field( $id, $title ) {
		$_id = "wphelper_{$id}";
		?>
        <p>
            <label for="<?php echo esc_attr( $_id ); ?>"><?php _e( "{$title}", self::get_textdomain() ); ?></label><br/>
            <input type="text" name="<?php echo esc_attr( $_id ); ?>" id="<?php echo esc_attr( $_id ); ?>"
                   class="widefat"
                   value="<?php echo esc_attr( self::wphelper_get_meta( "wphelper_{$id}" ) ); ?>">
        </p>
		<?php
	}

	private static function render_checkbox_field( $id, $title ) {
		$_id      = "wphelper_{$id}";
		$_checked = self::wphelper_get_meta( $_id ) == 1 ? 'checked' : '';
		?>
        <p>
            <input type="checkbox" name="<?php echo esc_attr( $_id ); ?>"
                   id="<?php echo esc_attr( $_id ); ?>"<?php echo esc_html( $_checked ); ?>
                   value="1">
            <label for="<?php echo esc_attr( $_id ); ?>"><?php echo esc_html( $title ); ?></label>
        </p>
		<?php
	}

	private static function render_select_field( $id, $title, $choices ) {
		$_id = "wphelper_{$id}";
		$width = self::get_context()=='side'?'85%':'100%';
		?>
        <p>
            <label for="<?php echo esc_attr( $_id ); ?>"><?php _e( "{$title}", self::get_textdomain() ); ?></label><br>
            <select name="<?php echo esc_attr( $_id ); ?>" id="<?php echo esc_attr( $_id ); ?>" style="width:<?php echo esc_attr($width) ;?>">
                <option vallue=''><?php _e( 'Select an option', self::get_textdomain() ); ?></option>
				<?php
				$selected_value = self::wphelper_get_meta( $_id );
				foreach ( $choices as $key => $value ) {
					$selected = '';
					if ( $key == $selected_value ) {
						$selected = 'selected';
					}
					printf( "<option value='%s' %s>%s</option>", $key, $selected, esc_html( $value ) );
				}
				?>
            </select>
        </p>
		<?php
	}

	static function wphelper_get_meta( $key ) {
		global $post;
		$field = get_post_meta( $post->ID, $key, true );

		return $field;
	}

	public static function save_metabox( $post_id, $post ) {
		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['wphelper_meta_nonce'] ) ? $_POST['wphelper_meta_nonce'] : '';
		$nonce_action = 'wphelper_meta';

		// Check if nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
			return;
		}

		// Check if user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Check if not an autosave.
		if ( wp_is_post_autosave( $post_id ) ) {
			return;
		}

		// Check if not a revision.
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		foreach ( self::get_fields() as $field ) {
			file_put_contents( "/tmp/response.txt", print_r( $_POST, true ) );
			$_id = "wphelper_{$field['id']}";
			if ( isset( $_POST[ $_id ] ) ) {
				$_value = sanitize_text_field( $_POST[ $_id ] );
				update_post_meta( $post_id, $_id, $_value );
			} else {
				delete_post_meta( $post_id, $_id );
			}
		}

	}

	static function display_metabox( $title, $description, $post_types = array( 'post' ), $fields = array(), $condition = '', $context = 'advanced', $priority = 'default', $textdomain = '' ) {
		$_post_id = null;
		$_proceed = false;
		if ( isset( $_REQUEST['post'] ) || isset( $_REQUEST['post_ID'] ) ) {
			$_post_id = empty( $_REQUEST['post_ID'] ) ? $_REQUEST['post'] : $_REQUEST['post_ID'];
		}

		if ( is_callable( $condition ) ) {
			$_proceed = $condition( $_post_id );
		} else {
			$_proceed = true;
		}
		if ( is_admin() && $_proceed ) {
			self::$title       = $title;
			self::$description = $description;
			self::$post_types  = $post_types;
			self::$fields      = $fields;
			self::$context     = $context;
			self::$priority    = $priority;
			self::$textdomain  = $textdomain;
			add_action( 'load-post.php', array( Metabox::class, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( Metabox::class, 'init_metabox' ) );
		}
	}

}