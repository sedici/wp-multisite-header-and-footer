<?php

namespace SediciMultisiteFooter\Inc;
use SediciMultisiteFooter\Inc\Footer_Data_Provider;


abstract class Manager_Interface {

    public function __construct( ) {
        // Registro hook para renderizar el footer en el frontend
        add_action( 'wp_footer', [ $this, 'render_footer' ] );
    }

    abstract public function is_footer_enabled();
    abstract public function disable_footer();
    abstract public function enable_footer();

    /**
    * Devuelve las opciones disponibles para este contexto específico.
    */
    abstract public function get_available_options();

    /**
    * Valida si la opción enviada por el form es válida para este contexto.
    */
    abstract public function is_valid_footer_type( $option );
    
    abstract public function save_footer_type_choice($type);

    /*
    *   Obtiene el tipo de footer seteado a nivel de sitio individual.
    */
    abstract public function get_footer_type();

    /*
    *   Setea el tipo de footer a nivel de sitio individual.
    */
    abstract public function set_footer_type($type);

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
