<?php

namespace SediciMultisiteFooter\Inc;
use SediciMultisiteFooter\Inc\Manager_Interface;

/*
*
*   Clase para englobar comportamiento del plugin activo a nivel de red. 
*   Implementa la interfaz Footer_Interface
*/
class Network_Manager extends Manager_Interface {
    
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
    *   Obtiene el tipo de footer seteado para el sitio actual. Si no se encuentra, devuelve 'heredado' por defecto.
    */
    public function get_footer_type() {
        return get_option('sedici_footer_type', 'heredado');
    }

    /*
    *   Setea el tipo de footer para el sitio actual. Si se setea 'heredado', el sitio tomará la configuración del footer a nivel de red.
    */
    public function set_footer_type($type) {
        update_option('sedici_footer_type', $type);
    }

    public function save_footer_choice() {
        
    }

}


?>