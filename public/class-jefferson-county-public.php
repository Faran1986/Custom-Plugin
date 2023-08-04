<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://iplex.co
 * @since      1.0.0
 *
 * @package    Jefferson_County
 * @subpackage Jefferson_County/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Jefferson_County
 * @subpackage Jefferson_County/public
 * @author     Iplex <info@iplex.co>
 */
class Jefferson_County_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/jefferson-county-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'mobiscroll-css', plugin_dir_url( __FILE__ ) . 'css/mobiscroll.jquery.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'font-awesome-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), $this->version, 'all' );
		
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jefferson-county-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'mobiscroll-js', plugin_dir_url( __FILE__ ) . 'js/mobiscroll.jquery.min.js', array( 'jquery' ), $this->version, false );
		
		wp_localize_script($this->plugin_name, 'ajax_object', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce'   => wp_create_nonce('custom-ajax-nonce'),
		));

	}




	public function calendar_templates_shortcode(){

		add_shortcode('calendar_template',array($this,'calendar_templates_callback'));

	}


	public function calendar_templates_callback(){

		$html = '';

		ob_start();

		include ABSPATH  . 'wp-content/plugins/jefferson-county/public/partials/jefferson-county-public-display.php';

		$html = ob_get_contents();

		ob_clean();

		return $html;

	}




	public function get_calendar_events(){

	  $colors = ['#ff6d42','#7bde83','#7bde83', '#913aa7'];

	  
    
      $args = array(
            'post_type' => 'calendar_events',
            'posts_per_page' => -1, // Retrieve all posts
      );

	//   if(isset($_POST['cat_slug']) && $_POST['cat_slug'] != 'all'){
	// 	$args['category_name'] = $_POST['cat_slug'];
	//   }
      
      $query = new WP_Query($args);

      $aw_posts = [];

      $i = 1;
      
      if ($query->have_posts()) {

            while ($query->have_posts()) {

            $query->the_post();
            
            global $post;

            $post_id = $post->ID;
            
            $start_date = get_post_meta($post_id,'start_date',true);
            $end_date = get_post_meta($post_id,'start_date',true);

            $aw_posts[] =  array(
                  'start' => $start_date,
                  'end' => $end_date,
                  'title' => get_the_title(),
                  'color' => '#7bde83',
                  'desc' => get_the_content(),
                  'id' => $post_id,
            );

            

            $i++;
            
            }
      }
 
	  
      wp_reset_postdata();

	  echo json_encode($aw_posts);

	  wp_die();


	}






	// get event detail

	public function get_event_detail(){

		$event_id = $_POST['post_id'];

		$post = get_post($event_id);
		$post_title = $post->post_title; 
		$post_content = $post->post_content; 
		$start_date = strtotime(get_post_meta($event_id,'start_date',true));
		$end_date = strtotime(get_post_meta($event_id,'end_date',true));

		?>

		<h2><?= $post_title; ?></h2>
        <p><span><?= date("j F Y, H:i",$start_date); ?></span> - <span><?= date("j F Y, H:i",$end_date); ?></span></p>
        <p><?= $post_content; ?></p>


		<?php


		wp_die();

	}


	//get serach events

	public function get_search_events(){


		$colors = ['#ff6d42','#7bde83','#7bde83', '#913aa7'];

    
      $args = array(
            'post_type' => 'calendar_events',
            'posts_per_page' => -1,
      );

	  if(isset($_POST['cat_slug']) && $_POST['cat_slug'] != 'all'){
		$args['category_name'] = $_POST['cat_slug'];
	  }
	  if(isset($_POST['search_content']) && $_POST['search_content'] != ''){
		$args['s'] = $_POST['search_content'];
	  }
      
      $query = new WP_Query($args);

      $aw_posts = [];

      $i = 1;
      
      if ($query->have_posts()) {

            while ($query->have_posts()) {

            $query->the_post();
            
            global $post;

            $post_id = $post->ID;
            
            $start_date = get_post_meta($post_id,'start_date',true);
            $end_date = get_post_meta($post_id,'start_date',true);

            $aw_posts[] =  array(
                  'start' => $start_date,
                  'end' => $end_date,
                  'title' => get_the_title(),
                  'color' => '#7bde83',
                  'desc' => get_the_content(),
                  'id' => $post_id,
            );

            

            $i++;
            
            }
      }
 
	  
      wp_reset_postdata();

	  echo json_encode($aw_posts);

	  wp_die();

	}





}
