<?php

namespace SediciMultisiteFooter\Inc;
use SediciMultisiteFooter\Inc\Manager_Interface;

/*
*
*   Clase para englobar comportamiento del plugin activo a nivel de sitio individual. 
*   Implementa la interfaz Footer_Interface. CAMBIAR NOMBRE DE LA CLASE
*/
class Single_Site_Manager extends Manager_Interface {
    
    public function is_footer_enabled() {
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

    public function save_footer_choice() {
        
    }
}


?>