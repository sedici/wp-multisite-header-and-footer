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
		else {
			$this->define_public_hooks();

		}
		
		$this->loader = new Loader();
		$this->loader->run();
		
		
	}

	public function define_public_hooks() {
		add_action( 'plugins_loaded', 'load_plugin_textdomain' );
		add_filter('script_loader_tag', array($this,'add_type_attribute') , 10, 3);
		add_action('wp_enqueue_scripts',array($this,'reg_public_styles'),30);

	}

	public function reg_public_styles() {
		$public_css_HYF_url = SEDICI_MULTISITE_FOOTER_PLUGIN_DIR.'templates/css/headerAndFooter.css';
		$public_css_GENERAL_url = SEDICI_MULTISITE_FOOTER_PLUGIN_DIR.'public/css/sedici-global-footer-public.css';
		wp_register_style("multisite-manager-general-css", $public_css_GENERAL_url);
		wp_enqueue_style("multisite-manager-general-css");
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