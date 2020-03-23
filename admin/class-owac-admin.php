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
			add_menu_page('Apartment 1 Calendar', 'Apartment Calendar', 'manage_options', 'owacapt1', 'OWAC_apt1','dashicons-calendar-alt');
            
            add_submenu_page( 'owacapt1', 'owaccategorylist', 'Category', 'manage_options', 'owaccategorylist', 'OWAC_category');
			add_submenu_page( 'owacapt1', 'Apartment 1 Calendar', 'Apartment 1 Calendar', 'manage_options', 'owacapt1', 'OWAC_apt1');
			add_submenu_page( 'owacapt1', 'Apartment 2 Calendar', 'Apartment 2 Calendar', 'manage_options', 'owacapt2', 'OWAC_apt2');
			add_submenu_page( 'owacapt1', 'Apartment 3 Calendar', 'Apartment 3 Calendar', 'manage_options', 'owacapt3', 'OWAC_apt3');
			add_submenu_page( 'owacapt1', 'Apartment 4 Calendar', 'Apartment 4 Calendar', 'manage_options', 'owacapt4', 'OWAC_apt4');
		
		    remove_submenu_page('owacapt1','owacapt1');
		}
		add_action('admin_menu', 'owac_admin_menu');
		
	}
}