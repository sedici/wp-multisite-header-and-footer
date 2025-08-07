<?php 

namespace Wp_multisite_manager\Core;
use Wp_multisite_manager as MM;
use Wp_multisite_manager\Admin as Admin;
use Wp_multisite_manager\Inc as Inc;
use Wp_multisite_manager\Inc\HeaderFooter_DataService;

require_once 'class-loader.php';

require plugin_dir_path( __DIR__ ) . 'Inc/class-My-Template-Loader.php';


$dirMultisite = plugin_dir_path( __DIR__ ) . 'admin/multisiteAdmin.php';
$dirSinglesite = plugin_dir_path( __DIR__ ) . 'admin/singlesiteAdmin.php';

require  $dirSinglesite ;
require  $dirMultisite ;


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

	protected $multisite_administrator;

	protected $singlesite_administrator;
	
	protected $plugin_name;
	protected $version;
	protected $plugin_text_domain;

	/**
     * Constructor de la clase Init.
     * Inicializa propiedades del plugin, carga la clase Loader,
     * registra hooks de administración y frontend,
     * incluye shortcodes y agrega filtros de templates.
     */
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

	/**
     * Ejecuta todos los hooks registrados a través de la clase Loader.
     */
	public function run() {
		$this->loader->run();
	} 


	/**
     * Define y registra los hooks específicos para el área de administración de WordPress.
     * Encola los estilos y scripts de administración.
     */
	private function define_admin_hooks() {
	
		if ( ! defined('ABSPATH') ) {
			/** Set up WordPress environment */
			require_once( dirname( __FILE__ ) . '/wp-load.php' );
		}

		$service = new Inc\HeaderFooter_DataService('network');
		add_action('admin_enqueue_scripts',array($this,'reg_admin_styles'),30);
		add_action('admin_enqueue_scripts',array($this,'reg_admin_scripts'),30);
		add_action('wp_ajax_load_form', array($service, 'load_form_data'));

	}

	/**
     * Define y registra los hooks específicos para el frontend público de WordPress.
     * Carga el text domain y encola los estilos públicos.
     */
	private function define_public_hooks() {
		add_action( 'plugins_loaded', 'load_plugin_textdomain' );
		
		add_action('wp_enqueue_scripts',array($this,'reg_public_styles'),30);
		
	}

	/**
	 * Registra y encola los estilos CSS para el frontend público del plugin.
	*/	
	function reg_public_styles() {
		$js_url = MM\PLUGIN_NAME_URL.'admin/js/';
		
		$public_css_HYF_url = MM\PLUGIN_NAME_URL.'templates/css/headerAndFooter.css';

	
		wp_register_style("multisite-manager-hyf-css", $public_css_HYF_url);

		wp_enqueue_style("multisite-manager-hyf-css");

		$public_css_GENERAL_url = MM\PLUGIN_NAME_URL.'templates/css/general.css';
		wp_register_style("multisite-manager-general-css", $public_css_GENERAL_url);

		wp_enqueue_style("multisite-manager-general-css");

	}

	/**
     * Registra y encola los estilos necesarios para la interfaz de administración.
    */
	function reg_admin_styles(){

		$css_url = MM\PLUGIN_NAME_URL.'admin/css/administrationStyle.css';

		wp_register_style("administrationStyle", $css_url);

		wp_enqueue_style("administrationStyle");
	}

	/**
     * Registra y encola los scripts necesarios para la interfaz de administración.
    */
	function reg_admin_scripts(){

		$js_url = MM\PLUGIN_NAME_URL.'admin/js/';

		wp_register_script('dinamicHeader', $js_url . 'dinamicHeader.js', array('jquery'),'1.1', true);
		wp_enqueue_script('dinamicHeader');

		wp_register_script('HyF_load_form', $js_url . 'loadFormData.js', array('jquery'),'1', true);
		wp_enqueue_script( 'HyF_load_form', MM\PLUGIN_NAME_URL.'admin/js/loadFormData.js', array('jquery') );
		wp_localize_script( 'HyF_load_form', 'ajax_var', array(
			'url'    => admin_url( 'admin-ajax.php' ),
			'action' => 'load_form',
			'form_class' => 'wp_multisite_hyf_form', // Id del formulario para identificar cúando recuperar datos del form
		));
	}
	
	/**
     * Carga el text domain del plugin para permitir la traducción de cadenas de texto.
     */
	function load_plugin_textdomain() {
		load_plugin_textdomain( 'wp-multisite-manager', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

}