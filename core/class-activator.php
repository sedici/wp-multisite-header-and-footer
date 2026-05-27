<?php

namespace SediciMultisiteFooter\Core;

/**
 * Acciones luego de desactivar el plugin
 */

class Activator {

	/** 
	 * Acciones a ejecutar luego de activar el plugin
     * Incluye 2 options : uno para conocer el estado del footer y otro para obtener el tipo de footer seteado
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

    public static function register_network_options_in_database() {
        add_network_option(get_current_network_id(),'sedici_footer_network_status', 0);
        add_network_option(get_current_network_id(),'sedici_footer_network_type', 'prebi-sedici');
    }
    
    public static function register_site_options_in_database($default_type = 'prebi-sedici') {
        add_option('sedici_footer_status', 0);
        add_option('sedici_footer_type', $default_type);
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
