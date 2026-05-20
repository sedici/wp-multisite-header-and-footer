<?php

namespace SediciMultisiteFooter\Inc;

/**
 * Acciones luego de desactivar el plugin
 */

class Deactivator {

	/**
	 *
	 */
	public static function deactivate() {

		if ( is_multisite() ) {
            delete_network_option(get_current_network_id(),'sedici_footer_network_status', 0);
			self::run_on_all_sites( function() {
				delete_option('sedici_footer_status');
			});
        }
		else {
			delete_option('sedici_footer_status');
		}
	
	}

	/**
     * Ejecuta una función específica (callback) en todos los sitios de la red multisitio.
     *
     * @param callable $callback La función a ejecutar dentro del contexto de cada sitio.
     * @return void
     */
    private static function run_on_all_sites( callable $callback ) {
        if ( ! is_multisite() ) {
            return; // Seguridad: Si no es multisitio, salimos.
        }

        $blog_id_actual = get_current_blog_id();
        $sitios = get_sites();

        foreach ( $sitios as $sitio ) {
            switch_to_blog( $sitio->blog_id );
            
            // Ejecutamos la función que nos pasaron por parámetro
            call_user_func( $callback );
            
            restore_current_blog();
        }

        switch_to_blog( $blog_id_actual );
    }

}
