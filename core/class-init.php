<?php 

namespace SediciMultisiteFooter\Core;
use SediciMultisiteFooter\Admin\Admin;

require_once 'class-loader.php';


/**
 * Clase para administrar los hooks y encolar los estilos / scripts
 */
class Init {
    /**
	 * @var      Loader    $loader    es el encargado de mantener y administar los hooks.
	 */
	protected $loader;
	/**
	 * @var      string    $plugin_base_name    string para identificar al plugin
	 */
	protected $plugin_basename;

	protected $plugin_name;
	protected $version;
	protected $plugin_text_domain;


	public function __construct() {

		if ( is_admin() ) {
            $admin = new Admin();
        }
		
		$this->loader = new Loader();
		$this->define_public_hooks();
		
	}

	public function run() {
		$this->loader->run();
	} 

	
	# Register PUBLIC Styles and Scripts --------------------------------------------------------------------
	
	function reg_public_styles() {
		$js_url = SEDICI_MULTISITE_FOOTER_PLUGIN_DIR.'admin/js/';
		
		$public_css_HYF_url = SEDICI_MULTISITE_FOOTER_PLUGIN_DIR.'templates/css/headerAndFooter.css';

	
		wp_register_style("multisite-manager-hyf-css", $public_css_HYF_url);

		wp_enqueue_style("multisite-manager-hyf-css");

		$public_css_GENERAL_url = SEDICI_MULTISITE_FOOTER_PLUGIN_DIR.'templates/css/general.css';
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


    private function define_public_hooks() {
		add_action( 'plugins_loaded', 'load_plugin_textdomain' );

		add_filter('script_loader_tag', array($this,'add_type_attribute') , 10, 3);

		add_action('wp_enqueue_scripts',array($this,'reg_public_styles'),30);

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