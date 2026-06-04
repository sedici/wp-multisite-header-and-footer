<?php

namespace SediciMultisiteFooter\Inc;
use SediciMultisiteFooter\Inc\Data_Provider;
use SediciMultisiteFooter\Inc\Manager_Interface;

/*
*
*   Clase para englobar el comportamiento de la administración de red del footer en un multisitio.
*/
class Network_Multisite_Manager extends Manager_Interface {

    public function is_footer_enabled() {
        return get_network_option(get_current_network_id(), 'sedici_footer_network_status') == 1;
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
        $type = $this->get_footer_type_from_network();
        return $type;
    }

    /*
    *   Setea el tipo de footer a nivel de sitio red.
    */
    public function set_footer_type($type) {
        update_network_option(get_current_network_id(), 'sedici_footer_network_type', $type);
    }

    /**
     * Devuelve datos adicionales para renderizar el formulario de configuracion del footer
     */
    public function get_data_for_form() {
        return [ 'is_network_admin_interface' => true, 
                 'is_footer_sync_with_network' => false ];
    }

}


?>