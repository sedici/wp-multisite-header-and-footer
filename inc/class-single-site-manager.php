<?php

namespace SediciMultisiteFooter\Inc;
use SediciMultisiteFooter\Inc\Manager_Interface;

/*
*
*   Clase para englobar comportamiento de un sitio individual dentro de un multisitio.
*/
class Single_Site_Manager extends Manager_Interface {

    public function is_footer_enabled() {
        
        $local_status = get_option('sedici_footer_status', 'heredado');

        if ( $local_status == '1' )
            return true;
        else return false;
    }

    public function enable_footer() {
        update_option('sedici_footer_status', 1);
    }

    public function disable_footer() {
        update_option('sedici_footer_status', 0);
    }

    public function set_footer_type($type) {
        update_option('sedici_footer_type', $type);
    }

    /*
    *   Obtiene el tipo de footer seteado a nivel de red.
    */
    public function get_footer_type_from_network() {
        return get_option('sedici_footer_type');
    }

    /*
    *   Obtiene el tipo de footer seteado para el sitio actual.
    */
    public function get_footer_type() {
        $type = get_option('sedici_footer_type', 'prebi-sedici');

        return $type;
    }

    /**
     * Devuelve un array con los datos necesarios para el formulario de configuración del footer.
     * is_network_admin se retorna en true porque es un sitio individual y no es necesario mostrar el checkbox de sincronización con la red.
     */
    public function get_data_for_form() {
        return [ 'is_network_admin_interface' => true, 
                 'is_footer_sync_with_network' => false ];
    }
}


?>