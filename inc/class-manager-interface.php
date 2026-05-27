<?php

namespace SediciMultisiteFooter\Inc;
use SediciMultisiteFooter\Inc\Footer_Data_Provider;


abstract class Manager_Interface {

    public function __construct( ) {
        // Registro hook para renderizar el footer en el frontend
        add_action( 'wp_footer', [ $this, 'render_footer' ] );
    }

    public abstract function is_footer_enabled();
    public abstract function disable_footer();
    public abstract function enable_footer();

    
    public abstract function save_footer_type_choice();

    /*
    *   Obtiene el tipo de footer seteado a nivel de sitio individual.
    */
    public abstract function get_footer_type();

    /*
    *   Setea el tipo de footer a nivel de sitio individual.
    */
    public abstract function set_footer_type($type);

    public function render_footer() {
        if ( ! $this->is_footer_enabled() ) {
            return;
        }

        $variante_elegida = get_option( 'sedici_footer_variant_id', '' );

        if ( empty( $variante_elegida ) ) {
            $variante_elegida = get_network_option( get_current_network_id(), 'sedici_network_footer_variant_id', 'institucional' );
        }

        $datos_footer = Footer_Data_Provider::get( $variante_elegida );

        $ruta_plantilla = SEDICI_MULTISITE_FOOTER_PLUGIN_DIR . 'public/footer-template.php';
        load_template( $ruta_plantilla, false, $datos_footer );
    }

}
