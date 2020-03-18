<?php
class OWAC_Activator {

	public static function activate() {
		global $wpdb;
		global $at_db_version;

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$category_table = $wpdb->prefix . 'OWAC_category';
		$event_table = $wpdb->prefix . 'OWAC_event';
		
		$charset_collate = $wpdb->get_charset_collate();

		$category = "CREATE TABLE IF NOT EXISTS $category_table (cat_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, cat_name_eng VARCHAR(255) NOT NULL, cat_name_fre VARCHAR(255) NOT NULL, cat_color VARCHAR(50), cat_ord_num INT( 20 ), created_date VARCHAR( 255 ), status INT( 10 ), flag INT(10))$charset_collate";

		$event = "CREATE TABLE IF NOT EXISTS $event_table (ev_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, apt_id INT(10) UNSIGNED NOT NULL, from_date VARCHAR(255) NOT NULL, to_date VARCHAR(255) NOT NULL, cat_id INT(10),created_date VARCHAR( 255 ),  status INT( 10 ), flag INT(10))$charset_collate";
		
		$settings_options = array('language_display' => 'english' ,'header_display' => 'yes' ,'header_add_text' => "", 'category_display' => 'yes', 'display_calendar_month' => '12m', 'desktop_column' => '3', 'tablet_column' => '2', 'mobile_column' => '1', 'slides_to_scroll' => '1', 'background_color' => 'ffffff', 'calendar_background_color' => 'ffffff', 'month_title_font_color' => '000000', 'month_background_color' => 'ffffff' );
	
		add_option('OWAC_settings_option',$settings_options, '', 'yes');
		dbDelta($category);
		dbDelta($event);
	}

}