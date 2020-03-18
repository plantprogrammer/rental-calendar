<?php
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

Class OWAC_Availability_list_trash_Table extends WP_List_Table
{
	public static function define_columns() {
		$columns = array(
		    'apa_id' => __( 'Apartment Number', 'availability-calendar' ),
			'cb' => '<input type="checkbox" />',
			'from_date' => __( 'From Date', 'availability-calendar' ),
			'to_date' => __( 'To Date', 'availability-calendar' ),
			'cat_id' => __( 'Category Name', 'availability-calendar' )
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
            $this->owac_availability_restore_item();
            $this->owac_availability_delete_item();           

    }
	
	public function get_columns() {
		$columns = array(
		    'apa_id' => __( 'Apartment Number', 'availability-calendar' ),
			'cb' => '<input type="checkbox" />',
			'from_date' => __( 'From Date', 'availability-calendar'),
			'to_date' => __( 'To Date', 'availability-calendar' ),
			'cat_id' => __( 'Category Name', 'availability-calendar' ),
		);

		return $columns;
	}
	
    function get_sortable_columns() {
        $columns = array(
			'from_date' =>  array('from_date',true),
			'to_date' => array('to_date',true),
			'cat_id' => array('category_name',true),
		);
        return $columns;
    }
	
    function prepare_items() {
		
		$per_page = "20";

		$args = array(
			'posts_per_page' => $per_page,
			'orderby' => 'ev_id',
			'order' => 'DESC',
			'offset' => ( $this->get_pagenum() - 1 ) * $per_page,
		);

		if ( isset( $_GET['orderby'] ) && ! empty( $_GET['orderby'] ) ) {
			$orderby = sanitize_text_field($_GET['orderby']);
			if ( 'from_date' == $orderby ) {
				$args['orderby'] = 'from_date';
			} elseif ( 'to_date' == $orderby ) {
				$args['orderby'] = 'to_date';
			} elseif ( 'category_name' == $orderby ) {
				$args['orderby'] = 'cat_id';
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
		$table_name = $wpdb->prefix . 'OWAC_event';
		$this->items = $wpdb->get_results(
							$wpdb->prepare(
								"SELECT * from 
									`{$wpdb->prefix}OWAC_event` 
								WHERE 1 AND `flag`='1' 
								ORDER BY ".$args['orderby']." ".$args['order']." LIMIT %d, %d",
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
			$item->ev_id
		);
	}
	
	public function column_from_date( $item ) {
		$output = sprintf(__( '%s', 'availability-calendar' ),
			esc_html( date('d-m-Y', $item->from_date) )
		);
		
		$output = sprintf( '<strong>%s</strong>', $output );
		return $output;
	}
	
	public function column_to_date( $item ) {
		$output = sprintf(__( '%s', 'availability-calendar' ),
			esc_html( date('d-m-Y', $item->to_date) )
		);
		
		$output = sprintf( '<strong>%s</strong>', $output );
		return $output;
	}
	
	public function column_cat_id( $item ) {
		global $wpdb;
		$get_cat_name = $wpdb->get_results(
							$wpdb->prepare(
								"SELECT cat_name from 
									`{$wpdb->prefix}OWAC_category` 
								WHERE `cat_id`=%d AND `flag`='0'",
								$item->cat_id
							)
						);
		
		if(isset($get_cat_name[0]->cat_name) && !empty($get_cat_name[0]->cat_name)){
			$output = sprintf(__( '%s', 'availability-calendar' ),
				esc_html( $get_cat_name[0]->cat_name )
			);
		}else{
			$output = "";
		}
		$output = sprintf( '<strong>%s</strong>', $output );
		
		return $output;
	}
	
	protected function handle_row_actions( $item, $column_name, $primary ) {
		
		if ( $column_name !== $primary ) {
			return '';
		}

		$edit_link = add_query_arg(
			array(
				'page' => 'availabilitycalendar&Trash=Trash',
				'restore' => absint( $item->ev_id ),
			),
			menu_page_url( 'availability-calendar', false )
		);
		
		$trash_link = add_query_arg(
			array(
				'page' => 'availabilitycalendar&Trash=Trash',
				'delete' => absint( $item->ev_id ),
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
                'move_to_restore' => __( 'Move to Restore', 'availability-calendar' ),
				'delete_permanently' => __( 'Delete Permanently', 'availability-calendar' )
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
			
            case 'move_to_restore':
				if(isset($_POST['owac_post']) && !empty($_POST['owac_post'])) {
					foreach($_POST['owac_post'] as $check_id) {
						//Set restore
						$this->owac_availability_restore_chk(intval($check_id)); 
					}
					header('Location: admin.php?page=availabilitycalendar');	
				}
                break;
			
			case 'delete_permanently':
				if(isset($_POST['owac_post']) && !empty($_POST['owac_post'])) {
					foreach($_POST['owac_post'] as $check_id) {
						//Set delete
						$this->owac_availability_delete_chk(intval($check_id)); 
					}
					header('Location: admin.php?page=availabilitycalendar');	
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
						`{$wpdb->prefix}OWAC_event` 
					WHERE 1 AND `flag`='0'"
				);
	
        return $count_all;
    }
	
	public function count_trash() {
		global $wpdb;
		$count_trash = $wpdb->get_var(
						"SELECT COUNT(*) FROM 
							`{$wpdb->prefix}OWAC_event` 
						WHERE 1 AND `flag`='1'"
					);
		
        return $count_trash;
    }
	
	//Availability Restore Chk
	function owac_availability_restore_chk($check_id) {
		$id = intval($check_id);

		global $wpdb;
		$availability_restore_chk = $wpdb->get_results(
							$wpdb->prepare(
								"SELECT * from 
									`{$wpdb->prefix}OWAC_event` 
								WHERE `ev_id`=%d",
								$id
							)
						);
		//availability_restore_chk
		if (count($availability_restore_chk) == 1 ) {
			
			global $wpdb;
			$table_prefix = $wpdb->prefix . 'OWAC_event';
			$flag = "0";
			$wpdb->update(
				$table_prefix, 
				array('flag' => $flag), 
				array('ev_id' => $id), 
				array('%d'), 
				array('%d')
			);
		}
	}

	//Availability Delete Chk
	function owac_availability_delete_chk($check_id) {

		$id = intval($check_id);
		
		global $wpdb;
		$table_prefix = $wpdb->prefix . 'OWAC_event';
		$wpdb->delete(
			$table_prefix,  
			array('ev_id' => $id), 
			array('%d')
		);

	}
	
	//Availability Restore
	function owac_availability_restore_item() {

		if(isset($_GET['restore']) && !empty($_GET['restore'])){ 
			$id = intval($_GET['restore']);
			//$update = true;
			global $wpdb;
			$availability_restore_item = $wpdb->get_results(
							$wpdb->prepare(
								"SELECT * from 
									`{$wpdb->prefix}OWAC_event` 
								WHERE `ev_id`=%d",
								$id
							)
						);

			//availability_restore_item
			if (count($availability_restore_item) == 1 ) {
				$id = intval($availability_restore_item[0]->ev_id);
			//Insert in availability_restore_item
				global $wpdb;
				$table_prefix = $wpdb->prefix . 'OWAC_event';
				$flag = "0";
				$wpdb->update(
					$table_prefix, 
					array('flag' => $flag), 
					array('ev_id' => $id), 
					array('%d'), 
					array('%d')
				);
			}
		}
	}
	
	//Availability Delete Item
	function owac_availability_delete_item() {

		if(isset($_GET['delete']) && !empty($_GET['delete'])){ 
			$id = intval($_GET['delete']);
			//$update = true;
			global $wpdb;
			$table_prefix = $wpdb->prefix . 'OWAC_event';
			$wpdb->delete(
				$table_prefix,  
				array('ev_id' => $id), 
				array('%d')
			);
		}
	}
	
}