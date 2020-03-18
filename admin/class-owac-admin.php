<?php
class OWAC_Admin {

	private $plugin_name;
	private $version;
	
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->admin_menu();
	}

	public function enqueue_styles() {

		wp_enqueue_style( 'owac-styles', plugin_dir_url( __FILE__ ) . 'css/styles.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'owac-pickmeup', plugin_dir_url( __FILE__ ) . 'css/pickmeup.css', array(), $this->version, 'all' );

	}

	public function enqueue_scripts() {

		wp_enqueue_script( 'owac-pickmeup', plugin_dir_url( __FILE__ ) . 'js/pickmeup.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'owac-jscolor', plugin_dir_url( __FILE__ ) . 'js/jscolor.js', array( 'jquery' ), $this->version, false );

	}
	
	public function admin_menu() {

		function owac_admin_menu() {
			add_menu_page('availabilitycalendar', 'Availability Calendar', 'manage_options', 'availabilitycalendar', 'owac_calendar_list_trash','dashicons-calendar-alt');
            
            add_submenu_page( 'availabilitycalendar', 'owaccategorylist', 'Category', 'manage_options', 'owaccategorylist', 'OWAC_category');
			
			add_submenu_page( 'availabilitycalendar', 'owacapt1', 'Apartment 1', 'manage_options', 'owacapt1', 'OWAC_apt1');
			add_submenu_page( 'availabilitycalendar', 'owacapt2', 'Apartment 2', 'manage_options', 'owacapt2', 'OWAC_apt2');
			add_submenu_page( 'availabilitycalendar', 'owacapt3', 'Apartment 3', 'manage_options', 'owacapt3', 'OWAC_apt3');
			add_submenu_page( 'availabilitycalendar', 'owacapt4', 'Apartment 4', 'manage_options', 'owacapt4', 'OWAC_apt4');

		}
		add_action('admin_menu', 'owac_admin_menu');
		
	}
}