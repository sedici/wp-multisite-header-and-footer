<?php
namespace SediciMultisiteFooter\Admin;
use SediciMultisiteFooter\Inc\Manager_Factory;
use SediciMultisiteFooter\Inc\Footer_Data_Provider;

class Admin {

    private $manager;

    public function __construct() {

        $this->manager = Manager_Factory::create();

        add_action('network_admin_menu',array($this,'add_plugin_admin_menu'),30); 
        add_action('admin_enqueue_scripts',array($this,'reg_admin_styles'),30);
        
        // Registro hook para procesar el form de estado del footer
        add_action( 'admin_post_sedici_footer_save_status', [ $this, 'save_footer_status' ] );

        // Registro hook para procesar el form de seleccion de footer
        add_action( 'admin_post_sedici_footer_selection', [ $this, 'save_footer_choice' ] );

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
            $footer_status = $this->manager->is_footer_enabled() ? 1 : 0;
            $form_options = Footer_Data_Provider::get_options();

            if ( is_multisite() && ! is_network_admin() ) {
                array_unshift( $form_options, 'heredado' );
            }

            $ruta_form = dirname(__DIR__) . '/admin/views/footer-form.php';
            load_template( $ruta_form, false, ['form_options' => $form_options, 'footer_status' => $footer_status ] );
        }
                
    }


    public function save_footer_status() {

        if ( ! is_super_admin() ) {
            wp_die( 'No tienes permisos suficientes para realizar esta acción.' );
        }

        if ( isset( $_POST['input_sedici_footer_status'] ) && $_POST['input_sedici_footer_status'] == '1' ) {
            $this->manager->enable_footer();
        } else {
            $this->manager->disable_footer();
        }

        $url_dest = add_query_arg( array( 'success' => 'true' ), wp_get_referer() );
        wp_redirect($url_dest);
        exit;
    }

    public function save_footer_choice() {

        if ( ! is_super_admin() ) {
            wp_die( 'No tienes permisos suficientes para realizar esta acción.' );
        }

        if ( isset( $_POST['sedici_footer_selection'] ) && ! empty( $_POST['sedici_footer_selection'] ) ) {
            $selected_option = sanitize_text_field( $_POST['sedici_gf_layout_simple'] );
            $this->manager->save_footer_type_choice($selected_option);
        }

        $url_dest = add_query_arg( array( 'success' => 'true' ), wp_get_referer() );
        wp_redirect($url_dest);
        exit;

    }

    public function reg_admin_styles(){

		$css_url = SEDICI_MULTISITE_FOOTER_PLUGIN_DIR.'admin/css/administrationStyle.css';
		wp_register_style("administrationStyle", $css_url);
		wp_enqueue_style("administrationStyle");
	}

}
?>