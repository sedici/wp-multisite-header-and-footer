<?php

namespace SediciMultisiteFooter\Inc;
use SediciMultisiteFooter\Inc\Single_Site_Manager;
use SediciMultisiteFooter\Inc\Network_Multisite_Manager;
use SediciMultisiteFooter\Inc\Subsite_Multisite_Manager;

class Manager_Factory {

    /**
     * Resuelve el contexto de WordPress una sola vez.
     * @return Manager
     */
    public static function create() {

        // 1. NO estamos en un entorno multisitio, devuelvo el manager para sitio único
        if ( ! is_multisite() ) {
            return new Single_Site_Manager();
        }

        // 2. ES multisitio y estamos en el panel de Administración de la Red
        if ( is_network_admin() ) {
            return new Network_Multisite_Manager();
        }
        
        // 3. Si ES multisitio pero estamos en un Subsitio
        return new Subsite_Multisite_Manager();   
        
    }


}
