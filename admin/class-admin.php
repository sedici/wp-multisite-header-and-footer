<?php
namespace SediciMultisiteFooter\Admin;
use SediciMultisiteFooter\Inc\Footer_Factory;


class Admin {

    private $footer;

    public function __construct() {

        $this->footer = Footer_Factory::create();

        add_action('network_admin_menu',array($this,'add_plugin_admin_menu'),30); 
        add_action('admin_enqueue_scripts',array($this,'reg_admin_styles'),30);
        
        // Registro hook para procesar el form de estado del footer
        add_action( 'admin_post_sedici_footer_save_status', [ $this, 'save_footer_status' ] );

        // Registro hook para procesar el form de seleccion de footer
        add_action( 'admin_post_sedici_footer_selection', [ $this, 'save_footer_choice' ] );

        // Registro hook para renderizar el footer en el frontend
        add_action( 'wp_footer', [ $this, 'render_global_footer' ] );
    }


    /**
     * Agrega el submenú bajo la pestaña "Sitios"
     */
    public function add_plugin_admin_menu() {

        add_submenu_page(
            'sites.php',                  
            'Configuración Global Footer', 
            'Configuración Footer Global',               
            'manage_network_options',      
            'sedici-global-footer',      
            [ $this, 'render_form_multisite_footer' ]
        );
    
    }

    public function render_form_multisite_footer()
    {   

        if ( ! is_super_admin() ) {
            wp_die( 'No tienes permisos suficientes para realizar esta acción.' );
        }

        else {
            $footer_status = $this->footer->is_enabled();
            if( $this->footer->is_enabled() )   
                include_once dirname(__DIR__) . '/admin/views/adminMenu/footer-form.php';
            else 
                include_once dirname(__DIR__) . '/admin/views/adminMenu/footer-form-manager.php'; 
        }
    }


    public function save_footer_status() {

        if ( ! is_super_admin() ) {
            wp_die( 'No tienes permisos suficientes para realizar esta acción.' );
        }

        if ( isset( $_POST['input_sedici_footer_status'] ) && $_POST['input_sedici_footer_status'] == '1' ) {
            $this->footer->enable_footer();
        } else {
            $this->footer->disable_footer();
        }

        $url_dest = add_query_arg( array( 'success' => 'true' ), wp_get_referer() );
        wp_redirect($url_dest);
        exit;
    }


    public function render_footer() {

    }

    public function reg_admin_styles(){

		$css_url = SEDICI_MULTISITE_FOOTER_PLUGIN_DIR.'admin/css/administrationStyle.css';
		wp_register_style("administrationStyle", $css_url);
		wp_enqueue_style("administrationStyle");
	}

}
?>