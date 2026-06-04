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

    public function is_footer_inherited() {
        $subsite_footer_status = get_option('sedici_footer_status', 'heredado');
        $variante_elegida = get_option('sedici_footer_type', 'heredado');
        
        if ( $subsite_footer_status == 'heredado' && $variante_elegida == 'heredado' )
            return true;
        else 
            return false;
        
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

    public function set_footer_type($type) {
        update_option('sedici_footer_type', $type);
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

    public function get_data_for_form() {
        return [
            'is_network_admin_interface' => false,
            'is_footer_sync_with_network' => (get_option('sedici_is_subsite_footer_sync_with_network') == 1)
        ];
    }

    public function set_sync_status( $status ) {
        if ( $status == '1' ) {
            $this->sync_with_network();
        }
        else if ( $status == '0' ) {
            $this->desync_with_network();
        }
    }

    protected function desync_with_network() {
        update_option('sedici_is_subsite_footer_sync_with_network', 0);
        update_option('sedici_footer_status', '1');
        update_option('sedici_footer_type', 'prebi-sedici');
    }

    protected function sync_with_network() {
        update_option('sedici_is_subsite_footer_sync_with_network', 1);
        update_option('sedici_footer_status', 'heredado');
        update_option('sedici_footer_type', 'heredado');
    }

}

?>