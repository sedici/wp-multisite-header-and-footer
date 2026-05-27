<?php

namespace SediciMultisiteFooter\Inc;
use SediciMultisiteFooter\Inc\Manager_Interface;
use SediciMultisiteFooter\Inc\Footer_Data_Provider;

/*
*
*   Clase para englobar comportamiento del plugin activo a nivel de red. 
*   Implementa la interfaz Footer_Interface
*/
class Multisite_Manager extends Manager_Interface {

    /**
    * Devuelve las opciones disponibles para el contexto de un multisitio (y chequeando si la peticion viene 
    * la interfaz de admin de la red).
    */
    public function get_available_options() {
        $options = Footer_Data_Provider::get_options();

        if ( is_multisite() && ! is_network_admin() ) {
            array_unshift( $options, 'heredado' );
        }

        return $options;
    }

    /**
    * Valida si la opción enviada por el form es válida para este contexto.
    */
    public function is_valid_footer_type( $type ) {

        if( is_network_admin()) {
            if( Footer_Data_Provider::type_exists( $type )) {
                return true;
            }
            else return false;
        }
        else {
            if( Footer_Data_Provider::type_exists( $type ) || $type === 'heredado' ) {
                return true;
            }
            else return false;
        }
    }

    /*
    *   Obtiene el tipo de footer seteado a nivel de red.
    */
    public function get_footer_type_from_network() {
        return get_network_option(get_current_network_id(), 'sedici_network_footer_type');
    }

    /*
    *   Setea el tipo de footer a nivel de sitio red.
    */
    public function set_network_footer_type($type) {
        update_network_option(get_current_network_id(), 'sedici_network_footer_type', $type);
    }

    public function is_footer_enabled() {
        return get_network_option(get_current_network_id(), 'sedici_footer_network_status') == 1;
    }

    public function disable_footer() {
        update_network_option(get_current_network_id(), 'sedici_footer_network_status', 0);
    }

    public function enable_footer() {
        update_network_option(get_current_network_id(), 'sedici_footer_network_status', 1);
    }

    /*
    *   Obtiene el tipo de footer seteado para el sitio actual.
    */
    public function get_footer_type() {
        return get_option('sedici_footer_type');
    }

    /*
    *   Setea el tipo de footer para el sitio actual.
    */
    public function set_footer_type($type) {
        update_option('sedici_footer_type', $type);
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

}


?>