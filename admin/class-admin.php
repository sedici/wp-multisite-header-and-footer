<?php
namespace SediciMultisiteFooter\Admin;
use SediciMultisiteFooter\Inc\Manager_Factory;
use SediciMultisiteFooter\Inc\Footer_Data_Provider;

class Admin {

    private $manager;

    public function __construct() {

        add_action('network_admin_menu',array($this,'add_plugin_admin_menu'),30); 
        add_action('admin_menu', array($this, 'add_plugin_admin_menu'), 30);

        add_action('admin_enqueue_scripts',array($this,'reg_admin_styles'),30);
        
        // Registro hook para procesar el form de estado del footer
        add_action( 'admin_post_sedici_footer_save_status', [ $this, 'save_footer_status' ] );

        // Registro hook para procesar el form de seleccion de footer
        add_action( 'admin_post_sedici_footer_selection', [ $this, 'save_footer_choice' ] );

        // Registro hook para procesar el form de sincronización con la red
        add_action( 'admin_post_sedici_footer_sync_with_network', [ $this, 'set_sync_status' ] );

    }


    /**
     * Agrega el submenú bajo la pestaña "Sitios"
     */
    public function add_plugin_admin_menu() {
        $parent_slug = is_network_admin() ? 'sites.php' : 'options-general.php';
        $capability = is_multisite() ? 'manage_network_options' : 'manage_options';
        add_submenu_page(
            $parent_slug,                  
            'Configuración Footer SEDICI', 
            'Configuración Footer SEDICI',               
            $capability,      
            'sedici-global-footer',      
            [ $this, 'render_form_multisite_footer' ]
        );
    
    }

    /**
     * Verifica si el usuario actual es super admin y tiene el permiso adecuado.
     */
    private function user_can_access() {
        return is_super_admin() && (current_user_can('manage_network_options') || current_user_can('manage_options'));
    }


    /**
     * Chequea que el nonce sea válido y que la acción del usuario es la que espera
     */
    private function nonce_is_valid($nonce_action) {
        return (isset($_POST['sedici_multisite_footer_nonce']) && check_admin_referer($nonce_action, 'sedici_multisite_footer_nonce'));
    }

    private function redirect_back() {
        $url_dest = add_query_arg( array( 'success' => 'true' ), wp_get_referer() );
        wp_safe_redirect($url_dest);
        exit;
    }

    /**
     * Renderiza el formulario de configuración del footer
     */
    public function render_form_multisite_footer()
    {   

        if ( ! $this->user_can_access() ) {
            wp_die( 'No tienes permisos suficientes para realizar esta acción.' );
        }

        else {
            $is_network_admin_interface = is_network_admin();

            $context = $is_network_admin_interface ? 'network' : 'subsite';
            $this->manager = Manager_Factory::create($context);
            
            $this->manager->load_form();
        }
                
    }


    /**
     * Guarda el estado del footer (activo/inactivo) para la red o el sitio, dependiendo del contexto.
     */
    public function save_footer_status() {

        if ( ! $this->user_can_access() ) {
            wp_die( 'No tienes permisos suficientes para realizar esta acción.' );
        }
        
        if ( ! $this->nonce_is_valid('sedici_footer_save_status')) {
            wp_die('Nonce inválido.');
        }

        // Chequeo el contexto, creo al manager correspondiente y guardo el estado del footer

        $context = isset($_POST['sedici_admin_context']) ? $_POST['sedici_admin_context'] : 'subsite';

        $this->manager = Manager_Factory::create($context);

        $input = isset( $_POST['input_sedici_footer_status'] ) ? '1' : '0';

        $this->manager->save_footer_status($input);


        $this->redirect_back();
    }


    /**
     * Guarda el estado de sincronización del subsitio con la red
     */
    public function set_sync_status() {
        

        if ( ! $this->user_can_access() ) {
            wp_die( 'No tienes permisos suficientes para realizar esta acción.' );
        }

        if ( ! $this->nonce_is_valid('sedici_footer_sync_with_network')) {
            wp_die('Nonce inválido.');
        }

        $this->manager = Manager_Factory::create('subsite');

        $input = isset( $_POST['input_sync_status'] ) ? $_POST['input_sync_status'] : '0';

        $this->manager->set_sync_status($input);

        $this->redirect_back();
    }

    /**
     * Guarda la opción seleccionada para el footer
     */
    public function save_footer_choice() {

        if ( ! $this->user_can_access() ) {
            wp_die( 'No tienes permisos suficientes para realizar esta acción.' );
        }

        if ( ! $this->nonce_is_valid('sedici_footer_save_type')) {
            wp_die('Nonce inválido.');
        }

        // Chequeo el contexto, creo al manager correspondiente y guardo el estado del footer
        $context = isset($_POST['sedici_admin_context']) ? $_POST['sedici_admin_context'] : 'subsite';

        $this->manager = Manager_Factory::create($context);
        if ( isset( $_POST['sedici_footer_option_selected'] ) && ! empty( $_POST['sedici_footer_option_selected'] ) ) {
            $selected_option = sanitize_text_field( $_POST['sedici_footer_option_selected'] );
            $this->manager->save_footer_type_choice($selected_option);
        }

        $this->redirect_back();

    }

    /**
     * Registra y encola los estilos CSS para la página de administración del plugin
     */
    public function reg_admin_styles(){

		$css_url = plugins_url( 'css/sedici-global-footer-admin.css', __FILE__ );
        wp_register_style("sedici-administration-style", $css_url);
        wp_enqueue_style("sedici-administration-style");
    }

}
?>