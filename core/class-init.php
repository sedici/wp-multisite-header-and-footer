<?php 

namespace Wp_multisite_manager\Core;
use Wp_multisite_manager as MM;
use Wp_multisite_manager\Admin as Admin;
use Wp_multisite_manager\Inc as Inc;

require_once 'class-loader.php';

require plugin_dir_path( __DIR__ ) . 'Inc/class-My-Template-Loader.php';


$dirMultisite = plugin_dir_path( __DIR__ ) . 'admin/multisiteAdmin.php';
$dirSinglesite = plugin_dir_path( __DIR__ ) . 'admin/singlesiteAdmin.php';

require  $dirSinglesite ;
require  $dirMultisite ;


/**
 * Clase para administrar los hooks y encolar los estilos / scripts
 */
class Init{
    /**
	 * @var      Loader    $loader    es el encargado de mantener y administar los hooks.
	 */
	protected $loader;
	/**
	 * @var      string    $plugin_base_name    string para identificar al plugin
	 */
	protected $plugin_basename;

	protected $multisite_administrator;

	protected $singlesite_administrator;
	
	protected $plugin_name;
	protected $version;
	protected $plugin_text_domain;


	public function __construct() {

		$this->plugin_name = MM\PLUGIN_NAME;
		$this->version = MM\PLUGIN_VERSION;
		$this->plugin_basename = MM\PLUGIN_BASENAME;
		$this->plugin_text_domain = MM\PLUGIN_TEXT_DOMAIN;

		$this->loader = new Loader();

		$this->multisite_administrator = new admin\multisiteAdmin($this);
		$this->singlesite_administrator = new admin\singlesiteAdmin($this);

		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	public function run() {
		$this->loader->run();
	} 

	# Register ADMIN Styles and Scripts --------------------------------------------------------------------

	function reg_admin_styles(){

		$js_url = MM\PLUGIN_NAME_URL.'admin/js/';

		wp_register_script('dinamicHeader', $js_url . 'dinamicHeader.js', array('jquery'),'1.1', true);
 
		wp_enqueue_script('dinamicHeader');
	

		$css_url = MM\PLUGIN_NAME_URL.'admin/css/administrationStyle.css';

		wp_register_style("administrationStyle", $css_url);

		wp_enqueue_style("administrationStyle");
	}


	function insert_modal_js (){ 
		wp_register_script('identify-modal',  MM\PLUGIN_NAME_URL . 'templates/js/modal-ajax.js', array('jquery'), '1', true );
		wp_enqueue_script('identify-modal');	
		wp_localize_script('identify-modal','imjs_vars',array('url'=>admin_url('admin-ajax.php')));
	}

	
	# Register PUBLIC Styles and Scripts --------------------------------------------------------------------
	
	function reg_public_styles() {
		$js_url = MM\PLUGIN_NAME_URL.'admin/js/';
		
		$public_css_HYF_url = MM\PLUGIN_NAME_URL.'templates/css/headerAndFooter.css';

	
		wp_register_style("multisite-manager-hyf-css", $public_css_HYF_url);

		wp_enqueue_style("multisite-manager-hyf-css");

		$public_css_GENERAL_url = MM\PLUGIN_NAME_URL.'templates/css/general.css';
		wp_register_style("multisite-manager-general-css", $public_css_GENERAL_url);

		wp_enqueue_style("multisite-manager-general-css");

	}

	# End of Styles and Scripts register --------------------------------------------------------------------

	function add_type_attribute($tag, $handle, $src) {
		// if not your script, do nothing and return original $tag
		if ( 'carrousel' !== $handle ) {
			return $tag;
		}
		// change the script tag by adding type="module" and return it.
		$tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
		return $tag;
	}

	# Register ADMIN Hooks --------------------------------------------------------------------

	/*
	* Esta función define los Hooks de ADMIN para SINGLE SITE
	*
	*/


	private function define_admin_hooks() {


		// Solo debemos registrar el CPT de sitios si es el sitio principal

		if(is_main_site()){

		
	
			/* wp_enqueue_scripts es el hook usado para encolar el script insertar_modal_js
			que sera usado en el frontend */
		

			/* wp_enqueue_scripts es el hook usado para encolar el script carga-dinamica.js
			que sera usado en el frontend */
			add_action('wp_enqueue_scripts',array($this,'dynamic_view_js'));

			/* Hook usado para encolar scripts helpers */
			add_action('wp_enqueue_scripts',array($this,'helpers_js'));


			add_action('wp_ajax_load_more',array($this,'load_more')  );
			add_action( 'wp_ajax_nopriv_load_More', array($this,'load_more') );

		}


		if ( ! defined('ABSPATH') ) {
			/** Set up WordPress environment */
			require_once( dirname( __FILE__ ) . '/wp-load.php' );
		}
	
		// Register Scripts and Styles
		

		add_action('admin_enqueue_scripts',array($this,'reg_admin_styles'),30);

	}

	function load_plugin_textdomain() {
		load_plugin_textdomain( 'wp-multisite-manager', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	  }


    private function define_public_hooks() {
		add_action( 'plugins_loaded', 'load_plugin_textdomain' );

		add_filter('script_loader_tag', array($this,'add_type_attribute') , 10, 3);

		add_action('wp_enqueue_scripts',array($this,'reg_public_styles'),30);

	}


    // Función para registrar los shortcodes

	function dynamic_view_js (){ 
		wp_register_script('dynamic_addition',  MM\PLUGIN_NAME_URL . 'templates/js/carga-dinamica.js', array('jquery'), '1', true );
		wp_enqueue_script('dynamic_addition');	
	}

	function helpers_js() {
		wp_register_script('helpers_multisite_js',  MM\PLUGIN_NAME_URL . 'templates/js/helpers.js');
		wp_enqueue_script('helpers_multisite_js');
	}

	








	function get_image_url($post_id) {

		if(get_post_meta(get_the_ID(),'site_screenshot') and (!empty(get_post_meta(get_the_ID(),'site_screenshot')[0]) ))
		{
			$image = $this->get_image($post_id,'site_screenshot');

			$image_src = '';

			if(!is_wp_error($image)){
				$image_src = wp_get_attachment_url($this->get_image($post_id,'site_screenshot')) ;
		 	} 

			return $image_src;

		}
	}
	

	function get_image($post_id,$field){
		return get_post_meta($post_id, $field,true);
	}

    




}