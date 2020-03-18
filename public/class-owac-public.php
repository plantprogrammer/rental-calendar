<?php
class OWAC_Public {

	private $availabilitycalendar;
	private $version;

	public function __construct( $availabilitycalendar, $version ) {

		$this->availabilitycalendar = $availabilitycalendar;
		$this->version = $version;
		$this->OWAC_Public_File_Add();
		
	}

	public function enqueue_styles() {

		wp_enqueue_style( 'owac-styles', plugin_dir_url( __FILE__ ) . 'css/styles.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'owac-slider', plugin_dir_url( __FILE__ ) . 'css/owac.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'owac-theme', plugin_dir_url( __FILE__ ) . 'css/owac-theme.css', array(), $this->version, 'all' );

	}

	public function enqueue_scripts() {

		wp_enqueue_script( 'owac-js', plugin_dir_url( __FILE__ ) . 'js/owac.js', array( 'jquery' ), $this->version, true );
		
	}
	
	public function OWAC_Public_File_Add() {
		
		if ( ! defined( 'OWAC_PUBLIC')) {
			define('OWAC_PUBLIC', plugin_dir_path(__FILE__));
		}
		
		require_once OWAC_ROOTDIR . 'includes/owac-language.php';
		require_once OWAC_PUBLIC . 'includes/frontend.php';

	}

}
