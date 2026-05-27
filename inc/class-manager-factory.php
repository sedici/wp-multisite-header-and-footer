<?php

namespace SediciMultisiteFooter\Inc;

class Manager_Factory {

    /**
     * Resuelve el contexto de WordPress una sola vez.
     * @return Manager
     */
    public static function create() {
        if ( is_multisite() ) {
            return new Network_Manager();
        }
        return new Single_Site_Manager();
    }


}

?>