<?php
/**
 * Plugin Name: Multisite Footer
 * Plugin URI: http://sedici.unlp.edu.ar/
 * Description: This plugin allows to create and display a footer on all sites of your multisite. 
 * Version: 1.0
 * Author: SEDICI
 * Author URI: http://sedici.unlp.edu.ar/   
 * Copyright (c) 2015 SEDICI UNLP, http://sedici.unlp.edu.ar
 * Domain Path: /languages
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 */

 namespace SediciMultisiteFooter;

 /**
 * Si se accede desde afuera de wordpress aborta la ejecución.
 */
if ((! defined( 'WPINC' ) ) or (! is_multisite())) die;

 define( 'SEDICI_MULTISITE_FOOTER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

 require_once 'Inc/activator.php';
 require_once 'Inc/deactivator.php';
 require_once 'core/class-init.php';


/**
 * Register Activation and Deactivation Hooks
 */
register_activation_hook( __FILE__, array( 'SediciMultisiteFooter\Inc\Activator', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'SediciMultisiteFooter\Inc\Deactivator', 'deactivate' ) );


class WP_Multisite_Footer {
    
    static $curr_dir; 

	static $init;

	/**
	 * Loads the plugin
	 * @access    public
	 */
	public static function init() {

       // Load the header on the DB
      //  $wpdb->insert('bannerCustom', 
     // $banner);
     
		if ( null == self::$init ) {
            self::$init = new Core\Init();
			self::$init->run();
		}

		return self::$init;
	}



    public static function curr_dir() {
        return plugins_url( '.', __FILE__ );
    }
}



/*
 * Comienza la ejecución del plugin
 */ 
function wp_multisite_footer_init(){
	return WP_Multisite_Footer::init();
}


wp_multisite_footer_init();

?>
