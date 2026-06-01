<?php 

namespace SediciMultisiteFooter\Core;
use SediciMultisiteFooter\Admin\Admin;
use SediciMultisiteFooter\Inc\Manager_Factory;

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
		
		
	}
	
	public function run() {
		$this->loader->run();
	}

	public function define_public_hooks() {
		add_action('wp_enqueue_scripts',array($this,'reg_public_styles'),30);
		Manager_Factory::create('subsite');
	}

	public function reg_public_styles() {
		$public_footer_css = plugins_url( 'public/css/sedici-global-footer-public.css', dirname( __DIR__ ) . '/multisite-footer.php' );		wp_register_style("multisite-manager-general-css", $public_footer_css);
		wp_enqueue_style("multisite-manager-general-css");
	}

}