<?php

namespace SediciMultisiteFooter\Inc;
use SediciMultisiteFooter\Inc\Manager_Interface;

class Subsite_Multisite_Manager extends Manager_Interface {

    public function is_footer_enabled() {
        
        $local_status = get_option('sedici_footer_status', 'heredado');

        if( $local_status === 'heredado' ) {
            return get_network_option(get_current_network_id(), 'sedici_footer_network_status') == 1;
        }
        else if ( $local_status == '1' )
            return true;
        else return false;

    }

    public function enable_footer() {
        update_option('sedici_footer_status', 1);
    }

    /*
    *   Deshabilita el footer cambiando el footer status en la bd
    */
    public function disable_footer() {
        update_option('sedici_footer_status', 0);
    }

    /**
    * Devuelve las opciones disponibles para el contexto de un multisitio y la interfaz de admin de un subsitio
    */
    public function get_available_options() {
        $options = Footer_Data_Provider::get_options();

        array_unshift( $options, 'heredado' );
        
        return $options;
    }


    /**
    * Valida si la opción enviada por el form es válida para este contexto.
    */
    public function is_valid_footer_type( $type ) {
        return Footer_Data_Provider::type_exists( $type ) || $type === 'heredado';
    }

}

?>