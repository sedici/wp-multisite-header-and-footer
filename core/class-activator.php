<?php

namespace SediciMultisiteFooter\Core;
use SediciMultisiteFooter\Inc\Multisite_Helper;

/**
 * Acciones luego de desactivar el plugin
 */

class Activator {

    use Multisite_Helper;

	/** 
	 * Acciones a ejecutar luego de activar el plugin
     * @return void
     * 
	 */
	public static function activate() {

		if ( is_multisite() ) {
            
            self::register_network_options_in_database();

			self::run_on_all_sites( function() {
				self::register_site_options_in_database('heredado');
			});
        }
		else {
			self::register_site_options_in_database();
		}
	}

    /*
    *   Agrega las opciones de red del plugin a la base de datos
    */
    public static function register_network_options_in_database() {
        add_network_option(get_current_network_id(),'sedici_footer_network_status', 0);
        add_network_option(get_current_network_id(),'sedici_footer_network_type', 'prebi-sedici');
    }
    
    /*
    *   Agrega las opciones para un sitio individual a la base de datos 
    */
    public static function register_site_options_in_database($default_type = 'prebi-sedici') {
        $default_status = is_multisite() ? 'heredado' : 0;
        add_option('sedici_footer_status', $default_status);
        add_option('sedici_footer_type', $default_type);
    }

}
