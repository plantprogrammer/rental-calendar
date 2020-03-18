<?php
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

Class OWAC_Category_list_trash_Table extends WP_List_Table
{
	public static function define_columns() {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'cat_name' => __( 'Category Name', 'availability-calendar' ),
			'cat_short' => __( 'Category Shortcode', 'availability-calendar' ),
			'cat_color' => __( 'Category Color', 'availability-calendar' ),
			'cat_ord_num' => __( 'Ordering Numbers', 'availability-calendar' ),
		);
		return $columns;
	}
	
	public function __construct()
    {
             parent::__construct( array(
                  'singular'=> 'owac_post', 
                  'plural' => 'owac_posts', 
                  'ajax'   => false 
                  ) );      
            $this->owac_category_restore_item();
            $this->owac_category_delete_item();           

    }
	
	public function get_columns() {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'cat_name' => __( 'Category Name', 'availability-calendar'),
			'cat_short' => __( 'Category Shortcode', 'availability-calendar' ),
			'cat_color' => __( 'Category Color', 'availability-calendar' ),
			'cat_ord_num' => __( 'Ordering Numbers', 'availability-calendar' ),
		);

		return $columns;
	}
	
    function get_sortable_columns() {
        $columns = array(
			'cat_name' =>  array('cat_name',true),
			//'cat_des' => array('cat_des',false),
			//'cat_color' => array('cat_color',false),
			'cat_ord_num' => array('cat_ord_num',true),
		);
        return $columns;
    }
	
    function prepare_items() {
		
		$per_page = "20";

		$args = array(
			'posts_per_page' => $per_page,
			'orderby' => 'cat_id',
			'order' => 'DESC',
			'offset' => ( $this->get_pagenum() - 1 ) * $per_page,
		);

		if ( isset( $_GET['orderby'] ) && ! empty( $_GET['orderby'] ) ) {
			$orderby = sanitize_text_field($_GET['orderby']);
			if ( 'cat_name' == $orderby ) {
				$args['orderby'] = 'cat_name';
			} elseif ( 'cat_ord_num' == $orderby ) {
				$args['orderby'] = 'cat_ord_num';
			}
		}

		if ( isset( $_GET['order'] ) && ! empty( $_GET['order'] ) ) {
			$order = sanitize_text_field($_GET['order']);
			if ( 'asc' == strtolower( $order ) ) {
				$args['order'] = 'ASC';
			} elseif ( 'desc' == strtolower( $order ) ) {
				$args['order'] = 'DESC';
			}
		}
		
		global $wpdb;
		$table_name = $wpdb->prefix . 'OWAC_category';
		$this->items = $wpdb->get_results(
							$wpdb->prepare(
								"SELECT * from 
									`{$wpdb->prefix}OWAC_category` 
								WHERE 1 AND `flag`='1' 
								ORDER BY ".$args['orderby']." ".$args['order']." LIMIT %d, %d;",
								$args['offset'],
								$args['posts_per_page']
							)
						);
		
		$total_items = count($this->items);
		
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
		$total_pages = ceil( $total_items / $per_page );
		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'total_pages' => $total_pages,
			'per_page' => $per_page,
		) );
    }
	
	protected function column_default( $item, $column_name ) {
		return '';
	}

	public function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			$this->_args['singular'],
			$item->cat_id
		);
	}
	
	public function column_cat_name( $item ) {
		$output = sprintf(__( '%s', 'availability-calendar' ),
			esc_html( $item->cat_name)
		);
		
		$output = sprintf( '<strong>%s</strong>', $output );
		return $output;
	}
	
	public function column_cat_short( $item ) {
		$output = sprintf(__( '%s', 'availability-calendar' ),
			esc_html( '[availabilitycalendar category="'.$item->cat_id.'"]' )
		);
		
		$output = sprintf( '<strong>%s</strong>', $output );
		return $output;
	}
	
	public function column_cat_color( $item ) {
		$output = sprintf(__( '%s', 'availability-calendar' ),
			sanitize_hex_color( $item->cat_color )
		);
		
		$output = sprintf( '<strong style="background-color: %s;"></strong>', $output );
		return $output;
	}
	
	public function column_cat_ord_num( $item ) {
		$output = sprintf(__( '%s', 'availability-calendar' ),
			intval( $item->cat_ord_num )
		);
		
		$output = sprintf( '<strong>%s</strong>', $output );
		return $output;
	}
	
	protected function handle_row_actions( $item, $column_name, $primary ) {
		
		if ( $column_name !== $primary ) {
			return '';
		}

		$edit_link = add_query_arg(
			array(
				'page' => 'owaccategorylist&Trash=Trash',
				'restore' => absint( $item->cat_id ),
			),
			menu_page_url( 'availability-calendar', false )
		);
		
		$trash_link = add_query_arg(
			array(
				'page' => 'owaccategorylist&Trash=Trash',
				'delete' => absint( $item->cat_id ),
			),
			menu_page_url( 'availability-calendar', false )
		);
		
		$actions = array(
			'restore' => owac_link( $edit_link, __( 'Restore', 'availability-calendar' ) ),
			'delete' => owac_link( $trash_link, __( 'Delete Permanently', 'availability-calendar' ) ),
		);

		return $this->row_actions( $actions );
	}
	
	protected function bulk_actions( $which = '' ) {
		if ( is_null( $this->_actions ) ) {
			$this->_actions = $this->get_bulk_actions();
			$this->_actions = apply_filters( "bulk_actions-{$this->screen->id}", $this->_actions );
			$two            = '';
		} else {
			$two = '2';
		}
	 
		if ( empty( $this->_actions ) ) {
			return;
		}
	 
		echo '<label for="bulk-action-selector-' . esc_attr( $which ) . '" class="screen-reader-text">' . __( 'Select bulk action' ) . '</label>';
		echo '<select name="action' . $two . '" id="bulk-action-selector-' . esc_attr( $which ) . "\">\n";
		echo '<option value="-1">' . __( 'Bulk Actions' ) . "</option>\n";
	 
		foreach ( $this->_actions as $name => $title ) {
			$class = 'edit' === $name ? ' class="hide-if-no-js"' : '';
	 
			echo "\t" . '<option value="' . $name . '"' . $class . '>' . $title . "</option>\n";
		}
	 
		echo "</select>\n";
	 
		submit_button( __( 'Apply' ), 'action', '', false, array( 'id' => "doaction$two" ) );
		echo "\n";
	}

	protected function get_bulk_actions() {
		return array(
                'restore' => __( 'Move to Restore', 'availability-calendar' ),
				'delete' => __( 'Delete Permanently', 'availability-calendar' ),
        );
	}
	
	public function process_bulk_action() {
		
        // security check!
        if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {

            $nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
            $action = 'bulk-' . $this->_args['plural'];

            if ( ! wp_verify_nonce( $nonce, $action ) )
                wp_die( 'Nope! Security check failed!' );

        }

        $action = $this->current_action();
		
        switch ( $action ) {

            case 'restore':
				if(isset($_POST['owac_post']) && !empty($_POST['owac_post'])) {
					foreach($_POST['owac_post'] as $check_id) {
						//Set restore
						$this->owac_category_restore_chk(intval($check_id)); 
					}
					header('Location: admin.php?page=owaccategorylist');	
				}
                break;
			
			case 'delete':
				if(isset($_POST['owac_post']) && !empty($_POST['owac_post'])) {
					foreach($_POST['owac_post'] as $check_id) {
						//Set delete
						$this->owac_category_delete_chk(intval($check_id)); 
					}
					header('Location: admin.php?page=owaccategorylist');	
				}
                break;

            default:
                
                return;
                break;
        }

        return;
    }
	
	public function count_all() {
		global $wpdb;
		$count_all = $wpdb->get_var(
					"SELECT COUNT(*) FROM 
						`{$wpdb->prefix}OWAC_category` 
					WHERE 1 AND `flag`='0'"
				);
	
        return $count_all;
    }
	
	public function count_trash() {
		global $wpdb;
		$count_trash = $wpdb->get_var(
						"SELECT COUNT(*) FROM 
							`{$wpdb->prefix}OWAC_category` 
						WHERE 1 AND `flag`='1'"
					);
		
        return $count_trash;
    }
	
	//Category Restore Chk
	function owac_category_restore_chk($check_id) {
		$id = $check_id;
		
		global $wpdb;
		$category_restore_chk = $wpdb->get_results(
							$wpdb->prepare(
								"SELECT * from 
									`{$wpdb->prefix}OWAC_category` 
								WHERE `cat_id`=%d",
								$id
							)
						);
		//category_restore_chk
		if (count($category_restore_chk) == 1 ) {
		
			global $wpdb;
			$table_prefix = $wpdb->prefix . 'OWAC_category';
			$flag = "0";
			$wpdb->update(
				$table_prefix, 
				array('flag' => $flag), 
				array('cat_id' => $id), 
				array('%d'), 
				array('%d')
			);
		}
	}

	//Category Delete Chk
	function owac_category_delete_chk($check_id) {

		$id = intval($check_id);
		global $wpdb;
		$table_prefix = $wpdb->prefix . 'OWAC_category';
		$wpdb->delete(
			$table_prefix,  
			array('cat_id' => $id), 
			array('%d')
		);

	}
	
	//Availability Restore
	function owac_category_restore_item() {

		if(isset($_GET['restore']) && !empty($_GET['restore'])){ 
			$id = intval($_GET['restore']);
			
			global $wpdb;
			$category_restore_item = $wpdb->get_results(
							$wpdb->prepare(
								"SELECT * from 
									`{$wpdb->prefix}OWAC_category` 
								WHERE `cat_id`=%d",
								$id
							)
						);

			//category_restore_item
			if (count($category_restore_item) == 1 ) {
				$id = intval($category_restore_item[0]->cat_id);
	
				global $wpdb;
				$table_prefix = $wpdb->prefix . 'OWAC_category';
				$flag = "0";
				$wpdb->update(
					$table_prefix, 
					array('flag' => $flag), 
					array('cat_id' => $id), 
					array('%d'), 
					array('%d')
				);
			}
		}
	}
	
	//Availability Delete Item
	function owac_category_delete_item() {

		if(isset($_GET['delete']) && !empty($_GET['delete'])){ 
			$id = intval($_GET['delete']);
			
			global $wpdb;
			$table_prefix = $wpdb->prefix . 'OWAC_category';
			$wpdb->delete(
					$table_prefix,  
					array('cat_id' => $id), 
					array('%d')
				);
		}
	}
}