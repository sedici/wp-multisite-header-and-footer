<?php

namespace SediciMultisiteFooter\Inc;
use SediciMultisiteFooter\Inc\Data_Provider;
use SediciMultisiteFooter\Inc\Manager_Interface;

/*
*
*   Clase para englobar el comportamiento de la administración de red de un multisitio.
*/
class Network_Multisite_Manager extends Manager_Interface {

    /*
    *   Obtiene el tipo de footer seteado a nivel de red.
    */
    public function get_footer_type_from_network() {
        return get_network_option(get_current_network_id(), 'sedici_network_footer_type');
    }

    public function enable_footer() {
        update_network_option(get_current_network_id(), 'sedici_footer_network_status', 1);
    }

    /*
    *   Deshabilita el footer cambiando el footer status en la bd
    */
    public function disable_footer() {
        update_network_option(get_current_network_id(), 'sedici_footer_network_status', 0);
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
    *   Setea el tipo de footer a nivel de sitio red.
    */
    public function set_network_footer_type($type) {
        update_network_option(get_current_network_id(), 'sedici_network_footer_type', $type);
    }

    /**
    * Devuelve las opciones disponibles para el contexto de un multisitio y la interfaz de admin de la red.
    */
    public function get_available_options() {
        $options = Footer_Data_Provider::get_options();

        return $options;
    }

    /**
    * Valida si la opción enviada por el form es válida para este contexto.
    */
    public function is_valid_footer_type( $type ) {
        return Footer_Data_Provider::type_exists( $type );
    }

}


?>