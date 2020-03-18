<?php
class OWAC_Availability_Calendar {

	protected $loader;
	protected $availabilitycalendar;
	protected $version;
	
	public function __construct() {
		if ( defined( 'Availability_Calendar_VERSION' ) ) {
			$this->version = OWAC_VERSION;
		} else {
			$this->version = '1.1.2';
		}
		$this->availabilitycalendar = 'availabilitycalendar';

		$this->OWAC_load_dependencies();
		$this->OWAC_admin_hooks();
		$this->OWAC_admin_settings_hooks();
		$this->OWAC_public_hooks();
	}

	private function OWAC_load_dependencies() {
		
		require_once OWAC_ROOTDIR . 'includes/class-owac-loader.php';
		require_once OWAC_ROOTDIR . 'admin/class-owac-admin.php';
		require_once OWAC_ROOTDIR . 'admin/settings.php';
		require_once OWAC_ROOTDIR . 'public/class-owac-public.php';
		$this->loader = new OWAC_Loader();

	}

	private function OWAC_admin_hooks() {

		$plugin_admin = new OWAC_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );


	}

	private function OWAC_public_hooks() {

		$plugin_public = new OWAC_Public( $this->get_plugin_name(), $this->get_version() );
		
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	private function OWAC_admin_settings_hooks() {

		$plugin_admin = new OWAC_Admin_Settings( $this->get_plugin_name(), $this->get_version() );

	}

	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->availabilitycalendar;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}

}