<?php
class OWAC_Admin_Settings {

	private $availability_calendar_settings;
	private $version;
	
	public function __construct( $availability_calendar_settings, $version ) {

		$this->availability_calendar_settings = $availability_calendar_settings;
		$this->version = $version;
		$this->OWAC_Admin_File_Add();

	}

	public function OWAC_Admin_File_Add() {
		
		if ( ! defined( 'OWAC_ADMINDIR')) {
			define('OWAC_ADMINDIR', plugin_dir_path(__FILE__));
		}

		require_once OWAC_ROOTDIR . 'includes/owac-language.php';
		require_once OWAC_ADMINDIR . 'class/owac-class-addedit.php';
		require_once OWAC_ADMINDIR . 'class/owac-category-class-addedit.php';
		require_once OWAC_ADMINDIR . 'class/owac-list-table.php';
		require_once OWAC_ADMINDIR . 'class/owac-list-table-trash.php';
		require_once OWAC_ADMINDIR . 'class/owac-category-list-table.php';
		require_once OWAC_ADMINDIR . 'class/owac-category-list-table-trash.php';
		require_once OWAC_ADMINDIR . 'includes/owac-functions.php';
		require_once OWAC_ADMINDIR . 'includes/owac-settings.php';
		require_once OWAC_ADMINDIR . 'includes/owac-add.php';
		require_once OWAC_ADMINDIR . 'includes/owac-category-add.php';
		require_once OWAC_ADMINDIR . 'includes/owac-calendars.php';
		require_once OWAC_ADMINDIR . 'includes/owac-calendar-settings.php';
		
		function OWAC_category() { 
			if(isset($_GET['Trash']) && !empty($_GET['Trash'])){ 
				OWAC_Category_list_trash(); 
			} else { 
				OWAC_Category_list();
			} 
		}

		function owac_calendar_list_trash() { 
			if(isset($_GET['Trash']) && !empty($_GET['Trash'])){ 
				OWAC_Availability_list_trash(); 
			} else { 
				OWAC_Availability_list(); 
			} 
		}

	}
}