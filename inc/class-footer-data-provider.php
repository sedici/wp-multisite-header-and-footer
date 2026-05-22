<?php

namespace SediciMultisiteFooter\Inc;

class Footer_Data_Provider {

    /**
     * Devuelve todas las variantes disponibles.
     */
    private static function get_all() {
        return [
            'prebi-sedici' => [
                'color_fondo'     => '#004b87',
                'logo_dependencia' => '',
                'texto_principal' => 'Sitio web desarrollado en colaboracion con',
                'nombre_dependencia' => 'PREBI-SEDICI',
                'url_dependencia' => 'https://prebi.sedici.unlp.edu.ar/',
                'nombre_institución' => 'Universidad Nacional de La Plata (UNLP)',
                'url_institución' => 'https://unlp.edu.ar/',

            ],
            'cesgi' => [
                'color_fondo'     => '#004b87',
                'logo_dependencia' => '',
                'texto_principal' => 'Sitio web desarrollado en colaboracion con',
                'nombre_dependencia' => 'CESGI',
                'url_dependencia' => 'https://cesgi.cic.gba.gob.ar/',
                'nombre_institución' => 'Comisión de Investigaciones Científicas de la Provincia de Buenos Aires (CIC)',
                'url_institución' => 'https://www.cic.gba.gob.ar/',
            ],
            'prebi-cesgi' => [
                'color_fondo'     => '',
                'logo_dependencia' => '',
                'texto_principal' => '',
                'nombre_dependencia' => '',
                'url_dependencia' => '',
                'nombre_institución' => '',
                'url_institución' => '',
            ]
        ];
    }

    public static function get_options() {
        return [
            'heredado',
            'prebi-sedici',
            'cesgi',
            'prebi-cesgi'
        ];
    }

    /**
     * Devuelve los datos de una variante específica por su ID.
     */
    public static function get( $id_variante ) {
        $variantes = self::get_all();
        
        // Si el ID existe, lo devolvemos. Si no, devolvemos el institucional por defecto.
        return isset( $variantes[ $id_variante ] ) ? $variantes[ $id_variante ] : $variantes['prebi-sedici'];
    }

}



?>