<?php

namespace SediciMultisiteFooter\Inc;
use SediciMultisiteFooter\Inc\Footer_Data_Provider;
use SediciMultisiteFooter\Inc\Multisite_Helper;


abstract class Manager_Interface {

    use Multisite_Helper;

    public function __construct( ) {
        // Registro hook para renderizar el footer en el frontend
        add_action( 'wp_footer', [ $this, 'render_footer' ] );
    }

    abstract public function disable_footer();
    abstract public function enable_footer();
    abstract public function get_available_options();

    /**
    * Valida si la opción enviada por el form es válida para este contexto.
    */
    abstract public function is_valid_footer_type( $option );

    abstract public function is_footer_enabled();

    abstract public function is_footer_inherited();
    
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

    /*
    *   Obtiene el tipo de footer seteado para el sitio actual.
    */
    public function get_footer_type() {
        $variante_elegida = get_option('sedici_footer_type', 'heredado');
        
        if ( $variante_elegida == 'heredado' ) {
            $variante_elegida = $this->get_footer_type_from_network();
        }
        return $variante_elegida;
    }

    /*
    *   Setea el tipo de footer para el sitio actual.
    */
    public function set_footer_type($type) {
        update_option('sedici_footer_type', $type);
    }

    public function render_footer() {
        
        if ( ! $this->is_footer_enabled() ) {
            return;
        }

        $variante_elegida = $this->get_footer_type();

        $datos_footer = Footer_Data_Provider::get( $variante_elegida );

        $ruta_plantilla = SEDICI_MULTISITE_FOOTER_PLUGIN_DIR . 'public/footer-template.php';
        load_template( $ruta_plantilla, false, $datos_footer );
    }

}
