<?php

namespace SediciMultisiteFooter\Core;
use SediciMultisiteFooter\Inc\Multisite_Helper;

/**
 * Acciones luego de desactivar el plugin
 */

class Deactivator {

    use Multisite_Helper;

	/**
	 *  Acciones a ejecutar luego de desactivar el plugin
     * Elimina las opciones seteadas al activar el plugin
     * @return void
	 */
	public static function deactivate() {

		if ( is_multisite() ) {
            self::delete_network_options_from_database();
			self::run_on_all_sites( function() {
                self::delete_site_options_from_database();
			});
        }
		else {
			self::delete_site_options_from_database();
		}
	
	}


    public static function delete_network_options_from_database() {
        delete_network_option(get_current_network_id(),'sedici_footer_network_status');
        delete_network_option(get_current_network_id(),'sedici_footer_network_type');
    }

    public static function delete_site_options_from_database() {
        delete_option('sedici_footer_status');
        delete_option('sedici_footer_type');
    }

}
