<?php

namespace SediciMultisiteFooter\Inc;
use SediciMultisiteFooter\Inc\Footer_Data_Provider;
use SediciMultisiteFooter\Inc\Multisite_Helper;

/**
 * Clase abstracta que define la interfaz común para los managers de footer.
 */
abstract class Manager_Interface {

    use Multisite_Helper;

    public function __construct( ) {
        // Registro hook para renderizar el footer en el frontend
        add_action( 'wp_footer', [ $this, 'render_footer' ] );
    }

    abstract protected function disable_footer();
    abstract protected function enable_footer();
    abstract public function is_footer_enabled();
    abstract public function set_footer_type($type);
    abstract public function get_footer_type();

    abstract public function get_data_for_form();


    /**
    * Valida si la opción enviada por el form es válida para este contexto.
    */
    public function is_valid_footer_type( $type ) {
        return Footer_Data_Provider::type_exists( $type );
    }

    /**
    * Devuelve las opciones disponibles para setear el tipo de footer.
    */
    public function get_available_options() {
        $options = Footer_Data_Provider::get_options();

        return $options;
    }

    /**
     * Carga el formulario de admin del footer pasando los datos necesarios para su renderizado.
     */
    public function load_form() {
        $common_args = [
            'footer_status' => $this->is_footer_enabled() ? 1 : 0,
            'form_options' => $this->get_available_options(),
            'footer_type_selected' => $this->get_footer_type()
        ];
        
        $args = array_merge( $common_args, $this->get_data_for_form() );

        $ruta_form = dirname(__DIR__) . '/admin/views/footer-form.php';
        load_template( $ruta_form, false, $args );

    }

    /**
     * Guarda la elección de habilitar o deshabilitar el footer realizada por el usuario.
     */
    public function save_footer_status($status) {
        
        if ($status == '1') {
            $this->enable_footer();
        }
        else if ($status == '0') {
            $this->disable_footer();
        }
        else {
            wp_die('Valor de status de footer no válido.');
        }
    }
    
    /*
    *   Guarda la elección del tipo de footer realizada por el usuario. 
    */
    public function save_footer_type_choice($type) {
        if ($this->is_valid_footer_type($type)) {

            $this->set_footer_type($type);
        }
        else {
            wp_die('Opción de footer no válida.');
        }
    }

    /*
    *   Obtiene el tipo de footer seteado a nivel de red.
    */
    public function get_footer_type_from_network() {
        return get_network_option(get_current_network_id(), 'sedici_footer_network_type');
    }

    /**
     * Renderiza el footer en el frontend
     */
    public function render_footer() {
        
        if ( ! $this->is_footer_enabled() ) {
            return;
        }

        $variante_elegida = $this->get_footer_type();

        $datos_footer = Footer_Data_Provider::get( $variante_elegida );

        $ruta_plantilla = SEDICI_MULTISITE_FOOTER_PLUGIN_DIR . 'public/footer-template.php';
        load_template( $ruta_plantilla, false, ['datos_footer' => $datos_footer, 
                                                'variante_elegida' => $variante_elegida] );
    }

}
