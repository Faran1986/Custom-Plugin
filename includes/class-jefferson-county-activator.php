<?php

/**
 * Fired during plugin activation
 *
 * @link       https://iplex.co
 * @since      1.0.0
 *
 * @package    Jefferson_County
 * @subpackage Jefferson_County/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Jefferson_County
 * @subpackage Jefferson_County/includes
 * @author     Iplex <info@iplex.co>
 */
class Jefferson_County_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {


		global $wpdb,$table_prefix;

		$table_name = $table_prefix . 'event_import';

		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") !== $table_name) {

	
				// SQL query to create the table
				$sql = "CREATE TABLE `$table_name` (";
				$sql .= " `id` int(11) NOT NULL auto_increment, ";
				$sql .= " `url` text, ";
				$sql .= " `date` text, ";
				$sql .= " `status` varchar(500), ";
				$sql .= " PRIMARY KEY (`id`) ";
				$sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

				// Include Upgrade Script
				require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
			
				// Create or update the table
				dbDelta( $sql );
		
		}

	}




}
