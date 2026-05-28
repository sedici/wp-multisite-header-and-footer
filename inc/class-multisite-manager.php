<?php

namespace SediciMultisiteFooter\Inc;
use SediciMultisiteFooter\Inc\Manager_Interface;
use SediciMultisiteFooter\Inc\Footer_Data_Provider;
use SediciMultisiteFooter\Inc\Multisite_Helper;

/*
*
*   Clase para englobar comportamiento del plugin activo a nivel de red. 
*   Implementa la interfaz Footer_Interface
*/
class Multisite_Manager extends Manager_Interface {

    use Multisite_Helper;

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
        // 1. Se lee la configuración local del subsitio
        $local_status = get_option('sedici_footer_status', 'heredado');

        // 2. Si el subsitio decidió explícitamente apagarlo (0) o prenderlo (1), respetamos eso
        if ( $local_status == '1' )
            return true;
        else return false;

        // 3. Si el estado local es 'heredado', preguntamos a la red si el footer esta activo o no
        return get_network_option(get_current_network_id(), 'sedici_footer_network_status') == 1;
    }

    public function disable_footer() {
        update_network_option(get_current_network_id(), 'sedici_footer_network_status', 0);
    }

    /*
    *   Setea el estado del footer a nivel de red como habilitado.
    *   Tiene que diferenciar entre habilitar el footer a nivel de red (que se refleja en la base de datos como una 
    *   opción de red) y habilitarlo a nivel de sitio individual (que se refleja como una opción del sitio). 
    */
    public function enable_footer() {

        if(is_network_admin()) {
            update_network_option(get_current_network_id(), 'sedici_footer_network_status', 1);
            self::run_on_all_sites( function() {
                update_option('sedici_footer_status', 1);
            });
        }
        else {
            update_option('sedici_footer_status', 1);
        }
        

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