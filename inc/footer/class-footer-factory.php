<?php

namespace SediciMultisiteFooter\Inc\Footer;

class Footer_Factory {

    /**
     * Resuelve el contexto de WordPress una sola vez.
     * @return FooterInterface
     */
    public static function create() {
        if ( is_multisite() ) {
            return new Network_Footer();
        }
        return new Single_Site_Footer();
    }


}

?>