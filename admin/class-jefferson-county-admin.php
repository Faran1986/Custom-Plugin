<?php

use Sabre\VObject;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://iplex.co
 * @since      1.0.0
 *
 * @package    Jefferson_County
 * @subpackage Jefferson_County/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Jefferson_County
 * @subpackage Jefferson_County/admin
 * @author     Iplex <info@iplex.co>
 */
class Jefferson_County_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jefferson_County_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jefferson_County_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/jefferson-county-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jefferson_County_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jefferson_County_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jefferson-county-admin.js', array( 'jquery' ), $this->version, false );

	}




	/*==============================================================
	  Register Events Post Type
	  =============================================================*/

	  	public function register_events_post_type() {
			$args = array(
				'labels'              => array(
					'name'                  => 'Calendar Events',
					'singular_name'         => 'Calendar Event',
				),
				'public'              => true,
				'menu_icon'           => 'dashicons-calendar',
				'rewrite'             => array( 'slug' => 'custom-post' ),
				'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
				'taxonomies'          => array( 'category' ), // Add 'category' support
			);
			register_post_type( 'calendar_events', $args );


			$args1 = array(
				'type'         => 'string',
				'description'  => 'Start Date',
				'single'       => true,
				'show_in_rest' => true,
			);
			register_meta('calendar_events', 'start_date', $args1);

			$args2 = array(
				'type'         => 'string', 
				'description'  => 'End Date',
				'single'       => true,
				'show_in_rest' => true,
			);
			register_meta('calendar_events', 'end_date', $args2);

		}




		/*===========================================================
		  Add Menu Page for ICS Import
		  ===========================================================*/

		public function add_import_events_menu_page() {
			add_menu_page(
				__( 'Import Eents', 'textdomain' ),
				'Import Events',
				'manage_options',
				'import_events',
				array($this,'add_import_events_menu_page_callback'),
				'dashicons-download',
				12
			);
		}



		public function add_import_events_menu_page_callback(){

			include ABSPATH . 'wp-content/plugins/jefferson-county/admin/partials/jefferson-county-admin-display.php';
					

		}




		public function import_ics_events(){

			if (isset($_FILES['ics_file']) && $_FILES['ics_file']['error'] === UPLOAD_ERR_OK) {


				


					
				/*====================================================================
				 Retrieve ICS file data and insert posts
				  ===================================================================*/

				  // Retrieve the uploaded .ics file
				  $ics_file = $_FILES['ics_file']['tmp_name'];

				  // Parse the .ics file
				  $vcalendar = VObject\Reader::read(file_get_contents($ics_file));
			  
				  // Loop through each event in the .ics file
				  foreach ($vcalendar->VEVENT as $event) {
					  // Extract event details
					  $title = (string) $event->SUMMARY;
					  $start_date = (string) $event->DTSTART;
					  $end_date = (string) $event->DTEND;
					  $description = (string) $event->DESCRIPTION;
			  
					  // Create a new post of the custom post type
					  global $wpdb;

					  $post_data = array(
						'post_title' => $title,
						'post_content' =>  $description,
						'post_type' => 'calendar_events',
						'post_status' => 'publish',
					);
					$wpdb->insert($wpdb->posts, $post_data);

					// Insert the post and retrieve its ID
					$event_id = $post_id = $wpdb->insert_id;
			  
					// Set the event metadata
					update_post_meta($event_id, 'start_date', $start_date);
					update_post_meta($event_id, 'end_date', $end_date);

					}

				  /*====================================================================
				   Upload File in Media and store its url in Database
				  ===================================================================*/

					// Retrieve the base uploads directory
					$file = $_FILES['ics_file'];
					$upload_dir = wp_upload_dir();
					$base_path = $upload_dir['basedir'];
					$base_url = $upload_dir['baseurl'];

					// Create a unique file name
					$file_name = uniqid() . '_' . $file['name'];

					// Move the uploaded file to the uploads directory
					$file_path = $base_path . '/' . $file_name;
					move_uploaded_file($file['tmp_name'], $file_path);

					// Generate the file URL
					$file_url = $base_url . '/' . $file_name;


					global $wpdb;
					$event_table = $wpdb->prefix . 'event_import';

					$wpdb->insert($event_table, array(
						'url' => $file_url,
						'date' => date('Y-m-d H:i:s'),
						'status' => 1));

					$event_db_id = $wpdb->insert_id;

					wp_send_json_success('Events imported successfully!');


				} else {
					wp_send_json_error('Error uploading .ics file.');
				}

			wp_die();

		}



		/*==============================================================
		  Register Custom Post Meta Field
		  ============================================================*/

		public function custom_events_meta_field() {
			
		}











}
