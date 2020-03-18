<?php
/**
 * If uninstall not called from WordPress, then exit.
 */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * Uninstall OWAC plugin All Option Settings and Database Table Delete
 */
OWAC_delete();

/**
 * OWAC Delete function
 */
function OWAC_delete() {
	global $wpdb;
	
/**
 * Option Settings Delete
 */
	delete_option( 'OWAC_settings_option' );
	
/**
 * Database Table Delete
 */	
	$OWAC_category = $wpdb->prefix . "OWAC_category";
	$OWAC_event = $wpdb->prefix . "OWAC_event";
	$wpdb->query( "DROP TABLE IF EXISTS $OWAC_category" );
	$wpdb->query( "DROP TABLE IF EXISTS $OWAC_event" );
}