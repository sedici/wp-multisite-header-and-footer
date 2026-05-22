<?php

namespace SediciMultisiteFooter\Inc;

class Single_Site_Footer extends Footer_Interface {
    
    public function is_enabled() {
        return get_option('sedici_footer_status') == 1;
    }

    public function disable_footer() {
        update_option('sedici_footer_status', 0);
    }

    public function enable_footer() {
        update_option('sedici_footer_status', 1);
    }

    /*
    *   Obtiene el tipo de footer seteado para el sitio actual. Si no se encuentra, devuelve 'prebi-sedici' por defecto.
    */
    public function get_footer_type() {
        return get_option('sedici_footer_type', 'prebi-sedici');
    }

    /*
    *   Setea el tipo de footer para el sitio actual.
    */
    public function set_footer_type($type) {
        update_option('sedici_footer_type', $type);
    }
}


?>